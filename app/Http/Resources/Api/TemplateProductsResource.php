<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Resources\Json\JsonResource;

class TemplateProductsResource extends JsonResource
{
    public function toArray($request)
    {
         
        return [
            'id' => $this->get_product?$this->get_product->slug :'',
            'product_id'=>$this->get_product?$this->get_product->slug :'',
            'pro_id'=>$this->get_product?$this->get_product->slug :'',
            'name'=>$this->get_product?$this->get_product->name :'',
            'bid_option'=>$this->get_product?$this->get_product->bid_option :'',
            'add_to_cart_option'=>$this->get_product?$this->get_product->add_to_cart_option :'',
            'type'=>$this->get_product?$this->get_product->type :'',
            'discount'=>$this->get_product?$this->get_product->discount :'',
            'discounted_price'=>$this->get_product?$this->get_product->discounted_price :'',
            'price'=>$this->get_product?$this->get_product->price :'',
            'bid_price'=> '',
            'start_bid_price'=>'',
            'qty'=>$this->get_product?$this->get_product->qty :'',
            'shipping_option'=>$this->get_product ? $this->get_product->shipping_option :'',
            'user_id'=>$this->get_product?$this->get_product->user_id :'',
            'pro_images'=> $this->get_product ? new GetProductImgResource( $this->get_product->pro_images[0])  : ''            
        ];
    }
}
