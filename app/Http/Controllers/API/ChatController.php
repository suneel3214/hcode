<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ChatroomUser;
use App\Models\Chatrooms;
use App\Models\ChatroomMessages;
use App\Models\UnreadMessage;
use App\Models\User;
use Auth;

class ChatController extends Controller
{
    public function getUser(){
        $userId = Auth::user()->id;
        $chatrooms = ChatroomUser::where('UserId',$userId)->select('chatroom_id')->get();
        $chatroomsIds = [];
        foreach($chatrooms as $ids ){
            $chatroomsIds[] = $ids->chatroom_id; 
        }

        $chatuser = ChatroomUser::with(['user'=>function($unr){
            $unr->withCount('unreadMessage');
        }])->whereIn('chatroom_id',
            $chatroomsIds)->where('UserId','!=',$userId)->get();
        UnreadMessage::whereIn('chatroomId',$chatroomsIds)->where('UserId',$userId)->delete();

        return $chatuser;
    }

    public function getMessages($chatroomsId ,$userId,$senderId=''){
        $chatuser = ChatroomUser::with('user')->where('chatroom_id',
            $chatroomsId)->where('UserId',$userId)->first(); 
        if($senderId !==''){
            $chatuser = ChatroomUser::with('user')->where('chatroom_id',
                $chatroomsId)->where('UserId',$senderId)->first();
        }
         UnreadMessage::where('chatroomId',$chatroomsId)->where('UserId',$userId)->delete();
        $messages = ChatroomMessages::with('user')->where('chatroomId',$chatroomsId)->get();
        $data['user'] = $chatuser;
        $data['messages'] = $messages;
        return $data;
    }
    public function startChat($sellerId){
        $newChatroom['initiator_id'] = Auth::guard('api')->user()->id; 
        $userRooms = ChatroomUser::where('UserId',Auth::guard('api')->user()->id)->select('chatroom_id')->get();
        $sellerRooms = ChatroomUser::where('UserId',$sellerId)->select('chatroom_id')->get();
        $u=[];
        $s=[];
        foreach($sellerRooms as $Seller){
            $s[] =  $Seller->chatroom_id;
        }
        foreach($userRooms as $User){
            if(in_array($User->chatroom_id, $s)){
                $u[] =  $User->chatroom_id;
            }
        }

        // $result = array_intersect($u,$s);
            // return $u;
        if(count($u)===0){
            $newChatId = Chatrooms::create($newChatroom)->id;
            $count = 0;
            $chatUsers = [(int)$sellerId,Auth::guard('api')->user()->id];

            while( 1 >= $count){
                ChatroomUser::create(['chatroom_id'=>$newChatId,'UserId'=>$chatUsers[$count] ]);
                $count++;
            }
            
            $chatuser = ChatroomUser::with('user')->where('chatroom_id',
                $newChatId )->where('UserId',$sellerId)->first(); 
            $messages = ChatroomMessages::with('user')->where('chatroomId',$newChatId)->get();
            $data['user'] = $chatuser;
            $data['messages'] = $messages;
            return $data;
        }
        else{
            $chatuser = ChatroomUser::with('user')->where('chatroom_id',
               $u[0] )->where('UserId',$sellerId)->first(); 
            $messages = ChatroomMessages::with('user')->where('chatroomId',$u[0])->get();
            $data['user'] = $chatuser;
            $data['messages'] = $messages;
            return $data;
        }
    }

    public function readMessage($chatroomId,$userId){
        UnreadMessage::where(['chatroomId'=>$chatroomId,'userId'=>$userId])->delete();
    }

    public function totalReadMessage(){
        $chat = ChatroomUser::where(['UserId'=>auth()->user()->id])->get();
        $array = [];
        foreach($chat  as $chatRoom){
            $array[] = $chatRoom->chatroom_id;
        }
        $count  = UnreadMessage::whereIn('chatroomId',$array)->whereNull('read_at')->count();
        return $count;
    }

     public function saveMessages(Request $request){
        
        $chatuser = ChatroomUser::where('chatroom_id',$request->chatroomId)->where('UserId','!=',$request->senderId)->first();
        $data['chatroomId'] = $request->chatroomId;
        $data['senderId'] = $request->senderId;
        $data['message'] = $request->message;
        $data['url'] = $request->url;

        $lastId  = ChatroomMessages::create($data)->id;
        $unrd = UnreadMessage::create(['chatroomId'=>$request->chatroomId,'userId'=>$request->senderId,'message_id'=>$lastId,'deleted_at'=>NULL]);
        return $lastId;
     
    }
}
