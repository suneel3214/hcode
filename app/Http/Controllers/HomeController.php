<?php

namespace App\Http\Controllers;

use App\Http\Repositories\Admin\CategoryRepository;
use Illuminate\Http\Request;
use App\Models\PlaceBid;
use App\Models\User;
use App\Models\Order;
use App\Models\Activity;
use App\Models\Product;
use App\Models\Document;
use App\Models\Province;
use App\Models\ChatroomUser;
use App\Models\ChatroomMessages;
use Carbon\Carbon;
use App\Models\UnreadMessage;
use App\Models\Region;
use Auth;
use DB;


class HomeController extends Controller
{
    private $categoryRepo;
    private $subCategoryRepo;
   
    public function __construct(CategoryRepository $categoryRepo)
    {
        $this->middleware('auth');
        $this->categoryRepo = $categoryRepo;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if(Auth::user()->user_role===4){
            return redirect('/products');
        }
        $category = $this->categoryRepo->all();
        User::find(Auth::user()->id)->update(['online_status'=>1]);
        $user = User::where(['user_role'=>3,'status'=>'A'])->count();
        $seller = User::where(['user_role'=>4,'status'=>'A'])->count();
        $product = Product::where(['status'=>'A'])->count();
        $cityName = User::where('user_role',4)->orderBy('city')->get()->groupBy('city');
        $cityNameUser = User::where('user_role',3)->orderBy('city')->get()->groupBy('city');
        $monthName=['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sept','Oct','Nov','Dec'];
        $monthArrayOne = [];
        $monthArrayHundrad = [];
        $monthArrayBid = [];
        $monthUser = [];
        $monthSeller = [];
        foreach($monthName as $Month){
            $monthArrayOne[] = Product::where(['month'=>$Month,'price'=>1,'status'=>'A'])->count(); 
            $monthArrayHundrad[] = Product::where(['month'=>$Month,'status'=>'A'])->where('price','<=',100)->count(); 
            $monthArrayBid[] = Product::where(['month'=>$Month,'status'=>'A'])->where('bid_option',1)->count(); 
            $monthUser[] = User::where(['user_role'=>3,'status'=>'A','month'=>$Month])->count();
            $monthSeller[] = User::where(['user_role'=>4,'status'=>'A','month'=>$Month])->count();
        }
        // dd($monthSeller);
        $circulChart = [];
        $circulChartUser = [];
        foreach($cityName as $key=>$city){
            $circulChart[] = ['value'=>count($city),'name'=>$key];
        }
        foreach($cityNameUser as $key=>$city){
            $circulChartUser[] = ['value'=>count($city),'name'=>$key];
        }

       
        // mycode start
         $totalproduct = Product::count();
         $totalorder = Order::count();

        //  $date_wise_user = User::where('created_at')->count();
        // $date_wise_user =   User::whereDate('created_at', Carbon::today())->count(['created_at']);

        $date_wise_user =   User::select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as total'))
        ->where(['user_role'=>4,'status'=>'A'])
        ->groupBy('date')
        ->orderBy('date', 'desc')
        ->take(7)
        ->get();

        $recent_order =   Order::select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as total'))
        ->groupBy('date')
        ->orderBy('date', 'desc')
        ->take(2)
        ->get();

        $chatMessage = ChatroomMessages::count();
        $chatRoomUser = DB::table('chatroom_users')
        ->select('UserId')
        ->groupBy('UserId')
        ->get();

        $chatRoomUserCount = $chatRoomUser->count();

        //  dd($chatRoomUserCount);
        // mycode end


        $mostActiveUsers = Activity::whereHas('getUser')->with(['getUser'])->orderBy('total_count','DESC')->get();
       
        return view('welcome',compact('user','seller','product','circulChart','circulChartUser'
        ,'monthArrayOne','monthArrayHundrad','monthArrayBid','monthSeller','monthUser',
        'mostActiveUsers','totalproduct','totalorder','date_wise_user','recent_order','chatMessage','chatRoomUserCount'));
    }
    // in used test function

    public function test(Request $request){
        $id = $request->proId;
        if(!empty($request->file)){
            foreach ($request->file as $key => $image) {
                if($request->hasFile('file.'.$key)){
                    $docs =  document_upload($request->file[$key],Auth::user()->id.'/Product_images');
                }
                // if($request->type === 'edit'){
                //     Document::where(['product_id'=>$id,'doc_type'=>'product'])->delete();    
                // }
                $docs['product_id'] = $id; 
                $docs['doc_type'] = 'product'; 
                $docs['order'] = $key+1; 
                Document::create($docs);
            }
        }
    }

    public function unreadMessageCount(){
        $chat = ChatroomUser::where(['UserId'=>auth()->user()->id])->get();
        $array = [];
        foreach($chat  as $chatRoom){
            $array[] = $chatRoom->chatroom_id;
        }

        $count  = UnreadMessage::whereIn('chatroomId',$array)->where('UserId','!=',auth()->user()->id)->count();
        if($count > 0){
            return "<span class='badge badge-warning text-white count mychatCount' style='background-color:red'>".$count."
                                </span>";
        }
        else{
            return json_encode($count);
        }
    } 
    
    public function deleteUnreadMessage(){
        return UnreadMessage::where(['deleted_at'=>NULL,'userId'=>(int)Auth::user()->id])->delete();
    }
}
