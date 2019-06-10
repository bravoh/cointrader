<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use TCG\Voyager\Models\Post;
use DB;
use Carbon\Carbon;
class CryptoCCTNewsFeedController extends Controller
{

	public function getFeed()
	{
		$today = Carbon::tomorrow()->toDateString();
		$day_before_yesterday = Carbon::now()->subDays(5)->toDateString();		
		$posts = Post::select('title', 'excerpt', 'image', 'created_at', 'slug')
			->whereBetween('created_at', [$day_before_yesterday, $today])
			->orderBy('created_at', 'desc')
			->get();
		$posts_array = $post_data = [];
		foreach ($posts as $post) {
			if(file_exists('public/storage/' . $post->image)) {
				$post->image = URL::asset('public/storage/' . $post->image);
			}
			$post_data['title'] = $post->title;
			$post_data['description'] = $post->excerpt;
			$post_data['image_link'] = $post->image;
			$post_data['pubDate'] = date('Y-m-d H:i:s', strtotime($post->created_at));
			$post_data['link'] = "https://cryptocurrencytracker.info/blog/" . $post->slug;
			$posts_array[] = $post_data;
		}
		return $posts_array;
	}

	public function insertPost()
	{
		$feeds = file_get_contents('https://coinsutra.com/blog/feed/');
        $feeds = str_replace("<content:encoded>","<contentEncoded>", $feeds);
        $feeds = str_replace("</content:encoded>","</contentEncoded>", $feeds);
        $news_feed = simplexml_load_string($feeds, null, LIBXML_NOCDATA);
        if(isset($news_feed->channel->item)) {
	        foreach ($news_feed->channel->item as $news) {
	        	if(isset($news->description) && strlen($news->description) > 15 && isset($news->title) && strlen($news->title) > 4) {
		            $data = $this->prepareNewsData($news, 'Coinsutra.com');
		            Post::updateOrCreate(
		                ['slug' => $data['slug']],
		                $data
		            );
		        }
	        }
	    }
	}

	public function prepareNewsData($news, $author)
	{
		if(isset($news->contentEncoded)) {
			$news_content = $news->contentEncoded;
		} else {
			$news_content = $news->description;
		}

		return [
			'author_id' => 0,
			'title' => $news->title,
			'seo_title' => $news->title,
			'excerpt' => str_limit(strip_tags($news->description), 300),
			'body' => $this->cleanBody($news_content) . 'News appeared first on: ' . $author,
			'image' => $this->getImage($news_content),
			'slug' => slugify($news->title),
			'meta_description' => str_limit(strip_tags($news->description), 280),
			'status' => 'PUBLISHED',
			'created_at' => isset($news->pubDate) ? date("Y-m-d H:i:s", strtotime($news->pubDate)) : date("Y-m-d H:i:s")
		];
	}

	function cleanBody($content)
	{
		$remove_links = preg_replace('#<a.*?>(.*?)</a>#i', '\1', $content);
		$remove_text = preg_replace('/Here are a few[\s\S]+?CoinSutra - Bitcoin Community./', '', $remove_links) . ' cct_web.';
		$remove_text = preg_replace('/Further suggested readings:[\s\S]+?cct_web./', '', $remove_text);
		return preg_replace('/appeared first on[\s\S]+?Bitcoin Community./', '', str_replace('cct_web.', '', $remove_text));
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
