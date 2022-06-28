<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CartItem extends Model
{
    use HasFactory,SoftDeletes;
    protected $table = 'cart_item';
    protected $guarded =[];

    public function products_detail(){
        return $this->belongsTo('App\Models\Product','product_id','pro_id');
    }
}
