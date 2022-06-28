<?php

use App\Models\ChatroomUser;
use App\Models\UnreadMessage;
use App\Models\Orders;
use App\Models\OrderItem;
use App\Models\Province;
use App\Models\Payout;
use App\Models\User;
use App\Models\Product;
use App\Models\PaymentHistory;
use App\Models\Chatrooms;
use App\Models\ChatroomMessages;
use App\Models\Feedback;
use App\Models\Template;
use App\Models\Transaction;
use App\Models\Refund;

if (!function_exists('document_upload')) {
    function document_upload($file,$folder,$data='',$fieldName=null){      
        if(!empty($data)){
            // dd($data);
            if($data->doc_path){
               Storage::delete('public'.$data->doc_path);
            }
        }
        $name =  time().'_'.$file->getClientOriginalName();
        // dd($name);
        $mime =  $file->getClientMimeType();
        $size =  $file->getSize();
        $file->storeAs('public/'.$folder, $name);
        $path = $folder.'/'.$name;

        return [
          'doc_name' => $name,
          'doc_mime' => $mime,
          'doc_size' => $size,
          'doc_path' => $path,
        ];
    }
}

if (!function_exists('chatrooms')) {
    function chatrooms(){  
        $userId = auth()->user()->id;
        $chatrooms = ChatroomUser::where('UserId',$userId)->select('chatroom_id')->get();
        $chatroomsIds = [];
        foreach($chatrooms as $ids ){
            $chatroomsIds[] = $ids->chatroom_id; 
        }
        return (json_encode($chatroomsIds));
    }    
}

if (!function_exists('notification')) {
    function notification(){  
        $data = auth()->user()->unreadNotifications;
        return view('admin.notification.notification',compact('data'));
    }    
}


if (!function_exists('notificationList')) {
    function notificationList(){  
        $data = auth()->user()->unreadNotifications;
        return $data;
    }    
}

if (!function_exists('notiCount')) {
    function notiCount(){  
        $data = count(auth()->user()->unreadNotifications);
        return $data;
    }    
}

if (!function_exists('total_earn')) {
    function total_earn(){  
        $data = Orders::with('get_order_items')->where('seller_id',auth()->user()->id)->get();
        $total= 0;
        $dis= 0;
        foreach ($data as $key => $value) {
            $total += OrderItem::where('order_id',$value->id)->whereIn('status',['confirmed','shipped','delivered'])->sum('amount') ;
            $dis += OrderItem::where('order_id',$value->id)->whereIn('status',['confirmed','shipped','delivered'])->sum('discount_amount') ;
            $total = $total - $dis;
        }
        return $total;
    }    
}

if (!function_exists('total_loss')) {
    function total_loss(){  
        $data = Orders::where('seller_id',auth()->user()->id)->where(['status'=>NULL])->sum('total_price');
        $data1 = Orders::where('seller_id',auth()->user()->id)->where(['status'=>'reject'])->sum('total_price');
        return $data+$data1;
    }    
}

if (!function_exists('isPending')) {
    function isPending(){  
        $data = Orders::where('seller_id',auth()->user()->id)->where(['status'=>NULL])->count();
        return $data;
    }    
}

if (!function_exists('allPendingOrder')) {
    function allPendingOrder(){  
        $data = Orders::where('seller_id',auth()->user()->id)->where(['status'=>NULL])->get();
        return view('admin.order.pendingProduct',compact('data'));
    }    
}

if (!function_exists('acountDetails')) {
    function acountDetails(){  
        if(!auth()->user()->account_number  || !auth()->user()->account_name){
            return false; 
        }
        return true;
        // return view('admin.order.pendingProduct',compact('data'));
    }    
}

if (!function_exists('getAllProvince')) {
    function getAllProvince(){  
        return Province::all();
    }    
}

if (!function_exists('userImage')) {
    function userImage(){  
        $user = User::with('image')->find(auth()->user()->id);
        if($user->image){
            return url('/storage').$user->image->doc_path;
        }
        return 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQ31DmEt-YVwkvB-WcdLOg83zEcRHeOkGl8ng&usqp=CAU';
    }    
}

if (!function_exists('productReviewMsg')) {
    function productReviewMsg(){  
        $product = Product::where(['user_id'=>auth()->user()->id])->count();
        $productTo = Product::where(['user_id'=>auth()->user()->id,'status'=>'inreview'])->count();
        
        if($product === 1 && $product === $productTo){
            return true;
        }
        return false;
    }    
}

if (!function_exists('pendingOrder')) {
    function pendingOrder(){  
        $order = Orders::where(['seller_id'=>auth()->user()->id,'status'=>'placed'])->count();
        if($order > 0){
            return true;
        }
        return false;
    }    
}

if (!function_exists('totalOrder')) {
    function totalOrder(){  
        $order = Orders::where(['seller_id'=>auth()->user()->id])->count();
        $orderTo = Orders::where(['seller_id'=>auth()->user()->id,'status'=>'placed'])->count();

        if($order === 1 || $order === $orderTo){
            return true;
        }
        return false;
    }    
}

if (!function_exists('allFieldRequired')) {
    function allFieldRequired(){  
        $user = auth()->user();
        if( !empty($user->gender) && !empty($user->dob) && !empty($user->business_name) && !empty($user->city) && !empty($user->state) ) {
            return true;
        }
        return false;
    }    
}

if (!function_exists('totalOrderPrice')) {
    function totalOrderPrice($orderId){  
        $orderItems = OrderItem::where('order_id',$orderId)->get();
        $price = 0;
        $shipping = 0;
        foreach($orderItems as $order){
            $price += ($order->amount - $order->discount_amount);
            $shipping += ($order->get_product->shipping_price*$order->quantity);
        }
        
        return $price+$shipping;
    }    
}

if (!function_exists('totalOrderProduct')) {
    function totalOrderProduct($orderId){  
        return $orderItems = OrderItem::where('order_id',$orderId)->sum('quantity');
      
    }    
}

if (!function_exists('myOrder')) {
    function myOrder(){  
        $order = Orders::where(['seller_id'=>auth()->user()->id,'status'=>'placed'])->count();
        return $order;
    }    
}

if (!function_exists('myPayout')) {
    function myPayout(){  
        $order = Payout::where(['status'=>'pending'])->count();
        return $order;
    }    
}

if (!function_exists('productInreview')) {
    function productInreview(){  
        $product = Product::where(['status'=>'inreview'])->count();
        return $product;
    }    
}

if (!function_exists('changeOrderStatus')) {
    function changeOrderStatus(){  
        Product::where(['user_id'=>auth()->user()->id,'qty'=>0])->update(['status'=>'inactive']);
        Product::where('user_id',auth()->user()->id)->where('end_date','<',date('Y-m-d'))->update(['status'=>'inactive']);
    }    
}
if (!function_exists('removeSession')) {
    function removeSession(){  
        session()->forget('success');
    }    
}

if (!function_exists('myChat')) {
    function myChat(){  
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
}

if (!function_exists('delete_user')) {
        function delete_user(){ 
        // $deleteUser = User::withTrashed()->get();
        $deleteUser = DB::table('users')->whereNotNull('deleted_at')->get();
        $deleteOrder = DB::table('orders')->whereNotNull('deleted_at')->get();
      
        foreach($deleteUser as $chatdelt){
            // dd($chatdelt);
             Orders::where('user_id',$chatdelt->id)->delete();
             Payout::where('seller_id',$chatdelt->id)->delete();
             Chatrooms::where('initiator_id',$chatdelt->id)->delete();
             Product::where('user_id',$chatdelt->id)->delete();
             ChatroomMessages::where('senderId',$chatdelt->id)->delete();
             ChatroomUser::where('UserId',$chatdelt->id)->delete();
             Feedback::where('user_id',$chatdelt->id)->delete();
             Template::where('user_id',$chatdelt->id)->delete();
             Transaction::where('seller_id',$chatdelt->id)->delete();
             Refund::where('order_id',$chatdelt->id)->delete();
             PaymentHistory::where('order_id',$chatdelt->id)->delete();
             
        }

        foreach($deleteOrder as $orderdelt){
            Refund::where('order_id',$orderdelt->id)->delete();
            PaymentHistory::where('order_id',$orderdelt->id)->delete();                
       }

        
        
        }    
    }

    if(!function_exists('same_method')){
        function same_method($paymentId){
            $method = PaymentHistory::where('payment_method',$paymentId)->get();
            $total = 0;
            foreach($method as $methods){
                $order = Orders::find($methods->order_id);
                $total += $order->shipping ? $order->shipping_price + $order->total_price : $order->total_price;
            }
            return (float) number_format($total+ ((($total * 3.5) / 100)+0.30),2);
            
        }
    }

    if(!function_exists('updateForfotPasswordUser')){
        function updateForfotPasswordUser(){
            $user = DB::table('password_resets')->get();
            foreach($user as $User){
                $userUpdate = User::where('email',$User->email)->update(['email_verified_at'=>date('Y-m-d H:i:s'),'status'=>'A']);
            }
            
        }
    }


?>