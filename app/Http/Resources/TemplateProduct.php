<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Resources\Json\JsonResource;

class TemplateProduct extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->slug,
            'product_id'=>$this->slug,
            'pro_id'=>$this->slug,
            'name'=>$this->name,
            'bid_option'=>$this->bid_option,
            'free_option'=>$this->free_option ? true :false,
            'add_to_cart_option'=>$this->add_to_cart_option ,
            'type'=>$this->type,
            'discount'=>$this->discount ,
            'discounted_price'=>$this->discounted_price ,
            'price'=>$this->price ,
            'bid_price'=> $this->latestBid !== null ? $this->latestBid->your_bid_price:'' ,
            'start_bid_price'=>$this->bid_price,
           
            'shipping_option'=>$this->shipping_option ,
            'user_id'=>$this->user_id ,
            'review_count'=>count($this->productReview),
            'user_details'=>$this->user_details ,
            'pro_images'=> new GetProductImgResource( $this->pro_images[0])          
        ];
    }
}
