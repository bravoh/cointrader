<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use URL;
class CryptoMarkets extends Model
{
    protected $fillable = ['unique_name', 'name', 'alias', 'symbol', 'image', 'rank', 'price_usd', 'price_btc', 'volume_usd_day', 'market_cap_usd', 'available_supply', 'total_supply', 'max_supply', 'percent_change_hour', 'percent_change_day', 'percent_change_week', 'last_updated'];
    public function getAvailableSupplyAttribute($available_supply)
    {
        return number_format($available_supply);
    }
    public function getImageAttribute($image)
    {
        if(file_exists("public/images/coins_icons/thumbs/" . $image)) {
            return URL::asset("public/images/coins_icons/thumbs") . '/' . $image;
        } else if(file_exists('public/storage/' . $image)) {
            return URL::asset('public/storage') . '/' . $image;
        } else {
            return URL::asset("public/images") . '/default_coin.png';
        }
    }
}
