<?php 

namespace App\Http\Repositories\Admin;
use Illuminate\Http\Request;
use App\Http\Repositories\EloquentRepository;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\Document;
use App\Models\ProductTag;
use App\Models\Activity;
use App\Models\Tag;
use Auth;
use Illuminate\Support\Str;
use DB;

class ProductsRepository extends EloquentRepository{

	public function allPro($request){

		if (Auth::user()->user_role==1) {
			// dd(Product::get());
			$product = Product::withCount('productReview')->with('productReview')->orderBy('pro_id','DESC')->simplePaginate(10);
			if($request->search !==''){
				$product = Product::withCount('productReview')
								->orderBy('pro_id','DESC')
								->where('name','like','%'.$request->search.'%')
								->simplePaginate(20);
			}
			if($request->search !=='' && $request->sort){
				// dd('dfsdsfd');
				$product = Product::withCount('productReview')
								->orderBy('pro_id','DESC')
								->where('status',$request->sort)
								->where('name','like','%'.$request->search.'%')
								->simplePaginate(20);
			}
			return $product;
		}else{
			$product = Product::where('user_id',Auth::user()->id)->withCount('productReview')->orderBy('pro_id','DESC')->simplePaginate(10);
			if($request->search !==''){
				$product = Product::where('user_id',Auth::user()->id)->withCount('productReview')->orderBy('pro_id','DESC')->where('name','like','%'.$request->search.'%')->simplePaginate(10);
			}
			if($request->search !=='' && $request->sort){
				// dd('dfsdsfd');
				$product = Product::withCount('productReview')
								->where('user_id',Auth::user()->id)
								->orderBy('pro_id','DESC')
								->where('status',$request->sort)
								->where('name','like','%'.$request->search.'%')
								->simplePaginate(10);
			}
			return $product;
		}
	}
	public function all($sort=''){
		if (Auth::user()->user_role==1) {
			// dd(Product::get());
			$product = Product::withCount('productReview')
						 ->with('productReview')
						 ->orderBy('pro_id','DESC')
						 ->simplePaginate(10);
			if($sort !==''){
				$product = Product::withCount('productReview')
						 		->with('productReview')
						 		->where('status',$sort)
						 		->orderBy('pro_id','DESC')
						 		->simplePaginate(10);
			}
		}else{
			$product = Product::where('user_id',Auth::user()->id)
							->withCount('productReview')
							->orderBy('pro_id','DESC')
							->simplePaginate(10);

			if($sort !==''){
				$product = Product::withCount('productReview')
						 		->with('productReview')
						 		->where('user_id',Auth::user()->id)
						 		->where('status',$sort)
						 		->orderBy('pro_id','DESC')
						 		->simplePaginate(10);
			}
		}
		return $product ;
	}
	
	public function productStore($request){
		$data = $this->validation($request);
		
		unset($data['tag']);
		unset($data['image']);
		unset($data['state']);
		unset($data['city']);
		$data['sub_catg_id'] = $request->subcatg_id;
		$data['user_id']= Auth::user()->id;
		$data['uriid']= (string) Str::uuid();
		$data['province_id']= $request->state;
		$data['region_id']= $request->city;
		$data['start_date'] = date('Y-m-d'); 
		$data['end_date'] = date('Y-m-d', strtotime(date('Y-m-d'). ' + 365 days')); 
		unset($data['subcatg_id']);

		$oldStatus = Product::where('user_id',Auth::user()->id)->where('status',['active','inreview'])->get();
		if(count($oldStatus) > 0 ){
			$data['status'] = 'active';
		}
		else{
			$data['status'] = 'inreview';
		}

		$product = Product::create($data);
		
		 
		$activ = Activity::where(['userId'=>Auth::user()->id])->first();
		if($activ){
			$activ->increment('count',1);
			$activ->total_count = $activ->sum('count');
		}else{
			$activity['userId'] = Auth::user()->id;
			$activity['activity'] = 'create';
			$activity['month'] = date('M');
			$activity['year'] = date('Y');
			$activity['count'] = 1;
			$activity['total_count'] = 1;
			Activity::create($activity);
		}
		foreach ($request->tag as $key => $id) {
			if(is_numeric($id)){
				$tags['tag_id'] = $id; 
				$tags['product_id'] = $product->pro_id; 
				$isTag = ProductTag::where(['product_id' =>$product->pro_id,'tag_id'=>$id])->count();
				if($isTag===0){
					ProductTag::create($tags);
				};
			}
			else{
				$tag = Tag::create(['tag_name'=>$id]);
				ProductTag::create(['product_id' =>$product->pro_id,'tag_id'=>$tag->id]);
			}
		}

		if($request->catg_id) {
			$datacate['product_id'] = $product->pro_id;
			$datacate['cateory_id'] =  $request->catg_id;
			$datacate['type'] =  'category' ;
			ProductCategory::create($datacate);
		}

		if ($request->subcatg_id) {
			$datacate['product_id'] = $product->pro_id;
			$datacate['cateory_id'] = $request->subcatg_id ;
			$datacate['type'] =  'subcategory' ;
			ProductCategory::create($datacate);
		}

      
		// dd($image);	
    	// dd($docs);
       return $product->pro_id;
		
	}
	public function singleProduct($id){
		return Product::where('pro_id',$id)->with(['tag','pro_images'=>function($img){
			$img->orderBy('order','asc');
		},'categories','brand'])->first();
	}
	public function updateProduct($request,$id){
		$data = $this->validation($request);
	
		unset($data['tag']);
		unset($data['image']);
		unset($data['state']);
		unset($data['city']);
		unset($data['sku']);
		unset($data['slug']);

		$data['sub_catg_id'] = $data['subcatg_id'];
        $data['province_id']= $request->state;
		$data['region_id']= $request->city;
		unset($data['subcatg_id']);
      $oldStatus = Product::where('user_id',Auth::user()->id)->where('status',['active','inreview'])->get();
		if(count($oldStatus) > 0 ){
			$data['status'] = 'active';
		}
		else{
			$data['status'] = 'inreview';
		}
		
      if(empty($product->start_date) && empty($product->start_date)){
	        $data['start_date'] = date('Y-m-d'); 
			$data['end_date'] = date('Y-m-d', strtotime(date('Y-m-d'). ' + 14 days'));
		} 
        $product = Product::where('pro_id',$id)->update($data);
		$activ = Activity::where(['userId'=>Auth::user()->id,'activity'=>'update'])->first();
		if($activ){
			$activ->increment('count',1);
			$activ->total_count = $activ->sum('count');
		}

        foreach ($request->tag as $key => $tgid) {
			if(is_numeric($tgid)){
				$tags['tag_id'] = $tgid; 
				$tags['product_id'] = $id; 

				$isTag = ProductTag::where(['product_id' =>$id,'tag_id'=>$tgid])->count();
				if($isTag===0){
					ProductTag::create($tags);
				};

			}
			else{
				$tag = Tag::create(['tag_name'=>$tgid]);
				ProductTag::create(['product_id' =>$id,'tag_id'=>$tag->id]);
			}
		}

        if ($request->catg_id ) {
        	$count = ProductCategory::where(['product_id'=>$id,'cateory_id'=>$request->catg_id])->delete();
        		$datacate['product_id'] = $id;
				$datacate['cateory_id'] =  $request->catg_id ;
				$datacate['type'] =  'category' ;
				ProductCategory::create($datacate);
		}

		if ($request->subcatg_id) {
        	$count = ProductCategory::where(['product_id'=>$id,'cateory_id'=>$request->subcatg_id])->delete();
			$datacate['product_id'] = $id;
			$datacate['cateory_id'] =  $request->subcatg_id ;
			$datacate['type'] =  'subcategory' ;
			ProductCategory::create($datacate);
		}
		// dd($request->all());
 //        if(!empty($request->image)){
 //         foreach ($request->image as $key => $image) {
 //            if($request->hasFile('image.'.$key)){
 //                $docs =  document_upload($request->image[$key],Auth::user()->id.'/Product_images');
 //                $docs['product_id'] = $id; 
 //                $docs['doc_type'] = 'product'; 
 //                Document::create($docs);
 //            }
 //        }
	// }
	
       return $id;

	}

	public function productApprove($id,$status){
		$productStatus= Product::where('pro_id',$id)->select('status')->first();
		Product::where('pro_id',$id)->update(['status'=>$status]);		
	}

	public function trash($id){
		Product::where('pro_id',$id)->delete();
        Document::where(['product_id' => $id , 'doc_type' => 'product'])->delete();
		$activ = Activity::where(['userId'=>Auth::user()->id,'activity'=>'delete'])->first();
		if($activ){
			$activ->increment('count',1);
			$activ->total_count = $activ->sum('count');
			$activ->save();
		}
	
        // unlink($filePath->doc_path);
	}
	 public function validation($request,$id=null){
	 	 
	 	$product = Product::latest()->first();
        $data = $request->validate([
			'name'=>'required',
			'catg_id'=>'required',
			'subcatg_id'=>'nullable',
			'brand'=>'nullable',
			'qty'=>'required',
			'state'=>'required',
			'city'=>'required',
			'tag'=>'required',
			'type'=>'required',
			'free_option'=>'required',
			'add_to_cart_option'=>'required_if:free_option,No',
			'long_des'=>'required',
			'short_des'=>'required',
			'shipping_option'=>'required',
			'shipping_price'=>'required_if:shipping_option,Available',
		]);
		if($data['free_option']==='Yes' && isset($data['bid_option']) && $data['add_to_cart_option'] === 'No'){
			$data['free_start_date'] = date('Y-m-d');
			$data['free_end_date'] = date('Y-m-d',strtotime(date('Y-m-d'))+2592000);
		}

		if($request->add_to_cart_option==="Yes" && $request->free_option === 'No'){
			$request->validate([
				'price'=>'required_if:add_to_cart_option,Yes',
				'discount'=>'nullable',
			]);
		}
			
		if($request->free_option === 'Yes' ){
			$request->validate([
				'price'=>'nullable',
				'discount'=>'nullable',
			]);
		}
		$discontedPrice = isset($request->price) ? $request->price * $request->discount/100:0;
		$data['price'] = isset($request->price) ? $request->price : 0;
		$data['discount'] = isset($request->discount) ? $request->discount : 0;
		$data['discounted_price'] = isset($request->price) ? $request->price - $discontedPrice:0;
		$data['brand'] = $request->brand;
		$data['type'] = $request->type;
		$data['sku'] = '#'.(string)mt_rand(10000000, 99999999).''.(string)($product ? $product->pro_id+1 : 1);
		$data['slug'] =  str_replace(" ","-",strtoupper($request->name)).'-'.(string)mt_rand(10000000, 99999999).''.(string)($product ? $product->pro_id+1 : 1);
		$data['status'] = "inreview";
		$data['bid_price']=  0.00 ;

		if($data['free_option'] === 'No'){
			$data['free_option'] = false;
			$data['add_to_cart_option'] =  $data['add_to_cart_option'] === 'Yes' ? true : false;
		}
		if($data['free_option'] === 'Yes'){
			$data['add_to_cart_option'] =  true;
			$data['free_option'] = true;
			$data['price'] = 0;
			$data['discount'] = 0;
			$data['discounted_price'] = 0;
		}
		if($data['shipping_option'] !== 'Available'){
			$data['shipping_price'] = 0;
		}

		$data['bid_option']= false;
		$data['color'] = json_encode($request->color);
		$data['size'] = json_encode(explode(',', $request->size));
		
        return $data;
    }

    public function extendDate($id){
    	$data['end_date'] = date('Y-m-d', strtotime(date('Y-m-d'). ' + 14 days'));
    	$data['start_date'] = date('Y-m-d');
    	$product = Product::find($id)->update($data);
    	return $product;
    }
    public function deleteImage($id,$productId){
    	Document::find($id)->delete();
    	return Product::where('pro_id',$productId)->with('tag','pro_images','categories','brand')->first();
    }

}

?>