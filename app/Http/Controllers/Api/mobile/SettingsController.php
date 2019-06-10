<?php
namespace App\Http\Controllers\Api\Mobile;
use App\Http\Controllers\Controller;
use TCG\Voyager\Models\Setting;
class SettingsController extends Controller
{

	public function getAll()
	{
		return Setting::where('group', '=', 'Site')->get();
	}

}