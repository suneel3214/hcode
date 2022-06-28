<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Refund extends Model
{
    use HasFactory , SoftDeletes;

    protected $table='refund';
    protected $guarded = [];

    public function order(){
        return $this->belongsTo(Order::class,'order_id','id');
    }

    public function product(){
        return $this->belongsTo(Product::class,'product_id','pro_id');
    }
}
