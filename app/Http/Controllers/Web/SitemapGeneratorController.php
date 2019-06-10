<?php
namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App, URL, DB;
class SitemapGeneratorController extends Controller
{

	public function generate()
	{		
		$langs = DB::table('available_languages')->select('code')->where('status', '=', 1)->get();	   
		$this->subSitemaps($langs);
		$this->gatherAllSubSitemaps($langs);
	}

	public function gatherAllSubSitemaps($langs)
	{
		$all_sitemaps = App::make("sitemap");
		$categories = ['coins', 'site'];
		$newsCount = DB::table('crypto_news')->count();
		foreach ($langs as $lang) {
			foreach ($categories as $category) {
				$all_sitemaps->addSitemap(env('SITE_URL') . '/sitemap/sitemap-' . $category . '-' . $lang->code . '.xml', date("Y-m-d H:i:s"));
			}
			for($i=0; $i<ceil($newsCount/2000); $i++) {
				$all_sitemaps->addSitemap(env('SITE_URL') . '/sitemap/sitemap-news-' . $i . '-' . $lang->code . '.xml', date("Y-m-d H:i:s"));
			}
		}
	    $all_sitemaps->store('sitemapindex', 'sitemap', base_path());
	}

	public function subSitemaps($langs)
	{
	    foreach ($langs as $lang) {
	    	$this->generateSitePagesSiteMap($lang->code);
			$this->generateCoinsDetailsSiteMap($lang->code);
		}
		$this->generateNewsSiteMap($langs);
	}

	public function generateNewsSiteMap($langs)
	{
		$newsCount = DB::table('crypto_news')->count();
		$all_sitemap = App::make("sitemap");
		for($i=0; $i<ceil($newsCount/2000); $i++) {
			$news_results = DB::table('crypto_news')
			->select('id', 'alias', 'updated_at')
			->offset($i*2000)
			->limit(2000)
			->orderBy('id', 'desc')->get();
			foreach ($langs as $lang) {
				$sitemap = App::make("sitemap");
				foreach ($news_results as $news) {
			    	$news_url = env('SITE_URL') . '/' . $lang->code . '/crypto-news/' . $news->id . '/' . $news->alias;
			        $sitemap->add($news_url, $news->updated_at, '1', 'daily');
			    }
			    $sitemap->store('xml', 'sitemap/sitemap-news-' . $i . '-' . $lang->code, base_path());
			}
		}
	}

	public function generateSitePagesSiteMap($lang)
	{
		$langs_priority = ['en' => 1, 'ru' => 0.9, 'tr' => 0.9, 'et' => 0.8];
		$sitemap = App::make("sitemap");
    	foreach ($this->siteStaticUrls($lang) as $site_url) {
    		$priority = isset($langs_priority[$lang]) ? $langs_priority[$lang] : 0.8;
    		$sitemap->add($site_url, date("Y-m-d H:i:s"), $priority, 'daily'); //['images'=> ['url' =>'test.png']]
    	}
	
		$pages = DB::table('pages')->select('slug', 'updated_at')->orderBy('id', 'desc')->get();
	    foreach ($pages as $page) {
	    	$page_url = env('SITE_URL') . '/' . $lang . '/page/' . $page->slug;
	        $sitemap->add($page_url, $page->updated_at, '0.9', 'weekly');
	    }
	
		$posts = DB::table('posts')->select('slug', 'updated_at')->orderBy('id', 'desc')->get();
	    foreach ($posts as $post) {
	    	$post_url = env('SITE_URL') . '/' . $lang . '/blog/' . $post->slug;
	        $sitemap->add($post_url, $post->updated_at, '0.9', 'daily');
	    }
	    $sitemap->store('xml', 'sitemap/sitemap-site-' . $lang, base_path());
	}

	public function generateCoinsDetailsSiteMap($lang)
	{
		$details = DB::table('crypto_coins_full_details')->select('alias', 'updated_at')->orderBy('id', 'desc')->get();
		$sitemap = App::make("sitemap");
	    foreach ($details as $detail) {
	    	$detail_url = env('SITE_URL') . '/' . $lang . '/currencies/' . $detail->alias;
	        $sitemap->add($detail_url, $detail->updated_at, '0.9', 'weekly');
	    }
	    $sitemap->store('xml', 'sitemap/sitemap-coins-' . $lang, base_path());
	}

	public function siteStaticUrls($lang)
	{
		return [
			0 => env('SITE_URL') . '/' . $lang,
			1 => env('SITE_URL') . '/' . $lang . '/currencies',
			3 => env('SITE_URL') . '/' . $lang . '/top-gainers-crypto-currencies',
			4 => env('SITE_URL') . '/' . $lang . '/top-losers-crypto-currencies',
			5 => env('SITE_URL') . '/' . $lang . '/high-low-crypto-currencies',
			6 => env('SITE_URL') . '/' . $lang . '/crypto-exchanges',
			7 => env('SITE_URL') . '/' . $lang . '/crypto-coins-news-headlines',
			8 => env('SITE_URL') . '/' . $lang . '/crypto-ico',
			9 => env('SITE_URL') . '/' . $lang . '/events',
			10 => env('SITE_URL') . '/' . $lang . '/mining-pools',
			11 => env('SITE_URL') . '/' . $lang . '/wallets',
			12 => env('SITE_URL') . '/' . $lang . '/user/favorites-coins',
			13 => env('SITE_URL') . '/' . $lang . '/user/login',
			14 => env('SITE_URL') . '/' . $lang . '/user/register',
			15 => env('SITE_URL') . '/' . $lang . '/crypto-mining-equipment',
			16 => env('SITE_URL') . '/' . $lang . '/advertise',
			17 => env('SITE_URL') . '/' . $lang . '/contact-us',
		];
	}

}
