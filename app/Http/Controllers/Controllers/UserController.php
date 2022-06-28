<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ServiceType;
use Illuminate\Auth\Events\Registered;
use Mail;
use App\Mail\VerifyMail;
use Illuminate\Support\Str;

class UserController extends Controller
{
    // 
    public function __construct()
    {
        // $this->middleware('guest');
        // $this->middleware('VerifyTemplate');

    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6', 'confirmed']
            
        ]);
    }
    function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

   public function userLogin(Request $request)
    {
        $user= User::where('email', $request->email)->first();
            if (!$user || !Hash::check($request->password, $user->password)) {
                return response([
                    'message' => ['These credentials do not match our records.']
                ], 404);
            }
        	if ($user->email_verified_at !=null && $user->user_role ==3) {
	            // $token = $user->createToken('my-app-token')->plainTextToken;
                $token = $user->createToken($this->generateRandomString())->accessToken;
	            $response = [
	                'user' => $user,
	                'token' => $token
	            ];
                // return $token ;
            User::where('id',$user->id)->update(['api_token'=>$token]);
             return response($response, 200);
        	}else{
        		return response('Your account is not active. We already sent activation link, Check your email and click on the link to verify your email',201);
        	}
           
    }

    public function loginWithSocial(Request $request)
    {
        return $request->all();
        $user= User::where('email', $request->email)->first();
            if (!$user || !Hash::check($request->password, $user->password)) {
                return response([
                    'message' => ['These credentials do not match our records.']
                ], 404);
            }
            if ($user->email_verified_at !=null && $user->user_role ==3) {
                // $token = $user->createToken('my-app-token')->plainTextToken;
                $token = $user->createToken($this->generateRandomString())->accessToken;
                $response = [
                    'user' => $user,
                    'token' => $token
                ];
                // return $token ;
            User::where('id',$user->id)->update(['api_token'=>$token]);
             return response($response, 200);
            }else{
                return response('Your account is not active. We already sent activation link, Check your email and click on the link to verify your email',201);
            }
           
    }


    public function userRegister(Request $request){
        $role_id =  '3' ;
    	 // $request->validate([
      //       'email' 	=> 'required', 'string', 'email', 'max:255', 'unique:users',
      //       'password'  => 'required', 'string', 'min:6', 'confirmed',
      //       'country' 	=> 'required',
      //       'f_name' 	=> 'required',
      //       'l_name' 	=> 'required',
      //       'dob' 		=> 'required',
      //       'phone_no' 	=> 'required',
      //       'gender' 	=> 'required',
      //       'address' 	=> 'required',
      //       'district_town' => 'required'
      //   ]);
        $data = [
            'name' 		=> $request['f_name'],
            'email' 	=> $request['email'],
            'password' 	=> Hash::make($request['password']),
            'country' 	=> $request['country'],
            'f_name'	=> $request['f_name'],
            'l_name' 	=> $request['l_name'],
            'dob'		=> $request['dob'],
            'phone_no' 	=> $request['phone_no'],
            'gender' 	=> $request['gender'],
            'address' 	=> $request['address'],
            'district_town' => $request['district_town'],
            'remember_token'=> Str::random(40),
            'user_role' 	=> $role_id,
            'city' => $request['city'],
    		'state' => $request['state'],
    		'zip'=> $request['zip']

        ];
       // return($data);
       $user = User::create($data);
       if(!empty($user)){

       $token = $user->createToken($this->generateRandomString())->accessToken;

        $response = [
            'user' => $user,
            'token' => $token
        ];

       $user->attachRole($role_id);
         Mail::to($user->email)->send(new VerifyMail($user));
         return $response;
       }else{
         return Response::json('status',201);
       }


    }
    public function register(Request $request)
    {
        $this->validator($request->all())->validate();
        event(new Registered($user = $this->create($request->all())));
        return $this->registered($request, $user)
                        ?: redirect('http://localhost:3000/login')->with('success','We sent activation link, Check your email and click on the link to verify your email');


    }
    public function getUserInfo($token){
        $userId = Auth::guard('api')->user()->id;

        $userInfo = User::where('id',$userId)->with('order_details')->first();
        return response($userInfo, 200);

    }

}
