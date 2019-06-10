<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DonateCoins extends Model
{
    protected $fillable = ['coin', 'address'];
}
