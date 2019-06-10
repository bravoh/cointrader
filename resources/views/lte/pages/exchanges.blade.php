@extends(getCurrentTemplate() . '.layouts.default')
@section('meta_title')@lang('seo.EXCHANGES_TITLE')@stop
@section('meta_desc')@lang('seo.EXCHANGES_DESCRIPTION')@stop
@section('meta_link'){{ Request::url() }}@stop
@section('meta_image'){{ URL::asset('public/images/pages/images') . '/exchanges.png' }}@stop
@section('styles')
<style type="text/css">
.mb-3, .my-3 {margin-bottom: 1.5rem !important;}
a.card {position: relative;display: flex;flex-direction: column;min-width: 0;word-wrap: break-word;background-color: #fff;background-clip: border-box;border: 1px solid rgba(0, 0, 0, 0.125);border-radius: 0.25rem;text-align: center;font-weight: normal;text-decoration: unset;}
a.card:hover {text-decoration: unset;}
a.card img {width: 100%;}
.img-fluid{height: 160px;border-bottom: 1px solid #eee;}
</style>
@stop
@section('content')
<div class="panel panel-default">
    <div class="box box-success table-heading-class">
        <div class="box-header with-border">
            <h3 class="box-title">@lang('headings.EXCHANGES_PAGE')</h3>
        </div>
    </div>
</div>
<div class="row">
    @foreach ($crypto_exchanges as $exchange)
    <div class="col-4 col-xl-3 col-lg-3 col-md-3 col-sm-4 mb-3">            
    <a class="card" target="_blank" href="{{$exchange->website}}{{$exchange->affiliate}}" rel="nofollow noopener noreferrer">      
        <img class="img-fluid" src="{{ $exchange->image }}" title="{{ $exchange->name }}" alt="{{ $exchange->name }}">
        <div class="card-body">
            <h5 class="mb-0"><strong>{{ str_limit(ucfirst(strtolower($exchange->name)), 19) }}</strong></h5>
        </div>
    </a>
    </div>
    @endforeach
</div>
@stop
