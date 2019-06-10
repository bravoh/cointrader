<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/callbacks/paypal', 'Api\PayPalController@store');
Route::post('/callbacks/paypal-tbc', 'Api\PayPalController@tbc');

Route::get('/top-crypto-markets-data', 'Api\CoinMarketCapApiController@topCoinsMarketCap');
Route::get('/all-crypto-markets-data', 'Api\CoinMarketCapApiController@allCoinsMarketCap');
Route::get('/crypto-global-data', 'Api\CoinMarketCapApiController@cryptoGlobalData');
Route::get('/crypto-icons', 'Api\CoinMarketCapApiController@cryptoIcons');

Route::get('/crypto-exchanges-data', 'Api\CoinApiController@cryptoExchangesData');

Route::get('/crypto-news-data', 'Api\CryptoNewsApiController@getNews');
Route::get('/crypto-turkish-news-data', 'Api\CryptoTurkishNewsApiController@getNews');
Route::get('/crypto-cct-news-data', 'Api\CryptoCCTNewsApiController@getNews');
Route::get('/crypto-cct-news-post', 'Api\CryptoCCTNewsFeedController@insertPost');
// Route::get('/cct-feed', 'Api\CryptoCCTNewsFeedController@getFeed');

Route::get('/crypto-top-trading-pairs', 'Api\CryptoCompareApiController@getPairs');
Route::get('/crypto-historical-data', 'Api\CryptoCompareApiController@getAllHistoricalDayData'); //all data from start
Route::get('/crypto-daily-historical-data', 'Api\CryptoCompareApiController@getDailyHistoricalDayData'); //daily data
Route::get('/crypto-historical-hour-data', 'Api\CryptoCompareApiController@getHistoricalHourData');
Route::get('/crypto-coins-rates', 'Api\CryptoCompareApiController@cryptoCoinsRates');
Route::get('/crypto-coins-details', 'Api\CryptoCompareApiController@cryptoCoinsFullDetails');
Route::get('/crypto-mining-equipment', 'Api\CryptoCompareApiController@cryptoMiningEquipment');
Route::get('/crypto-mining-pools', 'Api\CryptoCompareApiController@miningPools');
Route::get('/crypto-wallets', 'Api\CryptoCompareApiController@wallets');
Route::get('/crypto-exchanges-pairs', 'Api\CryptoCompareApiController@getAllExchangesPairs');
Route::get('/crypto-events', 'Api\CoinGeckoController@cryptoEvents');

Route::get('/crypto-icos', 'Api\IcoWatchListApiController@getICOs');
Route::get('/currencies-rates', 'Api\FixerCurrencyRateApiController@getCurrenciesRatesData'); //tangible currencies rates like USD EUR etc

/**
 * ******************
 * APIs Mobile
 * ******************
 */
Route::group(['middleware' => ['CheckMobileApiAuth']], function () {
	Route::get('/v1/markets/{limit?}', 'Api\Mobile\MarketsController@getAll');
	Route::get('/v1/gainers', 'Api\Mobile\MarketsController@topGainersCurrencies');
	Route::get('/v1/losers', 'Api\Mobile\MarketsController@topLosersCurrencies');
	Route::get('/v1/icos/{status?}', 'Api\Mobile\IcoController@getAll');
	Route::get('/v1/news/{limit?}', 'Api\Mobile\NewsController@getAll');
	Route::get('/v1/search-news/{query?}', 'Api\Mobile\NewsController@searchNews');
	Route::get('/v1/exchanges/{limit?}', 'Api\Mobile\ExchangesController@getAll');
	Route::get('/v1/pages', 'Api\Mobile\PagesController@getAll');
	Route::get('/v1/posts', 'Api\Mobile\PostsController@getAll');
	Route::get('/v1/languages/{lang?}', 'Api\Mobile\LanguagesController@getAll');
	Route::get('/v1/mining-equipment/{limit?}', 'Api\Mobile\MiningEquipmentController@getAll');
	Route::get('/v1/settings', 'Api\Mobile\SettingsController@getAll');

	Route::get('/v1/watchlist/{user_id}', 'Api\Mobile\WatchlistController@getAll');
	Route::get('/v1/user/{user_id}', 'Api\Mobile\UsersController@getUser');
	Route::post('/v1/user/do/login', 'Api\Mobile\UsersController@login');
	Route::post('/v1/user/do/register', 'Api\Mobile\UsersController@register');
	Route::post('/v1/user/do/update/{user_id}', 'Api\Mobile\UsersController@update');
	Route::post('/v1/save-watchlist/{user_id}/{coin}', 'Api\Mobile\WatchlistController@saveUserWatchlist');

	Route::get('/v1/blockfolio/get/{user_id}', 'Api\Mobile\BlockfolioController@getAll');
	Route::get('/v1/blockfolio/exchanges/{coin}', 'Api\Mobile\BlockfolioController@getExchanges');
	Route::get('/v1/blockfolio/pairs/{coin}/{exchange}', 'Api\Mobile\BlockfolioController@getPairs');
	Route::post('/v1/blockfolio/save/{user_id}', 'Api\Mobile\BlockfolioController@saveUserBlockfolio');
	Route::get('/v1/blockfolio/remove/{user_id}/{id}/{tx_id}', 'Api\Mobile\BlockfolioController@removeFromBlockfolio');
});


