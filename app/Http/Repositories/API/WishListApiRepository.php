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
use App\Http\Resources\Api\TemplateProductsResource;

class WishListApiRepository extends EloquentRepository{

	public function storeWishListPlace(Request $request){
		$userId = Auth::guard('api')->user()->id;
		$pro = Product::where('slug',$request->id)->first();
		$getWishList = WishList::where(['product_id'=>$pro->pro_id,'user_id'=>$userId])->first();

		$data['product_id'] = $pro->pro_id;
		$data['user_id'] = $userId;
		if (!empty($getWishList)) {
			if ($getWishList->product_id != $prot->pro_id) {

				WishList::create($data);
				return WishList::where('user_id',$userId)->get();

			}else{
				return response([
                    'message' => ['Item already added in WishList...']
                ], 422);
			}
		}else{
				WishList::create($data);
				return WishList::with('get_products.pro_images')->where('user_id',$userId)->get();

		}

	}

	public function getWishList(){
		$userId = Auth::guard('api')->user()->id;
		$data =  WishList::where('user_id',$userId)->with(['get_products'=>function($query){
			$query->with(['pro_images','latestBid']);
		}])->get();
		return $data;
		 return $res = TemplateProductsResource::collection($data);

	}
	public function deleteWishlistItem($id){
		$userId = Auth::guard('api')->user()->id;
		WishList::where(['product_id'=>$id,'user_id'=>$userId])->delete();
		return WishList::with('get_products.pro_images')->where('user_id',$userId)->get();
	}
	public function getAllCategories(){
		$data = Category::get();
		$res = CategoryResource::collection($data);
		return $res;
	}
	public function getCategories(){
		$data = Category::whereNull('parent_id')->with('subcategories')->get();
		$res = CategoryResource::collection($data);
		return $res;
	}

	
}

?>