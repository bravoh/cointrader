<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->call('App\Http\Controllers\Api\CoinMarketCapApiController@cryptoGlobalData')->everyFiveMinutes();
        $schedule->call('App\Http\Controllers\Api\CoinMarketCapApiController@topCoinsMarketCap')->everyFiveMinutes();
        $schedule->call('App\Http\Controllers\Api\CoinMarketCapApiController@allCoinsMarketCap')->everyThirtyMinutes();

        $schedule->call('App\Http\Controllers\Api\CryptoCompareApiController@cryptoCoinsRates')->hourly();
        $schedule->call('App\Http\Controllers\Api\CryptoNewsApiController@getNews')->hourly();
        $schedule->call('App\Http\Controllers\Api\FixerCurrencyRateApiController@getCurrenciesRatesData')->hourly();

        $schedule->call('App\Http\Controllers\Api\CryptoCompareApiController@getPairs')->twiceDaily(1, 13);
        $schedule->call('App\Http\Controllers\Api\CryptoCCTNewsApiController@getNews')->daily();
        $schedule->call('App\Http\Controllers\Api\CryptoCCTNewsFeedController@insertPost')->twiceDaily(3, 23);
        $schedule->call('App\Http\Controllers\Api\CryptoTurkishNewsApiController@getNews')->twiceDaily(4, 19);

        $schedule->call('App\Http\Controllers\Api\CryptoCompareApiController@miningPools')->daily();
        $schedule->call('App\Http\Controllers\Api\CryptoCompareApiController@wallets')->daily();
        $schedule->call('App\Http\Controllers\Api\CoinGeckoController@cryptoEvents')->daily();
        
        $schedule->call('App\Http\Controllers\Api\IcoWatchListApiController@getICOs')->daily();
        $schedule->call('App\Http\Controllers\Api\CryptoCompareApiController@getDailyHistoricalDayData')->daily();
        $schedule->call('App\Http\Controllers\Web\SitemapGeneratorController@generate')->daily(); 

        $schedule->call('App\Http\Controllers\Api\CoinApiController@cryptoExchangesData')->weekly();
        $schedule->call('App\Http\Controllers\Api\CryptoCompareApiController@cryptoCoinsFullDetails')->everyThirtyMinutes();
        $schedule->call('App\Http\Controllers\Api\CryptoCompareApiController@getAllExchangesPairs')->weekly();
        
        $schedule->call('App\Http\Controllers\Web\ClearCacheController@index')->twiceDaily(2, 21);
        $schedule->call('App\Http\Controllers\Api\CryptoCompareApiController@cryptoMiningEquipment')->weekly();
        
        /**
         * To load crypto icons
         */
        $schedule->call('App\Http\Controllers\Api\CoinMarketCapApiController@cryptoIcons')->weekly();

        /**
         * Twitter Auto Post APIs
         */
        $schedule->call('App\Http\Controllers\Web\TwitterAutoPostController@postNews')->hourly();
        $schedule->call('App\Http\Controllers\Web\TwitterAutoPostController@getTopCoinsPrices')->twiceDaily(8, 20);
        $schedule->call('App\Http\Controllers\Web\TwitterAutoPostController@getTopGainers')->twiceDaily(9, 21);
        $schedule->call('App\Http\Controllers\Web\TwitterAutoPostController@getTopLosers')->twiceDaily(10, 22);
        
        /**
        * Send newsletter
        **/
        $schedule->call('App\Http\Controllers\Web\CryptoNewsController@composeNewsLetter')->weekly();

        /**
         * Time and resource consuming call.
         * Call on demand - Contact to script owner before opening these
         */
        //$schedule->call('App\Http\Controllers\Api\CryptoCompareApiController@getExchangesVolumeByPairs')->weekly();
        // $schedule->call('App\Http\Controllers\Api\CryptoCompareApiController@getAllHistoricalDayData')->monthly();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
