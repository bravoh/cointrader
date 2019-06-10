<?php
namespace App\Http\Controllers\Web;

use App\Http\Controllers\{Controller, CurlCallController};
use App\{CryptoMarkets, CryptoGlobals, CryptoTwitterFeed, CryptoTopPairs, CryptoNews, CryptoCoinsIco, DashboardSlider};
use DB;
use Illuminate\Http\Request;

class CryptoDashboardController extends Controller
{

	public $top_coins = '';
	public $market_cap = '';
	public function index(Request $request)
	{
		$crypto_globals = CryptoGlobals::first();
		$this->market_cap = isset($crypto_globals) ? str_replace(array('$', ','), '', $crypto_globals['total_market_cap_usd']) : 0;
		$top_10 = $this->getTop10Coins();
		$streaming_data = [];

		foreach ($top_10 as $market) {
			$market_symbol = $market->symbol;
			if($market_symbol == 'MIOTA') {
				$market_symbol = 'IOT';
			} else if($market_symbol == 'NANO') {
				$market_symbol = 'XRB';
			}
			if (!preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $market_symbol)) {
				$streaming_data[] = "'5~CCCAGG~".$market_symbol."~USD'";
			}
		}

		$data = [
			'crypto_globals' => isset($crypto_globals) ? $crypto_globals : [], 
			'total_markets' => CryptoMarkets::all()->count(), 
			'crypto_top_markets' => $top_10,
			'streaming_data' => trim(implode(',', $streaming_data), ','),
			'pairs' => $this->getTopTradingPairs(),
			'top_pairs' => $this->getTopTradingCoins(),
			'dominance_data' => $this->getDominanceData(),
			'news_data' => $this->getNews(),
			'icos' => $this->getIcos(),
			'slider_images' => DashboardSlider::where('status', '=', 1)->get()
		];

		return view(getCurrentTemplate() . '.pages.dashboard', $data);
	}

	public function getTop10Coins()
	{
		$this->top_coins =  CryptoMarkets::take(10)->orderBy('rank', 'asc')->get();
		return $this->top_coins;
	}

	public function getTopTradingPairs($coin = 'BTC')
	{
		return CryptoTopPairs::where('symbol', $coin)->limit(5)
		->orderBy('volume24h_from', 'DESC')->orderBy('volume24h_to', 'DESC')
		->get();	
	}

	public function getTopTradingCoins()
	{
		return $this->top_coins;	
	}

	public function getDominanceData()
	{
		$dominance_data = [];
		$markets = $this->top_coins;
		$i = 0;
		if ($this->market_cap == 0) {
			return;
		}
		foreach($markets as $coin) {
			if($i < 4) {
				$dominance_data[$i]['label'] = $coin['name'] . ' Market %';
				$dominance_data[$i]['value'] = number_format(($coin['market_cap_usd'] / $this->market_cap) * 100, 2);
				$i++;
			}
		}
		return json_encode($dominance_data);
	}

	public function getNews()
	{
		$limit = 10;
		if(getCurrentTemplate() == 'default') {
			$limit = 7;
		} else if(getCurrentTemplate() == 'classic') {
			$limit = 6;
		}
		return CryptoNews::take($limit)->orderBy('publishedAt', 'desc')->get();
	}

	public function getIcos()
	{
		return CryptoCoinsIco::whereRaw('image <> ""')
				->take(15)->orderBy('start_time', 'desc')->get();
	}

}