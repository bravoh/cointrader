<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CryptoGlobals extends Model
{
    protected $fillable = ['total_market_cap_usd', 'total_24h_volume_usd', 'bitcoin_percentage_of_market_cap', 'active_currencies', 'active_assets', 'active_markets', 'last_updated'];

    public function getTotalMarketCapUsdAttribute($total_market_cap_usd)
	{
	    return sprintf('$%s', number_format($total_market_cap_usd));
	}
	public function getTotal24hVolumeUsdAttribute($total_24h_volume_usd)
	{
	    return sprintf('$%s', number_format($total_24h_volume_usd));
	}
}
