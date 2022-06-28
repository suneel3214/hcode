<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Repositories\API\OrderApiRepository;
use Response;

class OrdersApiController extends Controller
{
    private $order;

    public function __construct(OrderApiRepository $order)
    {
        $this->order = $order;
    }

    public function createOrder(Request $request){

        // return  $request;
        $data = $this->order->createOrder($request);
        return Response::json([
                'data' => $data
            ], 200);
    }
    public function storeShippingAddress(Request $request){

        $data = $this->order->storeShippingAddress($request);
        return Response::json([
                'data' => $data
            ], 200);
    }
    public function getShippingAddress(){
// return $id;
        $data = $this->order->getShippingAddress();
        return Response::json([
                'data' => $data
            ], 200);
    }
    public function getOrderDetails($id){

        $data = $this->order->getOrderDetails($id);
        return Response::json([
                'data' => $data
            ], 200);
    }
}
