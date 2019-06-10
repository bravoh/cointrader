<?php
namespace App\Http\Controllers\Web;

use App\Http\Controllers\{Controller, CurlCallController};
use App\Wallets;
use Illuminate\Http\Request;
class WalletsController extends Controller
{
	public function index()
	{
		return view(getCurrentTemplate() . '.pages.wallets', [
			'wallets_details' => $this->getWallets()
		]);
	}	

	public function wallet($wallet)
	{
		$wallet = Wallets::where('status', '=', 1)->where('alias', '=', $wallet)->first();
		if($wallet) {
			$related_wallets = Wallets::where('status', '=', 1)->limit(6)->inRandomOrder()->get();
			return view(getCurrentTemplate() . '.pages.single_wallet', [
				'wallet' => $wallet,
				'wallets' => $related_wallets,
			]);
		}
		return redirect(makeUrl('wallets'));
	}

	public function getWallets()
	{
		return Wallets::where('status', '=', 1)->orderBy('featured', 'desc')->orderBy('name', 'asc')->get();
	}

}