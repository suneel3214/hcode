<?php

namespace App\Http\Controllers\Admin\buyerseller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Repositories\Admin\ProductsRepository;
use App\Http\Repositories\Admin\CategoryRepository;
use App\Http\Repositories\Admin\BrandsRepository;

class ProductController extends Controller
{
    private $categoryRepo;
    private $productsRepo;
    private $brandRepo;
   
    public function __construct(ProductsRepository $productsRepo, CategoryRepository $categoryRepo, BrandsRepository $brandRepo)
    {
        $this->middleware('auth');
        $this->productsRepo = $productsRepo;
        $this->categoryRepo = $categoryRepo;
        $this->brandRepo = $brandRepo;
    }
    public function index()
    {
        $products = $this->productsRepo->all();
        
        return view('admin.products.index',compact('products'));
    }

   
    public function create()
    {
        $categories = $this->categoryRepo->all();
        $brands = $this->brandRepo->all();
        return view('admin.products.create',compact('categories','brands'));
        
    }

   
    public function store(Request $request)
    {
        $products = $this->productsRepo->productStore($request);
        return redirect()->back()->with('success','Product created Successfully');    


        
    }

    
    public function show($id)
    {
        $product = $this->productsRepo->singleProduct($id);
        // dd($product);
        return view('admin.products.show',compact('product'));
        
    }

    public function edit($id)
    {
        $categories = $this->categoryRepo->all();
        $product = $this->productsRepo->singleProduct($id);
        // dd($categories );
        $brands = $this->brandRepo->all();

        return view('admin.products.edit',compact('product','categories','brands'));
    }

    
    public function update(Request $request, $id)
    {
        $this->productsRepo->updateCategory($request,$id);
        return redirect()->back()->with('success','Product Update Successfully');    
    }

    
    public function destroy($id)
    {
       
        
    }

    public function productApprove($id){
        // dd($id);
        $this->productsRepo->productApprove($id);
        return [
            'status' => 'success',
            'message' => 'Product Status Changed Successfully'
        ];    

    }
     public function productDestroy($id){
         $this->productsRepo->trash($id);
        return redirect()->back()->with('success','Product Deleted successfully');   

    }
}
