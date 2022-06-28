<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Feedback;
use App\Models\ReportAbuse;
use Auth;
use App\Mail\feedbackMail;
use Mail;


class ReportController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function abuseReport(Request $request){
        $report = ReportAbuse::simplePaginate(10);
        if(isset($request->sort) && $request->sort !==''){
            $report = ReportAbuse::where('type_of_report', $request->sort)->simplePaginate(10);
        }
        return view('admin.report.abuseReport',compact('report'));;
    }

    public function feedbacks(Request $request){

        $feedbacks = Feedback::with('user')->orderBy('id','desc')->simplePaginate(10);
        if(isset($request->sort) && $request->sort !=='' ){
            
            $feedbacks = Feedback::with('user')->where('type_of_issue',$request->sort)->orderBy('id','desc')->simplePaginate(10);
        }
        return view('admin.report.feedback',compact('feedbacks'));
    }

    public function detailReport($id){
        $report = ReportAbuse::find($id);
    }

    public function feedbackAndSupport(){
        return view('admin.report.feedbackandsupport');
    }

    public function saveFeedback(Request $request){
        $data = $request->validate([
            'sbject' => 'required',
            'type_of_issue' => 'required',
            'message' => 'required',
        ]);
        $data['user_id']  = Auth::user()->id;

        Feedback::create($data);
        
        $userData['user'] = [
            'name' => Auth::user()->name,
            'email' => Auth::user()->email,
            'sbject' => $request->sbject,
            'type_of_issue' => $request->type_of_issue,
            'message' =>$request->message
        ];
        $res = Mail::send('mail.feedbackMail', $userData, function($message)use($userData) {
                $message->to('support@hithere.co.nz', '')
                ->subject('Feedback Mail');
                // ->attachData($pdf->output(), "invoice.pdf");
                });
        return redirect()->back()->with('success','Thanks for providing feedback/support. Our team will contact you as soon as possible...');
    }
}
