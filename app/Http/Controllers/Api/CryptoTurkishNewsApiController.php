<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\CryptoNews;
use DOMDocument;
class CryptoTurkishNewsApiController extends Controller
{

	public $crypto_news;	
	public function __construct()
	{
		$this->crypto_news = new CryptoNews;
	}

	public function getNews()
	{
		// $this->coingape(); // in progress
		$this->getCoinTurkFeed();
        $this->getKoinBulteniFeed();
        $this->getCoinAdamFeed();
	}
	
	public function getCoinTurkFeed()
	{
		$news_feed = simplexml_load_file('https://coin-turk.com/feed', null, LIBXML_NOCDATA);
        foreach ($news_feed->channel->item as $news) {
        	if(isset($news->description) && strlen($news->description) > 25 && isset($news->title) && strlen($news->title) > 4) {
	            $data = $this->prepareNewsData($news, 'Coin-turk.com');
	            $this->crypto_news->updateOrCreate(
	                ['alias' => $data['alias']],
	                $data
	            );
	        }
        }
	}

	public function getCoinAdamFeed()
	{
		$news_feed = simplexml_load_file('http://coinadam.com/feed/', null, LIBXML_NOCDATA);
        foreach ($news_feed->channel->item as $news) {
        	if(isset($news->description) && strlen($news->description) > 25 && isset($news->title) && strlen($news->title) > 4) {
	            $data = $this->prepareNewsData($news, 'Coinadam.com');
	            $this->crypto_news->updateOrCreate(
	                ['alias' => $data['alias']],
	                $data
	            );
	        }
        }
	}

	public function getKoinBulteniFeed()
	{
		$news_feed = simplexml_load_file('https://koinbulteni.com/feed', null, LIBXML_NOCDATA);

        foreach ($news_feed->channel->item as $news) {
        	if(isset($news->description) && strlen($news->description) > 25 && isset($news->title) && strlen($news->title) > 4) {
	            $data = $this->prepareNewsData($news, 'Koinbulteni.com');
	            $this->crypto_news->updateOrCreate(
	                ['alias' => $data['alias']],
	                $data
	            );
	        }
        }
	}

	function coingape()
	{
		$feeds = file_get_contents('https://coingape.com/feed/');
        $feeds = str_replace("<content:encoded>","<contentEncoded>",$feeds);
        $feeds = str_replace("</content:encoded>","</contentEncoded>",$feeds);
        $news_feed = simplexml_load_string($feeds, null, LIBXML_NOCDATA);

    	foreach ($news_feed->channel->item as $news) {
        	if(isset($news->description) && strlen($news->description) > 25 && isset($news->title) && strlen($news->title) > 4) {
	            $data = $this->prepareNewsData($news, 'Coingape.com');
	            $this->crypto_news->updateOrCreate(
	                ['alias' => $data['alias']],
	                $data
	            );
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
			'url' => isset($news->link) ? $news->link : '',
			'urlToImage' => $this->getImage($news->description),
			'publishedAt' => isset($news->pubDate) ? date("Y-m-d H:i:s", strtotime($news->pubDate)) : date("Y-m-d H:i:s"),
			'lang'=> 'tr'
		];
	}

	public function getImage($html)
	{
		$dom = new \DOMDocument();
		libxml_use_internal_errors(true);
	    $dom->loadHTML(mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8'));
	    libxml_clear_errors();
	    $dom->preserveWhiteSpace = false;
	    $imgs  = $dom->getElementsByTagName("img");
	    $links = array();
	    for($i = 0; $i < $imgs->length; $i++) {
	       $links[] = $imgs->item($i)->getAttribute("src");
	    }
	    return isset($links[0]) ? $links[0] : '';
	}

}
