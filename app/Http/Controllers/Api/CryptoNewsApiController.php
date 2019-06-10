<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\{Controller,CurlCallController};
use App\CryptoNews;

class CryptoNewsApiController extends Controller
{

	public $crypto_news;	
	public function __construct()
	{
		$this->crypto_news = new CryptoNews;
	}

	public function getNews()
	{
		if(setting('3rdparty.news_apikey') != '') {
			$apiKey = setting('3rdparty.news_apikey');
		} else {
			$apiKey = '73856379751b4986b00d72ef47bbbea7';
		}
		$news_feed = json_decode(CurlCallController::curl('https://newsapi.org/v2/top-headlines?sources=crypto-coins-news&apiKey=' . $apiKey), true);
        foreach ($news_feed['articles'] as $news) {
        	if(isset($news['description']) && strlen($news['description']) > 60 && isset($news['author'])) {
	            $data = $this->prepareNewsData($news);
	            $this->crypto_news->updateOrCreate(
	                ['alias' => $data['alias']],
	                $data
	            );
	        }
        }

        $this->cryptoCompareNews();
	}

	public function prepareNewsData($news)
	{
		return [
			'author' => $news['author'],
			'title' => $news['title'],
			'alias' => slugify($this->getStopWordsCleanTitle($news['title'])),
			'description' => $news['description'],
			'url' => $news['url'],
			'urlToImage' => $news['urlToImage'],
			'publishedAt' => $news['publishedAt'],
		];
	}

	public function cryptoCompareNews()
	{
		$news_feed = json_decode(CurlCallController::curl('https://min-api.cryptocompare.com/data/news/?lang=EN'), true);
        foreach ($news_feed as $news) {
        	if(isset($news['body']) && strlen($news['body']) > 60 && isset($news['source_info']['name'])) {
	            $data = $this->prepareCryptCompareNewsData($news);
	            $this->crypto_news->updateOrCreate(
	                ['alias' => $data['alias']],
	                $data
	            );
	        }
        }
	}

	public function prepareCryptCompareNewsData($news)
	{
		return [
			'author' => isset($news['source_info']['name']) ? $news['source_info']['name'] : '',
			'title' => $news['title'],
			'alias' => slugify($this->getStopWordsCleanTitle($news['title'])),
			'description' => $news['body'],
			'url' => $news['url'],
			'urlToImage' => $news['imageurl'],
			'publishedAt' => date("Y-m-d H:i:s", $news['published_on']),
		];
	}

	public function newsFeedForMobileApp()
	{
		return $this->crypto_news::select('id','author','title', 'alias','description', 'urlToImage', 'publishedAt')
					->take(20)->orderBy('publishedAt', 'desc')
					->get();
	}

	public function getStopWordsCleanTitle($title)
	{
		$stopWords = stopWords();
		$news_title = explode(' ', $title);
		$title = '';
		foreach ($news_title as $word) {
			if(!in_array(strtolower(trim($word)), $stopWords)) {
				$title .= '#' . $word . ' ';
			}
		}
		return $title;
	}

}
