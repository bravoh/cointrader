<?php
namespace App\Http\Controllers\Api\Mobile;
use App\Http\Controllers\Controller;
use App\CryptoMiningEquipments;
class MiningEquipmentController extends Controller
{

	public function getAll($limit = '')
	{
		if($limit != '') {
			return CryptoMiningEquipments::orderBy('recommended', 'desc')->limit($limit)->get();
		}
		return CryptoMiningEquipments::orderBy('recommended', 'desc')->get();
	}

}