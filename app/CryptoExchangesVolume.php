<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CryptoExchangesVolume extends Model
{
    protected $fillable = ['symbol', 'exchange', 'pair', 'price', 'volume_day_from', 'volume_day_to'];
}
