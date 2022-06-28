<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Template extends Model
{
    use HasFactory;
    protected $table = 'tamplates';
    protected $guarded = [];

    public function get_assign_products(){
        return $this->hasMany('App\Models\ProductAssignTemplate','id','template_id');
    }

    public function category(){
        return $this->hasMany(TemplateCategory::class,'id','template_id');
    }
}
