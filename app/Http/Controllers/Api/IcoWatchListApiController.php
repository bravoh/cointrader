<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\{Controller,CurlCallController};
use App\CryptoCoinsIco;
use App\Helpers\BulkInsertUpdate;
class IcoWatchListApiController extends Controller
{

	public $crypto_icos;	
	public function __construct()
	{
		$this->crypto_icos = new CryptoCoinsIco;
	}

	public function getICOs()
	{
		$icos = json_decode(CurlCallController::curl('https://api.icowatchlist.com/public/v1/'), true);
        $this->saveIcoData($icos['ico']['live'], 0);
        $this->saveIcoData($icos['ico']['upcoming'], 1);
        $this->saveIcoData($icos['ico']['finished'], 2);
	}
	public function saveIcoData($icos, $status)
	{
		foreach ($icos as $ico) {
            $data[] = $this->prepareIcoData($ico, $status);
        }
        if(isset($data) && count($data) > 0) {
            BulkInsertUpdate::do($this->crypto_icos->getTable(), $data);
        }
	}

	public function prepareIcoData($ico, $status)
	{
		return [
			'name' => $ico['name'],
			'alias' => $this->createICONameAlias($ico['name']),
			'status' => $status,
			'image' => $ico['image'],
			'website' => $ico['website_link'],
			'icowatchlist_url' => $ico['icowatchlist_url'],
			'start_time' => $ico['start_time'],
			'end_time' => $ico['end_time'],
			'timezone' => $ico['timezone'],
			'description' => $ico['description']
		];
	}

	public function createICONameAlias($ico_name)
	{
		return str_replace(' ', '-', strtolower($ico_name));
	}

}