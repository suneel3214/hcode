<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Repositories\AllProductsRepository;

class ProductsController extends Controller
{

    private $allProductsRepo;
    private $productDetailsRepo;
   
    public function __construct(AllProductsRepository $allProductsRepo ,AllProductsRepository $productDetailsRepo)
    {
        $this->allProductsRepo = $allProductsRepo;
        $this->productDetailsRepo = $productDetailsRepo;
    }
    public function allProducts()
    {
    	 $allProducts = $this->allProductsRepo->all();
       return response($allProducts, 200);
    }
    public function productDetails($id)
    {
         $productDetails = $this->productDetailsRepo->productDetails($id);
         return response($productDetails, 200);
    }
  
}
