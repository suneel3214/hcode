<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Template extends Model
{
    use HasFactory,SoftDeletes;
    protected $table = 'tamplates';
    protected $guarded = [];

    public function get_assign_products(){
        return $this->hasMany(ProductAssignTemplate::class,'template_id','id');
    }

    public function get_assign_category(){
        return $this->hasMany(TemplateCategory::class,'template_id','id');
    }
}
