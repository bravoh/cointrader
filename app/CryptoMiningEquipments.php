<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use URL;
class CryptoMiningEquipments extends Model
{
    protected $fillable = ['company', 'logo', 'name', 'alias', 'url', 'affiliate', 'algorithm', 'hashes_per_second', 'cost', 'currency', 'type', 'power_consumption', 'currencies_available', 'recommended'];

    public function getLogoAttribute($logo)
    {
        $url = URL::asset('public/images/mining/');
        if(file_exists("public/images/mining/" . $logo)) {
            return $url."/".$logo;
        }
        return URL::asset('public/storage') . '/' . $logo;
    }
}
