<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Repositories\OrdersRepository;

class OrdersController extends Controller
{
    private $postOrderDataRepo;
    private $getOrderDataRepo;
    private $getCartsDataRepo;

    public function __construct(OrdersRepository $postOrderDataRepo,OrdersRepository $getOrderDataRepo,OrdersRepository $getCartsDataRepo)
    {
        $this->postOrderDataRepo = $postOrderDataRepo;
        $this->getOrderDataRepo = $getOrderDataRepo;
        $this->getCartsDataRepo = $getCartsDataRepo;
    }
  
    public function postOrder(Request $request){
        $ordertData = $this->postOrderDataRepo->postOrder($request);
        return response($ordertData, 200);
    }
    public function getOrder(){
        // dd(Auth::user()->id);
        $orders = $this->getOrderDataRepo->getOrder();
        return view('admin.order.index',compact('orders'));
        
    }
    public function getCarts(){

        $cartsData = $this->getCartsDataRepo->getCarts();
    }
}
