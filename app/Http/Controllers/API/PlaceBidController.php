<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Repositories\API\OrderApiRepository;
use App\Http\Repositories\AllProductsRepository;
use App\Http\Resources\BidRecource;
use Response;
use App\Models\PlaceBid;

class PlaceBidController extends Controller
{
    private $placeBid;
    private $allProduct;

    public function __construct(OrderApiRepository $placeBid,AllProductsRepository $allProduct)
    {
        $this->placeBid = $placeBid;
        $this->allProduct = $allProduct;
    }
    public function placeBid(Request $request){
        
        $this->placeBid->storeBidePlace($request);
        $data = $this->allProduct->productDetails($request->product_id);
        return Response::json([
                'data' => $data
            ], 200);
    }


    public function getBidHistory($proId){
        $bids = PlaceBid::with('user')->where('product_id',$proId)->get();
        return BidRecource::collection($bids);
    }
}
