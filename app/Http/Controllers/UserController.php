<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use App\Models\ChatroomUser;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ServiceType;
use App\Models\Document;
use App\Models\Region;
use App\Models\Notification;
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
        // return $request->all();
        $user= User::where('email', $request->email)->first();
            if (!$user || !Hash::check($request->password, $user->password)) {
                return response([
                    'message' => ['These credentials do not match our records.']
                ], 422);
            }
            if ($user->email_verified_at !=null) {
                if ($user->status ==='P') {
                    return response(['message'=>'Your account is not active..'],422);    
                }
                User::where('id',$user->id)->update(['online_status'=>1]);

                // $token = $user->createToken('my-app-token')->plainTextToken;
                $token = $user->createToken($this->generateRandomString())->accessToken;
                $chatrooms = ChatroomUser::where('UserId',$user->id)->select('chatroom_id')->get();

                $chatroomsIds = [];
                foreach($chatrooms as $ids ){
                    $chatroomsIds[] = $ids->chatroom_id; 
                }

                $response = [
                    'user' => $user,
                    'token' => $token,
                    'chatrooms'=>json_encode($chatroomsIds)
                ];
                // return $token ;
            User::where('id',$user->id)->update(['api_token'=>$token]);
             return response($response, 200);
            }else{
                return response(['message'=>'Your account is not active. We already sent activation link, Check your email and click on the link to verify your email'],422);
            }
           
    }

    public function loginWithSocial(Request $request)
    {
        $name = explode(' ',$request->name);
        $user= User::where('email', $request->email)->first();
        $role_id =  '4' ;
        if($user && Hash::check($request->id, $user->password)){
            $token = $user->createToken($this->generateRandomString())->accessToken;
            $response = [
                'user' => $user,
                'token' => $token
            ];
            User::where('id',$user->id)->update(['api_token'=>$token]);
            return response($response, 200);
        }else{
            $data = [
                'name'      => $name[0].' '. isset($name[1]) ? $name[1]:'',
                'f_name'      =>$name[0],
                'l_name'      =>isset($name[1]) ? $name[1]:'',
                'email'     => $request->email,
                'password'  => Hash::make($request->id),
                'user_role'  => $role_id,
            ];
            if(!$user){
                $user = User::create($data);
                $user->attachRole($role_id);
            }
            else{
                $user = User::where('id',$user->id)->update($data);
                $user= User::where('email', $request->email)->first();
            }
            $token = $user->createToken($this->generateRandomString())->accessToken;
            $response = [
                'user' => $user,
                'token' => $token
            ];
            User::where('id',$user->id)->update(['api_token'=>$token]);
            return response($response, 200);
        }
           
    }

    public function userRegister(Request $request){

        $role_id =  '4' ;
         $request->validate([
            'email'     => 'required|email|unique:users',
            'password'  => 'required', 'string','min:6',            
            'f_name'    => 'required',
            'l_name'    => 'required',
            'city'      => 'required',
            'phone_no'  => 'required | string | unique:users,phone_no',
            'address'   => 'required',
            // 'billing_address'   => 'required',
            // 'gender'    => 'required',
            // 'dob'    => 'required',
            // 'terms'    => 'required',
            // 'password_confirmation' => 'required_with:password|same:password|min:6'

        ]);
        // dd($request->all());    
        $data = [
            'name'      => $request['f_name'].' '.$request['l_name'],
            'email'     => $request['email'],
            'password'  => Hash::make($request['password']),
            'country'   => 'New Zealand',
            // 'gender'    => $request['gender'],
            'f_name'    => $request['f_name'],
            'l_name'    => $request['l_name'],
            // 'dob'        => $request['dob'],
            'phone_no'  => $request['phone_no'],
            'address'   => $request['address'],
            // 'district_town' => $request['district_town'],
            'remember_token'=> Str::random(40),
            'user_role'     => $role_id,
            'city' => $request['city'],
            // 'nz_gst_no' => $request['nz_gst_no'],
            // 'business_name'=> $request['business_name'],
            // 'nz_business_no'=> $request['nz_business_no'],
            // 'billing_address'=> $request['billing_address'],
            // 'address_finder'=> $request['address_finder'],

        ];
       // return($data);
       $user = User::create($data);
       if(!empty($user)){

       // $token = $user->createToken($this->generateRandomString())->accessToken;

            $user->attachRole($role_id);
            Mail::to($user->email)->send(new VerifyMail($user));
            return response()->json(['message'=>'We have sent you an verification email. Please verify...'],200);
       }else{
         return response()->json(['message'=>'user already exist'],422);
       }


    }
    public function register(Request $request)
    {
    
        $this->validator($request->all())->validate();
        event(new Registered($user = $this->create($request->all())));
        return $this->registered($request, $user)
                        ?: redirect('http://localhost:3000/login')->with('success','We sent activation link, Check your email and click on the link to verify your email');


    }

    public function getUserInfo(){
        $user = Auth::guard('api')->user();
        $token = User::select('api_token')->find($user->id);
        $chatrooms = ChatroomUser::where('UserId',$user->id)->select('chatroom_id')->get();

        $chatroomsIds = [];
        foreach($chatrooms as $ids ){
            $chatroomsIds[] = $ids->chatroom_id; 
        }

        $response = [
            'user' => $user,
            'token' => $token->api_token,
            'chatrooms'=>json_encode($chatroomsIds)
        ];
        
        return response($response, 200);
    }

    public function profileUpdate(Request $request){
        $id = Auth::guard('api')->user()->id;

        $request->validate([
            'country'   => 'required',
            'f_name'    => 'required',
            'l_name'    => 'required',
            'city'      => 'required',
            'phone_no'  => 'required',
            'address'   => 'required',
            // 'district_town' => 'required'
        ]);
        $data = [
            'name'      => $request['f_name'].' '.$request['l_name'],
            'country'   => $request['country'],
            'f_name'    => $request['f_name'],
            'l_name'    => $request['l_name'],
            'phone_no'  => $request['phone_no'],
            'address'   => $request['address'],
        ];

        if(User::find($id)->update($data)){
            $user = Auth::guard('api')->user();
            $response = [
                'user' => $user
            ];
            return response($response, 200); 
        }
        else{
            return response()->json([
                'message'=>'Something went wrong...',
            ],422);
        }
    }

    public function logout(){
        $customer = User::find(Auth::guard('api')->user()->id);
        if ($customer) {
            $customer->api_token = null;
            $customer->online_status = 0;
            $customer->save();
            return 'Logout success...';
        }
    }

    public function editProfile(){
        $user = User::with('image')->find(Auth::user()->id);
        return view('admin.profile.update',compact('user'));
    }
    public function updateProfile(Request $request){
        $oldData = User::with('image')->find(auth()->user()->id);

        $data = $request->validate([
                    'country'   => 'required',
                    'f_name'    => 'required',
                    'l_name'    => 'required',
                    'city'      => 'nullable',
                    'address_finder'   => 'required',
                    'billing_address'   => 'required',
                    'gender'    => 'required',
                    'dob'    => 'required',
                    'state'  => 'required',
                    'city'  => 'required',
                    'business_name' => 'required'
                ]);     

        if($request->phone_no ==='' || Auth::user()->phone_no !==$request->phone_no){
            $request->validate(['phone_no'  => 'required | string | unique:users',]);
            $data['phone_no'] = $request->phone_no;
        }
        if($request->password !==null){
            $request->validate([
                'password_confirmation' => 'required_with:password|same:password|min:8',
                'password'  => 'required', 'string','min:8',
                ]);
            $data['password'] = Hash::make($request['password']);
        }
        unset($data['image']);
        User::find(Auth::user()->id)->update($data);
        if(!empty($request->image)){
            if($request->hasFile('image')){
                $docs =  document_upload($request->image,'/user_images');
                $docs['product_id'] = Auth::user()->id; 
                $docs['doc_type'] = 'user'; 
                Document::create($docs);
            }
        }
        return redirect()->back()->with('success','Profile updated...');
    }

    public function getNotification(){
        $data['noti'] = notification();
        $data['count'] = notiCount();
        $data = auth()->user()->unreadNotifications;
         return view('admin.notification.notification',compact('data'));
    }
    public function addBankDetails(){
        $data = User::find(Auth::user()->id);
        return view('admin.profile.bank',compact('data'));
    }

    public function addBankDetailsUpdate(Request $request){
        $data =$request->validate([
                'account_number' => 'required|numeric',
                'account_name'=> 'required',
            ]);
        User::find(Auth::user()->id)->update($data);
        return redirect()->back()->with('success','You Bank Details Updated Successfully...');
    }

    public function listNotification(){
        $data = auth()->user()->unreadNotifications;
        return view('admin.notification.index',compact('data'));
    }

    public function verification_form(){
        return view('auth.passwords.verification');
    }

    public function verifysend(Request $request){

       $user = User::where('email',$request->email)->first();
       if(!empty($user)){
            Mail::to($user->email)->send(new VerifyMail($user));
            return redirect('/login')->with('success','We have sent verification mail on your email...');
       }else{
        return redirect('/login')->with('success','User not exist...');
       }    
    }

    public function verifylinksend(Request $request){

       $user = User::where('email',$request->email)->first();
       if(!empty($user)){
            Mail::to($user->email)->send(new VerifyMail($user));
            return response()->json([
                'message'=>'link send on your email...',
            ],200);
       }else{
        return response()->json([
                'message'=>'User not exist...',
            ],422);
       }    
    }


    public function readNotification($id){
        auth()->user()->unreadNotifications->where('id', $id)->markAsRead();
        $data = auth()->user()->unreadNotifications->whereNull('read_at');
        return view('admin.notification.index',compact('data'));
    }

    public function getRegions($provinceId,$selected=''){
        $region = Region::where('province_id',$provinceId)->get();
        foreach($region as $Region){ ?>
            <option <?php echo (int)$selected === $Region->id ? 'selected=selected' : ''; ?> value="<?php echo $Region->id; ?>"><?php echo $Region->name; ?></option>
        <?php 
        }
    }

}
