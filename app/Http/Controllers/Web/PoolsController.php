<?php
namespace App\Http\Controllers\Web;

use App\Http\Controllers\{Controller, CurlCallController};
use App\MiningPools;
use Illuminate\Http\Request;
class PoolsController extends Controller
{
	public function index()
	{
		$pools = json_decode(CurlCallController::curl('https://api.blockchain.info/pools?timespan=10days'), true);
		arsort($pools);
		$pie_data = [];
		foreach ($pools as $pool => $count) {
				$pie_data[] = ['pool' => $pool, 'value' => $count];
		}
		return view(getCurrentTemplate() . '.pages.pools', [
			'pools' => $pools, 
			'pie_data' => json_encode($pie_data), 
			'pools_details' => $this->getMiningPools()
		]);
	}	

	public function hashrateDistribution()
	{
		$pools = json_decode(CurlCallController::curl('https://api.blockchain.info/pools?timespan=10days'), true);
		arsort($pools);
		$pie_data = [];
		foreach ($pools as $pool => $count) {
				$pie_data[] = ['pool' => $pool, 'value' => $count];
		}
		return view(getCurrentTemplate() . '.pages.hashrate', [
			'pools' => $pools, 
			'pie_data' => json_encode($pie_data)
		]);
	}

	public function pool($pool)
	{
		$pool = MiningPools::where('status', '=', 1)->where('alias', '=', $pool)->first();
		if($pool) {
			$related_pools = MiningPools::where('status', '=', 1)->limit(6)->inRandomOrder()->get();
			return view(getCurrentTemplate() . '.pages.single_pool', [
				'pool' => $pool,
				'pools' => $related_pools,
			]);
		}
		return redirect(makeUrl('mining-pools'));
	}

	public function getMiningPools()
	{
		return MiningPools::where('status', '=', 1)->orderBy('featured', 'desc')->orderBy('name', 'asc')->get();
	}

}