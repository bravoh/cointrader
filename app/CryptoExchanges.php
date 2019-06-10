<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use URL;
class CryptoExchanges extends Model
{
    protected $fillable = ['exchange_id', 'name', 'website', 'affiliate', 'image'];

    public function getImageAttribute($image)
    {
    	if(file_exists("public/images/exchanges/" . $image)) {
            return URL::asset("public/images/exchanges") . '/' . $image;
        } else if(file_exists('public/storage/' . $image)) {
            return URL::asset('public/storage') . '/' . $image;
        } else {
            return URL::asset("public/images") . '/no_image.png';
        }
    }
}
