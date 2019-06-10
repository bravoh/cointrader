<?php
namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use LaravelLocalization, Validator, Auth, Redirect, Mail;
use TCG\Voyager\Models\Page;
use App\{Events, ContactUs};
use Illuminate\Support\Facades\Input;
class PagesController extends Controller
{
	public function index(Request $request)
	{
		$slug =$request->segment(3);
		$language = LaravelLocalization::getCurrentLocale();
		$page = Page::where('slug', '=', $slug)
					->where('language', '=', $language)
					->where('status', '=', 'ACTIVE')
					->first();
		if(!isset($page->title)) { //show English content as a default
			$page = Page::where('slug', '=', $slug)
					->where('language', '=', 'en')
					->where('status', '=', 'ACTIVE')
					->first();
		}			
		return view(getCurrentTemplate() . '.pages.static.page', ['data' => $page]);
	}	

	public function advertise()
	{
		return view(getCurrentTemplate() . '.pages.static.advertise', ['events' => $this->getEvents()]);
	}

	public function contactUs()
	{	
		return view(getCurrentTemplate() . '.pages.static.contact_us', ['events' => $this->getEvents()]);
	}

	public function contactUsSave(Request $request)
	{	
		$rules = [
		    'name'    => 'required|min:3|max:100',
		    'email'    => 'required|email|max:150',
		    'message' => 'required|max:2000',
		    'g-recaptcha-response' => 'required|recaptcha'
		];
		$validator = Validator::make(Input::all(), $rules);
		if ($validator->fails()) {
		    return Redirect::to(makeUrl('contact-us'))
		        ->withErrors($validator) 
		        ->withInput(Input::except('inquiry_type'));
		} else {
		    $contact = new ContactUs;
		    $contact->name = $request->name;
		    $contact->email = $request->email;
		    $contact->inquiry_type = $request->inquiry_type;
		    $contact->message = $request->message;
		    $contact->created_at = date("Y-m-d H:i:s");
		    if($contact->save()) {
		    	return Redirect::to(makeUrl('contact-us'))
		        ->withErrors(['success' => __('v7.SUCCESS_CONTACT')]);
		    }
		}
	}

	public function getEvents()
	{
		return Events::where('status', '=', 1)
						->limit(10)->orderBy('start_date', 'asc')
						->where('start_date', '>', date('Y-m-d'))->get();
	}

}