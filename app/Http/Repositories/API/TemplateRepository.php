<?php 

namespace App\Http\Repositories\API;
use Illuminate\Http\Request;
use App\Http\Repositories\EloquentRepository;
use App\Models\Template;
use App\Models\Product;
use Auth;
use DB;
use App\Http\Resources\Api\TemplateResource;	
use App\Http\Resources\Api\TemplateProductsResource;
use App\Http\Resources\Api\TemplateProduct;


class TemplateRepository extends EloquentRepository{

	public function getTemplateProduct($slug){
	
		if($slug === 'trending'){
			 
			$data = Product::whereHas('user_details')->whereHas('pro_images')->with(['pro_images','latestBid','wishlist'])->inRandomOrder()->limit(15)->withCount('productReview')->where('qty','>',0)->where('status','active')->take(20)->where('end_date', '>=', date('Y-m-d'))->get();
			// return $data;	
			$res = TemplateProduct::collection($data);
			return $res;
		}
		if($slug === 'one_dollar_reserve_only'){
			$data = Product::whereHas('pro_images')->whereHas('user_details')->with(['user_details','pro_images','latestBid','wishlist'])->whereBetween('price',[1,10])->where('bid_option',0)->where('qty','>',0)->where('status','active')->take(20)->where('end_date', '>=', date('Y-m-d'))->get();
			$res = TemplateProduct::collection($data);
			return $res;
		}
		if($slug === 'deals'){
			$data = Product::whereHas('pro_images')->whereHas('user_details')->with(['user_details','pro_images','latestBid','wishlist'])->whereBetween('price',[1,100])->where('bid_option',0)->where('qty','>',0)->take(20)->where('status','active')->where('end_date', '>=', date('Y-m-d'))->get();
			$res = TemplateProduct::collection($data);
			return $res;
		}
		if($slug === 'bid_only'){
			$data = Product::whereHas('pro_images')->whereHas('user_details')->with(['user_details','pro_images','latestBid','wishlist'])->where(['bid_option'=>1,'status'=>'active'])->take(20)->where('qty','>',0)->where('end_date', '>=', date('Y-m-d'))->get();
			$res = TemplateProduct::collection($data);
			return $res;
		}

		if($slug === 'free_product'){
			$data = Product::whereHas('pro_images')->whereHas('user_details')->with(['user_details','pro_images','latestBid','wishlist'])->where(['free_option'=>1,'status'=>'active'])->where('qty','>',0)->take(20)->where('end_date', '>=', date('Y-m-d'))->get();
			$res = TemplateProduct::collection($data);
			return $res;
		}
		
		// $data = Template::whereHas('get_assign_products',function($q){
		// 				$q->whereHas('get_product');
		// 			})->with('get_assign_products.get_product.pro_images','get_assign_products.get_product.latestBid')->where('slug',$slug)->first();
		// $res = TemplateProductsResource::collection($data->get_assign_products);

	}
	public function getTemplate(){
		$userId = Auth::guard('api')->user()->id;
		$data = Template::with('get_assign_products.get_product.pro_images')->get();
		// return $data;
		$res = TemplateResource::collection($data);
		return $res;

	}
	
	
}

?>