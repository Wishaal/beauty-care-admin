<?php

namespace App\Http\Controllers;

use App\Models\Discount;
use App\ServicePayment;
use Illuminate\Http\Request;

class UpdateRecordsController extends Controller
{
    public function index(){

        $servicepayment  = ServicePayment::all();

        foreach ($servicepayment as $r){
            $payment = ServicePayment::find($r->id);

            $servicediscount = $payment->service_discount;
            $productdiscount = $payment->product_discount;

            if(!empty($servicediscount)){
                $adddiscount  = new Discount;
                $adddiscount->discount = $servicediscount;
                $adddiscount->service_payment_id = $payment->id;
                $adddiscount->currency_id = 5;
                $adddiscount->type = 'service';
                $adddiscount->save();
            }

            if(!empty($productdiscount)){
                $adddiscount  = new Discount;
                $adddiscount->discount = $productdiscount;
                $adddiscount->service_payment_id = $payment->id;
                $adddiscount->currency_id = 5;
                $adddiscount->type = 'product';
                $adddiscount->save();
            }


            $payment->totalsrd = $payment->actualtotal;

            $payment->save();
        }
        return "done";
    }
}
