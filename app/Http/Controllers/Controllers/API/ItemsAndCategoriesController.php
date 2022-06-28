<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Repositories\API\ItemsAndCategoriesRepository;
use Response;
class ItemsAndCategoriesController extends Controller
{
    
    private $itemsAndCategories;

    public function __construct(ItemsAndCategoriesRepository $itemsAndCategories)
    {
        $this->itemsAndCategories = $itemsAndCategories;
    }

     public function getAllCategories(){
        $data = $this->itemsAndCategories->getAllCategories();
        return Response::json([
                'data' => $data
            ], 200);
    }
    public function getCategories(){
        $data = $this->itemsAndCategories->getCategories();
        return Response::json([
                'data' => $data
            ], 200);
    }
    public function getItemsByCategory($id){
        $data = $this->itemsAndCategories->getItemsByCategory($id);
        return Response::json([
                'data' => $data
            ], 200);
    }
}
