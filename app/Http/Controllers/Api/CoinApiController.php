<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\{Controller,CurlCallController};
use App\{CryptoExchanges};
use App\Helpers\BulkInsertUpdate;
class CoinApiController extends Controller
{
	public $crypto_exchanges;

	public function __construct()
	{
		$this->crypto_exchanges = new CryptoExchanges;
	}

	public function cryptoExchangesData()
	{
		$crypto_exchanges_data = json_decode(CurlCallController::curl('https://rest.coinapi.io/v1/exchanges'), true);
        foreach ($crypto_exchanges_data as $exchange_record) {
            $data[] = $this->prepareExchangesData($exchange_record);
        }
        if(isset($data) && count($data) > 0) {
            BulkInsertUpdate::do($this->crypto_exchanges->getTable(), $data);
        }
	}

	public function prepareExchangesData($exchange_record)
	{
		return [
            'exchange_id' => $exchange_record['exchange_id'],
            'name' => $exchange_record['name'],
            'image' => strtolower($exchange_record['exchange_id']).'.png',
            'website' => $exchange_record['website']
        ];
	}

}
