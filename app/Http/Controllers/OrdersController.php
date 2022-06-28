<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Repositories\OrdersRepository;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Refund;
use App\Models\PaymentHistory;
use App\Http\Resources\OrderResource;

class OrdersController extends Controller
{
    private $postOrderDataRepo;
    private $getOrderDataRepo;
    private $getCartsDataRepo;

    public function __construct(OrdersRepository $postOrderDataRepo,OrdersRepository $getOrderDataRepo,OrdersRepository $getCartsDataRepo)
    {
        $this->middleware('auth');
        $this->postOrderDataRepo = $postOrderDataRepo;
        $this->getOrderDataRepo = $getOrderDataRepo;
        $this->getCartsDataRepo = $getCartsDataRepo;
    }

    
  
    public function postOrder(Request $request){
        $ordertData = $this->postOrderDataRepo->postOrder($request);
        return response($ordertData, 200);
    }

    public function getOrder(Request $request){
        $orders = $this->getOrderDataRepo->getOrder($request);
        return view('admin.order.index',compact('orders'));
    }
    public function getCarts(){
        $cartsData = $this->getCartsDataRepo->getCarts();
    }

    public function changeState(Request $request){
        // return $request->all();
        $cartsData = $this->postOrderDataRepo->changeState($request);
        return $cartsData;
    }

    public function NotichangeState(Request $request){
        $id = $request->id;
        $status = $request->status;
        $desc = $request->desc;
        $notifiId = $request->notifiId;

        $cartsData = $this->postOrderDataRepo->changeState($request);
        auth()->user()->unreadNotifications->where('id', $notifiId)->markAsRead();
        $data = auth()->user()->unreadNotifications;
        return view('admin.notification.index',compact('data'));
    }

    public function bidList(Request $request){
        $bid = $this->postOrderDataRepo->bidList($request);
        return view('admin.bid.index',compact('bid'));
    }

    public function notificationOrderDetails($number){
        $data = Orders::with('get_order_items')->where('invoice_number',$number)->find();
    }

    public function refundList(Request $request){
        $data = Refund::whereHas('order',function($q){
                    $q->with(['get_payment','get_seller','get_user']);
                })
                ->whereHas('product')
                ->with(['order'=>function($qu){
                    $qu->with(['get_payment','get_seller','get_user']);
                },'product'])
                ->simplePaginate(10);

        if(isset($request->search) && $request->search !== ''){
            $data = Refund::whereHas('order',function($q){
                $q->with(['get_payment','get_seller','get_user']);
            })
            ->where('product_number','like','%'.$request->search.'%')
            ->whereHas('product')
            ->with(['order','product'])
            ->simplePaginate(10);    
        }
    
        return view('admin.refund',compact('data'));
    }

    public function PaymentList(){
        $data = PaymentHistory::with(['order'=>function($q){
            $q->whereHas('get_payment')
              ->whereHas('get_seller')
              ->whereHas('get_user')
              ->with(['get_payment','get_seller','get_user']);
        }])->get();
        
        return view('admin.payment_history',compact('data'));
    }

    public function show($id){
        $order = Order::with('get_order_items.get_product','get_user')->find($id);
        // dd($order);
        return view('admin.order.show',compact('order'));
    }

    public function orderDetails($orderID){
        $orderItems = Order::with('get_order_items.get_product','get_user')->where('invoice_number','#'.$orderID)->first();
        return new OrderResource($orderItems);
    }
}
