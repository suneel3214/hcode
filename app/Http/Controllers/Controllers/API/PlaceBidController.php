<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Repositories\API\OrderApiRepository;
use Response;

class PlaceBidController extends Controller
{
    private $placeBid;

    public function __construct(OrderApiRepository $placeBid)
    {
        $this->placeBid = $placeBid;
    }
    public function placeBid(Request $request){
        
        $data = $this->placeBid->storeBidePlace($request);
        return Response::json([
                'data' => $data
            ], 200);
    }
}
