<?php

namespace App\Http\Controllers\Admin\master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Repositories\Admin\BrandsRepository;

class BrandsController extends Controller
{
    private $brandsRepo;

    public function __construct(BrandsRepository $brandsRepo)
    {
        $this->middleware('auth');
        $this->brandsRepo = $brandsRepo;
    }
    public function index()
    {
        $brands = $this->brandsRepo->all();
        return view('admin.master.brand.index',compact('brands'));

    }

   
    public function create()
    {
        $brands = $this->brandsRepo->all();
        return view('admin.master.brand.create',compact('brands'));
    }

   
    public function store(Request $request)
    {
        $brands = $this->brandsRepo->brandsStore($request);
        return redirect()->back()->with('success','Category Created Successfully');
    }

   
    public function show($id)
    {
        //
    }

   
    public function edit($id)
    {
        $brands = $this->brandsRepo->singleBrand($id);
        return view('admin.master.brand.edit',compact('brands'));
    }

   
    public function update(Request $request, $id)
    {
        $brands = $this->brandsRepo->updateBrands($request,$id);
        return redirect()->back()->with('success','Brand Updated Successfully');
    }

   
    public function destroy($id)
    {
        $brands = $this->brandsRepo->trash($id);
        return redirect()->back()->with('success','Brand deleted Successfully');
    }
}
