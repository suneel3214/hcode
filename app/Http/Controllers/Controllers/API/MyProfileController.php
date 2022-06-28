<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Repositories\API\MyProfileRepository;
use Response;

class MyProfileController extends Controller
{
    private $myProfile;

    public function __construct(MyProfileRepository $myProfile)
    {
        $this->myProfile = $myProfile;
    }

     public function deleteAddress($id){
        $data = $this->myProfile->deleteAddress($id);
        return Response::json([
                'data' => $data
            ], 200);
    }
}
