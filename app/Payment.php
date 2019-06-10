<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    public $guarded = [];

    public function order(){
        return $this->belongsTo(Exchange::class,"exchange_id");
    }
}
