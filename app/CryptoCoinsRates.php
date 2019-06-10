<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CryptoCoinsRates extends Model
{
    protected $fillable = ['id', 'coin', 'f_currency', 'price', 'change_hour', 'change_day'];
}
