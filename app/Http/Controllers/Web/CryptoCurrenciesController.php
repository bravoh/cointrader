<?php
namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\{CryptoMarkets, CryptoCoinsFullDetails, FavoritesCoins, CryptoHistoricalDayData, CryptoExchangesVolume, Affiliates,CryptoNews};
use DB, URL, Auth;
class CryptoCurrenciesController extends Controller
{
	/**
	 * It get coin full detail based on alias
	 * @param  string $alias [description]
	 * @return [type]        [description]
	 */
	public function index($alias = '')
	{
		if ($alias !== '') {
			$market = CryptoMarkets::where('alias', '=', $alias)->first();
			$coin_details = CryptoCoinsFullDetails::where('symbol', '=', $market->symbol)->first();
			return view(getCurrentTemplate() . '.pages.coin_details', [
				'market'=> $market,
				'coin_details'=> $coin_details,
				'favorite_coins' => $this->getFavoriteCoins(), 
				'affiliates'=> Affiliates::all(),
				'coin_historical_data' => $this->getCoinHistoricalData($market->symbol),
				'markets' => $this->getMarketsData($market->symbol),
				'crypto_news' => $this->getCoinRelatedNews($market->name),
				'related_coins' => $this->getRelatedCoins(),
			]);
		}
		return redirect('/currencies');
	}

	public function getCoinRelatedNews($coin)
	{
		return CryptoNews::where('title', 'like', '%' . $coin . '%')
					->orderBy('publishedAt', 'desc')->limit(6)->get();
	}

	public function getRelatedCoins()
	{
		return  CryptoMarkets::where('status', '=', 1)->inRandomOrder()->limit(6)->get();
	}

	public function getMarketsData($coin)
	{
		return CryptoExchangesVolume::where('symbol', '=', $coin)->get();
	}

	public function getCoinHistoricalData($coin)
	{
		return CryptoHistoricalDayData::where('coin', '=', $coin)->orderBy('time', 'asc')->get();
	}

	public function liveCurrenciesUpdates()
	{
		$all_markets = CryptoMarkets::where('market_cap_usd', '>', 0)
						->where('status', '=', 1)
						->where('sponsored', '=', 0)
						->orderBy('rank', 'asc')->simplePaginate(50);

		$sponsored_markets = CryptoMarkets::where('market_cap_usd', '>', 0)
						->where('status', '=', 1)
						->where('sponsored', '=', 1)
						->orderBy('rank', 'asc')->simplePaginate(5);
										
		$streaming_data = [];
		foreach ($all_markets as $market) {
			if($market->symbol == 'MIOTA') {
				$market->symbol = 'IOT';
			} else if($market->symbol == 'NANO') {
				$market->symbol = 'XRB';
			}
			if (!preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $market->symbol)) {
				if($market->symbol == 'ONT' || $market->symbol == 'BSV') {
					continue;
				}
				$streaming_data[] = "'5~CCCAGG~".$market->symbol."~USD'";
			}
		}
		$data = [
			'all_markets' => $all_markets, 
			'streaming_data' => trim(implode(',', $streaming_data), ','), 
			'affiliates'=> Affiliates::all(),
			'sub_heading' => __('headings.LIVE_UPDATES_COIN_WATCH'),
			'title' => __('seo.LIVE_COINS_TITLE'),
			'desc' => __('seo.LIVE_COINS_DESCRIPTION'),
			'sponsored_markets' => $sponsored_markets,
			'favorite_coins' => $this->getFavoriteCoins()
		];
		return view(getCurrentTemplate() . '.pages.live_currencies', $data);
	}

	public function topCurrencies()
	{
		$crypto_top_markets = CryptoMarkets::where('status', '=', 1)->orderBy('rank', 'asc')->simplePaginate(50);
		$data = [
			'crypto_top_markets' => $crypto_top_markets, 
			'favorite_coins' => $this->getFavoriteCoins(), 
			'affiliates'=> Affiliates::all(),
			'sub_heading' => __('headings.TOP_COINS_PAGE'),
			'title' => __('seo.TOP_COINS_TITLE'),
			'desc' => __('seo.TOP_COINS_DESCRIPTION'),
			'link' => 'coinmarketcap'
		];
		return view(getCurrentTemplate() . '.pages.top_currencies', $data);
	}

	public function topGainersCurrencies()
	{
		$crypto_top_markets = CryptoMarkets::where('status', '=', 1)->where('percent_change_day', '>', 0)->orderBy('percent_change_day', 'desc')->simplePaginate(50);
		$data = [
			'crypto_top_markets' => $crypto_top_markets, 
			'favorite_coins' => $this->getFavoriteCoins(), 
			'affiliates'=> Affiliates::all(),
			'sub_heading' => __('headings.TOP_GAINERS_PAGE'),
			'title' => __('seo.TOP_GAINERS_COINS_TITLE'),
			'desc' => __('seo.TOP_GAINERS_COINS_DESCRIPTION'),
			'link' => 'top-gainers-crypto-currencies'
		];
		return view(getCurrentTemplate() . '.pages.top_currencies', $data);
	}

	public function topLosersCurrencies()
	{
		$crypto_top_markets = CryptoMarkets::where('status', '=', 1)->where('percent_change_day', '<', 0)->orderBy('percent_change_day', 'asc')->simplePaginate(50);
		$data = [
			'crypto_top_markets' => $crypto_top_markets, 
			'favorite_coins' => $this->getFavoriteCoins(), 
			'affiliates'=> Affiliates::all(),
			'sub_heading' => __('headings.TOP_LOSERS_PAGE'),
			'title' => __('seo.TOP_LOSERS_COINS_TITLE'),
			'desc' => __('seo.TOP_LOSERS_COINS_DESCRIPTION'),
			'link' => 'top-losers-crypto-currencies'
		];
		return view(getCurrentTemplate() . '.pages.top_currencies', $data);
	}

	public function allTimeHighLowCurrencies()
	{
		$symbols_arry = $coins_ahl = $coins_ids = [];
		$markets = CryptoMarkets::where('status', '=', 1)->orderBy('rank', 'asc')->simplePaginate(50);
		foreach ($markets as $key) {
			$symbols_arry[] = $key->symbol;
		}
		$symbols = "'".implode("','", $symbols_arry)."'";
		$results = DB::select(
		DB::raw("SELECT coin, min(low) AS low, max(high) AS high, max(id) AS id 
			FROM crypto_historical_day_datas 
			WHERE coin IN (".$symbols.") 
			GROUP BY coin") 
		);
		foreach ($results as $result) {
			$coins_ahl[$result->coin] = $result;		
			$coins_ids[] = $result->id;			
		}
		
		$data = [
			'markets' => $markets, 
			'all_time_high_low' => $coins_ahl, 
			'latest_high_low' => $this->getCoinsLatestHighLow($coins_ids), 
			'sub_heading' => __('headings.AT_HIGH_LOW_PAGE'),
			'title' => __('seo.AHL_COINS_TITLE'),
			'desc' => __('seo.AHL_COINS_DESCRIPTION')
		];
		return view(getCurrentTemplate() . '.pages.all_time_high_low_markets', $data);
	}

	public function getCoinsLatestHighLow($coins_ids)
	{
		$coins_latest_hl = [];
		$ids = "'".implode("','", $coins_ids)."'";
		$latest_results = DB::select(
		DB::raw("SELECT coin, low AS latest_low, high AS latest_high
			FROM crypto_historical_day_datas 
			WHERE id IN (".$ids.")") 
		);
		foreach ($latest_results as $latest_result) {
			$coins_latest_hl[$latest_result->coin] = $latest_result;
		}
		return $coins_latest_hl;
	}

	public function getListOfFavoriteCoins()
	{
		$user_favorite_coins = $this->getFavoriteCoins();
		$all_markets = CryptoMarkets::whereIn('symbol', $user_favorite_coins)
						->where('status', '=', 1)
						->orderBy('rank', 'asc')->simplePaginate(50);
		$streaming_data = [];
		foreach ($all_markets as $market) {
			if($market->symbol == 'MIOTA') {
				$market->symbol = 'IOT';
			} else if($market->symbol == 'NANO') {
				$market->symbol = 'XRB';
			}
			if (!preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $market->symbol)) {
				$streaming_data[] = "'5~CCCAGG~".$market->symbol."~USD'";
			}
		}
		$data = [
			'favorite_coins' => $all_markets,
			'streaming_data' => trim(implode(',', $streaming_data), ',')
		];
		return view(getCurrentTemplate() . '.pages.user.favorites', $data);
	}

	public function getFavoriteCoins()
	{
		$coins_list = [];
		if(Auth::user()) {
			foreach(FavoritesCoins::select('coin')->where('user_id', '=', Auth::user()->id)->get()->toArray() as $coin) {
				$coins_list[] = $coin['coin'];
			}
			return $coins_list;
		}
		return $coins_list;
	}

	public function getNameAndAliasForCoinSearch()
	{
		if(!request()->ajax()) {
			return [':)'];
		}
		$where = $_GET['q'];
		$url = URL::to('/');
		$data = CryptoMarkets::select(DB::raw("CONCAT(name, ' (', symbol, ')') AS title"), DB::raw("CONCAT('".$url."/currencies/', alias) AS url"))
					->where('symbol', 'like', "%".$where."%")
					->orWhere('name', 'like', "%".$where."%")
					->take(100)->orderBy('rank', 'asc')->get();
		return '{"results": ' . $data . '}';
	}
}
