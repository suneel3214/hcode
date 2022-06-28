<?php 

namespace App\Http\Repositories\API;
use Illuminate\Http\Request;
use App\Http\Repositories\EloquentRepository;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use App\Models\PaymentHistory;
use App\Models\ShipingAddress;
use App\Models\PlaceBid;
use App\Models\User;
use Auth;
use DB;
use Mail;
use App\Mail\OrderConfirm;
use App\Events\Notify;
use Illuminate\Support\Facades\Notification;
use App\Notifications\OrderNotification;
use PDF;

class OrderApiRepository extends EloquentRepository{

	public function getOrder(){
		$userId = Auth::guard('api')->user()->id;

		$order = Order::where('user_id',$userId)
					->with(['get_order_items.get_product.pro_images'])
					->orderBy('id','desc')
					->get();

		// return $order;			
		return OrderResource::collection($order);		
	}

	public function createOrder(Request $request){

		$userId = Auth::guard('api')->user()->id;
		$oldInvoice = Order::orderBy('id','desc')->first();
		$uniqueInvoice = 'INVHT-101';

        $orderNum = Order::orderBy('id','desc')->first();
        if($orderNum){
            $dataArray = explode('-',$orderNum->invoiceNumber);           
            $nextNumber = ((int)$dataArray[1]+1);         
            $uniqueInvoice = 'INVHT-'.(string)$nextNumber;
        }

		if ($request->order_type == 'buy_now') {
			// if ($request->address_type == 'custome_address') {
			// $shipingAddress = $this->shippingAddress($request);
			// $shippingAdrId = ShipingAddress::create($shipingAddress)->id;
			$products = Product::where('pro_id',$request->product_id)->first();
			$total_discounted_price = $products->discounted_price*1;
			$totalAmount = $products->price*1;

			$order['user_id'] = $userId;
			$order['seller_id'] = $products->user_id;
			$order['invoice_number'] = '#'.(string)$userId.(string)rand();
			$order['amount'] = $products->free_option !=='Yes' ? $totalAmount:0;

			$order['total_price'] =$products->free_option !=='Yes' ? $total_discounted_price:0;
			$order['discounted_price'] =$products->free_option !=='Yes' ?  $totalAmount - $total_discounted_price:0;
			$order['shiping_charges'] = 0;
			$order['total_item'] = 1;
			$order['item_qty'] = 1;
			$order['address_id'] = $request->address_id;
			$order['type_of_shiping'] = $request->type_of_shiping;
			$orderId = Order::create($order)->id;
			$orderID = $orderId;
			$orderId->invoiceNumber = $uniqueInvoice.$orderId;
			$orderId->save();
			$orderItem = [
				'order_id' => $orderId,
				'product_id' => $request->product_id,
				'quantity' => $request->quantity,
				'unit_price' => $products->free_option !=='Yes' ? $products->price:0,
				'total_price' => 0,
				'tax_percentage' =>0,
				'discount_percentage' => $products->free_option !=='Yes' ? $products->discount:0,
				'discount_amount' =>$products->free_option !=='Yes' ?  $totalAmount - $total_discounted_price:0,
				'tax_amount' => 0,
				'amount' =>  $products->free_option !=='Yes' ? $totalAmount :0
			];

			PaymentHistory::find($request->paymentId)->update(['order_id'=>$orderId]);
			$orderItems = OrderItem::create($orderItem);
			$cart->delete();
			$orderAndItem['orderNumber'] = $orderId->invoice_number;
			$orderAndItem['orderItems'] = $orderItems;
			return $orderAndItem;
			// }

		}else{

			$cart = Cart::where('user_id',$userId)->first();
			// $shipingAddress = $this->shippingAddress($request);
			// $shippingAdrId = ShipingAddress::create($shipingAddress)->id;

			$cartId = $cart->id;
			// $address = $request->address;
			// $shipping_charges = $request->type_of_shiping;
			// $cart = Cart::find($cartId);
			// return $cart;

			$cartItem = CartItem::where('cart_id',$cartId)->with('products_detail.user_details')->get();
			// return $cartItem;
			$marchentIds = [];
			$orderId = 0;
			$count = 1;
			$orderIDs=[];
			$orderItems=[];
			$sameUserOrderId = '';
			$countMk = 0;
			foreach($cartItem as $item){
				$product = Product::with(['pro_images'])->find($item->product_id);
				if(!in_array($item->products_detail->user_id,$marchentIds)){
					$marchentIds[] = $item->products_detail->user_id;
					$order['user_id'] = $userId;
					$order['invoice_number'] = '#'.(string)$cart->id.(string)rand();
					$order['seller_id'] = $item->products_detail->user_id;
					$order['total_price'] = $product->free_option !=='Yes' ? ($item->total_price):0;
					$order['discounted_price'] = $product->free_option !=='Yes' ? $item->discount_amount:0;
					$order['amount'] = $product->free_option !=='Yes' ? $item->amount:0;
					// $order['shiping_charges'] = $shipping_charges;
					$order['total_item'] = $product->free_option !=='Yes' ? $item->total_item:0;
					$order['item_qty'] = $count;
					$order['address_id'] = $request->address_id;
					$order['type_of_shiping'] = $request->type_of_shiping;
					$order['invoiceNumber'] = $uniqueInvoice;
					$orderId = Order::create($order);
					$orderIDs[] = $orderId->invoice_number;


					$orderId->save();
					if($countMk === 0){
						$payment = PaymentHistory::find($request->paymentId);
						$payment->update(['order_id'=>$orderId->id]);
					}

					$marchentIds2[$orderId->id] = $item->products_detail->user_id;
					$orderAmount[$orderId->id] = $order['total_price'];
					$orderid[] = $orderId->id;
					$invoice[$orderId->id] = $orderId->invoice_number;
					$countMk++;


				}
				else{
					if($product->free_option !=='Yes'){
						$orderId->increment('amount',$item->amount);
						$orderId->increment('total_price',$item->total_price);
						$orderId->increment('discounted_price',$item->discount_amount);
						$orderAmount[$orderId->id] = $orderAmount[$orderId->id] + $item->total_price;
						$orderId->item_qty= $count;
					}
					
				}

				$orderItem = new OrderItem;
				$orderItem->order_id = $orderId->id; 
				$orderItem->product_id = $item->product_id; 
				$orderItem->quantity = $item->quantity; 
				$orderItem->unit_price =$product->free_option !=='Yes' ? $item->unit_price:0; 
				$orderItem->tax_percentage = $product->free_option !=='Yes' ? $item->tax_percentage:0; 
				$orderItem->discount_percentage =$product->free_option !=='Yes' ? $item->discount_percentage:0; 
				$orderItem->discount_amount = $product->free_option !=='Yes' ? $item->discount_amount:0; 
				$orderItem->tax_amount = $product->free_option !=='Yes' ? $item->tax_amount:0; 
				$orderItem->amount = $product->free_option !=='Yes' ? $item->amount:0; 
				$orderItem->save();
				$payment = PaymentHistory::find($request->paymentId);
				$product->decrement('qty',$item->quantity);

				if($payment->shipping){
					$orderId->shipping = true;
					$orderId->increment('shipping_price',$product->shipping_price);
					$orderId->save();
				}else{
					$orderId->shipping = false;
					$orderId->increment('shipping_price',0);
					$orderId->save();
				}

				if($payment->order_id !== $orderId->id ){
					$paymentData = [
						'stripe_id'=>$payment->stripe_id,
						'order_id'=>$orderId->id,
						'currency'=>$payment->currency,
						'payment_method'=>$payment->payment_method,
						'status'=>$payment->status,
						'shipping_price'=>$payment->shipping_price,
						'amount'=>$payment->amount,
						'shipping'=>$payment->shipping,
						'parent_payment_id'=>$request->paymentId
					];
					$pay = PaymentHistory::create($paymentData);
				}			

				$count++;
				$orderItems[] = $this->makeData($product,$orderItem);
				
			}
			$cart->delete();

			$orderAndItem['orderNumber'] = $orderIDs;
			$orderAndItem['orderItems'] = $orderItems;
			$orderAndItem['shipping'] = $payment->shipping;
			$orderAndItem['shipping_price'] = $payment->shipping_price;
			if($payment->order_id ===null){
				$payment->update(['order_id'=>$orderId->id]);
			}

			foreach($orderid as $key => $OrderNumber){
	            $orderGet = Order::with(['get_order_items.get_product','get_user'])->find($OrderNumber);
				$details = [
	                'title' => 'New Order!',
	                'body' => $invoice[$OrderNumber],
	                'amount'=>$orderAmount[$OrderNumber],
	                'actionURL' => $OrderNumber,
	                'actionText' => 'Open',
	                'reciverId' => $orderGet->seller_id
	            ];
	            $user = User::find($marchentIds2[$OrderNumber]);
	            broadcast(new Notify(['reciverId' => $orderGet->seller_id]));
	        }
			$this->sendOrderMail($orderid);

			return $orderAndItem;
		}
	}

	public function sendOrderMail($orderid){
	    $orderData  = [
	        'price'=> 0
	    ];
	  
	    $count = 0;
	    foreach($orderid as $key => $OrderNumber){
            $total = 0;
            $orderGet = Order::with(['get_order_items.get_product','get_user'])->find($OrderNumber);
            $orderData['seller_name'] = $orderGet->get_seller->name;  
            $orderData['seller_email'] = $orderGet->get_seller->email;  
            $orderData['user_name'] = $orderGet->get_user->name;  
            $orderData['user_email'] = $orderGet->get_user->email;  
            $orderData['date'] = date('d F, Y',strtotime($orderGet->created_at));  
            $orderData['invoice_number'] = $orderGet->invoiceNumber;  
            $orderData['order_number'] = $orderGet->invoice_number;  
            $orderData['shipping'] = $orderGet->shipping;  
            $orderData['price'] +=  $orderGet->shipping ? ($orderGet->total_price - $orderGet->discounted_price) + $orderGet->shipping_price:($orderGet->total_price - $orderGet->discounted_price);
            
            $orderItems = [];
            foreach($orderGet->get_order_items as $items){

                if($orderGet->shipping){
                    $orderItems[$count]['shipping_price'] = $items->get_product->shipping_price;
                    $total +=$items->get_product->shipping_price;
                }
                $orderItems[$count]['product_name'] = $items->get_product->name;
                $orderItems[$count]['amount'] = $items->amount - $items->discount_amount;
                $orderItems[$count]['quantity'] = $items->quantity;
                $orderItems[$count]['subtotal'] = $orderItems[$count]['amount'] ;
                $count++;
            }
            $total += $orderGet->total_price;
            $data['orderData'] = $orderData;
            $data['orderItems'] = $orderItems;
            $data['total'] = $total;   
            Mail::send('mail.invoiceMail', $data, function($message)use($data) {
                $message->to(Auth::user()->email, Auth::user()->name)
                ->subject('Order Invoice');
                // ->attachData($pdf->output(), "invoice.pdf");
                });
            Mail::send('mail.orderNoti', $data, function($message)use($orderGet) {
	            $message->to($orderGet->get_seller->email, $orderGet->get_seller->name)
	            ->subject('Order Notification');
            	// ->attachData($pdf->output(), "invoice.pdf");
            });
        }
	}


	public function makeData($product,$orderItems){

		$item['id'] =  $product->pro_id;
		$item['name'] =  $product->name;
		$item['shipping'] =  $product->shipping_option;
		$item['shipping_price'] =  $product->shipping_price;
		$item['order_id'] =  $orderItems->order_id;
		$item['quantity'] =  $orderItems->quantity;
		$item['unit_price'] =  $orderItems->unit_price;
		$item['discount_percentage'] =  $orderItems->discount_percentage;
		$item['discount_amount'] =  $orderItems->discount_amount;
		$item['amount'] =  $orderItems->amount;
		$item['total_price'] =  ($orderItems->unit_price * $orderItems->quantity)-$orderItems->discount_amount;
		$item['pro_images'] =  $product->pro_images;
		return $item;
	}

	public function storeBidePlace(Request $request){
		$data = [
			'user_id'=>	 Auth::guard('api')->user()->id,
			'product_id'=>$request->product_id,
			'your_bid_price'=>$request->your_bid_price,
			'shipping_option'=>$request->shipping_option,
			'payment_methode'=>$request->payment_methode,
			'reminder_email'=>$request->reminder_email
		];
		PlaceBid::create($data);
		return 'Bid Placed successfully...';
	}
	public function storeShippingAddress(Request $request){

		// return ShipingAddress::all()->delete();
		$shipingAddress = $this->shippingAddress($request);
		$shippingAdrId = ShipingAddress::create($shipingAddress);
		return $shippingAdrId;
	}
	public function getShippingAddress(){
		$userId = Auth::guard('api')->user()->id;
		$shippingAddress = ShipingAddress::where('user_id',$userId)->get();
		return $shippingAddress;
	}
	public function getOrderDetails($id){
		$userId = Auth::guard('api')->user()->id;
		return Order::where('user_id',$userId)
					->where('id',$id)
					->with('get_order_items.get_product.pro_images','get_user')
					->first();
	}
	public function shippingAddress($request,$id=null){

		// return $request;
		$userId = Auth::guard('api')->user()->id;

		$shipingAddress = [
				'user_id'=> $userId,
				'state'=> $request->state,
				'address'=> $request->address,
				'city'=> $request->city,
				'f_name'=> $request->f_name,
				'zip_code'=> $request->zip,
				'email'=> $request->email,
				'phone_no'=> $request->phone_no,
				'alternative_phone_no'=> $request->alternative_phone_no,
				'notes'=>$request->notes
			];

			return $shipingAddress;
	}
	
}

?>