<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatroomUser extends Model
{
    use HasFactory;
    protected $table = 'chatroom_users';
    protected $guarded = [];

    public function user(){
        return $this->belongsTo(User::class,'UserId')->select('id','name','email','phone_no','user_role','online_status');
    }
}
