<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Response;
use App\Http\Repositories\API\TemplateRepository;
use DB;

class TemplateController extends Controller
{
     private $template;

    public function __construct(TemplateRepository $template)
    {
        $this->template = $template;
    }
    public function getTemplateProduct($slug){
        $data = $this->template->getTemplateProduct($slug);
        return $data;
    }
     public function getTemplate(){
        $data = $this->template->getTemplate();
        return Response::json([
                'data' => $data
            ], 200);
    }

    public function getSingleProductReview($proid){
        // return $proid;
        $topReview = DB::table('product_review')->where('product_id',$proid)->select(DB::raw('rate, count(rate) as count'))->groupBy('rate')->get();
        return $topReview;
    }

}
