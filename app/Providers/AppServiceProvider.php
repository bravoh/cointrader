<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use App\{CurrenciesRates, CryptoGlobals, AvailableLanguages, CryptoMarkets, DonateCoins};
use TCG\Voyager\Models\Page;
use LaravelLocalization, DB;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
        view()->composer(getCurrentTemplate() . '.includes.currencies_list', function ($view) {
            $view->with('currencies_list', CurrenciesRates::where('status', '=', 1)->orderBy('order', 'asc')->get());
        });
        view()->composer([getCurrentTemplate() . '.includes.top_bar', getCurrentTemplate() . '.includes.globals', getCurrentTemplate() . '.includes.footer-three-column'], function ($view) {
            $view->with('global_data', CryptoGlobals::first());
        });
        view()->composer([getCurrentTemplate() . '.includes.top_bar', getCurrentTemplate() . '.includes.globals'], function ($view) {
            $view->with('total_markets', CryptoMarkets::all()->count());
        });
        view()->composer(getCurrentTemplate() . '.includes.footer-three-column', function ($view) {
            $view->with('today_news', DB::table('crypto_news')->where(DB::raw("DATE_FORMAT(FROM_UNIXTIME(publishedAt),'%Y-%m-%d')"), '=', date("Y-m-d"))->count());
        });
        view()->composer([getCurrentTemplate() . '.includes.sidebar', getCurrentTemplate() . '.includes.topbar'], function ($view) {
            $view->with('pages', Page::where('status', '=', 'ACTIVE')->where('language', '=', LaravelLocalization::getCurrentLocale())->whereNotIn('slug', ['privacy-policy', 'terms-conditions', 'frequently-asked-questions'])->get());
        });
        view()->composer([getCurrentTemplate() . '.includes.available_languages', getCurrentTemplate() . '.includes.header'], function ($view) {
            $view->with('available_languages', AvailableLanguages::where('status', '=', 1)->orderBy('order', 'asc')->get());
        });
        view()->composer([getCurrentTemplate() . '.includes.footer-three-column', getCurrentTemplate() . '.includes.footer'], function ($view) {
            $view->with('donate_coins', DonateCoins::all());
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
