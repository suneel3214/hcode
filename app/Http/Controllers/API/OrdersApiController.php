<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Repositories\API\OrderApiRepository;
use App\Models\Order;
use App\Models\OrderItem;
use Response;
use Auth;
use App\Http\Resources\OrderResource;


class OrdersApiController extends Controller
{
    private $order;

    public function __construct(OrderApiRepository $order)
    {
        $this->order = $order;
    }

    public function createOrder(Request $request){

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

    public function getOrders(){
        $data = $this->order->getOrder();
        return $data;
        // return Response::json([
        //         'data' => $data
        //     ], 200);
    }

    public function getOrderByNumber(Request $request){
        $orderAndItem = [];
        foreach ($request->orderNumbers as $key => $OrderNumber) {
           $order = Order::with(['get_order_items.get_product','get_user'])->where('invoice_number',$OrderNumber)->first();
           foreach ($order->get_order_items as $orderItem) {
                $orderAndItem['orderItems'][] = $this->makeData($orderItem->get_product,$orderItem);
           }

            $orderAndItem['orderNumber'] =$request->orderNumbers;
            $orderAndItem['shipping'] = $order->shipping;
            $orderAndItem['shipping_price'] = $order->shipping_price;
        }
        return $orderAndItem;
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

    public function cancelOrder(Request $request){
        $qty = $request->qty;
        $user =  Auth::guard('api')->user();
        $status = '';
        if($request->type==='product'){
            $OrderItems = OrderItem::find($request->proID);
            $orderId = $OrderItems->order_id;
           
            $cancelAmt = ($OrderItems->unit_price - $OrderItems->discount_amount)*$qty;
            $orderCount=OrderItem::where('order_id',$OrderItems->order_id)->where('status','cancelled')->count();
            $OrderItems->update(['status'=>'cancelled',
                                 'cancel_qty'=>$qty,
                                 'cancel_by'=>$user->id
                               ]);
            $OrderItems = OrderItem::where('order_id',$orderId
        );
            if($OrderItems->count() > $orderCount){
                $status='pcancelled';
            }
            else{
                $status='cancelled';
            }

            Order::find($orderId)->update(['cancel_qty'=>$request->qty,
                                           'cancel_amt'=>$cancelAmt,
                                           'status'=>$status,
                                           'cancel_by'=>$user->id]);
            $orderItems = Order::with('get_order_items.get_product','get_user')->find($orderId);
            return new OrderResource($orderItems);
        }
        else{

        }

    }
}
