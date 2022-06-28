<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Repositories\API\WishListApiRepository;
use Response;

class WishListController extends Controller
{
    private $wishList;

    public function __construct(WishListApiRepository $wishList)
    {
        $this->wishList = $wishList;
    }
    public function addWishList(Request $request){
        
        $data = $this->wishList->storeWishListPlace($request);
        return Response::json([
                'data' => $data
            ], 200);
    }
    public function getWishList(Request $request){
        
        $data = $this->wishList->getWishList($request);
        return Response::json([
                'data' => $data
            ], 200);
    }
    public function deleteWishlistItem($id){
        // return $id;
        $data = $this->wishList->deleteWishlistItem($id);
        return Response::json([
                'data' => $data
            ], 200);
    }
   
}
