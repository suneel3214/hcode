<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatWithSeller extends Model
{
    use HasFactory;

    protected $table = 'chat_with_sellers';
    protected $guarded = [];

    public function get_users(){
        return $this->hasMany(User::class,'id','user_id');
    }
}
