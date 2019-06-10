<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DashboardSlider extends Model
{
    protected $fillable = ['name', 'text', 'image_link', 'page_link', 'status', 'lang'];
}
