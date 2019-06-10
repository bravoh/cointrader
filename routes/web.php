<?php
Route::group([
	'prefix' => LaravelLocalization::setLocale(),
	'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ]
],
function() {
	Route::get('/dashboard', 'Web\CryptoDashboardController@index');
	
	Route::get('/currencies', 'Web\CryptoCurrenciesController@liveCurrenciesUpdates');
	Route::get('/currencies/{alias?}', 'Web\CryptoCurrenciesController@index');
	Route::get('/top-gainers-crypto-currencies', 'Web\CryptoCurrenciesController@topGainersCurrencies');
	Route::get('/top-losers-crypto-currencies', 'Web\CryptoCurrenciesController@topLosersCurrencies');
	Route::get('/high-low-crypto-currencies', 'Web\CryptoCurrenciesController@allTimeHighLowCurrencies');

	Route::get('/crypto-exchanges', 'Web\CryptoExchangesController@index');

    Route::get('/crypto-exchange', 'Web\ExchangeController@index');
    Route::get('tbc-exchange', 'Web\ExchangeController@tbcExchange');
    Route::get('/crypto-receive-rates', 'Web\ExchangeController@receive_rates');
    Route::match(['get'],'/change/{pair_id}', 'Web\ExchangeController@change');
    Route::match(['post'],'/change', 'Web\ExchangeController@change')->name("bitChange");

    Route::match(['get'],'checkout/{id}', 'Web\ExchangeController@checkout')->name('checkout.get');
    Route::match(['post'],'checkout', 'Web\ExchangeController@checkout')->name('checkout.post');
    Route::match(['get'],'/receipt/{payment_id}', 'Web\PaymentController@receipt');

	Route::get('/crypto-coins-news-headlines', 'Web\CryptoNewsController@index');
	Route::get('/crypto-coins-news-search', 'Web\CryptoNewsController@searchNews');
	Route::get('/crypto-news/{id}/{alias}', 'Web\CryptoNewsController@news');
	Route::get('archive-news/{date?}', 'Web\CryptoArchiveNewsController@index');
	Route::get('blog', 'Web\CryptoBlogPostsController@blog');
	Route::get('blog/{slug?}', 'Web\CryptoBlogPostsController@index');
	Route::get('page/{alias}', 'Web\PagesController@index');
	
	Route::get('/crypto-ico', 'Web\CryptoIcoController@index');
	Route::get('/crypto-ico/{ico?}', 'Web\CryptoIcoController@ico');
	
	Route::get('crypto-mining-equipment', 'Web\CryptoMiningEquipmentController@index');
	Route::get('buy-sell-cryptocoins', 'Web\CryptoBuySellController@index');
	Route::get('cryptocurrency-converter', 'Web\CryptoConverterController@index');
	Route::get('cryptocurrency-widgets', 'Web\CryptoWidgetsController@index');
	Route::get('block-explorer/{hash?}', 'Web\CryptoBlockExplorerController@index');

	Route::get('mining-pools', 'Web\PoolsController@index');
	Route::get('mining-pools/hashrate-distribution', 'Web\PoolsController@hashrateDistribution');
	Route::get('mining-pools/{alias?}', 'Web\PoolsController@pool');
	Route::get('wallets', 'Web\WalletsController@index');
	Route::get('wallets/{wallet?}', 'Web\WalletsController@wallet');
	Route::get('events', 'Web\EventsController@index');
	Route::get('events/{event?}', 'Web\EventsController@event');

	Route::get('user/login', 'Web\UserController@login');
	Route::get('user/register', 'Web\UserController@register');
	Route::get('user/profile', 'Web\UserController@profile');
	Route::get('user/favorites-coins', 'Web\UserController@favorites');
	Route::get('user/logout', 'Web\UserController@logout');
	Route::get('user/verify', 'Web\UserController@verify');
	Route::get('user/forgot', 'Web\UserController@forgot');
	Route::get('user/login/facebook', 'Web\UserController@facebookLogin');
	Route::get('user/login/facebook/callback', 'Web\UserController@facebookLoginCallback');
	Route::get('user/login/twitter', 'Web\UserController@twitterLogin');
	Route::get('user/login/twitter/callback', 'Web\UserController@twitterLoginCallback');
	Route::post('user/login', 'Web\UserController@doLogin');
	Route::post('user/register', 'Web\UserController@doRegistration');
	Route::post('user/profile', 'Web\UserController@updateProfile');
	Route::post('user/forgot', 'Web\UserController@submitForgotPassword');
	Route::post('user/change_password', 'Web\UserController@changePassword');
	Route::get('user/download-account-data', 'Web\UserController@downloadAccountData');
	Route::get('user/delete-account', 'Web\UserController@deleteAccountForm');
	Route::post('user/delete-account', 'Web\UserController@deleteAccount');

	Route::get('user/blockfolio', 'Web\BlockfolioController@index');
	Route::get('user/add-blockfolio', 'Web\BlockfolioController@addCoinForm');
	Route::post('user/add-coin', 'Web\BlockfolioController@addCoin');
	Route::get('user/remove-coin/{id}/{tx_id}', 'Web\BlockfolioController@removeFromBlockfolio');
	Route::get('user/transactions-history', 'Web\BlockfolioController@blockfolioTransactionsHistory');

	Route::get('advertise', 'Web\PagesController@advertise');
	Route::get('contact-us', 'Web\PagesController@contactUs');
	Route::post('contact-us', 'Web\PagesController@contactUsSave');

	/**
	 * Widgets
	 */
	Route::get('widget/ticker/{coin?}/{currency?}', 'Web\CryptoWidgetsController@ticker');
	Route::get('widget/dominance-chart', 'Web\CryptoWidgetsController@dominanceChart');
	
	/**
	 * Admin Panel
	 */
	Route::group(['prefix' => 'admin'], function () {
	    Voyager::routes();
	});


	/**
	* Set as a main page, put below mentioned pages controllers to change your default main page
	* 
	* If you want another page as a home page then copy controller from above list which page you want as a home page
	*
	* Dashboard page - Web\CryptoDashboardController@index
	* For live page - Web\CryptoCurrenciesController@liveCurrenciesUpdates
	* New Page - Web\CryptoNewsController@index
	* 
	*/

	//Route::get('/', 'Web\CryptoDashboardController@index');
    Route::get('/', 'Web\ExchangeController@index');


	Route::get('/live-crypto-currencies-updates', function() {
		return redirect('/currencies');
	});

});

/**
* Ajax Calls
*/
Route::get('/ajax-load-trading-paris/{coin}', 'Web\CryptoDashboardController@getTopTradingPairs');
Route::get('/ajax-load-coin-data', 'Web\CryptoCurrenciesController@getNameAndAliasForCoinSearch');
Route::get('/ajax-load-historical-data/{coin}/{time_frame}/{currency}', 'Web\ChartsAjaxController@getHistoricalDayData');
Route::get('/ajax-load-historical-data-candle/{coin}/{time_frame}/{currency}/{dashboard?}', 'Web\ChartsAjaxController@getHistoricalDayDataCandle');
Route::get('/ajax-save-favorite-coin/{coin}', 'Web\UserController@ajaxSaveFavoriteCoin');

Route::get('/ajax-get-exchanges/{coin}', 'Web\BlockfolioController@getExchanges');
Route::get('/ajax-get-pairs/{coin}/{exchange}', 'Web\BlockfolioController@getPairs');
Route::get('/ajax-get-price/{exchange}/{pair}', 'Web\BlockfolioController@getPrice');
Route::get('/ajax-get-pair-price', 'Web\BlockfolioController@getPairPrice');
Route::post('/ajax-save-newsletter', 'Web\CryptoNewsController@saveNewsLetterSubscription');

/**
 * Generate Sitemap
 */
Route::get('generate-sitemap', 'Web\SitemapGeneratorController@generate');

/**
 * Post on twitter
 */
Route::get('twitter-post-news', 'Web\TwitterAutoPostController@postNews');
Route::get('twitter-post-topcoins', 'Web\TwitterAutoPostController@getTopCoinsPrices');
Route::get('twitter-post-topgainers', 'Web\TwitterAutoPostController@getTopGainers');
Route::get('twitter-post-toplosers', 'Web\TwitterAutoPostController@getTopLosers');

/**
* Newletter
**/
Route::get('newsletter', 'Web\CryptoNewsController@composeNewsLetter');

/**
 * Clear cache
 */
Route::get('/clear-cache', 'Web\ClearCacheController@index');

/**
 * RSS feed
 */
Route::get('/rss', 'Web\RSSFeedController@index');

/**
* Cron
*/
Route::get('/cron', function() {
	Artisan::call('schedule:run');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
