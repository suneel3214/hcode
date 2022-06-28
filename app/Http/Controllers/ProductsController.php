<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Repositories\AllProductsRepository;
use App\Models\Product;
use App\Http\Resources\Api\TemplateProduct;
use App\Http\Resources\CategoryProduct;


class ProductsController extends Controller
{

    private $allProductsRepo;
    private $productDetailsRepo;
   
    public function __construct(AllProductsRepository $allProductsRepo ,AllProductsRepository $productDetailsRepo)
    {
        $this->allProductsRepo = $allProductsRepo;
        $this->productDetailsRepo = $productDetailsRepo;
    }
    public function allProducts(Request $request)
    {
    	$allProducts = $this->allProductsRepo->allProducts($request);
       return response($allProducts, 200);
    }
    public function productDetails($id)
    {
         $productDetails = $this->productDetailsRepo->productDetails($id);
         return $productDetails;
    }

    public function export()
    {
        return Excel::download(new ProductsExport, 'product.csv');
    }

    public function productOtherInfo($type){
        if($type==='count'){
            return Product::whereHas('user_details')->where('qty','>',0)->where('status','A')->where('end_date', '>=', date('Y-m-d'))->with('pro_images','categories','brand')->withCount('productReview')->count();
        }
    }  

     public function searchProducts(Request $request){
        $category = $request->category;
        $search = $request->search;
        $limit = $request->limit;

        $product = Product::whereHas('categories',function($q)use($category){
                            if($category !=='all'){
                                $q->where('slug',$category);
                            }
                        })
                        ->with(['categories'=>function($q)use($category){
                            $q->where('slug',$category);
                        },'latestBid'=>function($q){
                            $q->orderBy('your_bid_price','desc')->first();
                        },'pro_images','brand','user_details'])  
                        ->withCount('bidsCount');
        if($search !==''){
            $product->where('name', 'LIKE', "%{$search}%");
        }
        $product->where('qty','>',0)
                ->where('status','active')
                ->where('end_date', '>=', date('Y-m-d'))
                ->take($limit);
        return CategoryProduct::collection($product->get());
    }

    public function sortProducts(Request $request){
        $sort_by = $request->sort_by;
        $start = $request->start;
        $limit = $request->limit;
        $product = Product::with(['categories','latestBid'=>function($q){
                            $q->orderBy('your_bid_price','desc')->first();
                        },'pro_images','brand','user_details','productReview'=>function($rate)use($sort_by){
                            if($sort_by === 'rating'){
                                $rate->orderBy('rate','DESC');
                            }
                        }])  
                        ->where('status','active')
                        ->where('qty','>',0)
                        ->where('end_date', '>=', date('Y-m-d'));

        if($sort_by ==='latest'){
            $product->orderBy('pro_id','DESC');
            $product->offset($start)->take($limit);
            return $product->get();
        }
        if($sort_by ==='highTolow'){
            $product->orderBy('price','DESC');
            return $product->get();
            $product->offset($start)->take($limit);
        }
        if($sort_by ==='lowToHigh'){
            $product->orderBy('price','ASC');
            $product->offset($start)->take($limit);
            return $product->get();
        }
        if($sort_by ==='free'){
            $product->where('free_option',1);
            $product->offset($start)->take($limit);
            return $product->get();
        }
        if($sort_by ==='bid'){
            $product->where('bid_option',1);
            $product->offset($start)->take($limit);
            return $product->get();
        }
        
        $product->offset($start)->take($limit);
        return $product->get();
       

    }

    public function getFilterProduct($name){
        $product = Product::with(['categories','latestBid'=>function($q){
                            $q->orderBy('your_bid_price','desc')->first();
                        },'pro_images','brand'])  
                        ->withCount('bidsCount');
        $product->where('status','active')->where('end_date', '>=', date('Y-m-d'))->where('name', 'LIKE', "%{$name}%");
        
        return $product->get();

    }

    public function similerProduct(Request $request){
        $tagIds = json_decode($request->tagIds);
        $product = Product::whereHas('tag',function($tg)use($tagIds){
            $tg->whereIn('tag.id',$tagIds);
        })->whereHas('pro_images')->with(['tag','pro_images','latestBid','wishlist'])->inRandomOrder()->limit(15)->where('status','A')->get();
        $res = TemplateProduct::collection($product);
        return $res;
    }
}
