<?php
namespace App\Http\Controllers\Api\Mobile;
use App\Http\Controllers\{Controller, CurlCallController};
use Illuminate\Support\Facades\Input;
use App\{BlockfolioCoins, CryptoExchangesVolume, CryptoMarkets};
use Validator, DB;
class BlockfolioController extends Controller
{
	public function getAll($user_id = '')
	{
		if($user_id != '') {
			$blockfolio_details = [];
			$blockfolio = BlockfolioCoins::select('id', 'transaction_id', 'coin', 'exchange', 'pair', 'type', 'price', 'quantity', DB::raw('SUM(quantity) as total_quantity'))
				->where('user_id', '=', $user_id)
				->groupBy('coin', 'exchange', 'pair')
				->orderBy('id', 'asc')->get();
			foreach ($blockfolio as $record) {
				$current_price = $this->getPrice($record->exchange, $record->pair);
				$record['current_price'] = $this->convertFromExponent($current_price);
				$record['price'] = $this->convertFromExponent($record->price);
				$record['profit_loss'] = $current_price*$record->total_quantity - $record->price*$record->total_quantity;

				$pair_coins = explode('/', $record->pair);	
				$price_data = json_decode(CurlCallController::curl('https://min-api.cryptocompare.com/data/price?fsym='.$pair_coins[1].'&tsyms=USD'), true);
				if(isset($price_data['USD'])) {
					$usd_price = $price_data['USD'];
				} else {
					$usd_price = CryptoMarkets::select('price_usd')->where('symbol', '=', $coin[1])->first()['price_usd'];
				}
				$record['fiat_profit_loss'] = round(($current_price*$record->total_quantity - $record->price*$record->total_quantity)*$usd_price, 3);
				$blockfolio_details[] = $record;
			}	
			return $blockfolio_details;
		}
		return [
			'status' => false,
			'error' => 'Please provide user id.'
		];
	}

	public function saveUserBlockfolio($user_id)
	{
		if($user_id == '') {
			return [
				'status' => false,
				'error' => 'Please provide user_id.'
			];
		}
		$rules = [
		    'coin'    => 'required',
		    'exchange'    => 'required',
		    'pair' => 'required',
		    'quantity' => 'required',
		    'price' => 'required',
		    'type' => 'required'
		];
		$validator = Validator::make(Input::all(), $rules);
		if ($validator->fails()) {
		    return [
				'status' => false,
				'error' => $validator->errors()
			];
		} else {
			$blockfolio = new BlockfolioCoins;
        	$blockfolio->transaction_id = md5(rand(0, 9999).time().'0x00');
        	$blockfolio->coin = Input::get('coin');
        	$blockfolio->exchange = Input::get('exchange');
        	$blockfolio->pair = Input::get('pair');
        	if(Input::get('type') == 2) {
        		$blockfolio->quantity = -Input::get('quantity');
        	} else {
        		$blockfolio->quantity = Input::get('quantity');
        	}
        	$blockfolio->price = Input::get('price') !='' ? Input::get('price') : '';
        	$blockfolio->type = Input::get('type');
        	$blockfolio->user_id = $user_id;

		    if ($blockfolio->save()) {
        		return [
					'status' => true
				];
		    } else {
		    	return [
					'status' => false,
					'error' => 'Sorry! Something went wrong. Please try again.'
				];
		    }
		}
	}

	public function removeFromBlockfolio($user_id, $id, $tx_id)
	{
		BlockfolioCoins::where('user_id', '=', $user_id)->where('id', '=', $id)->where('transaction_id', '=', $tx_id)->delete();
	}

	public function getExchanges($coin)
	{
		return CryptoExchangesVolume::where('symbol', $coin)->select('exchange')->groupBy('exchange')->get();
	}

	public function getPairs($coin, $exchange)
	{
		return CryptoExchangesVolume::where('symbol', $coin)->where('exchange', $exchange)->select('pair')->groupBy('pair')->get();
	}

	public function getPrice($exchange, $pair)
	{
		if($pair == '') {
			return false;
		}
		$pair_coins = explode('/', $pair);	
		$price_data = json_decode(CurlCallController::curl('https://min-api.cryptocompare.com/data/price?fsym='.$pair_coins[0].'&tsyms='.$pair_coins[1].'&e='.$exchange), true);
		return $price_data[$pair_coins[1]];
	}

	function convertFromExponent($amount, $decimals = 25)
	{
	    if($amount > 0) {
	        return rtrim(sprintf("%0.".$decimals."f", $amount), "0.");
	    }
	    return 0;
	}

}