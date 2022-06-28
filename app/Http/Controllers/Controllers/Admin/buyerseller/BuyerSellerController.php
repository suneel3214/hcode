<?php

namespace App\Http\Controllers\Admin\buyerseller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Repositories\Admin\BuyerSellerRepository;

class BuyerSellerController extends Controller
{
    private $buyerSellerRepo;

    public function __construct(BuyerSellerRepository $buyerSellerRepo)
    {
        $this->middleware('auth');
        $this->buyerSellerRepo = $buyerSellerRepo;

    }
    public function index()
    {
        $users = $this->buyerSellerRepo->all();
        return view('admin.buyerseller.index',compact('users'));
    }

    
    public function create()
    {
        //
    }

  
    public function store(Request $request)
    {
        //
    }

   
    public function show($id)
    {
        //
        dd('a');

    }

    
    public function edit($id)
    {
        //
    }

    
    public function update(Request $request, $id)
    {
        //
    }

   
    public function destroy($id)
    {
    } 
    public function buyersellerAprove($id)
    {
        $user = User::find($id);
        if($user->status == 'P'){
            $status = 'A';
            $message = 'User Approved Successfully';
        }else{
            $status = 'P';
            $message = 'User UnApproved Successfully';
        }
        $user->update(['status' => $status]);
        return [
            'status' => 'success',
            'message' => $message
        ];
    }
    public function buyerseller_destroy($id)
    {
       $user = User::find($id);
       $user->delete();
        return redirect()->back()->with('success',"User Deleted Successfully.");
    }
}
