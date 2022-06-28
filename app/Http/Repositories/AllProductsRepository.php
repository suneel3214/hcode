<?php 

namespace App\Http\Repositories;
use Illuminate\Http\Request;
use App\Http\Repositories\EloquentRepository;
use App\Models\Product;
use App\Models\ProductReview;
use App\Models\ProductTag;
use App\Http\Resources\ProductDetailsResource;
use App\Http\Resources\ProductResource;
use DB;

class AllProductsRepository extends EloquentRepository{

	public function allProducts($request){
		$take = $request->limit;
	
		$product = Product::whereHas('user_details')->where('qty','>',0)->where('status','active')->with('pro_images','categories','brand')->withCount('productReview');
		if(isset($request->start)){
			$product->offset($request->start);
		}
		$allProducts = $product->where('status','active')->where('end_date', '>=', date('Y-m-d'))->take($take)->get();
		return ProductResource::collection($allProducts);

	}	
	public function all(){
	
		$product = Product::where('status','active')->with('pro_images','categories','brand')->get();
		return $product;

	}
	public function productDetails($id){
		// return Product::all();
		$data = Product::where('slug',$id)->with(['latestBid'=>function($q){
			$q->orderBy('your_bid_price','desc')->first();
		},'pro_images','categories','brand','user_details','tag','tagId'])->where('qty','>',0)->withCount('bidsCount')->first();
		$reviews =  ProductReview::where('product_id',$data->pro_id);
		$ProductTag =  ProductTag::select('tag_id')->where('product_id',$data->pro_id)->get();
		$reviewCount = $reviews->count();
		$topReview = DB::table('product_review')->where('product_id',$data->pro_id)->select(DB::raw('rate, count(rate) as count'))->groupBy('rate')->get();
		$allReview =  [
			1=>0,
			2=>0,
			3=>0,
			4=>0,
			5=>0,
		];
		$all = $reviews->get();
		$tagsIds = [];
		foreach ($ProductTag  as $value) {
			$tagsIds[] = $value->tag_id; 
		}
		foreach ($all  as $value) {
			if($value->rate !==0){
		 		$allReview[$value->rate] = $allReview[$value->rate]+1;
			}
		}	

		$proDetails = 	array(
						'pro_id' => $data->slug,
			            'product_id'=>$data->slug,
			            'name'=>$data->name ,
			            'bid_option'=>$data->bid_option ,
			            'free_option'=>$data->free_option === 'Yes' || $data->free_option  ? true :false  ,
			            'add_to_cart_option'=>$data->add_to_cart_option ,
			            'type'=>$data->type ,
			            'discount'=>!$data->free_option ? $data->discount:0 ,
			            'discounted_price'=> !$data->free_option ? $data->discounted_price:0 ,
			            'price'=> !$data->free_option  ? $data->price :0 ,
			            'bid_price'=> $data->latestBid ? $data->latestBid->your_bid_price:'' ,
			            'start_bid_price'=> !$data->free_option ? $data->bid_price:0,
			            'sku'=>$data->sku,
			            'slug'=>$data->slug,
			            'bids_count_count'=>$data->bids_count_count,
			           
			            'shipping_option'=>$data->shipping_option ,
			            'user_id'=>$data->user_id ,
			            'long_des'=>$data->long_des ,
			            'short_des'=>$data->short_des ,
			            'shipping_price'=>$data->shipping_price ,
			            'user_details'=>$data->user_details, 
			            'pro_images'=>$data->pro_images,
			            'categories'=>$data->categories, 
			            'latest_bid'=>$data->latestBid, 
			            'tag'=>$data->tag, 
			            'tagId'=>json_encode($tagsIds), 
			            'bid_start_date'=>$data->bid_start_date, 
			            'bid_end_date'=>$data->bid_end_date, 
			            'start_date'=>$data->start_date, 
			            'end_date'=>$data->end_date, 
			            'qty'=>$data->qty, 
			            'topReview' =>$topReview,
			            'allReviews' =>$allReview,
			            'reviewCount' =>$reviewCount,
			        );
            
		// return $data;
		return $proDetails;
		return new ProductDetailsResource($data);
	}
	public function cartData(Request $request){
		return Product::create();
	}
	
}

?>