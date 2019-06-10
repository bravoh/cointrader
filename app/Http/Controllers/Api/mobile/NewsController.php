<?php
namespace App\Http\Controllers\Api\Mobile;
use App\Http\Controllers\Controller;
use App\CryptoNews;
use DB, URL;
class NewsController extends Controller
{

	public function getAll($limit = '')
	{
		if($limit != '') {
			$news_data = CryptoNews::orderBy('id', 'desc')->limit($limit)->get();
		} else {
			$news_data = CryptoNews::orderBy('id', 'desc')->get();
		}

		$data = [];
		foreach ($news_data as $news) {
			if(file_exists("public/storage/" . $news->urlToImage)) {
	            $image = URL::asset("public/storage") . '/' . $news->urlToImage;
	        } else {
	            $image = $news->urlToImage;
	        }
			$news->url = env('SITE_URL') . '/crypto-news/' . $news->id . '/' . $news->alias;
			$news->urlToImage = $image;
			$data[] = $news;
		}
		return $data;
	}

	public function searchNews($query = '')
	{
		$like = '';
		if($query != '') {
			$params = explode(' ', $query);
			foreach ($params as $value) {
				$like .= " `title` LIKE '%".$value."%' OR ";
			}
		}
		$news_data = DB::select( 
			DB::raw("SELECT id, author, urlToImage, title, alias, description, publishedAt 
			FROM `crypto_news` WHERE `status` = 1 AND 
			" . $like . " `title` LIKE '%".$query."%'
			AND `publishedAt` BETWEEN " . (time()-7890000) . " AND " . time() . " ORDER BY publishedAt DESC LIMIT 50") 
		);
		$data = [];
		foreach ($news_data as $news) {
			if(file_exists("public/storage/" . $news->urlToImage)) {
	            $image = URL::asset("public/storage") . '/' . $news->urlToImage;
	        } else {
	            $image = $news->urlToImage;
	        }
			$news->url = env('SITE_URL') . '/crypto-news/' . $news->id . '/' . $news->alias;
			$news->urlToImage = $image;
			$data[] = $news;
		}
		return $data;
	}

}