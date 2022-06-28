<?php 

namespace App\Http\Repositories;
use Illuminate\Http\Request;
use App\Http\Repositories\EloquentRepository;
use App\Models\Orders;
use App\Models\OrderItem;
use App\Models\PlaceBid;
use App\Models\Product;
use App\Models\PaymentHistory;
use App\Models\Transaction;
use App\Models\Cart;
use Auth;
use App\Models\User;
use App\Models\Refund;
use Mail;
use App\Mail\OrderStatus;
use App\Events\Notify;
use DB;

class OrdersRepository extends EloquentRepository{


	public function postOrder($request){

		// return $request->id;
		return $getOrderDetails = Cart::where('id',$request->id)->first();
		return Orders::create([
			'cart_id'=>$request->id
		]);
	}

	public function getOrder($request){
         
        $user = Auth::user()->user_role;
		if($user == 1){
			$order =  Orders::with('get_order_items.get_product','get_user')->orderBy('id','DESC')->simplePaginate(2);	
			if($request->search !==''){
				$order =  Orders::with('get_order_items.get_product','get_user')
							->where('invoice_number','like','%'.$request->search.'%')
							->orderBy('id','DESC')
							->simplePaginate(20);	
			}	
		}else{
			$order =  Orders::where('seller_id', Auth::user()->id)->with('get_order_items.get_product','get_user')->orderBy('id','DESC')->simplePaginate(10);
			if($request->search !==''){
				$order =  Orders::with('get_order_items.get_product','get_user')
							->where('seller_id', Auth::user()->id)
							->where('invoice_number','like','%'.$request->search.'%')
							->orderBy('id','DESC')
							->simplePaginate(20);	
			}

		}
		// dd($order[0]->get_user->f_name);
		return $order;

	}
	public function getCarts(){
		return Cart::where('user_id',Auth::user()->id)->get();
	}

	public function changeState($request){

		$id = $request->id;			
		$status = $request->status;	
		$desc = $request->desc;	
		$orderItem=OrderItem::with('get_product')->find($id);
		$orderSeller = Orders::where('id',$orderItem->order_id)->first();
		$items = $orderItem;
		$orderItemStatus['status'] = $status; 
		$userWallet = User::find($orderSeller->seller_id);
		$wallet = (float)$userWallet->wallet;
		if($status === 'shipped'){
			$orderItemStatus['awb_number'] = $request->awb_number;
			$orderItemStatus['shipping_details'] = $request->shipping_details;
			$orderItemStatus['shipping_company_name'] = $request->shipping_company_name;
		}
		if($status === 'rejected' || $status === 'cancelled'){
			 $data = $request->validate([
				'qty'=>'required|numeric|min:'.$request->qty
			]);
			 $productShip = Product::find($orderItem->product_id);
			$orderItemStatus['description'] = $request->description;

			$orderItemStatus['cancel_qty'] = $data['qty'];
			$orderItemStatus['cancel_by'] = auth()->user()->id;
			

			$shippingPrice = $orderSeller->shipping ? ($productShip->shipping_price * $orderItem->quantity) : 0;
			$productPrice =  ($orderItem->unit_price * $orderItem->quantity) - $orderItem->discount_amount;
			$wallet += ($productPrice + $shippingPrice);

			$tran['seller_id'] = $orderSeller->seller_id;
            $tran['order_id'] = $orderSeller->id;
            $tran['transaction'] = 'debit';
            $tran['amount'] = $wallet - (($wallet * 10)/100);
            $tran['status'] = 'active';
            $tran['commission'] = ($wallet * 10)/100;
            $tran['transction_for'] = 'order';
            Transaction::create($tran);
		}
		if($status === 'delivered'){
			$orderItemStatus['description'] = $request->description;
			$productShip = Product::find($orderItem->product_id);
			
			$shippingPrice = $orderSeller->shipping ? ($productShip->shipping_price * $orderItem->quantity) : 0;
			$productPrice =  ($orderItem->unit_price * $orderItem->quantity) - $orderItem->discount_amount;
			$wallet += ($productPrice + $shippingPrice);
			$userWallet->wallet = $wallet;
			$userWallet->save();
			$tran['seller_id'] = $orderSeller->seller_id;
            $tran['order_id'] = $orderSeller->id;
            $tran['transaction'] = 'credit';
            $tran['amount'] = $wallet - (($wallet * 10)/100);
            $tran['status'] = 'active';
            $tran['commission'] = ($wallet * 10)/100;
            $tran['transction_for'] = 'order';
            Transaction::create($tran);
		}

		$items->update($orderItemStatus);

		$orderCount=OrderItem::where('order_id',$orderItem->order_id)->where('status','placed')->count();
		if($orderCount===0){
			$ratio =  DB::table('order_item')
					   ->select('status',DB::raw('COUNT(status) as count'))
					   ->where('order_id',$orderItem->order_id)
					   ->groupBy('status')
					   ->orderBy('count','DESC')
					   ->get();
			if(count($ratio) > 0){				
				Orders::where('id',$orderItem->order_id)->update(['status'=>$ratio[0]->status]);
			}		   
		}
		if($orderCount!==0){
			$ratio =  DB::table('order_item')
					   ->select('status',DB::raw('COUNT(status) as count'))
					   ->where('order_id',$orderItem->order_id)
					   ->groupBy('status')
					   ->orderBy('count','DESC')
					   ->get();
			if(count($ratio) > 0){			
				$statusUpdate = $ratio[0]->status === 'placed' ? $status : 'p'.$ratio[0]->status;
				Orders::where('id',$orderItem->order_id)->update(['status'=>$statusUpdate]);
			}			   

		}
		
		
		if($status === 'refunded'){
			$product = Product::find($orderItem->product_id);
			$payment = PaymentHistory::where('order_id',$orderItem->order_id)->first();
			$Order = Orders::find($orderItem->order_id);
			$seller = User::find($Order->seller_id);
			$buyer = User::find($Order->user_id);
			// return $product;
			$data['order_id']=$orderItem->order_id;
			$data['stripe_id']=$payment->stripe_id;
			$data['product_id']=$orderItem->product_id;
			$data['product_name']=$product->name;
			$data['seller_name']=$seller->name;
			$data['customer_name']=$buyer->name;
			$data['product_number']=$Order->invoice_number;
			$data['desc'] = $desc;
			$data['status'] = 0;
			// dd($data);
			$ref = Refund::create($data);
		}
		$order = Orders::with('get_user')->find($orderItem->order_id);
		$orderGet['product_name'] = $orderItem->get_product->name;
		$orderGet['product_qty'] = $orderItem->quantity;
		$orderGet['product_price'] = $orderItem->amount - $orderItem->discount_amount;
		$orderGet['order_number'] = $order->invoice_number;
		$orderGet['status'] = $status;
		Mail::to($order->get_user->email)->send(new OrderStatus($orderGet));

		if($status === 'reject'){
				// Notification::send($user, new OrderNotification($details));
	   			broadcast(new Notify($orderGet));
		}
	

		
	}

	public function bidList($request){
		$userId = Auth::user()->id;
		// if(request('search') !==''){
		// 	return PlaceBid::whereHas('product',function($pro)use($userId,$request){
		// 				$pro->where('user_id',$userId)
		// 				->where('name','like','%'.$request->search.'%');
		// 			})
		// 			->groupBy('product_id')
		// 			->distinct()
		// 			->with(['product','user'])
		// 			->simplePaginate(2);
		// }
		return PlaceBid::whereHas('product',function($pro)use($userId){
					$pro->where('user_id',$userId);
				})
				->with(['product','user'])
				->orderBy('id','desc')
				->distinct()
				->simplePaginate(2);
	}
	
}

?>