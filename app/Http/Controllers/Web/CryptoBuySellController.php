<?php
namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;

class CryptoBuySellController extends Controller
{
	public function index()
	{
		// return redirect(setting('3rdparty.buy_sell_coin'));
		$data = [];
		return view(getCurrentTemplate() . '.pages.buy_sell', $data);
	}

}
