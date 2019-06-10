<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\{Controller,CurlCallController};
use App\{CryptoTopPairs, CryptoMarkets, CryptoHistoricalDayData, CryptoHistoricalHourData, CryptoCoinsFullDetails, CryptoCoinsRates, CryptoMiningEquipments, CryptoExchangesVolume, MiningPools, Wallets};
use App\Helpers\BulkInsertUpdate;
use URL, Image; 
class CryptoCompareApiController extends Controller
{
	
	public $crypto_top_trading_paris;	
	public $crypto_markets;	
	public $crypto_histo;
    public $crypto_histo_hour;
    public $crypto_details;
    public $crypto_rates;
	public $crypto_mining;
    public $crypto_exchanges_volume;
    public $pools;
    public $wallets;
    public $key;
	public function __construct()
	{
		$this->crypto_top_trading_paris = new CryptoTopPairs;
		$this->crypto_markets = new CryptoMarkets;
		$this->crypto_histo = new CryptoHistoricalDayData;
        $this->crypto_histo_hour = new CryptoHistoricalHourData;
        $this->crypto_details = new CryptoCoinsFullDetails;
        $this->crypto_rates = new CryptoCoinsRates;
		$this->crypto_mining = new CryptoMiningEquipments;
        $this->crypto_exchanges_volume = new CryptoExchangesVolume;
        $this->pools = new MiningPools;
        $this->wallets = new Wallets;
        $this->key = setting('3rdparty.cryptocompare_api_key');
	}

	public function getPairs()
	{
		$markets = $this->crypto_markets::take(20)->orderBy('rank', 'asc')->get();
		foreach ($markets as $market) {
            $market_symbol = $market['symbol'];
            if ($market_symbol == 'MIOTA') {
                $market_symbol = 'IOT';
            } else if($market_symbol == 'NANO') {
                $market_symbol = 'XRB';
            }
			$pairs = json_decode(CurlCallController::curl('https://min-api.cryptocompare.com/data/top/pairs?fsym=' . $market_symbol), true);
	        if($pairs['Response'] == 'Success') {
		        foreach ($pairs['Data'] as $pair) {
		            $data[] = $this->preparePairsData($market['symbol'], $pair);
			    }
			}
	    }
        if(isset($data) && count($data) > 0) {
            BulkInsertUpdate::do($this->crypto_top_trading_paris->getTable(), $data);
        }
	}

	public function preparePairsData($market_symbol, $pair)
	{
		return [
			'symbol' => $market_symbol,
			'pair' => $pair['toSymbol'],
			'volume24h_from' => $pair['volume24h'],
			'volume24h_to' => $pair['volume24hTo']
		];
	}

    public function getAllHistoricalDayData()
    {
        ini_set('max_execution_time', 7200); //2 hrs
        $this->getHistoricalDayData(2000); //get all data from start date
    }

    public function getDailyHistoricalDayData()
    {
        $this->getHistoricalDayData(1);
    }

	public function getHistoricalDayData($limit = 1)
	{
        for($i=0;$i<250;$i++) {
            $markets = $this->crypto_markets::select('symbol')->orderBy('rank', 'asc')->offset(10*$i)->limit(10)->get();
    		foreach ($markets as $market) {
    			$market_symbol = $market['symbol'];
                if ($market_symbol == 'MIOTA') {
                    $market_symbol = 'IOT';
                    $market['symbol'] = 'IOT';
                } else if($market_symbol == 'NANO') {
                    $market_symbol = 'XRB';
                    $market['symbol'] = 'NANO';
                }
    			$response = json_decode(CurlCallController::curl('https://min-api.cryptocompare.com/data/histoday?fsym='.$market_symbol.'&tsym=USD&limit='.$limit.'&aggregate=1&e=CCCAGG'), true);
    			if($response['Response'] == 'Success') {
    		        foreach ($response['Data'] as $histo_data) {
    		        	if($histo_data['open'] == 0 && $histo_data['close'] == 0 && $histo_data['low'] == 0 && $histo_data['high'] == 0) {
    		        		continue;
    		        	}
    		            $data[] = $this->prepareHistoData($histo_data, $market['symbol']);
    			    }
    			}
    		}
            if(isset($data) && count($data) > 0) {
                BulkInsertUpdate::do($this->crypto_histo->getTable(), $data);
                $data = [];
            }
        }
	}

	public function prepareHistoData($histo_data, $coin)
	{
		return [
			'coin' => $coin,
			'time' => $histo_data['time'],
			'open' => $histo_data['open'],
			'close' => $histo_data['close'],
			'high' => $histo_data['high'],
			'low' => $histo_data['low'],
			'open' => $histo_data['open'],
			'volume_from' => $histo_data['volumefrom'],
			'volume_to' => $histo_data['volumeto']
		];
	}

    public function getHistoricalHourData()
    {
        $markets = $this->crypto_markets::orderBy('rank', 'asc')->get();
        foreach ($markets as $market) {
            $market_symbol = $market['symbol'];
            if ($market_symbol == 'MIOTA') {
                $market_symbol = 'IOT';
                $market['symbol'] = 'IOT';
            } else if($market_symbol == 'NANO') {
                $market_symbol = 'XRB';
                $market['symbol'] = 'NANO';
            }
            $response = json_decode(CurlCallController::curl('https://min-api.cryptocompare.com/data/histohour?fsym='.$market_symbol.'&tsym=USD&limit=3&aggregate=1&e=CCCAGG'), true);
            if($response['Response'] == 'Success') {
                foreach ($response['Data'] as $histo_data) {
                    if($histo_data['open'] == 0 && $histo_data['close'] == 0 && $histo_data['low'] == 0 && $histo_data['high'] == 0) {
                        continue;
                    }
                    $data[] = $this->prepareHistoData($histo_data, $market['symbol']);
                }
                if(isset($data) && count($data) > 0) {
                    BulkInsertUpdate::do($this->crypto_histo_hour->getTable(), $data);
                }
                $data = [];
            }
        }
    }

	public function cryptoCoinsRates()
    {
        for($i=0;$i<50;$i++) {
            $coins_symbols = $this->crypto_markets::select('symbol')->orderBy('rank', 'asc')->offset(50*$i)->limit(50)->get();
            $coins = '';
            foreach($coins_symbols as $symbol) {
                $coins .= $symbol->symbol.',';
            }
            $coins = rtrim($coins, ',');
            $f_currencies = 'BTC,ETH,LTC,USD,EUR,KRW';
            $rates = json_decode(CurlCallController::curl('https://min-api.cryptocompare.com/data/pricemultifull?fsyms='.$coins.'&tsyms='.$f_currencies), true);
            if(isset($rates['RAW'])) {
               foreach ($rates['RAW'] as $prices) {
                    foreach ($prices as $price) {
                        if($price['FROMSYMBOL'] == $price['TOSYMBOL']) {
                            $price['PRICE'] = 1;
                        }
                        $data[] = [
                            'coin' => $price['FROMSYMBOL'],
                            'f_currency' => $price['TOSYMBOL'],
                            'price' => $price['PRICE'],
                            'change_hour' => $price['CHANGEPCTDAY'],
                            'change_day' => $price['CHANGEPCT24HOUR']
                        ];
                    }
                }
            }
        }
        if(isset($data) && count($data) > 0) {
            BulkInsertUpdate::do($this->crypto_rates->getTable(), $data);
        }
    }

    public function getAllExchangesPairs()
    {
        $symbol_array = [];
        $symbols = CryptoMarkets::select('symbol')->get();
        foreach ($symbols as $symbol) {
            $symbol_array[] = strtoupper($symbol->symbol);
        }
        $exchanges = json_decode(CurlCallController::curl('https://min-api.cryptocompare.com/data/all/exchanges'), true);
        $exchange = $coin = $market = $markets_list = '';
        foreach ($exchanges as $exchange => $value) {
            foreach ($value as $coin => $markets) {
                $data = [];
                $markets_list = '';
                foreach ($markets as $market) {
                    if(in_array(strtoupper($coin), $symbol_array)) {
                        $data[] = $this->prepareExchangesData($coin, $market, $exchange);
                    }
                }
                if(isset($data) && count($data) > 0) {
                    BulkInsertUpdate::do($this->crypto_exchanges_volume->getTable(), $data);
                }
            }
        }
    }

    public function prepareExchangesData($coin, $market, $exchange)
    {
        return [
            'symbol' => $coin,
            'to_symbol' => $market,
            'exchange' => strtolower($exchange),
            'pair' => $coin . '/' . $market,
            'volume_day_from' => 0,
            'volume_day_to' => 0
        ];
    }

    public function getExchangesVolumeByPairs()
    {
        ini_set('max_execution_time', 7200);
        $pairs = ['BTC', 'ETH', 'LTC', 'DOGE', 'USD', 'USDT', 'EUR', 'KRW', 'JPY'];
        $markets = $this->crypto_markets::select('symbol')
                        ->where('market_cap_usd', '>', 0)
                        ->where('volume_usd_day', '>', 0)
                        ->orderBy('rank', 'asc')->get();
        foreach ($pairs as $pair) {
            foreach ($markets as $market) {
                $data = [];
                if($pair == $market->symbol) {
                    continue;
                }
                $exchanges_volume = json_decode(CurlCallController::curl('https://min-api.cryptocompare.com/data/top/exchanges?fsym='.$market->symbol.'&tsym=' . $pair), true);
                if(isset($exchanges_volume['Data'])) {
                    foreach ($exchanges_volume['Data'] as $volume) {
                        $data[] = $this->prepareExchangesVolumeData($volume, $pair);
                    }
                }
                if(isset($data) && count($data) > 0) {
                    BulkInsertUpdate::do($this->crypto_exchanges_volume->getTable(), $data);
                }
            }
        }
    }

    public function prepareExchangesVolumeData($volume, $pair)
    {
        return [
            'symbol' => $volume['fromSymbol'],
            'to_symbol' => $volume['toSymbol'],
            'exchange' => strtolower($volume['exchange']),
            'pair' => $volume['fromSymbol'] . '/' . $volume['toSymbol'],
            'volume_day_from' => $volume['volume24h'],
            'volume_day_to' => $volume['volume24hTo']
        ];
    }

    public function miningPools()
    {
        $pools = json_decode(CurlCallController::curl('https://min-api.cryptocompare.com/data/mining/pools/general?api_key=' . $this->key), true);
        if($pools['Response'] == 'Success') {
            foreach ($pools['Data'] as $pool) {
                $data[] = $this->preparePoolsData($pool);
            }
        }
        if(isset($data) && count($data) > 0) {
            BulkInsertUpdate::do($this->pools->getTable(), $data);
        }
    }

    public function preparePoolsData($pool)
    {
        return [
            'read_more' => "https://www.cryptocompare.com" . $pool['Url'],
            'logo' => "https://www.cryptocompare.com" . $pool['LogoUrl'],
            'name' => $pool['Name'],
            'alias' => slugify($pool['Name']),
            'merged_mining' => $pool['MergedMining'],
            'tx_fee_shared_with_miner' => $pool['TxFeeSharedWithMiner'],
            'affiliate_url' => $pool['AffiliateURL'],
            'pool_features' => implode(',', $pool['PoolFeatures']),
            'coins' => implode(',', $pool['Coins']),
            'server_locations' => implode(',', $pool['ServerLocations']),
            'payment_types' => implode(',', $pool['PaymentType']),
            'merged_mining_coins' => implode(',', $pool['MergedMiningCoins']),
            'twitter' => $pool['Twitter'],
            'average_fee' => $pool['AverageFee'],
            'fee_expanded' => $pool['FeeExpanded'],
            'minimum_payout' => $pool['MinimumPayout']
        ];
    }

    public function wallets()
    {
        $wallets = json_decode(CurlCallController::curl('https://min-api.cryptocompare.com/data/wallets/general?api_key=' . $this->key), true);
        if($wallets['Response'] == 'Success') {
            foreach ($wallets['Data'] as $pool) {
                $data[] = $this->prepareWalletsData($pool);
            }
        }
        if(isset($data) && count($data) > 0) {
            BulkInsertUpdate::do($this->wallets->getTable(), $data);
        }
    }

    public function prepareWalletsData($wallet)
    {
        return [
            'read_more' => "https://www.cryptocompare.com" . $wallet['Url'],
            'logo' => "https://www.cryptocompare.com" . $wallet['LogoUrl'],
            'name' => $wallet['Name'],
            'alias' => slugify($wallet['Name']),
            'security' => $wallet['Security'],
            'anonymity' => $wallet['Anonymity'],
            'affiliate_url' => $wallet['AffiliateURL'],
            'ease_of_use' => $wallet['EaseOfUse'],
            'has_attched_card' => $wallet['HasAttchedCard'],
            'has_trading_facilities' => $wallet['HasTradingFacilities'],
            'has_vouchers_and_offers' => $wallet['HasVouchersAndOffers'],
            'wallet_features' => implode(',', $wallet['WalletFeatures']),
            'coins' => implode(',', $wallet['Coins']),
            'platforms' => implode(',', $wallet['Platforms']),
            'source_code_url' => $wallet['SourceCodeUrl'],
            'validation_type' => $wallet['ValidationType']
        ];
    }


	public function cryptoCoinsFullDetails()
    {
        ini_set('max_execution_time', 7200);
        $markets = $this->crypto_details::select('symbol')->get();
        $symbols = [];
        foreach ($markets as $market) {
            if ($market->symbol == 'IOT') {
                $this->crypto_details::where('symbol', '=', 'IOT')->delete();
                $market->symbol = 'MIOTA';
            } else if($market->symbol == 'XRB') {
                $this->crypto_details::where('symbol', '=', 'XRB')->delete();
                $market->symbol = 'NANO';
            }
            $symbols[] = $market->symbol;
        }
        $coins = json_decode(CurlCallController::curl('https://www.cryptocompare.com/api/data/coinlist/'), true);
        if (isset($coins['Data'])) {
            foreach ($coins['Data'] as $coin) {
                if(in_array($coin['Symbol'], $symbols)) {
                    continue;
                }
                $details = json_decode(CurlCallController::curl('https://www.cryptocompare.com/api/data/coinsnapshotfullbyid/?id='.$coin['Id']), true);
                $social_details = json_decode(CurlCallController::curl('https://www.cryptocompare.com/api/data/socialstats/?id='.$coin['Id']), true);
                if(isset($details['Response']) && $details['Response'] == 'Success') {
                    $market_symbol = $details['Data']['General']['Symbol'];
                    if ($market_symbol == 'IOT') {
                        $details['Data']['General']['Symbol'] = 'MIOTA';
                    } else if($market_symbol == 'XRB') {
                        $details['Data']['General']['Symbol'] = 'NANO';
                    }
                    $data = $this->prepareCoinDetailsData($details['Data']);    
                    $data['reddit'] = isset($social_details['Data']['Reddit']['link']) ? $social_details['Data']['Reddit']['link'] : '';
                    $data['facebook'] = isset($social_details['Data']['Facebook']['link']) ? $social_details['Data']['Facebook']['link'] : '';
                    $this->crypto_details->updateOrCreate(
                        ['symbol' => $details['Data']['General']['Symbol']],
                        $data
                    );
                }
            }
        }
    }

    public function prepareCoinDetailsData($details)
    {
        return [
            'title' => $details['SEO']['PageTitle'] ?? '',
            'alias' => strtolower($this->getAlias($details['General']['Symbol'])),
            'seo_description' => $details['SEO']['PageDescription'] ?? '',
            'full_name' => $details['General']['H1Text'] ?? '',
            'symbol' => $details['General']['Symbol'],
            'description' => $details['General']['Description'] ?? '',
            'features' => $details['General']['Features'] ?? '',
            'technology' => $details['General']['Technology'] ?? '',
            'algorithm' => $details['General']['Algorithm'] ?? '',
            'proof_type' => $details['General']['ProofType'] ?? '',
            'start_date' => strtotime($details['General']['StartDate']) ?? '',
            'twitter' => $details['General']['Twitter'] ?? '',
            'reddit' => $details['reddit'] ?? '',
            'facebook' => $details['facebook'] ?? '',
            'website_url' => $details['General']['WebsiteUrl'] ?? '',
            'block_number' => $details['General']['BlockNumber'] ?? '',
            'block_time' => $details['General']['BlockTime'] ?? '',
            'total_coins_mined' => $details['General']['TotalCoinsMined'] ?? '',
            'previous_total_coins_mined' => $details['General']['PreviousTotalCoinsMined'] ?? '',
            'block_reward' => $details['General']['BlockReward'] ?? '',
            'net_hases_per_second' => $details['General']['NetHashesPerSecond'] ?? '',

            'ico_status' => $details['ICO']['Status'] ?? '',
            'ico_description' => $details['ICO']['Description'] ?? '',
            'ico_token_supply' => $details['ICO']['ICOTokenSupply'] ?? '',
            'ico_start_date' => $details['ICO']['Date'] ?? '',
            'ico_end_date' => $details['ICO']['EndDate'] ?? '',
            'ico_fund_raised_btc' => $details['ICO']['FundsRaisedList'] ?? '',
            'ico_fund_raised_usd' => $details['ICO']['FundsRaisedUSD'] ?? '',
            'ico_start_price' => $details['ICO']['StartPrice'] ?? '',
            'ico_security_audit_company' => $details['ICO']['SecurityAuditCompany'] ?? '',
            'ico_legal_form' => $details['ICO']['LegalForm'] ?? '',
            'ico_jurisdiction' => $details['ICO']['Jurisdiction'] ?? '',
            'ico_legal_advisers' => $details['ICO']['LegalAdvisers'] ?? '',
            'ico_blog' => $details['ICO']['BlogLink'] ?? '',
            'ico_white_paper_link' => $details['ICO']['WhitePaperLink'] ?? ''
        ];
    }
	
    public function getAlias($symbol)
    {
        $name = CryptoMarkets::select('name')->where('symbol', '=', $symbol)->first();
        if($name) {
            return slugify($name['name']);
        }
        return $symbol;
    }

	public function cryptoMiningEquipment()
	{
        $equipments = json_decode(CurlCallController::curl('https://www.cryptocompare.com/api/data/miningequipment/'), true);
        if (isset($equipments['MiningData'])) {
            foreach ($equipments['MiningData'] as $equipment) {
                if(isset($equipments['Response']) && $equipments['Response'] == 'Success') {
                    $data = $this->prepareMiningEquipmentData($equipment);    
                    $this->crypto_mining->updateOrCreate(
                        ['alias' => $data['alias']],
                        $data
                    );
                }
            }
        }
	}
	
	public function prepareMiningEquipmentData($details)
	{
		$image_name = strtolower(slugify($details['Name'])) . '_.png';
		if(!file_exists(public_path('/images/mining/' . $image_name))) {
			$image = Image::make(file_get_contents('https://www.cryptocompare.com/'.$details['LogoUrl'])); //intervention imag library
			$image->fit(300, 300)->save(public_path('/images/mining/' . $image_name));
			$image->resize(45, 45)->save(public_path('/images/mining/thumbs/' . $image_name));
		}
		return [
			'company' => $details['Company'],
			'name' => $details['Name'],
			'alias' => slugify($details['Name']),
			'logo' => $image_name,
			'url' => $details['AffiliateURL'],
			'algorithm' => $details['Algorithm'],
			'hashes_per_second' => $details['HashesPerSecond'],
			'cost' => $details['Cost'],
			'currency' => $details['Currency'],
			'type' => $details['EquipmentType'],
			'power_consumption' => $details['PowerConsumption'],
			'currencies_available' => $details['CurrenciesAvailableName']
		];
	}
		
}