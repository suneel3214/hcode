<?php

namespace App\Http\Controllers\Admin\master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Repositories\Admin\TemplateRepository;
use App\Http\Repositories\AllProductsRepository;
use App\Http\Repositories\Admin\CategoryRepository;
use App\Models\Category;


class TemplateController extends Controller
{
    private $templateRepo;
    private $allProductsRepo;
   
    public function __construct(TemplateRepository $templateRepo,AllProductsRepository $allProductsRepo )
    {
        $this->middleware('auth');
        $this->templateRepo = $templateRepo;
        $this->allProductsRepo = $allProductsRepo;
    }
   
    public function index()
    {
        $templates = $this->templateRepo->getTemplate();
        $allProducts = $this->allProductsRepo->all();
        return view('admin.master.template.index',compact('templates','allProducts'));
    }

   
    public function create()
    {
        return view('admin.master.template.create');
        
    }


    public function store(Request $request)
    {
        if (!$request->update_id) {
            $temlate = $this->templateRepo->storeTemplate($request);
            return redirect()->back()->with('success','Template Created Successfully');
        }else if($request->update_id){
            $temlate = $this->templateRepo->updateTemplate($request);
            // dd($temlate);
            return redirect()->back()->with('success','Template Update Successfully');
        }

    }

    
    public function show($id)
    {
        //
    }

   
    public function edit($id)
    {
        $template = $this->templateRepo->getTemplateById($id);
        return view('admin.master.template.create',compact('template'));
        
    }

   
    public function update(Request $request, $id)
    {
        //
    }

   
    public function destroy($id)
    {
        $deleteTemplate = $this->templateRepo->deleteTemplate($id);
        return redirect()->back()->with('success','Template deleted Successfully');

        
    }
   
    public function assignProducts($id)
    {
        $allProducts = $this->allProductsRepo->all();
        $getAssignProducts = $this->templateRepo->getAssignProducts($id);
        $templateId =$id;
        return view('admin.master.template.assign-product',compact('allProducts','templateId','getAssignProducts'));
    }
    public function storeAssignProducts(Request $request)
    {
        // dd($request->all());
        $assignProducts = $this->templateRepo->storeAssignProducts($request);
      //   dd($assignProducts);
      //  if ($assignProducts == 201) {
      //   return redirect()->back()->with('success','Product already assigned');
      //  }else if($assignProducts == 200){
        return redirect()->back()->with('success','Product assigned Successfully');
      // }
    }
    public function deleteAssignProduct($id)
    {
        $delete = $this->templateRepo->deleteAssignProduct($id);
        return redirect()->back()->with('success','Assigned product deleted Successfully');   
    }

    public function assignCategory($id)
    {
        // dd($id);
        // $category = $this->categoryRepo->categoryList();
        $category =  Category::whereNull('parent_id')->with(['subcategories','getImage'])->get();

        $getAssignCate = $this->templateRepo->getAssignCategory($id);
        // $templateId =$id;

        return view('admin.master.template.assignCategory',compact('category','id','getAssignCate'));
    }

    public function saveAssignCategory(Request $request)
    {
        // dd($request->all());
        $assignProducts = $this->templateRepo->storeAssignProducts($request);
      //   dd($assignProducts);
      //  if ($assignProducts == 201) {
      //   return redirect()->back()->with('success','Product already assigned');
      //  }else if($assignProducts == 200){
        return redirect()->back()->with('success','Product assigned Successfully');
      // }
    }
}
