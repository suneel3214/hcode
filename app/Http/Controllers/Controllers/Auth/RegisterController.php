<?php

namespace App\Http\Controllers\Auth;

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
use Laravel\Passport\HasApiTokens;

class RegisterController extends Controller
{
    use HasApiTokens;

    use RegistersUsers;

   
    public function __construct()
    {
        $this->middleware('guest');
    }

 
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
            'captcha'  => ['required','captcha']
            
        ],
        [
            'captcha.captcha'=>'Invalid captcha code.'
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

    protected function create(array $data)
    {
       

        $role_id = $data['user_role'] == 'buyer' ? '3' : ($data['user_role'] == 'seller' ? '4' : '5');
  
        $data = [
            'name' 		=>  $data['f_name'].' '.$data['l_name'],
           'email' 	=> $data['email'],
           'password' 	=> Hash::make($data['password']),
        //    'country' 	=> $data['country'],
           'f_name'	=> $data['f_name'],
           'l_name' 	=> $data['l_name'],
           'dob'		=> $data['dob'],
           'phone_no' 	=> $data['phone_no'],
        //    'gender' 	=> $data['gender'],
        //    'address' 	=> $data['address'],
           'district_town' => $data['district_town'],
           'remember_token'=> Str::random(40),
           'user_role' 	=> $role_id,
           'business_name' => $data['business_name'],
           'address_finder' => $data['address_finder'],
        //    'billing_address'=> $data['billing_address'],
           'nz_business_no'=> $data['nz_business_no'],
           'nz_gst_no' 	=> $data['nz_gst_no']

       ];
    //   dd($data);
       $user = User::create($data);
       $token = $user->createToken($this->generateRandomString())->accessToken;

        $response = [
            'user' => $user,
            'token' => $token
        ];

       // $user->update($response); 
       $user->attachRole($role_id);
    // return $user;
     Mail::to($user->email)->send(new VerifyMail($user));
    //    return view('home');
    return $user;


    }
    public function register(Request $request)
    {
        $this->validator($request->all())->validate();
        event(new Registered($user = $this->create($request->all())));

        return $this->registered($request, $user)
                        ?: redirect('/login')->with('success','We sent activation link, Check your email and click on the link to verify your email');


  }

}
