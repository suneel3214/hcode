<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
    public function login(Request $request)
    {

       $getUser =  user::where('email',$request->email)->first();
        $this->validateLogin($request);
        if (!empty($getUser)) {
            if($getUser->user_role == 4 || $getUser->user_role == 1 || $getUser->user_role == 2 && (!empty($getUser->email_verified_at)) ){
                if($getUser->status!="P"){
                    if (method_exists($this, 'hasTooManyLoginAttempts') &&
                        $this->hasTooManyLoginAttempts($request)) {
                        $this->fireLockoutEvent($request);

                        return $this->sendLockoutResponse($request);
                    }
                    if($this->guard()->validate($this->credentials($request))){
                        $user = $this->guard()->getLastAttempted();
                        if($user->email_verified_at !=null && $this->attemptLogin($request)) {
                            return $this->sendLoginResponse($request);                
                        }else{
                        //   $this->incrementLoginAttempts($request);
                          //$user->code = SendCode::sendCode($user->phone);
                          if($user->save()){
                             return redirect()->back()->with('warning','Your account is not active. We already sent activation link, Check your email and click on the link to verify your email');
                          }
                        }
                    }
                }
            $this->incrementLoginAttempts($request);

            return $this->sendFailedLoginResponse($request);
        }
        }else{
            return redirect()->route('register')->with('warning','User not register please register now...');
        }
    }
}
