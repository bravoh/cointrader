@extends(getCurrentTemplate() . '.layouts.default')
@section('meta_title'){{ $event->title }}@stop
@section('meta_desc'){{ str_limit(strip_tags($event->description), 250) }}@stop
@section('meta_link'){{ Request::url() }}@stop
@section('meta_image'){{ $event->logo }}@stop
@section('styles')
<link rel="stylesheet" type="text/css" href="{{ URL::asset('public/news-page/assets/css/style.css') }}">
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
  <div class="box box-success table-heading-class">
      <div class="box-header with-border">
          <h3 class="box-title">{{ $event->title }}</h3>
          <h1 class="sr-only">{{ $event->title }}</h1>
      </div>
  </div><br />
   <div class="row">
      <div class="col-lg-8 col-sm-12">
        <div class="ui segment">
        @if(file_exists('public/storage/' . $event->screenshot))
        <img alt="Blockchain Africa Conference 2019" class="card-img-top" src="{{URL::asset('public/storage/' . $event->screenshot)}}" style="width: 100%;">
        @else
        <img alt="Blockchain Africa Conference 2019" class="card-img-top" src="{{ $event->screenshot }}" style="width: 100%;">
        @endif
        <div class="card-body"><br />
           <div class="table-responsive">
              <table class="table">
                 <tbody>
                    <tr>
                       <td>
                          <p class="card-text"></p>
                          <div class="tab-title">@lang('v7.EVENT_TYPE'): </div>
                          {{ $event->type }}
                          <p></p>
                       </td>
                       <td>
                          <p class="card-text"></p>
                          <div class="tab-title">@lang('v7.EVENT_DATE'): </div>
                          {{ date("l, M d, Y", strtotime($event->start_date)) }} - 
                          {{ date("l, M d, Y", strtotime($event->end_date )) }}
                          <p></p>
                       </td>
                    </tr>
                    <tr>
                       <td>
                          <p class="card-text"></p>
                          <div class="tab-title">@lang('v7.ORGANIZED_BY'): </div>
                          @if($event->organier)
                           {{ $event->organier }}
                          @else
                           N/A
                          @endif
                          <p></p>
                       </td>
                       <td>
                          <p class="card-text"></p>
                          <div class="tab-title">@lang('v7.EMAIL'): </div>
                          @if($event->email)
                           <a href="mailto:{{ $event->email }}">{{ $event->email }}</a>
                          @else
                           N/A
                          @endif
                          <p></p>
                       </td>
                    </tr>
                    <tr>
                       <td>
                          <p class="card-text"></p>
                          <div class="tab-title">@lang('v7.VENUE'): </div>
                          @if($event->venue)
                           {{ $event->venue }}
                          @else
                           N/A
                          @endif
                          <p></p>
                       </td>
                       <td>
                          <p class="card-text"></p>
                          <div class="tab-title">@lang('v7.ADDRESS'): </div>
                          @if($event->address)
                           {{ $event->address }}
                          @else
                           N/A
                          @endif
                          <p></p>
                       </td>
                    </tr>
                 </tbody>
              </table>
           </div>
        </div>
        <p style="padding: 6px;">{{ $event->description }}</p>
        <p class="text-left" style="padding: 6px;">
            <a class="btn btn-primary coingecko" href="{{ $event->website }}" target="_blank" rel="nofollow noopener noreferrer">
              @lang('v7.REGISTER_NOW')
            </a>
        </p>
    </div>
  </div>
  <div class="col-lg-4">
   <div class="single_post_content ui segment">
    <div class="box box-success table-heading-class" style="box-shadow: unset;">
        <div class="box-header with-border"><div class="ui teal large ribbon label"><i class="tag icon"></i></div>
            <h3 class="box-title">@lang('v7.UPCOMING_EVENTS')</h3>
        </div>
    </div>
    <ul class="spost_nav single-page-news">
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
</div><br />
@if(count($events_details) > 0)
<div class="box box-success table-heading-class">
    <div class="box-header with-border">
        <h3 class="box-title">@lang('v7.RELATED_EVENTS')</h3>
        <h1 class="sr-only">@lang('v7.RELATED_EVENTS')</h1>
    </div>
    <p style="padding: 10px;">@lang('v7.RELATED_EVENTS_DESC')</p>
</div>
<div class="tab ui active">
    <div class="row">
        @foreach ($events_details as $event)
        <div class="col-3 col-xl-4 col-lg-4 col-md-3 col-sm-4 mb-3">    
            <a class="card" href="{{ makeUrl('events') }}/{{ $event->alias }}" title="{{ $event->title }}">  
              @if(file_exists('public/storage/' . $event->screenshot))
                <img class="img-fluid" src="{{URL::asset('public/storage/' . $event->screenshot)}}" title="{{ $event->title }}" alt="{{ $event->title }}" style="width: 100%;border-bottom: 1px solid #eee;height: 200px;">
                @else
                <img class="img-fluid" src="{{ $event->screenshot }}" title="{{ $event->title }}" alt="{{ $event->title }}" style="width: 100%;border-bottom: 1px solid #eee;height: 200px;">
                @endif
                <div class="card-body">
                <h5 class="mb-0"><strong>{{ str_limit(ucfirst(strtolower($event->title)), 30) }}</strong></h5>
                </div>
            </a>
        </div>
        @endforeach
    </div>
</div>
@endif
@include('default.includes.disqus')
@stop
