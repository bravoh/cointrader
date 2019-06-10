<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FavoritesCoins extends Model
{
	public $timestamps = false;
    protected $fillable = ['user_id', 'coin'];
}
