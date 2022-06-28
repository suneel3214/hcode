<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TemplateCategory extends Model
{
    use HasFactory,SoftDeletes;
    
    protected $table = 'template_category';
    protected $guarded = [];

    public function categories(){
        return $this->belongsToMany(Category::class,'catg_id','category_id');
    }
}
