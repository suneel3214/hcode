<?php 

namespace App\Http\Repositories\Admin;
use Illuminate\Http\Request;

use App\Http\Repositories\EloquentRepository;
use App\Models\Template;
use App\Models\TemplateCategory;
use App\Models\ProductAssignTemplate;
use Auth;
use DB;

class TemplateRepository extends EloquentRepository{

	public function getTemplate(){
		return Template::get();
	}

	public function getTemplateById($id){
		return Template::find($id);
	}
	public function storeTemplate($request){
		$userId = Auth::user()->id;
		$data = $request->validate([
			'name'=>'required',
			'sequence_no'=>'required',
			'slug'=>'required'
		]);
		$data['user_id'] = $userId;
		// $data=[
		// 	'name'=>$request->name,
		// 	'sequence_no'=>$request->sequence_no,
		// 	'slug'=>$request->slug,
		// 	'user_id'=>$userId
		// ];
		return Template::create($data);
	}
	public function updateTemplate($request){
		$data = $request->validate([
			'name'=>'required',
			'sequence_no'=>'required',
			'slug'=>'required'
		]);

		return Template::where('id',$request->update_id)->update($data);
	}
	public function storeAssignProducts($request){
		
		$request->validate(['product_id'=>'required']);
		foreach($request->product_id as $productId ){
			$data = [
				'product_id'=>$productId,
				'template_id'=>$request->template_id
			];
			
			 $singlePro = ProductAssignTemplate::where('product_id',$data['product_id'])
												->where('template_id',$data['template_id'])
												->first();
			 if(!empty($singlePro)){							
				if ($singlePro->product_id == $data['product_id'] && $singlePro->template_id == $data['template_id']) {
					$updateProductTemplate = ProductAssignTemplate::where('product_id',$data['product_id'])->where('template_id',$data['template_id'])->delete();
					$productTemplate = ProductAssignTemplate::create($data);

				// 	return 201;
				 }
			 }else{	
					$productTemplate = ProductAssignTemplate::create($data);
					// return 200;
				}

		}
		return $productTemplate;
	}

	public function getAssignProducts($id){
		return Template::Where('id',$id)->with('get_assign_products')->first();
	}

	public function getAssignCategory($id){
		return Template::Where('id',$id)->with('get_assign_category')->first();
		// return TemplateCategory::Where('id',$id)->with('get_assign_products')->first();
	}

	public function deleteAssignProduct($id){
		return ProductAssignTemplate::where('product_id',$id)->delete();
	}
	public function deleteTemplate($id){
		$tempDel = Template::Where('id',$id)->delete();
		if($tempDel){
			ProductAssignTemplate::Where('template_id',$id)->delete();
		}
	}
}

?>