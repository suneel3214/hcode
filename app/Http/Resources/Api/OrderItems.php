<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderItems extends JsonResource
{
 
     public function toArray($request)
    {
        // return ;
        return [
            'id' => $this->product_id,
            'product_id' => $this->product_id  ,
            'quantity' => $this->quantity,
            'unit_price' => $this->unit_price,
            'total_price' => $this->total_price,
            'discount_percentage' => $this->discount_percentage,
            'discount_amount' => $this->discount_amount,
            'name' => $this->products_detail->name,
            'pro_images' => new GetProductImgResource($this->products_detail->pro_images[0])

            
        ];
    }
}
