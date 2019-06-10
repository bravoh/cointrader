<?php
namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;

use App\{CryptoNews, NewsLetter};
use TCG\Voyager\Models\Post;
use LaravelLocalization;
use DB, Validator, Mail;
use Illuminate\Support\Facades\Input;
use Illuminate\Pagination\Paginator;
class CryptoNewsController extends Controller
{
	public function index()
	{
		$crypto_news = CryptoNews::where('status', '=', 1)->orderBy('publishedAt', 'desc')->whereIn('lang', ['en'])->limit(45)->get()->toArray();
		$turk_news = [];
		if(LaravelLocalization::getCurrentLocale() != 'en') {
			$turk_news_object = CryptoNews::where('status', '=', 1)->orderBy('publishedAt', 'desc')->where('lang', '=', LaravelLocalization::getCurrentLocale())->limit(45);
			if($turk_news_object->count() > 0) {
				$turk_news = $turk_news_object->get()->toArray();
			}
			if($turk_news_object->count() > 45) {
				$crypto_news = $turk_news;
			} else {
				$crypto_news = array_merge($turk_news, array_slice($crypto_news, 0, 45-$turk_news_object->count()));
			}
		}
		$editors_news = 3;
		$ccn_news = 5;
		if(getCurrentTemplate() == 'classic') {
			$editors_news = 5;
			$ccn_news = 3;
		}

		$data = [
			'crypto_news' => array_slice($crypto_news, 0, 5),
			'btc_news' => array_slice($crypto_news, 5, 5),
			'bitcoinist_news' => array_slice($crypto_news, 10, 5),
			'ccn_news' => array_slice($crypto_news, 15, $ccn_news),

			'coin_desk_news' => array_slice($crypto_news, 18, 3),
			'coin_telegraph_news' => array_slice($crypto_news, 21, 3),

			'the_merkle_news' => array_slice($crypto_news, 24, 5),
			'news_btc_news' => array_slice($crypto_news, 29, 5),
			'crypto_globe_news' => array_slice($crypto_news, 34, $editors_news),
			 
			'core_media_news' => array_slice($crypto_news, 35, 1),

			'live_btc_news' => array_slice($crypto_news, 36, 1), 
			'magnates_news' => array_slice($crypto_news, 37, 1),
			'trust_nodes_news' => array_slice($crypto_news, 38, 1),
			'btc_magazine_news' => array_slice($crypto_news, 39, 1)
		];
		return view(getCurrentTemplate() . '.pages.news', $data);
	}

	public function getNewsByAutors($author, $limit)
	{
		return CryptoNews::orderBy('publishedAt', 'desc')
				->where('author', '=', $author)->take($limit)->get();
	}

	public function news($id, $alias)
	{
		$crypto_news = CryptoNews::where('id', $id)->first();
		if(isset($crypto_news->title)) {
			$data = [
				'crypto_news' => $crypto_news,
				'crypto_related_news' => $this->getRelatedNews($id, 6),
				'crypto_most_read_news' => $this->getMostReadNews($id, 8, 6),
				'crypto_news_from_bitcoin' => $this->getNewsFromBitcoin($id, 9)
			];
			return view(getCurrentTemplate() . '.pages.single_news', $data);
		}
		return redirect('/crypto-coins-news-headlines');
	}

	public function getRelatedNews($id, $limit)
	{
		return CryptoNews::where('status', '=', 1)->orderBy('publishedAt', 'desc')
				->where('id', '!=', $id)->take($limit)->get();
	}

	public function getMostReadNews($id, $limit, $skip)
	{
		return CryptoNews::where('status', '=', 1)->orderBy('publishedAt', 'desc')
				->where('id', '!=', $id)->skip($skip)->take($limit)->get();
	}

	public function getNewsFromBitcoin($id, $limit)
	{
		return CryptoNews::where('status', '=', 1)->orderBy('publishedAt', 'desc')->take($limit)
				->where('author', '=', 'Bitcoin.com')
				->where('id', '!=', $id)
				->get();
	}

	public function searchNews()
	{
		$query = $like = '';
		if(isset($_GET['q'])) {
			$query = filter_input(INPUT_GET, 'q', FILTER_SANITIZE_SPECIAL_CHARS);
			$params = explode(' ', $query);
			foreach ($params as $value) {
				$like .= " `title` LIKE '%".$value."%' OR ";
			}
		}
		$news = DB::select( 
					DB::raw("SELECT id, author, title, alias, description, publishedAt 
					FROM `crypto_news` WHERE `status` = 1 AND 
					" . $like . " `title` LIKE '%".$query."%'
					AND `publishedAt` BETWEEN " . (time()-7890000) . " AND " . time() . " ORDER BY publishedAt DESC LIMIT 50") 
				);
		return view(getCurrentTemplate() . '.pages.news_search', ['crypto_news' => $news, 'query' => $query]);
	}

	/**
	* Newsletter related code
	**/

	public function saveNewsLetterSubscription()
	{
		$rules = [
		    'email'    => 'required|email|min:5|max:250',
		];
		$validator = Validator::make(Input::all(), $rules);
		if ($validator->fails()) {
		    return 'false';
		} else {
		    if (NewsLetter::updateOrCreate(request(['email']))) {
		    	return 'true';
		    } else {
		    	return 'false';
		    }
		}
	}

	public function composeNewsLetter()
	{
		$news = CryptoNews::where('lang', '=', 'en')->orderBy('publishedAt', 'desc')->take(10)->get();
		$post = Post::orderBy('created_at', 'desc')->first();
		$emails = NewsLetter::select('email')->get();
		foreach ($emails as $email) {
			$data = ['news' => $news, 'post' => $post];
			Mail::send('emails.newsletter', $data, function ($message) use ($email) {
			    $message->from(env('MAIL_EMAIL_ADDRESS'), setting('site.site_name'));
			    $message->subject(__(setting('site.site_name') . ' - Newsletter'));
			    $message->to($email->email);
			});
			sleep(1);
		}
	}


}
