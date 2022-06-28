<?php

namespace App\Http\Controllers\Admin\buyerseller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Repositories\Admin\ProductsRepository;
use App\Http\Repositories\Admin\CategoryRepository;
use App\Http\Repositories\Admin\BrandsRepository;
use App\Models\Product;
use App\Models\Tag;

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
        // dd($products);
        return view('admin.products.index',compact('products'));
    }

   
    public function create()
    {
        $categories = $this->categoryRepo->all();
        $subcategories = $this->categoryRepo->subCategory();
        $brands = $this->brandRepo->all();
        $tag = Tag::all();
        return view('admin.products.create',compact('categories','brands','tag','subcategories'));
        
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
        $subcategories = $this->categoryRepo->subCategory();
        $product = $this->productsRepo->singleProduct($id);
        $tag = Tag::get();
        $catIds = 0;
        $subcatIds = 0;
        $tagIds = [];

        foreach($product->tag as $Tag){
            $tagIds[] = $Tag->id;
        }

        foreach($product->categories as $cate){
            if($cate->parent_id ===null){
                $catIds = $cate->catg_id;
            }
            else{
                $subcatIds = $cate->catg_id;
            }
        }

        $brands = $this->brandRepo->all();

        return view('admin.products.edit',compact('product','categories','catIds','tagIds','tag','subcatIds'));
    }

    
    public function update(Request $request, $id)
    {
        $this->productsRepo->updateProduct($request,$id);
        return redirect()->back()->with('success','Product Update Successfully');    
    }

    
    public function destroy(Request $request)
    {
        $ids = $request->ids;
        // return $ids;
        Product::whereIn('pro_id',$ids)->delete(); 
        $products = $this->productsRepo->all();
        return view('admin.products._tr',compact('products')) ;   
    }

    public function productApprove($id){
        // dd($id);
        $this->productsRepo->productApprove($id);
        $products = $this->productsRepo->all();
        return view('admin.products._tr',compact('products')) ; 
    }

    public function productDestroy($id){
         $this->productsRepo->trash($id);
        return redirect()->back()->with('success','Product Deleted successfully');   
    }

    public function extendDate($id){
         $this->productsRepo->extendDate($id);
         $products = $this->productsRepo->all();
        return view('admin.products._tr',compact('products')) ; 
    }

    public function subcategory($id){
        $categories = $this->categoryRepo->subCategory($id); ?>
        <option value="">Select...</option>
        <?php 
            foreach($categories as $Category){ ?>
                <option value="<?php echo $Category->catg_id ?>"><?php echo $Category->catg_name ?></option>
        <?php
        }

    }
}
