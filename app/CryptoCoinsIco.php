<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CryptoCoinsIco extends Model
{
    protected $fillable = ['id', 'name', 'alias', 'status', 'featured', 'image', 'website', 'icowatchlist_url', 'affiliate', 'start_time', 'end_time', 'timezone', 'description'];
}
