<?php
namespace App\Http\Controllers\Api\Mobile;
use App\Http\Controllers\Controller;
use App\CryptoExchanges;
class ExchangesController extends Controller
{

	public function getAll($limit = '')
	{
		if($limit != '') {
			return CryptoExchanges::orderBy('id', 'desc')->limit($limit)->get();
		}
		return CryptoExchanges::orderBy('id', 'desc')->get();
	}

}