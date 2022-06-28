<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductDetailsResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->pro_id,
            'product_id'=>$this->pro_id ,
            'name'=>$this->name ,
            'bid_option'=>$this->bid_option ,
            'add_to_cart_option'=>$this->add_to_cart_option ,
            'type'=>$this->type ,
            'discount'=>$this->discount ,
            'discounted_price'=>$this->discounted_price ,
            'price'=>$this->price ,
            'bid_price'=> $this->latestBid ? $this->latestBid->your_bid_price:'' ,
            'start_bid_price'=>$this->bid_price,
           
            'shipping_option'=>$this->shipping_option ,
            'user_id'=>$this->user_id ,
            'long_des'=>$this->long_des ,
            'short_des'=>$this->short_des ,
            'user_details'=>$this->user_details ,
            'pro_images'=> GetProductImgResource::collection($this->pro_images),            
        ];
    }
}
