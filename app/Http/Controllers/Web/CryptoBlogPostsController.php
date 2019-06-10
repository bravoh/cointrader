<?php
namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;

use App\Http\Controllers\Web\CryptoNewsController;
use TCG\Voyager\Models\Post;
class CryptoBlogPostsController extends Controller
{
	public $news;
	
	public function __construct()
	{
		$this->news = new CryptoNewsController;
	}

	public function index($slug = '')
	{
		if($slug == '') {
			return redirect(makeUrl('crypto-coins-news-headlines'));
		}
		$post = Post::where('slug', '=', $slug)->first();
		if($post) {
			$data = [
				'post' => $post,
				'crypto_related_news' => $this->news->getRelatedNews(0, 6),
				'crypto_most_read_news' => $this->news->getMostReadNews(0, 9, 6)
			];
			return view(getCurrentTemplate() . '.pages.blog_post', $data);
		}
		return redirect(makeUrl('crypto-coins-news-headlines'));
	}


	public function blog()
	{
		$posts = Post::orderBy('created_at', 'desc')->simplePaginate(25);
		$data = [
			'posts' => $posts
		];
		return view(getCurrentTemplate() . '.pages.blog', $data);
	}

}
