<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cart extends Model
{
    use HasFactory ,SoftDeletes;
    protected $table = 'carts';
    protected $guarded =[];

    public function cart_items(){
    	return $this->hasMany('App\Models\CartItem','cart_id','id');
    } 
    
}
