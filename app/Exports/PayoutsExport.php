<?php

namespace App\Exports;

use App\Models\Order;
use App\Models\User;
use App\Models\Payout;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use DB;

class PayoutsExport implements FromCollection,WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
       $payout = Payout::with('seller')->select('id','seller_id','amount'
       ,'status','date','remark')->get();
       $allData = [];
       foreach($payout as $payouts){
        $data['id'] = $payouts->id;
        $data['seller_id'] = $payouts->seller ? $payouts->seller->name:'';
        $data['email'] = $payouts->seller ? $payouts->seller->email:'';
        $data['amount'] = $payouts->amount;
        $data['status'] = $payouts->status;
        $data['date'] = $payouts->date;
        $data['remark'] = $payouts->remark;
        // $data['created_at'] = $payouts->created_at;
       

        
        $allData [] = $data;
    }
        // dd($allData);
         return collect($allData);
    }

    /**
     * Return Headings for the exported data
     *
     * @return array
     */
    public function headings(): array
    {
        return [
            'No.','SellerName','Email','Amount','Status','Date','Remark'
        ];
        
    }
}

