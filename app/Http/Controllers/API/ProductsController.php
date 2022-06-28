<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Repositories\AllProductsRepository;
use App\Models\Product;


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

    public function productOtherInfo($type){
        if($type==='count'){
            return Product::get()->count();
        }
    }  

    public function searchProducts(Request $request){
        $category = $request->category;
        $search = $request->search;
        $limit = $request->limit;

        $product = Product::whereHas('categories',function($q)use($category){
                            $q->where('slug',$category);
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
        $product->take($limit);
        return $product->get();
    }

    public function getFilterProduct($name){
        $product = Product::with(['categories','latestBid'=>function($q){
                            $q->orderBy('your_bid_price','desc')->first();
                        },'pro_images','brand'])  
                        ->withCount('bidsCount');
        $product->where('name', 'LIKE', "%{$name}%");
        
        return $product->get();

    }
}
