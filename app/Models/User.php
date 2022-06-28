<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laratrust\Traits\LaratrustUserTrait;
// use Laravel\Sanctum\HasApiTokens;
// use Spatie\Permission\Traits\HasRoles;
// use Laratrust\Traits\LaratrustUserTrait;
// use Laravel\Sanctum\HasApiTokens;
// use Spatie\Permission\Traits\HasRoles;
use Laravel\Passport\HasApiTokens;
// use Laravel\Sanctum\PersonalAccessToken as SanctumPersonalAccessToken;
use Illuminate\Database\Eloquent\SoftDeletes;


class User extends Authenticatable
{
    use LaratrustUserTrait;
    use HasApiTokens, HasFactory, Notifiable , SoftDeletes;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];
    
    // protected $fillable = [
    //     'name',
    //     'email',
    //     'password',
    // ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        // 'api_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function order_details(){
        return $this->hasMany(Order::class,'user_id','id');
    }

    public function image(){
        return $this->belongsTo(Document::class, 'id','product_id')->where('doc_type','user');
    }

    public function unreadMessage(){
        return $this->hasMany(UnreadMessage::class,'userId');
    }
    // public function get_users(){
    //     return $this->hasMany(ChatWithSeller::class,'user_id');
    // }
}
