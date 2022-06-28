<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payout;
use App\Models\User;
use App\Models\Order;
use App\Models\PaymentHistory;
use Mail;
use App\Exports\PayoutsExport;
use Maatwebsite\Excel\Facades\Excel;


class PayoutController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request){
        if(auth()->user()->user_role === 1){
            $payout = Payout::with('seller')->simplePaginate(10);
            if($request->search !==null){
                $payout = Payout::with('seller')->where(['status'=>$request->search])->simplePaginate(10);
            }
        }
        else{
            $payout = Payout::with('seller')->where('seller_id',auth()->user()->id)->simplePaginate(10);
            if($request->search !==null){
                $payout = Payout::with('seller')->where(['seller_id'=>auth()->user()->id,'status'=>$request->search])->simplePaginate(10);
            }
        }
        return view('admin.payout.index',compact('payout'));
    }


    public function export()
    {
        return Excel::download(new PayoutsExport, 'payout.csv');
    }
    public function save(Request $request){
        $data = $request->validate([
            'amount'=>'required|numeric|max:'.auth()->user()->wallet,
        ]);
        $data['seller_id'] = auth()->user()->id;
        $data['date'] = date('Y-m-d');
        $user = User::find(auth()->user()->id);
        $user->decrement('wallet',$data['amount']);
        Payout::create($data);
        return true;
    }

    public function payoutStatus($id,$status){
        $payout = Payout::find($id);
        $user = User::find($payout->seller_id);
        if($status === 'cancelled'){
            $user->increment('wallet',$payout->amount);
        }

        $user = User::find($payout->seller_id);
        $payout->update(['status'=>$status]);
        $data['status'] = $status;
        $data['payment'] = $payout->amount;
        $data['member_id'] = $payout->member_id;

         Mail::send('mail.paymentStatus', $data, function($message)use($data,$user) {
            $message->to($user->email, $user->name)
            ->subject('Payment Status');
            // ->attachData($pdf->output(), "invoice.pdf");
            });
        return redirect()->back();
    }

    public function payoutStatusSeller($id,$status){
        if($status === 'cancelled'){
            $payout = Payout::find($id);
            $user = User::find(auth()->user()->id);
            $user->increment('wallet',$payout->amount);
            $payout->update(['status'=>$status]);
        }
        
        return redirect()->back();
    }

    public function payoutReject(Request $request){
        $id = $request->id;
        $payout = Payout::find($id);
        $data = $request->validate(['amount'=>'required|numeric|max:'.$payout->amount]);

        $remark = $request->remark;
        $amount = $request->amount;
        $user = User::find($payout->seller_id);
        $user->increment('wallet',$amount);
        $payout->update(['status'=>'rejected','remark'=>$remark]);
        return true;
    }

     public function TransactionTracker(){
        $payouts = PaymentHistory::whereHas('order',function($query){
            $query->whereHas('get_seller');
        })->with(['order'=>function($q){
            $q->with('get_seller');
        }])->get();
        // dd($payouts);
        return view('admin.payout.transaction_tracker',compact('payouts'));
    }
}
