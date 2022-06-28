<?php

namespace App\Http\Controllers\Admin\master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Repositories\Admin\CategoryRepository;

class CategoriesConroller extends Controller
{
    private $categoryRepo;
    private $subCategoryRepo;
   
    public function __construct(CategoryRepository $categoryRepo)
    {
        $this->middleware('auth');
        $this->categoryRepo = $categoryRepo;
    }
    public function index()
    {
        //
        $categories = $this->categoryRepo->all();
        return view('admin.master.category.index',compact('categories'));
    }

    
    public function create()
    {
        $categories = $this->categoryRepo->all();
        return view('admin.master.category.create',compact('categories'));
        
    }

    
    public function store(Request $request)
    {
        $categories = $this->categoryRepo->catgStore($request);
        return redirect()->back()->with('success','Category Created Successfully');

        
    }

    
    public function show($id)
    {
        //
    }

    
    public function edit($id)
    {
        $categories = $this->categoryRepo->all();
        $category1 = $this->categoryRepo->editCategory($id);
        // dd($category1);
        return view('admin.master.category.edit',compact('category1','categories'));
    }

  
    public function update(Request $request, $id)
    {
        $categories = $this->categoryRepo->updateCategory($request,$id);
        return redirect()->back()->with('success','Category Updated Successfully');
    }

   
    public function destroy($id)
    {
        $categories = $this->categoryRepo->trash($id);
        return redirect()->back()->with('success','Category deleted Successfully');
        
    }
}
