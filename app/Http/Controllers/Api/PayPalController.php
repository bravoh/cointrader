<?php

namespace App\Http\Controllers\Api;

use App\Exchange;
use App\Payment;
use App\Subscription;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PayPalController extends Controller
{
    public function store(Request $request){
        $payment_details = (object)$request->payment_details;

        $payment = Payment::create([
            "ref_no"=>$payment_details->id,
            "exchange_id"=>$request->order,
            "amount"=>$payment_details->purchase_units[0]['amount']['value'],
            "payment_mode"=>"paypal",
            "email_address"=>$payment_details->payer['email_address'],
            "country_code"=>$payment_details->payer['address']['country_code'],
            "name"=>$payment_details->payer['name']['given_name'].' '.$payment_details->payer['name']['surname'],
            "payload"=>json_encode($request->payment_details)
        ]);

        $order = Exchange::find($request->order);
        $order->paid = true;
        $order->save();

        return $payment->id;
    }

    public function tbc(Request $request){
        $payment_details = (object)$request->payment_details;

        $subscription = Subscription::create([
            'user_id'=>$request->uuu,
            'amount'=>$payment_details->purchase_units[0]['amount']['value'],
            'product'=>$request->product,
            'paid'=> true
        ]);

        $payment = Payment::create([
            "ref_no"=>$payment_details->id,
            "subscription_id"=>$subscription->id,
            "amount"=>$payment_details->purchase_units[0]['amount']['value'],
            "payment_mode"=>"paypal",
            "email_address"=>$payment_details->payer['email_address'],
            "country_code"=>$payment_details->payer['address']['country_code'],
            "name"=>$payment_details->payer['name']['given_name'].' '.$payment_details->payer['name']['surname'],
            "payload"=>json_encode($request->payment_details)
        ]);

        return $payment->id;
    }
}
