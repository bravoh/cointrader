<?php
namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Twitter, Storage, File;
use App\{CryptoNews, CryptoMarkets};
class TwitterAutoPostController extends Controller
{

	public function post($post)
	{
		Twitter::postTweet(['status' => $post, 'format' => 'json']);

		// Twitter::reconfig([
		//     "consumer_key" => $consumer_key,
		//     "consumer_secret"  => $consumer_secret,
		//     "token" => $access_token,
		//     "secret" => $access_token_secret,
		// ]);

		// Twitter::postTweet(['status' => $post, 'format' => 'json']);		
	}

	public function postNews()
	{
		$news = $this->getNews();
		$url = $this->bitlyUrlShorten(env('SITE_URL') . "/en/crypto-news/". $news->id . "/" . $news->alias);
		$status = $news->title . "\n" . $this->getHashTags(8) . "\n" . $url;
		if(strlen($status) > 280) {
			$status = $this->getHashTags(8) . " " . $url;
		}
		if(strlen($status) <= 280) {
			$this->post($status);
		} else {
			$this->getTopCoinsPrices();
		}
		CryptoNews::where('id', $news->id)->update(['twitter_post' => 1]);
	}

	public function getNews()
	{
		$news = CryptoNews::where('twitter_post', '=', 0)->select('id', 'title', 'alias')
					->orderBy('created_at', 'desc')->first();
		$news->title = $this->getHashBasedTitle($news->title);
		return $news;
	}

	public function getTopCoinsPrices()
	{
		$markets = CryptoMarkets::select('name', 'price_usd')->orderBy('rank', 'asc')->limit(5)->get();
		$coins = "Top 5 #cryptocurrencies \n Alert Time: " . date("Y-m-d H:i:s", time()+10800) . "\n";
		foreach ($markets as $market) {
			$coins .= "#" . str_replace(' ', '', $market->name) . ": $" . number_format($market->price_usd, 5) . "\n";
		}
		$this->post($coins . $this->getHashTags(4) . "\n\n" . env('SITE_URL'));
	}
	
	public function getTopGainers()
	{
		$markets = CryptoMarkets::where('status', '=', 1)->where('percent_change_day', '>', 0)->orderBy('percent_change_day', 'desc')->limit(5)->get();
		$coins = "Top 5 #crypto gainers \n Alert Time: " . date("Y-m-d H:i:s", time()+10800) . "\n";
		foreach ($markets as $market) {
			$coins .= "#" . str_replace(' ', '', $market->name) . ": $" . number_format($market->price_usd, 5) . "\n";
		}
		$this->post($coins . $this->getHashTags(4) . "\n\n" . env('SITE_URL'));
	}

	public function getTopLosers()
	{
		$markets = CryptoMarkets::where('status', '=', 1)->where('percent_change_day', '<', 0)->orderBy('percent_change_day', 'asc')->limit(5)->get();
		$coins = "Top 5 #crypto losers \n Alert Time: " . date("Y-m-d H:i:s", time()+10800) . "\n";
		foreach ($markets as $market) {
			$coins .= "#" . str_replace(' ', '', $market->name) . ": $" . number_format($market->price_usd, 5) . "\n";
		}
		$this->post($coins . $this->getHashTags(4) . "\n\n" . env('SITE_URL'));
	}

	public function getHashBasedTitle($title)
	{
		return $title;
		$stopWords = stopWords();
		$news_title = explode(' ', $title);
		$title = '';
		foreach ($news_title as $word) {
			if(!in_array(strtolower(trim($word)), $stopWords)) {
				$title .= '#' . $word . ' ';
			} else {
				$title .= $word . ' ';
			}
		}
		return ucfirst(strtolower($title));
	}

	public function getHashTags($cloudSize)
	{
		return implode(' ', array_values($this->hashCloud($cloudSize)));
	}

	public function hashCloud($cloudSize)
	{
		$hashCloud = [
			'#instacryptocurrency',
		 	'#instabitcoin', '#instablockchain', '#instacrypto',
		 	'#instabtc', '#instaico',
		 	'#instaethereum', '#instaeth',
		 	'#instavenezuela', '#instanews',
		 	'#instaairdrop', '#cryptocurrency',
		 	'#bitcoin', '#blockchain', '#crypto',
		 	'#btc', '#btcnews', '#ico', '#ethereum', '#airdrop',
		 	'#xrp', '#ripple', '#ripplenews', '#trx',
		 	'#trading', '#altcoin', '#altcoins', '#monero',
		 	'#cryptocurrencymarket', '#newcryptocurrency',
		 	'#cryptocurrencymarket', '#pumpanddump',
		 	'#coinbase', '#binance', '#bittrex', '#SmartContracts', 
		 	'#SecretContracts', '#FreeCoin', '#SmartCash', '#fintech',
		 	'#cryptonews', '#IoT', '#AI', '#BigData', '#dapp', 
		 	'#decentralized', '#trading', '#ltc', '#enigma', '#digialcurrency', '#virtualcurrency',
		 	'#tothemoon','#investing','#hodl','#shill','#lambo','#buyorders','#sellorders','#FUD',
		 	'#hardfork','#altcoins','#mining','#trading','#investor','#investments','#btfd','#fomo',
		 	'#ath','#alltimehigh','#moon','#bullrun','#bearrun','#softcap','#hotwallet','#coldwallet',
		 	'#coldstorage','#publickey','#node','#premining','#hashrate','#pow','#pos','#proofofwork','#proofofstake',
		 	'#dapps', '#hardcap','#dash','#neo','#stellar','#cardano','#eos','#zcash','#kucoin','#bitfinex','#er20', '#erc20',
		 	'#cryptokitties', '#coinmarketcap', '#bitcoincash', '#bch', '#steemit', '#steem'
		];
		$rand_numbers = array_rand($hashCloud, $cloudSize);
		$hashes = [];
		foreach ($rand_numbers as $rand_number) {
			$hashes[] = $hashCloud[$rand_number];
		}
		return $hashes;
	}

	function bitlyUrlShorten($url) {
	    $login = env('BITLY_LOGIN');
	    $apikey = env('BITLY_APIKEY');
	    $format = "json";
	    $query = array("login" => $login, "apiKey" => $apikey, "longUrl" => $url, "format" => $format);
	    $query = http_build_query($query);
	    $final_url = "http://api.bitly.com/v3/shorten?" . $query;
	    if (function_exists("file_get_contents")) {
	        $response = file_get_contents($final_url);
	    } else {
	        $ch = curl_init();
	        $timeout = 5;
	        curl_setopt($ch, CURLOPT_URL, $final_url);
	        curl_setopt($ch, CURLOPT_HEADER, 0);
	        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,false);
	        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
	        $response = curl_exec($ch);
	        curl_close($ch);
	    }
	    $response = json_decode($response);
	    if($response->status_code == 200 && $response->status_txt == "OK") {
	        return $response->data->url;
	    } else{
	        return $url;
	    }
	}

}
