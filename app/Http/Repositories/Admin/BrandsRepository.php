<?php 


namespace App\Http\Repositories\Admin;
use Illuminate\Http\Request;
use App\Http\Repositories\EloquentRepository;
use App\Models\Brand;


class BrandsRepository extends EloquentRepository{

  
	public function all(){
		return Brand::get();
	}
	public function brandsStore($request){
		$data=$request->validate([
			'name'=>'required'
		]);
		return Brand::create($data);
	}
	public function singleBrand($id){
		return Brand::where('brand_id',$id)->first();
	}
	public function updateBrands($request,$id){
		$data=$request->validate([
			'name'=>'required'
		]);
		return Brand::where('brand_id',$id)->update($data);
	}
	public function trash($id){
		return Brand::where('brand_id',$id)->delete();

	}
}
?>