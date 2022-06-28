<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Resources\Json\JsonResource;

class TemplateResource extends JsonResource
{
    public function toArray($request)
    {
        
        return [
            'id' => $this->id,
            'name' => $this->name,
            'sequence_no' => $this->sequence_no,
            'slug' => $this->slug,
            'get_assign_products'=>TemplateProductsResource::collection($this->get_assign_products)              
        ];
    }
}
