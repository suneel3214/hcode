<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WishList extends Model
{
    use HasFactory ,SoftDeletes;
    protected $table = 'wish_lists';
    protected $guarded = [];

    public function get_products(){
        return $this->belongsTo('App\Models\Product','product_id','pro_id');
    }
}
