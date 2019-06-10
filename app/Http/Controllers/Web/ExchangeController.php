<?php

namespace App\Http\Controllers\Web;

use App\CryptoExchanges;
use App\Exchange;
use App\Gateway;
use App\GatewayExchangePair;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ExchangeController extends Controller
{
    public function index(Request $request)
    {
        $gateways = Gateway::where('active', '=', 1)
            ->orderBy('id', 'asc')
            ->get();

        return view(getCurrentTemplate() . '.pages.exchange', compact("gateways"));
    }

    public function receive_rates(Request $request)
    {
        $gateway = Gateway::find($request->gateway_id);
        $pairings = GatewayExchangePair::whereSend_id($request->gateway_id)->get();
        return view("widgets.receive_rates",compact("gateway","pairings"));
    }

    public function change(Request $request)
    {
        if ($request->isMethod("POST")){
            return $this->saveExchange($request);
        }

        $pair = GatewayExchangePair::find($request->pair_id);
        return view(getCurrentTemplate() . '.pages.change',compact("pair"));
    }

    public function saveExchange(Request $request){
        $bit_pair = GatewayExchangePair::find($request->bit_pair);

        $exchange = Exchange::create([
            'gateway_exchange_pair_id'=>$request->bit_pair,
            'send_amount'=>$request->bit_amount_send,
            'receive_amount'=>$request->bit_amount_receive,
            'email_address'=>$request->bit_u_field_1,
            'crypto_address'=>$request->bit_u_field_2,
            'bit_currency_from'=>$request->bit_currency_from,
            'bit_currency_to'=>$request->bit_currency_to,
            'exchange_rate'=>$bit_pair->rate
        ]);

        return redirect(route("checkout.get",$exchange->id));
    }

    public function checkout(Request $request){
        $order = Exchange::find($request->id);
        return view(getCurrentTemplate() . '.pages.checkout',compact("order"));
    }

    public function tbcExchange(Request $request){
        $pair = GatewayExchangePair::find(8);
        return view(getCurrentTemplate() . '.pages.tbc_exchange',compact("pair"));
    }
}
