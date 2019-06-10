<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\{Controller,CurlCallController};
use App\{CryptoMarkets, CryptoGlobals};
use URL, Image; 
use App\Helpers\BulkInsertUpdate;
class CoinMarketCapApiController extends Controller
{
    public $crypto_markets;
    public $crypto_globals;
    public $api_key = '?CMC_PRO_API_KEY=';
    public $url = 'https://pro-api.coinmarketcap.com';
    public $btc_usd_price = 1;
    
    public function __construct()
    {
        $this->crypto_markets = new CryptoMarkets;
        $this->crypto_globals = new CryptoGlobals;

        $keys = explode(',', setting('3rdparty.cmc_api_key'));
        $key = array_rand($keys);

        $this->api_key = $this->api_key . $keys[$key];
    }

    public function topCoinsMarketCap()
    {
        $this->cryptoMarketsData(100);
    }

    public function allCoinsMarketCap()
    {
        $this->cryptoMarketsData($this->getCryptoGlobalCount());
    }

    public function cryptoMarketsData($limit = 0)
    {
        $data = [];
        $markets_records = json_decode(CurlCallController::curl($this->url . "/v1/cryptocurrency/listings/latest" . $this->api_key . '&limit=' . $limit), true);
        if(isset($markets_records['data'])) {
            foreach ($markets_records['data'] as $markets_record) {
                $data[] = $this->prepareMarketsData($markets_record);
            }
        }
        if(isset($data) && count($data) > 0) {
            BulkInsertUpdate::do($this->crypto_markets->getTable(), $data);
        }
    }

    public function prepareMarketsData($markets_record)
    {
        if($markets_record['symbol'] == 'BTC') {
            $this->btc_usd_price = $markets_record['quote']['USD']['price'];
        }
        return [
            'unique_name' => $markets_record['id'],
            'name' => $markets_record['name'],
            'alias' => slugify($markets_record['name']),
            'symbol' => $markets_record['symbol'],
            'image' => strtolower($markets_record['symbol'])."_.png",
            'rank' => $markets_record['cmc_rank'],
            'available_supply' => $markets_record['circulating_supply'],
            'total_supply' => $markets_record['total_supply'],
            'max_supply' => $markets_record['max_supply'],

            'price_usd' => $markets_record['quote']['USD']['price'],
            'volume_usd_day' => $markets_record['quote']['USD']['volume_24h'],
            'market_cap_usd' => $markets_record['quote']['USD']['market_cap'],
            'percent_change_hour' => $markets_record['quote']['USD']['percent_change_1h'],
            'percent_change_day' => $markets_record['quote']['USD']['percent_change_24h'],
            'percent_change_week' => $markets_record['quote']['USD']['percent_change_7d'],
            'price_btc' => $markets_record['quote']['USD']['price']/$this->btc_usd_price,
            'last_updated' => $markets_record['last_updated']
        ];
    }

    public function cryptoGlobalData()
    {
        $markets_globals = json_decode(CurlCallController::curl($this->url . "/v1/global-metrics/quotes/latest" . $this->api_key), true);
        if(isset($markets_globals['data'])) {
            $data = $this->prepareGlobalsData($markets_globals['data']);
            $this->crypto_globals->updateOrCreate(
                ['id' => 1],
                $data
            );
        }
    }

    public function prepareGlobalsData($markets_global)
    {
        return [
            'active_currencies' => $markets_global['active_cryptocurrencies'],
            'active_markets' => $markets_global['active_market_pairs'],
            'active_assets' => $markets_global['active_exchanges'],
            'bitcoin_percentage_of_market_cap' => $markets_global['btc_dominance'],
            'total_market_cap_usd' => $markets_global['quote']['USD']['total_market_cap'],
            'total_24h_volume_usd' => $markets_global['quote']['USD']['total_volume_24h'],
            'last_updated' => $markets_global['last_updated']
        ];
    }

    public function getCryptoGlobalCount()
    {
        $count = $this->crypto_globals::select('active_currencies')->first();
        if(isset($count['active_currencies']) && $count['active_currencies'] != '') {
            return $count['active_currencies'];
        }
        return 100;
    }

    public function cryptoIcons()
    {
        ini_set('max_execution_time', 450);
        $markets_records = $this->crypto_markets::select('symbol')->get();
        
        $markets_icons = json_decode(CurlCallController::curl('https://www.cryptocompare.com/api/data/coinlist/'), true);
        $icons_list = [];
        if($markets_icons['Response'] == 'Success') {
            foreach ($markets_icons['Data'] as $key => $icons) {
                $icons_list[strtolower($key)] = isset($icons['ImageUrl']) ? $icons['ImageUrl'] : '';
            }
        }
        foreach ($markets_records as $markets_record) {
			if(!file_exists(public_path('/images/coins_icons/' . strtolower($markets_record['symbol']) .'_.png'))) {
                $logo = strtolower($markets_record['symbol']);    
                if(isset($icons_list[$logo])) {
                    @$image = Image::make(file_get_contents('https://www.cryptocompare.com/'.$icons_list[$logo]));          
    				@$image->save(public_path('/images/coins_icons/'. strtolower($markets_record['symbol']) .'_.png'));
    				@$image->resize(30, 30)->save(public_path('/images/coins_icons/thumbs/'. strtolower($markets_record['symbol']) .'_.png'));
                }
			}
        }
    }

}
