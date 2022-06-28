<?php 

namespace App\Http\Repositories\Admin;
use Illuminate\Http\Request;
use App\Http\Repositories\EloquentRepository;
use App\Models\User;
use Auth;
class BuyerSellerRepository extends EloquentRepository{

	public function all(){
		return User::where('user_role',$type)->get();
	}

	public function getUserByRole($request){
		if(isset($request->search) && $request->search !=='' && (!isset($request->sort) || $request->sort ==='') ){
			return User::where('name','like','%'.$request->search.'%')
					   ->simplePaginate(10);
		}
		if($request->search =='' && $request->sort !=='' && isset($request->sort) ){
			
			if($request->sort === 'active'){
				return User::where('status','A')
							->simplePaginate(10);
			}
			elseif($request->sort === 'inactive'){
				return User::where('status','P')
							->simplePaginate(10);
			}
			elseif($request->sort === 'verified'){
				return User::whereNotNull('email_verified_at')
							->simplePaginate(10);
			}
			else{
				return User::whereNull('email_verified_at')
							->simplePaginate(10);	
			}
			
		}
		if($request->search !=='' && $request->sort){
			if($request->sort === 'active'){
				return User::where('name','like','%'.$request->search.'%')
							->where('status','A')
							->simplePaginate(10);
			}
			elseif($request->sort === 'inactive'){
				return User::where('name','like','%'.$request->search.'%')
							->where('status','P')	
							->simplePaginate(10);
			}
			elseif($request->sort === 'verified'){
				return User::where('name','like','%'.$request->search.'%')
							->whereNotNull('email_verified_at')
							->simplePaginate(10);
			}
			else{
				return User::where('name','like','%'.$request->search.'%')
							->whereNull('email_verified_at')
							->simplePaginate(10);	
			}
			
			return User::where('name','like','%'.$request->search.'%')
							->simplePaginate(10);
		}
		return User::simplePaginate(10);
	}
	
}

?>