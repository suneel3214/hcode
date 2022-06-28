<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class VerifyController extends Controller
{
    
    public function postVerfiy(Request $request){

    	dd( $request);
    	if($user = User::where('otp',$request->code)->first()){
    		$user->mobile_verified_at = date('Y-m-d h:i:s');
    		$user->status = 'A';
    		$user->otp = null;
    		$user->save();
    		return redirect()->route('login')->with('success','Your mobile number is active.'); 
    	}else{
    		return back()->with('warning','Verify code is not correct. Please try again'); 
    	}
    }

    public function verifyUser($token)
    {
      	$user = User::where('remember_token',$token)->first();

        if($user->email_verified_at == null && $user->user_role == 4){
        	$user->email_verified_at = date('Y-m-d h:i:s');
            $user->status = 'A';
        	$user->save();
        	return redirect()->route('login')->with('success','Your e-mail is verified. You can now login.'); 
        }else if($user->email_verified_at == null && $user->user_role == 3){
            $user->email_verified_at = date('Y-m-d h:i:s');
            $user->status = 'A';
            $user->save();
            return redirect('http://localhost:3000/login')->with('success','Your e-mail is verified. You can now login.');
        }else{
            return redirect()->route('login')->with('success','Your e-mail is already verified. You can now login.'); 

        }

    }
    
    public function resendVerifyCode(){    	
    	if($user = User::where('mobile',request()->get('phone'))->first()){
    		$user->otp = SendCode::sendCode($user->mobile); 
            $user->save();
            return "success";
    	}else{
    		return "warning";
    	}
    }
    public function resendVerifyMail(){     
        if($user = User::where('mobile',request()->get('phone'))->first()){
            $user->otp = SendCode::sendCode($user->mobile); 
            $user->save();
            return "success";
        }else{
            return "warning";
        }
    }


    // public function get_states($id){
    //     return State::where('country_code',$id)->orderBy('state_name')->get();
    // }

    // public function get_cities($id){
    //     return City::where('state_code',$id)->orderBy('city_name')->get();
    // }
    public function refreshCaptcha() {
      
        return captcha_img('math');
    }
    

    // public function contactStore(Request $request){
    //     $request->validate([
    //         'name'      => 'required',
    //         'email'     => 'required|email',
    //         'mobile'    => 'required|min:10|max:10',
    //         'subject'   => 'required|min:4|max:200',
    //         'message'   => 'required',
    //         'captcha'   => 'required|captcha',
    //     ],
    //     [
    //         'captcha.captcha'=>'Invalid captcha code.'
    //     ]);

    //     $data = [
    //         'name' => $request->name,
    //         'user_id' => session('user.id'),
    //         'email' => $request->email,
    //         'mobile' => $request->mobile,
    //         'subject' => $request->subject,
    //         'message' => $request->message,
    //     ];
    //     Contact::create($data);
    //     return redirect()->back()->with(['success'=>'Thank You! For Contact Us. We Will Contact You Soon...']);
    // }
}

