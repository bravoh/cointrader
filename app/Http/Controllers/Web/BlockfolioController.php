<?php
namespace App\Http\Controllers\Web;

use App\Http\Controllers\{Controller,CurlCallController};
use App\{BlockfolioCoins, CryptoExchangesVolume, CryptoMarkets};
use Illuminate\Http\Request;
use Validator, Auth, Redirect, DB;
use Illuminate\Support\Facades\Input;
class BlockfolioController extends Controller
{
	public function index()
	{
		if(!Auth::user()) {
			return Redirect::to(makeUrl('user/login'))->withErrors(['blockfolio_msg' => __('user.BLOCKFOLIO_PERSONALIZED_ERROR')]);
		}

		$coins = BlockfolioCoins::select('id', 'transaction_id', 'coin', 'exchange', 'pair', 'type', 'price', 'quantity', DB::raw('SUM(quantity) as total_quantity'))
					->where('user_id', '=', Auth::user()->id)
					->groupBy('coin', 'exchange', 'pair')
					->orderBy('id', 'asc')->get();
		return view(getCurrentTemplate() . '.pages.user.blockfolio', ['coins' => $coins]);
	}	

	public function blockfolioTransactionsHistory()
	{
		if(!Auth::user()) {
			return Redirect::to(makeUrl('user/login'))->withErrors(['blockfolio_msg' => __('user.BLOCKFOLIO_PERSONALIZED_ERROR')]);
		}
		$coins = BlockfolioCoins::where('user_id', '=', Auth::user()->id)->orderBy('id', 'asc')->get();
		return view(getCurrentTemplate() . '.pages.user.blockfolio_transactions_history', ['coins' => $coins]);
	}

	public function addCoinForm()
	{
		if(!Auth::user()) {
			return Redirect::to(makeUrl('user/login'))->withErrors(['blockfolio_msg' => __('user.BLOCKFOLIO_PERSONALIZED_ERROR')]);
		}

		$coins = CryptoMarkets::select('name', 'symbol')->orderBy('rank', 'asc')->get();
		return view(getCurrentTemplate() . '.pages.user.add_blockfolio', ['coins' => $coins]);
	}	

	public function addCoin(Request $request)
	{
		if(!Auth::user()) {
			return redirect('/');
		}
		$rules = [
		    'coin'    => 'required',
		    'exchange'    => 'required',
		    'pair' => 'required',
		    'quantity' => 'required'
		];
		$validator = Validator::make(Input::all(), $rules);
		if ($validator->fails()) {
		    return Redirect::to(makeUrl('user/add-blockfolio'))
		        ->withErrors($validator); 
		} else {
			$blockfolio = new BlockfolioCoins;
        	$blockfolio->transaction_id = md5(rand(0, 9999).time().'0x00');
        	$blockfolio->coin = $request->coin;
        	$blockfolio->exchange = $request->exchange;
        	$blockfolio->pair = $request->pair;
        	if($request->type == 2) {
        		$blockfolio->quantity = -$request->quantity;
        	} else {
        		$blockfolio->quantity = $request->quantity;
        	}
        	$blockfolio->price = $request->price !='' ? $request->price : 0;
        	$blockfolio->type = $request->type;
        	$blockfolio->user_id = Auth::user()->id;

		    if ($blockfolio->save()) {
        		return redirect(makeUrl('user/blockfolio'));
		    } else {
		    	return Redirect::to(makeUrl('user/add-blockfolio'))
		    			->withErrors(['wrong_credentials' => 'Sorry! Something went wrong. Please try again.']);
		    }
		}
	}

	public function removeFromBlockfolio($id, $tx_id)
	{
		if(!Auth::user()) {
			return redirect('/');
		}
		BlockfolioCoins::where('user_id', '=', Auth::user()->id)->where('id', '=', $id)->where('transaction_id', '=', $tx_id)->delete();
	}

	public function getExchanges($coin)
	{
		if(!request()->ajax()) {
			return [':)'];
		}
		return CryptoExchangesVolume::where('symbol', $coin)->select('exchange')->groupBy('exchange')->get();
	}

	public function getPairs($coin, $exchange)
	{
		if(!request()->ajax()) {
			return [':)'];
		}
		return CryptoExchangesVolume::where('symbol', $coin)->where('exchange', $exchange)->select('pair')->groupBy('pair')->get();
	}

	public function getPrice($exchange, $pair)
	{
		if(!request()->ajax()) {
			return [':)'];
		}
		if($pair == '') {
			return false;
		}
		$pair_coins = explode('-', $pair);	
		$price_data = json_decode(CurlCallController::curl('https://min-api.cryptocompare.com/data/price?fsym='.$pair_coins[0].'&tsyms='.$pair_coins[1].'&e='.$exchange), true);
		return $price_data[$pair_coins[1]];
	}

	public function getPairPrice()
	{
		if(!request()->ajax()) {
			return [':)'];
		}
		if(!Auth::user()) {
			return [':)'];
		}
		$profit_loss = Input::get('profit_loss');
		$quantity = Input::get('quantity');
		$coin = explode('-', Input::get('pair'));
		$fiat_currency = Input::get('fiat_currency');

		$price_data = json_decode(CurlCallController::curl('https://min-api.cryptocompare.com/data/price?fsym='.$coin[1].'&tsyms=USD'), true);
		if(isset($price_data['USD'])) {
			$usd_price = $price_data['USD'];
		} else {
			$usd_price = CryptoMarkets::select('price_usd')->where('symbol', '=', $coin[1])->first()['price_usd'];
		}

		return round($usd_price*$profit_loss*$fiat_currency, 3);

	}

}