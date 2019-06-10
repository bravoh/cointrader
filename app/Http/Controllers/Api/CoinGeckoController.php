<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\{Controller,CurlCallController};
use App\{Events};
use App\Helpers\BulkInsertUpdate;
use URL;
class CoinGeckoController extends Controller
{
	public $crypto_events;

	public function __construct()
	{
		$this->crypto_events = new Events;
	}

	public function cryptoEvents()
	{
		$crypto_events_data = json_decode(CurlCallController::curl('https://api.coingecko.com/api/v3/events'), true);
        foreach ($crypto_events_data['data'] as $event) {
            $data[] = $this->prepareEventsData($event);
        }
        if(isset($data) && count($data) > 0) {
            BulkInsertUpdate::do($this->crypto_events->getTable(), $data);
        }
	}

	public function prepareEventsData($event)
	{
        if($event['screenshot'] == 'missing_original.png' || $event['screenshot'] == '') {
            $event['screenshot'] =  URL::asset("public/images") . '/default_event.png';
        }
		return [
            'type' => $event['type'],
            'title' => $event['title'],
            'alias' => slugify($event['title']),
            'description' => $event['description'],
            'organizer' => $event['organizer'],
            'start_date' => $event['start_date'],
            'end_date' => $event['end_date'],
            'website' => $event['website'],
            'email' => $event['email'],
            'venue' => $event['venue'],
            'address' => $event['address'],
            'city' => $event['city'],
            'country' => $event['country'],
            'screenshot' => $event['screenshot']
        ];
	}

}
