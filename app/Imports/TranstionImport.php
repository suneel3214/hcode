<?php

namespace App\Imports;

use App\Models\Transaction;
use App\Models\Orders;
use App\Models\User;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class TranstionImport implements ToCollection
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function collection(Collection $row)
    {
        foreach($row as $key=> $Data){
            if($key > 0){
                if($Data[2] !==''){
                    $orderNumber = str_replace(' ', '', $Data[2]);
                    $order = Orders::where('invoice_number',$Data[2])->first();
                    if($order){                        
                        $data['seller_id'] = $order->seller_id;
                        $data['order_id'] = $order->id;
                        $data['transaction'] = $Data[1];
                        $data['amount'] = $Data[3] - $Data[4];
                        $data['status'] = 'active';
                        $data['commission'] = $Data[4];
                        $data['transction_for'] = $Data[0];
                        Transaction::create($data);
                    }
                }
            }
        }
    }
}
