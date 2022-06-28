<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payout extends Model
{
    use HasFactory , SoftDeletes;
    
    protected $table ='payout';
    protected $guarded = [];

    public function seller(){
        return $this->belongsTo(User::class,'seller_id','id');
    }
}
