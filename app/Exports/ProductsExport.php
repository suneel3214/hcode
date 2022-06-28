<?php

namespace App\Exports;

use App\Models\Product;
use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use DB;

class ProductsExport implements FromCollection,WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
       $product = Product::with('user_details','cate','subcate','provience','regions')->select('user_id','pro_id','name'
       ,'qty','discounted_price','catg_id','sub_catg_id','price','status','slug','sku','province_id','region_id')->get();
       $allData = [];
       foreach($product as $products){
        $data['pro_id'] = $products->pro_id;
        $data['user_id'] = $products->user_details ? $products->user_details->name:'';
        $data['email'] = $products->user_details ? $products->user_details->email:'';
        $data['qty'] = $products->qty;
        $data['discounted_price'] = $products->discounted_price;
        $data['catg_id'] = $products->cate ? $products->cate->catg_name:'';
        $data['sub_catg_id'] = $products->subcate ? $products->subcate->catg_name:'';
        $data['price'] = $products->price;
        $data['status'] = $products->status;
        $data['slug'] = $products->slug;
        $data['sku'] = $products->sku;
        $data['province_id'] = $products->provience ? $products->provience->name:'';
        $data['region_id'] = $products->regions ? $products->regions->name:'';

        
        $allData [] = $data;
    }
        // dd($allData);
         return collect($allData);
    }

    /**
     * Return Headings for the exported data
     *
     * @return array
     */
    public function headings(): array
    {
        return [
            'No.','UserName','Email','Quantity','Discount-Price','Category-name','SubCategory-Name','Price','Status','Slug','Sku','Province','Region'
        ];
        
    }
}

