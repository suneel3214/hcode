<?php

namespace App\Http\Controllers\Admin\chatwithUser;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Models\ChatWithSeller;
use App\Models\User;

class ChatWithUserController extends Controller
{
    public function chatWithUser(){
    $sellerId = Auth::user()->id;

       $getUsers = ChatWithSeller::where('seller_id',$sellerId)->with('get_users')->get();
       $array = [];
       foreach($getUsers as $getUser){
        foreach($getUser->get_users as $userId){
        $array[] = $userId->id;
        }
       }
       $uniqe = array_unique($array);
       $users = [];
       foreach($uniqe as $users_id){
        $users[] = User::where('id',$users_id)->first();
       }
       // dd(($users));
        return view('admin.chatwithuser.index',compact('users'));
    }

    public function userMessages(Request $request){
        $sellerId = Auth::user()->id;
         $messages = ChatWithSeller::where('user_id',$request->userId)->where('seller_id',$sellerId)->get();
         return view('admin.chatwithuser.messages',compact('messages'));
    }
}
