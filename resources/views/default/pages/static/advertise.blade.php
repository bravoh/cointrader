@extends(getCurrentTemplate() . '.layouts.default')
@section('meta_title')@lang('v7.ADVETISE_SEO_TITLE')@stop
@section('meta_desc')@lang('v7.ADVETISE_SEO_DESC')@stop
@section('meta_link'){{ Request::url() }}@stop
@section('meta_image'){{ URL::asset('public/images/pages/images') . '/advertise.png' }}@stop
@section('styles')
<style>.card {
    box-shadow: 1px 3px 15px 0px rgba(0, 0, 0, 0.14);
    border: none;
}
.card {
    position: relative;
    display: flex;
    flex-direction: column;
    min-width: 0;
    word-wrap: break-word;
    background-color: #fff;
    background-clip: border-box;
    border: 1px solid rgba(0, 0, 0, 0.125);
    border-radius: 0.25rem;
}.card-body {
    flex: 1 1 auto;
    padding: 0 .25rem;
    text-align: center;
    font-weight: 700;
}.mb-3, .my-3 {
    margin-bottom: 1.5rem !important;
}.pool-detail img{width: 115px;float: left;margin: 0 10px 0 0;border: 1px solid #eee;}
.pool-detail p {font-size: 20px; font-weight: 500;line-height: 29px;}
.pool-detail button {color: white!important;} 
</style>
@stop
@section('content')
<div class="ui segment latest-block-btn">
   <div class="coins_page_headings">
      <div class="ui teal large ribbon label"><i class="tag icon"></i></div>
      <h1>@lang('v7.ADVETISE_TITLE')</h1>
   </div>
</div>
<div class="row" style="margin-left: 0px;">
  <div class="col-lg-8 col-sm-12" style="padding: unset;border-radius: 3px;">
    <div class="ui segment latest-block-btn">
  	<p>
  		<strong>{{ setting('site.site_name') }}</strong> @lang('v7.ADVETISE_DESC_1') <a href="{{ makeUrl('crypto-coins-news-headlines') }}" target="_blank">@lang('v7.ADVETISE_DESC_2')</a>, @lang('v7.ADVETISE_DESC_3') <a href="{{ makeUrl('currencies') }}" target="_blank">@lang('v7.ADVETISE_DESC_4')</a>, @lang('v7.ADVETISE_DESC_5') <a href="{{ makeUrl('') }}" target="_blank">@lang('v7.ADVETISE_DESC_6')</a>, @lang('v7.ADVETISE_DESC_7') <a href="{{ makeUrl('') }}" target="_blank">@lang('v7.ADVETISE_DESC_8')</a>. @lang('v7.ADVETISE_DESC_9')
  	</p>
  	<h2>@lang('v7.WHY_ADVERTISE')</h2>
    <ul>
    	<li>@lang('v7.REASON_1')</li>
    	<li>@lang('v7.REASON_2')</li>
    	<li>@lang('v7.REASON_3')</li>
    	<li>@lang('v7.REASON_4')</li>
    	<li>@lang('v7.REASON_5')</li>
    	<li>@lang('v7.REASON_6')</li>
    	<li>@lang('v7.REASON_7')</li>
    </ul>
    <h2>@lang('v7.WHAT_OFFER')</h2>
    <p>@lang('v7.WHAT_OFFER_DESC')</p>
    <ul>
    	<li>@lang('v7.OFFER_1')</li>
    	<li>@lang('v7.OFFER_2')</li>
    	<li>@lang('v7.OFFER_3')</li>
    	<li>@lang('v7.OFFER_4')</li>
    	<li>@lang('v7.OFFER_5')</li>
    </ul>
    <h2>@lang('v7.AUDIENCE')</h2>
    <ul>
    	<li>@lang('v7.AUDIENCE_1')</li>
    	<li>@lang('v7.AUDIENCE_2')</li>
    	<li>@lang('v7.AUDIENCE_3')</li>
    	<li>@lang('v7.AUDIENCE_4')</li>
    </ul>
    <h2>@lang('v7.HOW_ADVERTISE')</h2>
    <p>@lang('v7.HOW_ADVERTISE_DESC') – <a href="mailto:{{ setting('site.contact_email') }}">{{ setting('site.contact_email') }}</a></p>
    <h2>@lang('v7.PHISING')</h2>
	   <p>@lang('v7.PHISING_DESC') <strong>{{ setting('site.contact_email') }}</strong>.</p>    

    <p class="text-left">
        <a class="btn btn-primary coingecko" href="{{ makeUrl('contact-us') }}" style="color: #fff!important;">@lang('v7.CONTACT_US')</a>
    </p>
  </div>
</div>
<div class="col-lg-4 col-sm-12">
     <div class="col-md-13">
        <div>
         <div class="single_post_content ui segment latest-block-btn">
          <div class="box box-success table-heading-class" style="box-shadow: unset;">
              <div class="box-header with-border"><div class="ui teal large ribbon label"><i class="tag icon"></i></div>
                  <h1 class="box-title">@lang('v7.UPCOMING_EVENTS')</h1>
              </div>
          </div>
          <ul class="spost_nav single-page-news" style="list-style: none;padding: 0px;margin:0px;">
            @foreach($events as $event)
            <li style="padding-top: 20px;">
              <div class="media wow fadeInDown"> 
                <a href="{{ makeUrl('events') }}/{{ $event->alias }}" class="media-left" style="height: unset;"> 
                  @if(file_exists('public/storage/' . $event->screenshot))
                  <img style="height: 50px;width: 120px;border: 1px solid #eee;" alt="{{$event->title}}" title="{{$event->title}}" src="{{URL::asset('public/storage/' . $event->screenshot)}}"> 
                  @else
                  <img style="height: 50px;width: 120px;border: 1px solid #eee;" alt="{{$event->title}}" title="{{$event->title}}" src="{{$event->screenshot}}"> 
                  @endif
                </a>
                <div class="media-body"> 
                  <a href="{{ makeUrl('events') }}/{{ $event->alias }}" class="catg_title"> 
                    {{ str_limit(strip_tags($event->title), 30, '...') }}
                  </a> <br />
                  <span class="ui label"><i class="fa fa-clock-o fa-fw"></i>{{ date("d M Y", strtotime($event->start_date)) }}</span>
                </div>
              </div>
            </li>
            @endforeach
          </ul>
        </div>
      </div>
    </div>
  </div>
</div><br />
@stop