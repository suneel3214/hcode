<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory,SoftDeletes;
    protected $table = 'products';
    protected $primaryKey = 'pro_id';
    protected $guarded = []; 

    public function pro_images(){
    	 return $this->hasMany('App\Models\Document', 'product_id','pro_id')->where('doc_type','product');
    }

    public function tag(){
         // return $this->hasMany('App\Models\ProductTag', 'product_id','pro_id');
         return $this->hasManyThrough(
            Tag::class,
            ProductTag::class,
            'product_id', // Foreign key on the environments table...
            'id', // Foreign key on the deployments table...
            'pro_id', // Local key on the projects table...
            'tag_id' // Local key on the environments table...
        );
    }

     public function tagId(){
         // return $this->hasMany('App\Models\ProductTag', 'product_id','pro_id');
         return $this->hasMany(ProductTag::class,'product_id','pro_id')->select('tag_id');
    }

    public function categories(){
        // return $this->hasMany(Category::class,'catg_id','catg_id')->select('catg_id','parent_id','catg_name');
        return $this->hasManyThrough(
            Category::class,
            ProductCategory::class,
            'product_id', // Foreign key on the environments table...
            'catg_id', // Foreign key on the deployments table...
            'pro_id', // Local key on the projects table...
            'cateory_id' // Local key on the environments table...
        );
    }

    public function bids(){
        return $this->hasMany(PlaceBid::class,'product_id','pro_id');
    }

    public function latestBid(){
        return $this->belongsTo(PlaceBid::class,'pro_id','product_id');
    }

    public function bidsCount(){
        return $this->hasMany(PlaceBid::class,'product_id','pro_id');
    }

    public function brand(){
        return $this->belongsTo('App\Models\Brand','brand','brand_id')->select('name');
    }
    public function user_details(){
        return $this->belongsTo('App\Models\User','user_id','id');
    }
    public function subcategories(){
        return $this->hasMany(Category::class,'parent_id','catg_id');
    }
    public function cate(){
        return $this->belongsTo(Category::class,'catg_id','catg_id');
    }
    public function subcate(){
        return $this->belongsTo(Category::class,'sub_catg_id','catg_id');
    }
    public function wishlist(){
        return $this->hasMany(WishList::class,'product_id','pro_id');
    }

    public function productReview(){
        return $this->hasMany(ProductReview::class,'product_id','pro_id');
    }
    public function provience(){
        return $this->belongsTo(Province::class,'province_id','id');
    }
    public function regions(){
        return $this->belongsTo(Region::class,'region_id','id');
    }
}
