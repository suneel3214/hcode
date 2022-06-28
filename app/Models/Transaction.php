<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use HasFactory , SoftDeletes;
    protected $table ='transaction';
    protected $guarded = [];

    public function seller(){
        return $this->belongsTo(User::class,'seller_id','id');
    }
    public function order(){
        return $this->belongsTo(Order::class,'order_id','id');
    }
}
