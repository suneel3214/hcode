<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class OrderResource extends JsonResource
{

    public function toArray($request)
    {
        $isShpping = false;
        foreach($this->get_order_items as $product){
            if($product->get_product){
                if($product->get_product->shipping_option==='Available'){
                    $isShpping = true;
                }
            }
        }

        return [
            'id' => $this->id,
            'invoiceId' => $this->invoice_number,
            'dateCreate' => Carbon::createFromFormat('Y-m-d H:i:s', $this->created_at)->format('d-m-Y'),
            'amount' => $this->total_price,
            'discounted_price' => $this->discounted_price,
            'shipping_price' => $this->shipping_price,
            'shipping' => $this->shipping,
            'status' => $this->status,
            'cancel_qty' => $this->cancel_qty,
            'cancel_amt' => $this->cancel_amt,
            'order_items'=>OrderItemDEtails::collection($this->get_order_items)              
        ];
    }
}
