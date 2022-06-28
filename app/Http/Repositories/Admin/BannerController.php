<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BannerApply;


class BannerController extends Controller
{
   
    public function index()
    {
        $bannerRequest = BannerApply::with('seller')->get();
        return view('admin.master.banner.index',compact('bannerRequest'));
    }

   
    public function create()
    {
        //
    }

  
    public function store(Request $request)
    {
        //
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
        //
    }
}
