<?php 

namespace App\Http\Repositories;
use Illuminate\Http\Request;
use App\Http\Repositories\EloquentRepository;
use DB;
use App\Models\CartItem;
use App\Models\Cart;
use App\Models\Orders;
use App\Models\Product;
use App\Models\User;
use Response;
use Auth;
use App\Http\Resources\CartResource;
use App\Http\Resources\CartItemResource;

class CartsRepository extends EloquentRepository{


	public function cartDataStore(Request $request){
		DB::beginTransaction();
		// return $request->all();
		
		// try{
			$user_id =  Auth::guard('api')->user()->id;
			$getDuplicatecart = Cart::where('user_id',$user_id)->first();
			if(!empty($getDuplicatecart)){
				$pro = Product::where('slug',$request->id)->first();
				$cartItem = CartItem::where(['cart_id'=>$getDuplicatecart->id,'product_id'=>$pro->pro_id])->first();
				// return $cartItem;
				if(empty($cartItem)){
					$updateCart = $this->updateCartObject($getDuplicatecart,$request);
					 Cart::where('user_id',$getDuplicatecart->user_id)->update($updateCart);
					$cartItemData = $this->cartItemData($request);
					$cartItemData['cart_id'] = $getDuplicatecart->id;
					CartItem::create($cartItemData);
					DB::commit();
					return $this->getCartData();				
				}
				else{
					return 'false';
				}	

			}else{ 

				$data = $this->cartData($request);
				
				$cartId =  Cart::create($data);
				$cartItemData =$this->cartItemData($request);
				// return $cartItemData;
				$cartItemData['cart_id'] = $cartId->id;
				// return $cartItemData;
				 CartItem::create($cartItemData);
				 DB::commit();
				 return $this->getCartData();

			}
		// }
		// catch (\Exception $e) {
  //           DB::rollback(); 

  //           return 'Somthing went wrong....';
        
		// }

	}

	public function updateCartObject($getDuplicatecart,$request){
		$updateCart['discounted_price'] =$getDuplicatecart->discounted_price + ($request->price * $request->discount)/100;
		$updateCart['total_price'] = $getDuplicatecart->total_price + $request->price - ( ($request->price * $request->discount)/100);
		$updateCart['amount'] = $getDuplicatecart->amount + $request->price;
		$updateCart['item_qty'] =$getDuplicatecart->item_qty + 1;
		return $updateCart;
	}

	public function getCartData(){

		$userId = Auth::guard('api')->user()->id;

		$data = Cart::with('cart_items.products_detail','cart_items.products_detail.pro_images')->where('user_id',$userId)->first();
		$cartTotal = 0;
		$cartAmount = 0;
		$cartDiscountAmount = 0;
		if($data->cart_items){
			foreach ($data->cart_items as $product) {
				$pro = Product::find($product->product_id);
				$cartItem = CartItem::find($product->id);
				$total = ((float)$pro->discounted_price * (int)$cartItem->quantity);
				
				$cartItem1['unit_price'] = $pro->price;
				if((int)$pro->discount !== 0){
					$discountAmt = ( (float)$pro->price - (float)$pro->discounted_price) * (int)$cartItem->quantity;
					$cartItem1['discount_amount'] = $discountAmt ;
				}
				else{				
					$cartItem1['discount_amount'] = 0;
					$discountAmt = 0;
				}
				$cartTotal += $total;
				$cartDiscountAmount += $discountAmt;
				$cartItem1['total_price'] = $total ;	
				$cartItem1['discount_percentage'] = (float)$pro->discount;			
				
				$cartItems = CartItem::find($product->id)->update($cartItem1);
			}
			Cart::find($data->id)->update([
										'total_price'=>$cartTotal,
										'discounted_price'=>$cartDiscountAmount,
										'amount'=>($cartTotal+$cartDiscountAmount)
										]);
		}

		
		if($data === null){
			return false;
		}
		// return($data);
		$res =  new CartResource($data);
		return $res;
	}

	public function updateCartItem($itemId,$qty,$type){
		$userId = Auth::guard('api')->user()->id;
		$pro = Product::where('slug',$itemId)->first();
		$itemId = $pro->pro_id;
		$cart = Cart::where('user_id',$userId)->first();
		$cartItem = CartItem::where('product_id',$itemId)->where('cart_id',$cart->id)->first();		
		if($type==='plus'){
			
			$discountAmt = $cartItem->unit_price * $cartItem->discount_percentage/100;
			// $discountAmt = $discountAmt * ($cartItem->quantity+1);
			$cart->increment('total_item',$qty);
			$cart->increment('discounted_price',$discountAmt);
			$cart->increment('amount',$cartItem->unit_price);
			$cart->increment('total_price',($cartItem->unit_price-$discountAmt));

			$cartItem->increment('quantity',$qty);
			$cartItem->increment('total_price',($cartItem->unit_price-$discountAmt));	
			$cartItem->increment('discount_amount',$discountAmt);
			$cartItem->increment('amount',$cartItem->unit_price);

		}
		else{
			if($cartItem->quantity > 1){
				$discountAmt = $cartItem->unit_price * $cartItem->discount_percentage/100;
				// $discountAmt = $discountAmt * ($cartItem->quantity-1);
				$cart->decrement('total_item',$qty);
				$cart->decrement('discounted_price',$discountAmt);
				$cart->decrement('amount',$cartItem->unit_price);
				$cart->decrement('total_price',($cartItem->unit_price-$discountAmt));

				$cartItem->decrement('quantity',$qty);
				$cartItem->decrement('total_price',($cartItem->unit_price-$discountAmt));	
				$cartItem->decrement('discount_amount',$discountAmt);	
				$cartItem->decrement('amount',$cartItem->unit_price);
			}else{
				return 'false';
			}

		}
		return $this->getCartData();
	}

	public function cartData($request,$id=null){
		$user_id =  Auth::guard('api')->user()->id;

		return $data=([
			'user_id' =>$user_id,
			'total_price' =>($request->price - ( ($request->price * $request->discount)/100))*$request->quantity,
			'discounted_price' =>(($request->price * $request->discount)/100)*$request->quantity,
			'amount' =>$request->price * $request->quantity,
			'total_item' =>$request->quantity,
			'item_qty' =>1
		]);
	}

	public function cartItemData($request,$id=null){
		$pro = Product::where('slug',$request->id)->first();
		return $data=([
			'product_id' =>$pro->pro_id,	
			'unit_price' =>$request->price,
			'amount' =>$request->price * $request->quantity,
			'total_price' =>($request->price-(($request->price * $request->discount)/100)) * $request->quantity,
			'quantity' =>$request->quantity,
			'discount_percentage' =>$request->discount,
			'discount_amount' => ( ($request->price * $request->discount)/100) *$request->quantity 
		]);
	}

	public function postOrder($request){
		return Orders::create([
			'cart_id'=>$request->id
		]);
	}

	public function deleteCartItem($itemId){
		// return $this->getCartData();
		$pro = Product::where('slug',$itemId)->first();
		$cart = Cart::where('user_id',Auth::guard('api')->user()->id)->first();
		$cartItem = CartItem::where('product_id',$pro->pro_id)->where('cart_id',$cart->id)->first();
		$totalItem = CartItem::where('cart_id',$cart->id)->get();
		if(count($totalItem) === 1){
			$totalItem = CartItem::where('cart_id',$cartItem->cart_id)->delete();
			$cart = Cart::find($cartItem->cart_id)->delete();

			return $this->getCartData();
		}
		// return $cartItem->total_price;
		$cart->total_price = $cart->total_price - ($cartItem->total_price - $cartItem->discount_amount);
		$cart->discounted_price = $cart->discounted_price - $cartItem->discount_amount ;
		$cart->amount = $cartItem->amount ;
		$cart->total_item = $cart->total_item - 1 ;
		$cart->item_qty = $cart->item_qty - $cartItem->quantity ;
		$cart->save() ;
		$cartItem->delete();
		return $this->getCartData();
	}
	
}

?>