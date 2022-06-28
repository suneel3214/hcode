<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ChatroomUser;
use App\Models\User;
use App\Models\ChatroomMessages;
use App\Models\UnreadMessage;
use Auth;

class ChatController extends Controller
{
    public function __construct()
    {

    }
    
    public function index()
    {
        $userId = Auth::user()->id;
        $chatrooms = ChatroomUser::where('UserId',$userId)->select('chatroom_id')->get();
        $chatroomsIds = [];
        foreach($chatrooms as $ids ){
            // return $ids;
            $chatroomsIds[] = $ids->chatroom_id; 
        }

        $chatuser = ChatroomUser::with(['user'=>function($unr){
            $unr->withCount('unreadMessage');
        }])->whereIn('chatroom_id',
            $chatroomsIds)->where('UserId','!=',$userId)->get();
        return view('admin.chat.chat',compact('chatuser'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        //
    }


    public function edit($id)
    {
        //
    }

    
    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }

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
        return view('admin.chat.contact',compact('chatuser'));
    }

    public function chatroomMessages($chatroomsId,$userId){
        $user = ChatroomUser::with('user')->where('chatroom_id',$chatroomsId)->where('UserId',$userId)->first(); 
        if(!empty($user)){
            $messages = ChatroomMessages::with('user')->where('chatroomId',$chatroomsId)->get();
            UnreadMessage::where(['chatroomId'=>$chatroomsId,'userId'=>(int)$userId])->delete();
            return view('admin.chat.chatarea',compact('messages','user'));
        }
    }

    public function getSingleMessage($userId,$chatroomId){
        $message = ChatroomMessages::with('user')->where(['senderId'=>Auth::user()->id,'chatroomId'=>$chatroomId])->orderBy('id', 'desc')->first();
        $message['to'] = (int)$userId;
        return $message ;
    }


    public function saveMessages(Request $request){

        $chatuser = ChatroomUser::where('chatroom_id',$request->chatroomId)->where('UserId','!=',$request->senderId)->first();
        $data['chatroomId'] = $request->chatroomId;
        $data['senderId'] = $request->senderId;
        $data['message'] = $request->message;
        $data['url'] = $request->url;

        $dupli = ChatroomMessages::where([
                                        'chatroomId'=>$request->chatroomId,
                                        'senderId'=>$request->senderId,
                                        'message'=>$request->message,   
                                        ])->orderBy('id','desc')->first();
        
        if(!$dupli){ 
                $dupli = ChatroomMessages::where([
                                        'chatroomId'=>$request->chatroomId,
                                        'senderId'=>$request->senderId,
                                        'message'=>$request->message,
                                        ])->where('created_at','<',date('Y-m-d H:i:s',strtotime("+5 seconds")))->first();
                if($dupli){
                    $message = ChatroomMessages::with('user')->find($dupli->id);
                    return view('admin.chat.updateChat',compact('message'));        
                }
            
                $lastId  = ChatroomMessages::create($data)->id;
                $message = ChatroomMessages::with('user')->find($lastId);
                if($request->selectedUser !== $request->senderId){ 
                    UnreadMessage::create(['chatroomId'=>$request->chatroomId,'userId'=>$request->senderId,'message_id'=>$message->id,'deleted_at'=>NULL]);
                }
            return view('admin.chat.updateChat',compact('message'));
        }
        else{
            
            if( (strtotime( date($dupli->created_at, strtotime("+5 seconds"))  )) < strtotime(date("m/d/Y h:i:s")) ){       
                
                $dupli = ChatroomMessages::where([
                                        'chatroomId'=>$request->chatroomId,
                                        'senderId'=>$request->senderId,
                                        'message'=>$request->message,
                                        ])->where('created_at',date('Y-m-d H:i:s'))->first();

                if($dupli){
                   $message = ChatroomMessages::with('user')->find($dupli->id);
                    return view('admin.chat.updateChat',compact('message'));
                }

                $lastId  = ChatroomMessages::create($data)->id;
                $message = ChatroomMessages::with('user')->find($lastId);
                if($request->selectedUser !== $request->senderId){ 
                    $unrd = UnreadMessage::create(['chatroomId'=>$request->chatroomId,'userId'=>$request->senderId,'message_id'=>$message->id,'deleted_at'=>NULL]);
                }
                return view('admin.chat.updateChat',compact('message'));
            }
            $message = ChatroomMessages::with('user')->find($dupli->id);
            return view('admin.chat.updateChat',compact('message'));
        }

    }

    public function getMessageById(Request $request){
        $message = ChatroomMessages::with('user')->find($request->id);
        if($request->selectedUser !== $request->senderId){ 
            UnreadMessage::create(['chatroomId'=>$request->chatroomId,'userId'=>$request->senderId,'message_id'=>$message->id,'deleted_at'=>NULL]);
        }   
        return view('admin.chat.updateChat',compact('message'));
    }

    public function OutsaveMessages(Request $request){
        $chatuser = ChatroomUser::where('chatroom_id',$request->chatroomId)->where('UserId','!=',$request->senderId)->first();
        $data['chatroomId'] = $request->chatroomId;
        $data['senderId'] = $request->senderId;
        $data['message'] = $request->message;

        $dupli = ChatroomMessages::where([ 
                                        'chatroomId'=>$request->chatroomId,
                                        'senderId'=>$request->senderId,
                                        'message'=>$request->message,
                                        ])->first();

        if($dupli){  
            if(strtotime($dupli->created_at) !== strtotime(date('Y-m-d H:i:s'))){
                $lastId  = ChatroomMessages::create($data)->id;
                $message = ChatroomMessages::with('user')->find($lastId);
                if($request->selectedUser !== $request->senderId){ 
                    UnreadMessage::create(['chatroomId'=>$request->chatroomId,'userId'=>$request->senderId,'message_id'=>$message->id,'deleted_at'=>NULL]);
                }
            return view('admin.chat.updateChat',compact('message'));
            }
        }else{
            $lastId  = ChatroomMessages::create($data)->id;
            $message = ChatroomMessages::with('user')->find($lastId);
            if($request->selectedUser !== $request->senderId){ 
                UnreadMessage::create(['chatroomId'=>$request->chatroomId,'userId'=>$request->senderId,'message_id'=>$message->id,'deleted_at'=>NULL]);
            }
        }

    }
}
