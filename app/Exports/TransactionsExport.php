<?php

namespace App\Exports;

use App\Models\Transaction;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;


class TransactionsExport implements FromCollection,WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {

          $transaction = Transaction::with('seller','order')->select('id','seller_id','order_id','transaction',
          'amount','status','commission','transction_for')->get();
          $allData = [];

          foreach($transaction as $transactions){
          $data['id'] = $transactions->id;
          $data['seller_id'] = $transactions->seller ? $transactions->seller->name :'';
          $data['email'] = $transactions->seller ? $transactions->seller->email :'';
          $data['order_id'] = $transactions->order ? $transactions->order->invoice_number:'';
          $data['transaction'] = $transactions->transaction;
          $data['amount'] = $transactions->amount;
          $data['status'] = $transactions->status;
          $data['commission'] = $transactions->commission;
          $data['transction_for'] = $transactions->transction_for;
          $allData[] = $data; 
        }
        //   dd($allData);
        return  collect($allData);
 
    }


    

    /**
     * Return Headings for the exported data
     *
     * @return array
     */
    public function headings(): array
    {
        return [
            'No.','SellerName','Email','InvoiceNumber','Transaction','Amount','Status','Commission','TransactionFor'
        ];
        
    }
}
