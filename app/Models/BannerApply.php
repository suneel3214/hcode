<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BannerApply extends Model
{
    use HasFactory ,SoftDeletes;
    protected $table = 'banner_apply';
    protected $guarded = [];

    function seller(){
        return $this->belongsTo(User::class,'seller_id');
    }
}
