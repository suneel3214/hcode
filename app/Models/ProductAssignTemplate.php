<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductAssignTemplate extends Model
{
    use HasFactory , SoftDeletes;
    protected $table = 'product_assign_templates';
    protected $guarded = []; 

    public function get_product(){
        return $this->belongsTo(Product::class,'product_id','pro_id');
    }

}
