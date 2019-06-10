<?php
namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\CryptoMiningEquipments;

class CryptoMiningEquipmentController extends Controller
{
	public function index()
	{
		$data = [
			'mining_equipments' => CryptoMiningEquipments::where('status', '=', 1)->orderBy('recommended', 'desc')->paginate(51),
			'sub_heading' => __('headings.MINING_PAGE')
		];
		return view(getCurrentTemplate() . '.pages.mining', $data);
	}

}
