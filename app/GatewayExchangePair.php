<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GatewayExchangePair extends Model
{
    public function send(){
        return $this->belongsTo(Gateway::class,"send_id");
    }

    public function receive(){
        return $this->belongsTo(Gateway::class,"receive_id");
    }
}
