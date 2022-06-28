<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\Models\User;
use Auth;
use Session;

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
    // protected $redirectTo = RouteServiceProvider::HOME;
    protected function authenticated(Request $request, $user)
    {   
        $active = User::whereNotNull('email_verified_at')->where('email',$request->email)->first();
        $canLogin = User::where(['email'=>$request->email,'status'=>'A'])->first();

        if(!$active){
            Session::put('messageError','We have sent activation link on you mail please verify first.');
            $this->guard()->logout();
            return back()->withErrors([
                'messageError' => 'We have sent activation link on you mail please verify first.',
            ]);     
        }
        if(!$canLogin){
            Session::put('messageError','We have sent activation link on you mail please verify first.');
            $this->guard()->logout();
            return back()->withErrors([
                'messageError' => 'We have sent activation link on you mail please verify first.',
            ]);     
        }
        if(url()->current() === "https://dashboard.hithere.co.nz/login" && $user->user_role === 4){
            User::find(Auth::user()->id)->update(['online_status'=>0]);
            $this->guard()->logout();

            $request->session()->flush();

            $request->session()->regenerate();

            return back()->withErrors([
            'message' => 'Admin can login with this portal.',
            ]);
        }
        if (url()->current() === "https://seller.hithere.co.nz/login" && $user->user_role === 1) {
            User::find(Auth::user()->id)->update(['online_status'=>0]);
            $this->guard()->logout();

            $request->session()->flush();

            $request->session()->regenerate();

            return back()->withErrors([
            'message' => 'Seller can login with this portal.',
            ]);
        }
        User::find(Auth::user()->id)->update(['online_status'=>1]);

        // return redirect('/');
    }
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function authenticate(Request $request)
    {
        // dd('dfdf');
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
        // if()


        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->intended('dashboard');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    public function logout(Request $request)
    {
        if(!Auth::user()){
            return redirect('/');
        }
        User::find(Auth::user()->id)->update(['online_status'=>0]);
        $this->guard()->logout();

        $request->session()->flush();

        $request->session()->regenerate();

        return redirect('/');
    }
}
