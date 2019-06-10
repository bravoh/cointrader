@extends(getCurrentTemplate() . '.layouts.default')
@section('meta_title')@lang('v7.WALLETS_SEO_TITLE')@stop
@section('meta_desc')@lang('v7.WALLETS_DESC')@stop
@section('meta_link'){{ Request::url() }}@stop
@section('meta_image'){{ URL::asset('public/images/pages/images') . '/wallets.png' }}@stop
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
    <div class="box box-success table-heading-class">
        <div class="box-header with-border">
            <h3 class="box-title">@lang('v7.WALLETS')</h3>
            <h1 class="sr-only">@lang('v7.WALLETS')</h1>
            <h2 class="sr-only">A complete list of crypto Wallets</h2>
            <h2 class="sr-only">Compare Bitcoin, Ethereum and Litecoin Wallets</h2>
            <h2 class="sr-only">Bitcoin, Ethereum and Litecoin Wallets</h2>
        </div>
        <p style="padding: 10px;">@lang('v7.WALLETS_DESC')</p>
    </div>
    <div class="row">
        @foreach ($wallets_details as $wallet)
        <div class="col-4 col-xl-2 col-lg-2 col-md-3 col-sm-4 mb-3">    
            <a class="card" href="{{ makeUrl('wallets') }}/{{ $wallet->alias }}" title="{{ $wallet->name }}">  
                @if(file_exists('public/storage/' . $wallet->logo))
                <img class="img-fluid" src="{{URL::asset('public/storage/' . $wallet->logo)}}" title="{{ $wallet->name }}" alt="{{ $wallet->name }}" style="width: 100%;border-bottom: 1px solid #eee;height: 182px;">
                @else
                <img class="img-fluid" src="{{ $wallet->logo }}" title="{{ $wallet->name }}" alt="{{ $wallet->name }}" style="width: 100%;border-bottom: 1px solid #eee;height: 182px;">
                @endif
                <div class="card-body">
                <h5 class="mb-0"><strong>{{ str_limit(ucfirst(strtolower($wallet->name)), 15) }}</strong></h5>
                </div>
            </a>
        </div>
        @endforeach
    </div>
</div>
@include('default.includes.disqus')
@stop
