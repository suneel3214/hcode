<?php

namespace App\Http\Controllers;

use App\Http\Repositories\Admin\CategoryRepository;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    private $categoryRepo;
    private $subCategoryRepo;
   
    public function __construct(CategoryRepository $categoryRepo)
    {
        $this->middleware('auth');
        $this->categoryRepo = $categoryRepo;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $category = $this->categoryRepo->all();
        // dd($category);
        return view('admin.home');
    }
}
