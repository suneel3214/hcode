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

    public function subcategory()
    {
        $categories = $this->categoryRepo->subCategory();
        return view('admin.master.category.subcategory',compact('categories'));
    }

    
    public function create()
    {
        $categories = $this->categoryRepo->all();
        $type = 'Category';
        return view('admin.master.category.create',compact('categories','type'));
        
    }
    public function create_sub()
    {
        $categories = $this->categoryRepo->all();
        $type = 'subCategory';
        return view('admin.master.category.create',compact('categories','type'));
        
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

    public function destory($id)
    {
        $categories = $this->categoryRepo->trash($id);
        return redirect()->back()->with('success','Category Deleted Successfully');
    }

    
    public function edit($id)
    {
        $categories = $this->categoryRepo->all();
        $category1 = $this->categoryRepo->editCategory($id);
        $type = 'category';
        // dd($category1);
        return view('admin.master.category.edit',compact('category1','categories','type'));
    }
    public function subCategoryedit($id)
    {
        $sub = $this->categoryRepo->subCategory();
        $categories = $this->categoryRepo->all();
        $category1 = $this->categoryRepo->editSubCategory($id);
        $type = 'subCategory';
        return view('admin.master.category.edit',compact('category1','categories','type'));
    }

    public function update(Request $request, $id)
    {
        $categories = $this->categoryRepo->updateCategory($request,$id);
        $categories = $this->categoryRepo->all();
        return view('admin.master.category.index',compact('categories'));
        return redirect()->back()->with('success','Category Updated Successfully');
    }

    public function gatSubCategory($id,$selected='')
    {
        $categories = $this->categoryRepo->getSubCategory($id); ?>

        <option value="">Select...</option>
        <?php foreach($categories as $cat){ ?>
            <option <?php echo (int)$selected === $cat->catg_id ? 'selected=true' :''; ?> value="<?php echo $cat->catg_id ; ?>"><?php echo $cat->catg_name ; ?></option>
        <?php
        }
    }
}
