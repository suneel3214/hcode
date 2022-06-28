<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CartResource extends JsonResource
{
    

    public function toArray($request)
    {
        $isShpping = false;
        foreach($this->cart_items as $product){
            if($product->products_detail){
                if($product->products_detail->shipping_option==='Available'){
                    $isShpping = true;
                }
            }
        }
        return [
            'id' => $this->id,
            'total_price' => $this->total_price,
            'discounted_price' => $this->discounted_price,
            'amount' => $this->amount,
            'total_item' => $this->total_item,
            'item_qty' => $this->item_qty,
            'isShpping' => $isShpping,
            'cart_items'=>CartItemsResource::collection($this->cart_items)              
        ];
    }
}
