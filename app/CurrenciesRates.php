<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CurrenciesRates extends Model
{
     protected $fillable = ['currency', 'rate', 'icon', 'flag', 'order'];
}
