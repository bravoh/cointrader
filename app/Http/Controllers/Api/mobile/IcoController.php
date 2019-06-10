<?php
namespace App\Http\Controllers\Api\Mobile;
use App\Http\Controllers\Controller;
use App\CryptoCoinsIco;
class IcoController extends Controller
{

	public function getAll($status = '')
	{
		if($status != '') {
			return CryptoCoinsIco::whereIn('status', explode(',', $status))->get();
		}
		return CryptoCoinsIco::all();
	}

}