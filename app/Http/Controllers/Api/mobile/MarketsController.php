<?php
namespace App\Http\Controllers\Api\Mobile;
use App\Http\Controllers\Controller;
use App\CryptoMarkets;
class MarketsController extends Controller
{

	public function getAll($limit = '')
	{
		if($limit != '') {
			$markets_data = CryptoMarkets::where('status', '=', 1)->orderBy('rank', 'asc')->limit($limit)->get();
		} else {
			$markets_data = CryptoMarkets::where('status', '=', 1)->orderBy('rank', 'asc')->get();
		}
		return $markets_data;
	}

	public function topGainersCurrencies()
	{
		return CryptoMarkets::where('status', '=', 1)
				->where('percent_change_day', '>', 0)->orderBy('percent_change_day', 'desc')
				->get();
	}

	public function topLosersCurrencies()
	{
		return CryptoMarkets::where('status', '=', 1)
				->where('percent_change_day', '<', 0)->orderBy('percent_change_day', 'asc')
				->get();
	}


}