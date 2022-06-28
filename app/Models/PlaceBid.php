<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PlaceBid extends Model
{
    use HasFactory,SoftDeletes;
    protected $table = 'place_bids';
    // protected $primaryKey = 'pro_id';
    // protected $primaryKey = 'user_id';
    protected $guarded = []; 

    public function user(){
        return $this->belongsTo(User::class,'user_id','id')->select('name','id');
    }
    public function product(){
        return $this->belongsTo(Product::class,'product_id','pro_id')->select('pro_id','user_id','name');
    }
}
