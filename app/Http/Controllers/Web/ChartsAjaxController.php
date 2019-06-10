<?php
namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\CryptoHistoricalDayData;

class ChartsAjaxController extends Controller
{
	public function getHistoricalDayData($coin = 'BTC', $time_frame = '3 months', $currency = 'USD')
	{
		if(!request()->ajax()) {
			return [':)'];
		}
		if ($time_frame == 'all') {
			$time_frame = "100 year";
		}
		$fromDate = strtotime(date("Y-m-d", strtotime('-'.$time_frame)));
		$toDate = strtotime(date("Y-m-d"));
		$results = CryptoHistoricalDayData::select('time', 'open')
						->where('coin', $coin)
						->whereBetween('time', [$fromDate, $toDate])->orderBy('time', 'asc')->get()
						->toArray();	
		$data = $res = [];	
		foreach ($results as $result) {
			$res['date'] = $result['time'];
			$res['visits'] = $result['open'];
			$data[] = $res;
		}
		return json_encode($data);
	}

	public function getHistoricalDayDataCandle($coin = 'BTC', $time_frame = '3 months', $currency = 'USD')
	{
		if(!request()->ajax()) {
			return [':)'];
		}
		if ($time_frame == 'all') {
			$time_frame = "100 year";
		}
		$fromDate = strtotime(date("Y-m-d", strtotime('-'.$time_frame)));
		$toDate = strtotime(date("Y-m-d"));
		$results = CryptoHistoricalDayData::select('time', 'open', 'high', 'low', 'close')->where('coin', $coin)
						->whereBetween('time', [$fromDate, $toDate])->orderBy('time', 'asc')->get()
						->toArray();
		$data = $res = [];	
		foreach ($results as $result) {
			$res['date'] = $result['time'];
			$res['open'] = $result['open'];
			$res['high'] = $result['high'];
			$res['low'] = $result['low'];
			$res['close'] = $result['close'];
			$data[] = $res;
		}
		return json_encode($data);
	}

}