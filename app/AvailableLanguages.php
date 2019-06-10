<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AvailableLanguages extends Model
{
    protected $fillable = ['name', 'short_name', 'code', 'status', 'order', 'flag'];
}
