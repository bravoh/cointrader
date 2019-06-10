<?php
namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\CryptoExchanges;
class CryptoExchangesController extends Controller
{

	public function index()
	{
		$crypto_exchanges = CryptoExchanges::where('status', '=', 1)->orderBy('order', 'asc')->get();
		$data = ['crypto_exchanges' => $crypto_exchanges];
		return view(getCurrentTemplate() . '.pages.exchanges', $data);
	}

}