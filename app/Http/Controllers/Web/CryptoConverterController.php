<?php
namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\{CurrenciesRates, CryptoMarkets};
class CryptoConverterController extends Controller
{
	public function index()
	{
		$markets = CryptoMarkets::orderBy('rank', 'asc')->select('name', 'price_usd', 'symbol', 'image')->get();
		$currencies_list = CurrenciesRates::where('status', '=', 1)->orderBy('order', 'asc')->get();
		foreach ($currencies_list as $currency) {
			$currency['usd_rate'] = 1/$currency->rate; //convert all to USD
		}
		$data = [
			'currencies_list' => $currencies_list,
			'markets' => $markets
		];
		return view(getCurrentTemplate() . '.pages.converter', $data);
	}	

}