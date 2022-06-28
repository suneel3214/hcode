<?php 

namespace App\Http\Repositories\API;
use Illuminate\Http\Request;
use App\Http\Repositories\EloquentRepository;
use App\Models\ChatWithSeller;
use Auth;
use DB;


class ChatWithSellerRepository extends EloquentRepository{

	public function storeMessage($request){
		$data = [
			'name'=>$request->name,
			'email'=>$request->email,
			'message'=>$request->message,
			'user_id'=>$request->user_id,
			'seller_id'=>$request->seller_id
		];
		return $data = ChatWithSeller::create($data);
		return "Message send successfully!";
	}
	public function getMessage($request){
		// $userId = Auth::guard('api')->user()->id;
		 $data = ChatWithSeller::where('seller_id',$request->seller_id)
		 						->where('user_id',$request->user_id)
		 						// ->where('email',$request->email)
		 						->get();
		return $data;
	}
	// public function chatWithUser($request){

		
	// 	$data =[
	// 		'name'=>$request->name,
	// 		'message'=>$request->message,
	// 		'user_id'=>$request->user_id,
	// 		'email'=>$request->email,
	// 		'seller_id'=>$request->seller_id
	// 	];
	// 	// return $data;
	// 	// $userId = Auth::guard('api')->user()->id;
	// 	 $data = ChatWithSeller::create($data);
	// 	return $data;
	// }
	

	
}

?>