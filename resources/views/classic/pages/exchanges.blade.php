@extends(getCurrentTemplate() . '.layouts.default')
@section('meta_title')@lang('seo.EXCHANGES_TITLE')@stop
@section('meta_desc')@lang('seo.EXCHANGES_DESCRIPTION')@stop
@section('meta_link'){{ Request::url() }}@stop
@section('meta_image'){{ URL::asset('public/images/pages/images') . '/exchanges.png' }}@stop
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
    padding: 0 1.25rem;
    text-align: center;
    font-weight: 700;
}.mb-3, .my-3 {
    margin-bottom: 1.5rem !important;
}</style>

@stop
@section('content')

<div class="ui segment"><div class="ui teal large ribbon label"><i class="tag icon"></i></div><h1>@lang('headings.EXCHANGES_PAGE')</h1>
</div>
<div class="row">
    @foreach ($crypto_exchanges as $exchange)
<div class="col-4 col-xl-2 col-lg-2 col-md-3 col-sm-4 mb-3">
                
    <a class="card" target="_blank" href="{{$exchange->website}}{{$exchange->affiliate}}" rel="noopener noreferrer">  
    <img class="img-fluid" src="{{ $exchange->image }}" title="{{ $exchange->name }}" alt="{{ $exchange->name }}">
    <div class="card-body">
    <h5 class="mb-0"><strong>{{ str_limit(ucfirst(strtolower($exchange->name)), 19) }}</strong></h5>
    
</div>
</a>

</div>@endforeach
</div>





@stop
