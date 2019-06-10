<?php
namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\{CryptoMarkets, CurrenciesRates, CryptoGlobals};
class CryptoWidgetsController extends Controller
{
	public function index()
	{
		$data = [
			'currencies' => CurrenciesRates::select('currency')->orderBy('status', 'asc')->get(),
			'coins' => CryptoMarkets::select('symbol')->orderBy('rank', 'asc')->get()
		];
		return view(getCurrentTemplate() . '.pages.widgets', $data);
	}	

	public function ticker($coin = 'top', $currency = 'USD')
	{
		if ($coin == 'top') {
			$markets = CryptoMarkets::limit(10)->orderBy('rank', 'asc')->get();
			return view('widgets.ticker', ['markets' => $markets]);
		} else {
			$market = CryptoMarkets::where('symbol', '=', $coin)->first();
			return view('widgets.price_ticker', ['market' => $market]);
		}
	}

	public function dominanceChart()
	{
		$crypto_globals = CryptoGlobals::first();
		$market_cap = isset($crypto_globals) ? str_replace(array('$', ','), '', $crypto_globals['total_market_cap_usd']) : 0;

		$dominance_data = [];
		$markets = CryptoMarkets::limit(4)->orderBy('rank', 'asc')->get();
		if ($market_cap == 0) {
			return;
		}
		$i = 0;
		foreach($markets as $coin) {
			$dominance_data[$i]['label'] = $coin['name'] . ' Market %';
			$dominance_data[$i]['value'] = number_format(($coin['market_cap_usd'] / $market_cap) * 100, 2);
			$i++;
		}
		return view('widgets.dominance', ['dominance_data' => json_encode($dominance_data)]);
	}

}