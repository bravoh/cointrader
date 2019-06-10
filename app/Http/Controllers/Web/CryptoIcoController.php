<?php
namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\CryptoCoinsIco;

class CryptoIcoController extends Controller
{
	public function index()
	{
		$icos = CryptoCoinsIco::where('hide', '=', 0)
				->orderBy('start_time', 'desc')
				->orderBy('end_time', 'desc')->paginate(102);
		if($icos) {
			$data = ['icos' => $icos];
			return view(getCurrentTemplate() . '.pages.icos', $data);
		}
		return redirect('/crypto-ico');
	}

	public function ico($ico)
	{
		$ico = CryptoCoinsIco::where('alias', '=', $ico)->where('hide', '=', 0)->first();
		if($ico) {
			$icos = CryptoCoinsIco::where('hide', '=', 0)->inRandomOrder()->paginate(12);
			$data = ['ico' => $ico, 'icos' => $icos];
			return view(getCurrentTemplate() . '.pages.single_ico', $data);
		}
		return redirect('/crypto-ico');
	}

}
