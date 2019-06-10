<?php
namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
Use Artisan;
class ClearCacheController extends Controller
{
	public function index()
	{
	    @Artisan::call('cache:clear');
	    @Artisan::call('view:clear');
	    @Artisan::call('config:cache');
	    @Artisan::call('config:clear');
	    @Artisan::call('route:clear');
	}	

}
