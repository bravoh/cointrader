<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CryptoTopPairs extends Model
{
    protected $fillable = ['symbol', 'pair', 'volume24h_from', 'volume24h_to'];

    public function getVolume24hFromAttribute($volume24h_from)
    {
    	return number_format($volume24h_from, 2);
    }

    public function getVolume24hToAttribute($volume24h_to)
    {
    	return number_format($volume24h_to, 2);
    }
}
