@extends(getCurrentTemplate() . '.layouts.default')
@section('meta_title')@lang('v7.EVENTS_SEO_TITLE')@stop
@section('meta_desc')@lang('v7.EVENTS_SEO_DESC')@stop
@section('meta_link'){{ Request::url() }}@stop
@section('meta_image'){{ URL::asset('public/images/pages/images') . '/events.png' }}@stop
@section('styles')<style>.card {
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
}</style>
@stop
@section('content')
<div class="tab ui active">
    <div class="ui segment  latest-block-btn">
        <div class="coins_page_headings">
            <div class="ui teal large ribbon label"><i class="tag icon"></i></div>
            <h1>@lang('v7.EVENTS')</h1>
            <h2 class="sr-only">A complete list of crypto Wallets</h2>
            <h2 class="sr-only">Compare Bitcoin, Ethereum and Litecoin Wallets</h2>
            <h2 class="sr-only">Bitcoin, Ethereum and Litecoin Wallets</h2>
        </div>
        <div class="ui divider"></div>
        <p>@lang('v7.EVENTS_DESC')</p>
    </div>
    <div class="row">
        @if(count($events_details) > 0)
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
        @else
        <div class="col-md-12">
            <div class="ui segment">No event yet.</div><br />
        </div>
        @endif
    </div>
</div>
@include('default.includes.disqus')
@stop
