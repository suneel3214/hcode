<?php 

namespace App\Http\Repositories\API;
use Illuminate\Http\Request;
use App\Http\Repositories\EloquentRepository;
use App\Models\ShipingAddress;
use Auth;
use DB;


class MyProfileRepository extends EloquentRepository{

	public function deleteAddress($id){
		$userId = Auth::guard('api')->user()->id;
		$data = ShipingAddress::where('id',$id)->where('user_id',$userId)->delete();
		return "Shipping address deleted successfully!";
	}
	

	
}

?>