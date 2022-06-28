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
    public function index(Request $request)
    {
        $users = $this->buyerSellerRepo->getUserByRole($request);
        return view('admin.buyerseller.index',compact('users'));
    }

    public function buyer()
    {
        $users = $this->buyerSellerRepo->getUserByRole(4);
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
    public function buyersellerAprove($id,$type)
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
        // $users = $this->buyerSellerRepo->getUserByRole($type);
        // return view('admin.buyerseller.refreshTable',compact('users'));

    }
    public function buyerseller_destroy($id)
    {
       $user = User::find($id);
       $user->email = (string)$user->id.''.$user->email;
       $user->business_name = (string)$user->id.''.$user->business_name;
       $user->save();
       $user->delete();
        return redirect()->back()->with('success',"User Deleted Successfully.");
    }
}
