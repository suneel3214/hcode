<?php 

namespace App\Http\Repositories\Admin;
use Illuminate\Http\Request;

use App\Http\Repositories\EloquentRepository;
use App\Models\Category;
use App\Models\Document;

class CategoryRepository extends EloquentRepository{

	public function all(){
		$cate = Category::whereNull('parent_id')->with(['subcategories','getImage'])->get();
		return $cate;
	}

	public function categoryList(){
		$cate = Category::whereNull('parent_id')->with(['subcategories','getImage'])->get();
		return $cate;
	}

	public function subCategory(){
		return Category::whereNotNull('parent_id')->get();
	}

	public function getSubCategory($id){
		return Category::where('parent_id',$id)->get();
	}

	public function catgStore($request){
		
		$data['catg_name']=$request->catg_name;
		$data['icon']=$request->icon;
		$data['slug']=$request->slug;
		$data['parent_id']=$request->parent_id;

		$category = Category::create($data);

		if($request->hasFile('image')){
            $docs =  document_upload($request->image,'/category');
            $docs['product_id'] = $category->id; 
            $docs['doc_type'] = 'category'; 
            Document::create($docs);
        }
		
	}
	public function editCategory($id){
		return Category::where('catg_id',$id)->with('subcategories')->first();
	}
	public function editSubCategory($id){
		return Category::where('catg_id',$id)->first();
	}
	public function updateCategory($request,$id){
		$data['catg_name']=$request->catg_name;
		$data['slug']=$request->slug;
		$data['icon']=$request->icon;

		if($request->hasFile('image')){
			$documents = Document::where('product_id',$id)->where('doc_type','category')->first();
            $docs =  document_upload($request->image,'/category',$documents);
			if(!$documents){
				$docs['doc_type'] = 'category';
				$docs['product_id'] = $id;
				$docs['order'] = 1;
				$documents = Document::create($docs);

			}else{
			    $documents->update($docs);
			}
        }

		return Category::where('catg_id',$id)->update($data);
	}
	public function trash($id){
		return Category::where('catg_id',$id)->delete();
	}

	

}

?>