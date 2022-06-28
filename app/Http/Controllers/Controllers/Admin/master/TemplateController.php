<?php

namespace App\Http\Controllers\Admin\master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Repositories\Admin\TemplateRepository;
use App\Http\Repositories\AllProductsRepository;


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
        if ($request->flag=="add") {
            $temlate = $this->templateRepo->storeTemplate($request);
            return redirect()->back()->with('success','Template Created Successfully');
        }else if($request->flag=="edit"){
            $temlate = $this->templateRepo->updateTemplate($request);
            return redirect()->back()->with('success','Template Update Successfully');
        }

    }

    
    public function show($id)
    {
        //
    }

   
    public function edit($id)
    {
        //
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
        // dd($getAssignProducts);
        return view('admin.master.template.assign-products',compact('allProducts','templateId','getAssignProducts'));
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
}
