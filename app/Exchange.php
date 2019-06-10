<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Exchange extends Model
{
    protected $guarded = [];
    public function bit_pair(){
        return $this->belongsTo(GatewayExchangePair::class,'gateway_exchange_pair_id');
    }
}
