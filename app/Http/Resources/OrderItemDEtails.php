<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderItemDEtails extends JsonResource
{
    
    public function toArray($request)
    {
        // return ;
        return [
            'id' => $this->id,
            'pro_id' => $this->product_id  ,
            'quantity' => $this->quantity,
            'cancel_qty' => $this->cancel_qty,
            'unit_price' => $this->unit_price,
            'awb_number' => $this->awb_number,
            'shipping_company_name' => $this->shipping_company_name,
            'status' => $this->status,
            'total_price' => $this->total_price,
            'discount_percentage' => $this->discount_percentage,
            'discount_amount' => $this->discount_amount,
            'name' => $this->get_product->name,
            'pro_images' => new GetProductImgResource($this->get_product->pro_images[0])
        ];
    }
}
