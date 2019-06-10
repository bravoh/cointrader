<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use URL;
class CryptoNews extends Model
{
    protected $fillable = ['title', 'alias', 'author', 'description', 'url', 'urlToImage', 'publishedAt', 'lang'];

    function getPublishedAtAttribute($publishedAt)
    {
 		return date("Y-m-d H:i:s", $publishedAt);   	
    }

    function setPublishedAtAttribute($publishedAt)
    {
 		 $this->attributes['publishedAt'] = strtotime($publishedAt);   	
    }

    function geturlToImageAttribute($urlToImage)
    {
        if(file_exists("public/storage/" . $urlToImage)) {
            return URL::asset("public/storage") . '/' . $urlToImage;
        } else {
            return $urlToImage;
        }
    }

}
