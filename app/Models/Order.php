<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory,SoftDeletes;

    protected $table = 'orders';
    protected $guarded = [];

    public function get_order_items(){
        return $this->hasMany(OrderItem::class,'order_id','id');
    }

    public function get_order_items_count(){
        return $this->hasMany(OrderItem::class,'order_id','id')->count();
    }

    public function get_user(){
        return $this->belongsTo(User::class,'user_id','id');
    }
    public function get_seller(){
        return $this->belongsTo(User::class,'seller_id','id');
    }
    public function get_payment(){
        return $this->belongsTo(PaymentHistory::class,'id','order_id');
    }
}
