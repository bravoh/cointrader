<?php
namespace App\Http\Controllers\Web;

use App\Http\Controllers\{Controller, CurlCallController};
use App\Events;
use Illuminate\Http\Request;
class EventsController extends Controller
{
	public function index()
	{
		return view(getCurrentTemplate() . '.pages.events', [
			'events_details' => $this->getEvents()
		]);
	}	

	public function event($event)
	{
		$event = Events::where('status', '=', 1)->where('alias', '=', $event)->first();
		if($event) {
			$related_events = Events::where('status', '=', 1)
						->limit(10)->orderBy('start_date', 'asc')
						->where('start_date', '>', date('Y-m-d'))->whereNotIn('id', [$event['id']])->get();
			return view(getCurrentTemplate() . '.pages.single_event', [
				'event' => $event,
				'events' => $related_events,
				'events_details' => $this->getRelatedEvents($event['id'], $related_events)
			]);
		}
		return redirect(makeUrl('events'));
	}

	public function getRelatedEvents($event, $events)
	{
		$events_ids[] = $event;
		foreach ($events as $event) {
			$events_ids[] = $event['id'];
		}
		return Events::where('status', '=', 1)->whereNotIn('id', $events_ids)->inRandomOrder()->limit(6)->get();
	}

	public function getEvents()
	{
		return Events::where('status', '=', 1)->orderBy('start_date', 'asc')
				->where('start_date', '>', date('Y-m-d'))
				->orderBy('featured', 'desc')
				->orderBy('title', 'asc')->get();
	}

}