<?php
namespace App\Http\Controllers\Api\Mobile;
use App\Http\Controllers\Controller;
use TCG\Voyager\Models\Page;
class PagesController extends Controller
{

	public function getAll()
	{
		return Page::where('status', '=', 'ACTIVE')->get();
	}

}