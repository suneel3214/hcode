<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\Order;
use App\Models\User;
use App\Imports\TranstionImport;
use App\Exports\TransactionsExport;
use Maatwebsite\Excel\Facades\Excel;

class TransactionController extends Controller
{

    public function index(Request $request)
    {
        if(auth()->user()->user_role === 1){
        
            $transaction = Transaction::with(['seller','order'])->simplePaginate(10);

            // dd($transaction);
            if($request->sort){
                $transaction = Transaction::with(['seller','order'])->where(['transaction'=>$request->sort])->simplePaginate(10);
            }
            if($request->search){
                if(is_numeric($request->search)){
                    $transaction = Transaction::whereHas('order',function($q)use($request){
                        $q->where('invoice_number','LIKE','%'.$request->search.'%');
                    })->with(['seller','order'=>function($q)use($request){
                        $q->where('invoice_number','LIKE','%'.$request->search.'%');
                    }])->simplePaginate(10);
                }
                else{
                    $transaction = Transaction::whereHas('seller', function ($query) use ($request){
                        $query->where('email', 'like', '%'.$request->search.'%');
                    })
                    ->with(['seller' => function($query) use ($request){
                        $query->where('email', 'like', '%'.$request->search.'%');
                    }])->simplePaginate(10);
                }
               
            }
           
        }
        else{
            $transaction = Transaction::with(['seller','order'])->where(['seller_id'=>auth()->user()->id,'status'=>'active'])->simplePaginate(10);
        }
        return view('transaction.index',compact('transaction'));
    }

    public function export()
    {
        return Excel::download(new TransactionsExport,'transaction.csv');
    }

 
    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $order = Order::where('invoice_number',$request->orderId)->first();
        $sellerId = 0;
        if(!$order && $request->transFor !=='portal_sevice_charge'){
            return response()->json(['errors' => 'This order number is wrong.'], 422);
        }

        $sellerId = $order ? $order->seller_id:0;

        if($request->memberID){
            $user = User::where('member_id',$request->memberID)->first();
            if(!$user){
                return response()->json(['errors' => 'This is not a valid member id.'], 422);
            }
            $sellerId = $user->id;
        }

        $data = [
            'order_id'=>$request->transFor !=='portal_sevice_charge' ? $order->id:NULL,
            'seller_id'=>$sellerId,
            'transaction'=>$request->transType,
            'amount'=>(int)$request->tranAmount - (int)$request->portanAmt,
            'commission'=>$request->portanAmt,
            'transction_for'=>$request->transFor,
        ];  

        Transaction::create($data);
        return true;
    }

     public function getOrder($orderNumber)
    {
        $order = Order::where('invoice_number','#'.$orderNumber)->first();
        if(!$order){
            return response()->json(['errors' => 'This order number is wrong.'], 422);
        }
        $data['amount'] = $order->amount;
        $data['commission'] = ($order->amount * 20)/100;

        return $data;
    }
    public function getMenberIdUser($memberId)
    {
        $user = User::where('member_id',$memberId)->first();
        if(!$user){
            return response()->json(['errors' => 'This is not a valid member id.'], 422);
        }
       
        return true;
    }

   
    public function show($id,$status)
    {
        Transaction::find($id)->update(['status'=>$status]);
        return redirect()->back();
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
        //
    }

    public function import(Request $request)
    {
        Excel::import(new TranstionImport,request()->file('file'));
    }
}
