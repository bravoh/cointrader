<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\{Controller, CurlCallController};
use App\CryptoNews;
class CryptoCCTNewsApiController extends Controller
{

	public $crypto_news;	
	public function __construct()
	{
		$this->crypto_news = new CryptoNews;
	}

	public function getNews()
	{
		$this->getCCTFeed();
	}
	
	public function getCCTFeed()
	{
		$news_feed = json_decode(CurlCallController::curl('https://cryptocurrencytracker.info/api/cct-feed', true));
	    if(isset($news_feed[0]->title) && isset($news_feed[0]->description)) {
	        foreach ($news_feed as $news) {
	        	if(isset($news->description) && strlen($news->description) > 25 && isset($news->title) && strlen($news->title) > 4) {
		            $data = $this->prepareNewsData($news, 'Cryptocurrencytracker.info');
		            $this->crypto_news->updateOrCreate(
		                ['alias' => $data['alias']],
		                $data
		            );
		        }
	        }
	    }
	}

	public function prepareNewsData($news, $author)
	{
		return [
			'author' => $author,
			'title' => $news->title,
			'alias' => slugify($news->title),
			'description' => strip_tags($news->description),
			'url' => isset($news->link) ? $news->link : 'http://cryptocurrencytracker.info/en/crypto-coins-news-headlines',
			'urlToImage' => $news->image_link,
			'publishedAt' => isset($news->pubDate) ? $news->pubDate : date("Y-m-d H:i:s"),
			'lang'=> 'en'
		];
	}

}
