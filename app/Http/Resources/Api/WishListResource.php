<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Resources\Json\JsonResource;

class WishListResource extends JsonResource
{
    public function toArray($request)
    {
        
        return [
            'id' => $this->id,
            'get_assign_products'=>TemplateProductsResource::collection($this->get_products)              
        ];
    }
}
