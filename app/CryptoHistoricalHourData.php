<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CryptoHistoricalHourData extends Model
{
    protected $fillable = ['id', 'coin', 'time', 'open', 'close', 'high', 'low', 'volume_from', 'volume_to', 'created_at', 'updated_at'];

    public function getTimeAttribute($time)
    {
    	return date("Y-m-d H:i:s", $time);
    }
}
