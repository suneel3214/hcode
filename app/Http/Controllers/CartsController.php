<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Repositories\CartsRepository;
use App\Http\Resources\CartResource;
use App\Models\Cart;
use Auth;
use Response;


class CartsController extends Controller
{
    private $cartsRepo;
    private $getCartDataRepo;
    private $postOrderDataRepo;

        
    public function __construct(CartsRepository $cartsRepo ,CartsRepository $getCartDataRepo,CartsRepository $postOrderDataRepo)
    {
        $this->cartsRepo = $cartsRepo;
        $this->getCartDataRepo = $getCartDataRepo;
        $this->postOrderDataRepo = $postOrderDataRepo;
    }
    public function cartDataStore(Request $request)
    { 
        // return $request->all();
        $cartData = $this->cartsRepo->cartDataStore($request);
        if($cartData === 'false'){
             return Response::json([
                'data' => 'Item already in cart...'
            ], 401);   
        }
        return Response::json([
                'data' => $cartData
            ], 200);
    }
    public function getCartData(){
        // return '$token';
        // return ($this->getCartDataRepo->getCartData());
        $cartData = $this->cartsRepo->getCartData();

        return Response::json([
            'data' => $cartData
        ], 200);
    }
    public function updateCartItem(Request $request){
        // return $request;
        $itemId = $request->itemId;
        $qty = $request->qty;
        $type = $request->type;
        // try{
            $cartData = $this->cartsRepo->updateCartItem($itemId,$qty,$type);
            if($cartData !=='false' ){
                return Response::json([
                    'data' => $cartData
                ], 200);
            }
            return Response::json([
                    'data' => $cartData
                ], 422);
        // }
        // catch{
        //     return Response::json([
        //         'data' =>'Somthing went wrong...'
        //     ], 401);
        // }
    }
    public function postOrder(Request $request){
        // return ($this->getCartDataRepo->getCartData());
        $ordertData = $this->postOrderDataRepo->postOrder($request);
        return response($ordertData, 200);

    }

    public function isCartEmpty(){
        // return ($this->getCartDataRepo->getCartData());
        $userId = Auth::guard('api')->user()->id;

        $data = Cart::with('cart_items.products_detail','cart_items.products_detail.pro_images')->where('user_id',$userId)->first();
        if($data){
            return Response::json([
                    'data' => 'true'
                    ], 200);
        }
        else{
             return Response::json([
                    'data' => 'false'
                    ], 200);
        }

    }

    public function deleteCart($itemId){
        // return response($itemId);
        $ordertData = $this->cartsRepo->deleteCartItem($itemId);
        return Response::json([
            'data' => $ordertData
        ], 200);
    }
}
