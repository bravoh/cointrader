<?php
namespace App\Http\Controllers\Api\Mobile;
use App\Http\Controllers\Controller;
use App\AvailableLanguages;
class LanguagesController extends Controller
{

	public function getAll($lang = '')
	{
		if($lang != '') {
			return AvailableLanguages::where('code', '=', $lang)->where('status', '=', 1)->first();
		}
		return AvailableLanguages::where('status', '=', 1)->orderBy('id', 'desc')->get();
	}

}