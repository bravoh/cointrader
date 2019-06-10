<?php
namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\CryptoNews;
class RSSFeedController extends Controller
{
	public function index()
	{
		header("Content-Type: application/xml");

		$rssfeed = '<?xml version="1.0" encoding="ISO-8859-1"?>';
	    $rssfeed .= '<rss version="2.0">';
	    $rssfeed .= '<channel>';
	    $rssfeed .= '<title>News RSS feed</title>';
	    $rssfeed .= '<link>' . env('SITE_URL') . '</link>';
	    $rssfeed .= '<description>This is an example RSS feed</description>';
	    $rssfeed .= '<language>en-us</language>';
	    $rssfeed .= '<copyright>Copyright (C) ' . date("y") . env('SITE_URL') . '</copyright>';

	    $news = CryptoNews::orderBy('publishedAt', 'desc')->limit(15)->get();

	    foreach ($news as $single_news) {
	 
	        $rssfeed .= '<item>';
	        $rssfeed .= '<title>' . preg_replace('/&(?!#?[a-z0-9]+;)/', '&amp;', $single_news->title) . '</title>';
	        $rssfeed .= '<description>' . preg_replace('/&(?!#?[a-z0-9]+;)/', '&amp;', str_limit($single_news->description, 300)) . '</description>';
	        $rssfeed .= '<link>' . env('SITE_URL') . '/en/crypto-news/' . $single_news->id .'/'. $single_news->alias . '</link>';
	         $rssfeed .= '<image>' . $single_news->urlToImage . '</image>';
	        $rssfeed .= '<pubDate>' . date("D, d M Y H:i:s O", strtotime($single_news->publishedAt)) . '</pubDate>';
	        $rssfeed .= '</item>';
	    }
	 
	    $rssfeed .= '</channel>';
	    $rssfeed .= '</rss>';

	    echo $rssfeed;
	}	

}