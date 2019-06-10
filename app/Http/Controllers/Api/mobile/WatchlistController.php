<?php
namespace App\Http\Controllers\Api\Mobile;
use App\Http\Controllers\Controller;
use App\FavoritesCoins;
class WatchlistController extends Controller
{

	public function getAll($user_id = '')
	{
		if($user_id != '') {
			return FavoritesCoins::where('user_id', '=', $user_id)->get();
		}
		return [
			'status' => false,
			'error' => 'Please provide user id.'
		];
	}

	public function saveUserWatchlist($user_id, $coin)
	{
		if($user_id == '') {
			return [
				'status' => false,
				'error' => 'Please provide user_id.'
			];
		}
		if($coin == '') {
			return [
				'status' => false,
				'error' => 'Please provide coin to watchlist.'
			];
		}
		if(!FavoritesCoins::where('coin', '=', $coin)->where('user_id', '=', $user_id)->first()) {
			$favorites = new FavoritesCoins;
	        $favorites->user_id = $user_id;
	        $favorites->coin = $coin;
	        $favorites->save();
	        return [
				'status' => true,
				'message' => 'Watchlist coin added.'
			];
	    } else {
	    	FavoritesCoins::where('coin', '=', $coin)->where('user_id', '=', $user_id)->delete();
	    	return [
				'status' => true,
				'message' => 'Watchlist coin removed.'
			];
	    }
	}

}