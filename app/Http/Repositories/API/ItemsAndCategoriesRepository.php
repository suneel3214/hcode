<?php 

namespace App\Http\Repositories\API;
use Illuminate\Http\Request;
use App\Http\Repositories\EloquentRepository;
use App\Models\WishList;
use Auth;
use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use DB;
use App\Http\Resources\CategoryResource;

class ItemsAndCategoriesRepository extends EloquentRepository{

	public function getAllCategories($limit=''){
		$data = Category::with('getImage')->whereNull('parent_id');
		if($limit !==''){
			$data = $data->inRandomOrder()->take($limit)->get();
		}
		else{
			$data = $data->get();
		}
		$res = CategoryResource::collection($data);
		return $res;
	}
	public function getCategories(){
		$data = Category::whereNull('parent_id')->with('subcategories');
	
		$res = CategoryResource::collection($data);
		return $res;
	}
	public function getItemsByCategory($catg_id){
		$categoryId = Category::where('slug',$catg_id)->with('subcategories')->first();
		
		if(!empty($catg_id)){
			$data = Product::where('catg_id',$categoryId->catg_id)
					->with('bids','subcategories','pro_images','categories')
					->where('status','active')
                    ->where('qty','>',0)
                    ->where('end_date', '>=', date('Y-m-d'))
					->get();
			return $data;
		}else{
			$data = Product::with('subcategories','pro_images','categories')
					->orWhere('name', 'like', '%' . $catg_name . '%')
					->where('status','active')
                    ->where('qty','>',0)
                    ->where('end_date', '>=', date('Y-m-d'))
					->get();
			if (empty($data)) {
				$data = Product::with('subcategories','pro_images','categories')
						->where('status','active')
                        ->where('qty','>',0)
                        ->where('end_date', '>=', date('Y-m-d'))
                        ->get();
			return $data;
			}
			return $data;

		}
		// $res = CategoryResource::collection($data);
	}

	
}

?>