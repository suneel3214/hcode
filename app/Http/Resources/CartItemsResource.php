<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CartItemsResource extends JsonResource
{
    
    public function toArray($request)
    {
        return [
            'id' => $this->products_detail->slug,
            'pro_id' => $this->products_detail->slug,
            'slug' => $this->products_detail->slug,
            'quantity' => $this->quantity,
            'unit_price' =>$this->products_detail->free_option === '0' ? $this->unit_price:0,
            'total_price' => $this->products_detail->free_option === '0' ? $this->total_price:0,
            'discount_percentage' =>  $this->products_detail->free_option === '0' ? $this->discount_percentage:0,
            'discount_amount' =>  $this->products_detail->free_option === '0' ? $this->discount_amount:0,
            'isFree' => $this->products_detail->free_option ,
            'name' => $this->products_detail->name,
            'current_qty' => (int)$this->products_detail->qty,
            'isShipping' => $this->products_detail->shipping_option ==='Available' ? true : false,
            'shipping_price' => $this->products_detail->shipping_price,
            'pro_images' => new GetProductImgResource($this->products_detail->pro_images[0])
        ];
    }
}
