<?php

namespace App\Http\Controllers\Web;

use App\Exchange;
use App\Payment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PaymentController extends Controller
{
    public function receipt(Request $request){
        $payment = Payment::find($request->payment_id);
        return view(getCurrentTemplate() . '.pages.payment',compact("payment"));
    }
}
