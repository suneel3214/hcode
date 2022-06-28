<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Response;
use App\Http\Repositories\API\TemplateRepository;

class TemplateController extends Controller
{
     private $template;

    public function __construct(TemplateRepository $template)
    {
        $this->template = $template;
    }
    public function getTemplateProduct(){
        $data = $this->template->getTemplateProduct();
        return Response::json([
                'data' => $data
            ], 200);
    }

}
