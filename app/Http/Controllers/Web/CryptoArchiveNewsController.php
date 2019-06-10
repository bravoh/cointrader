<?php
namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;

use App\CryptoNews;
use DB;
class CryptoArchiveNewsController extends Controller
{
	public function index($news_date = '')
	{
		if($news_date != '') {
			$archive_news = DB::table('crypto_news')->where(DB::raw("DATE_FORMAT(FROM_UNIXTIME(publishedAt),'%Y-%m-%d')"), '=', $news_date)->get();
			return view(getCurrentTemplate(). '.pages.archive_news_by_date', ['archive_news' => $archive_news, 'news_date' => $news_date]);	
		}
		$archive_news = CryptoNews::orderBy('publishedAt', 'desc')->get()->groupBy(function($date) {
			return date("Y-m-d", strtotime($date->publishedAt));
		});
		return view(getCurrentTemplate(). '.pages.archive_news', ['archive_news' => $archive_news]);
	}

}
