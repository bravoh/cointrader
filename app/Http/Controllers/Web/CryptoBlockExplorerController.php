<?php
namespace App\Http\Controllers\Web;

use App\Http\Controllers\{Controller, CurlCallController};
use Redirect;
use Illuminate\Support\Facades\Input;
class CryptoBlockExplorerController extends Controller
{
	public function index($hash = '')
    {
        $hash = Input::get('hash');
        if(isset($hash) && $hash !='') {
            return $this->getRawBlock($hash);
        }
        $block_info = json_decode(CurlCallController::curl('https://blockchain.info/latestblock'), false);
        $block_info->date_time = date("F j, Y g:i:s a", $block_info->time + 10800);
        $block_info->time = $this->getHumanReadableTime($block_info->time);
        return view(getCurrentTemplate() . '.pages.block_explorer.block_explorer', ['block' => $block_info, 'hash' => $hash]);
    }

    public function getRawBlock($block_hash = '')
    {
        $block_hash_info = json_decode(CurlCallController::curl('https://blockchain.info/rawblock/'.$block_hash), false);
        if($block_hash_info !== null || $block_hash_info != '') {
            $block_hash_info->date_time = date("F j, Y g:i:s a", $block_hash_info->time + 10800);
            $block_hash_info->time = $this->getHumanReadableTime($block_hash_info->time);
            return view(getCurrentTemplate() . '.pages.block_explorer.block_hash_info', ['block' => $block_hash_info, 'hash' => $block_hash]);
        }
        return Redirect::to(makeUrl('block-explorer'))->withErrors(['no_block' => 'There is no information related to this block address. Please try correct block address.']);
    }

    public function getHumanReadableTime($time)
    {
        $time = \Carbon\Carbon::createFromTimestamp($time);
        return $time->diffForHumans();
    }

}
