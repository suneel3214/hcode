<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BidRecource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'product_id'=>$this->product_id ,
            'name'=>$this->user->name ,
            'user_id'=>$this->user->id ,
            'your_bid_price'=>$this->your_bid_price ,
        ];
    }
}
