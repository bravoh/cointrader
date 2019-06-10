@extends(getCurrentTemplate() . '.layouts.default')
@section('meta_title')@lang('v5.POOLS_PAGE_TITLE')@stop
@section('meta_desc')@lang('v7.MINING_POOLS_DESC')@stop
@section('meta_link'){{ Request::url() }}@stop
@section('meta_image'){{ URL::asset('public/images/pages/images') . '/pools.png' }}@stop
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
<div class="ui pointing secondary menu">
    <a class="m item active" href="{{ makeUrl('mining-pools') }}">
        <i class="file alternate icon"></i>@lang('v7.MINING_POOLS')
    </a>
    <a class="m item" href="{{ makeUrl('mining-pools') }}/hashrate-distribution">
        <i class="microchip icon"></i>@lang('blockexplorer.HASRATE_DISTRIBUTION')
    </a>
</div>
<div class="tab ui active">
    <div class="ui segment">
        <div class="coins_page_headings latest-block-btn">
            <div class="ui teal large ribbon label"><i class="tag icon"></i></div>
            <h1>@lang('v7.MINING_POOLS')</h1>
            <h2 class="sr-only">A complete list of mining pools</h2>
            <h2 class="sr-only">Compare Bitcoin, Ethereum and Litecoin Mining Pools</h2>
            <h2 class="sr-only">Bitcoin, Ethereum and Litecoin Mining Pools</h2>
        </div>
        <div class="ui divider"></div>
        <p>@lang('v7.MINING_POOLS_DESC')</p>
    </div>
    <div class="row">
        @foreach ($pools_details as $pool)
        <div class="col-4 col-xl-2 col-lg-2 col-md-3 col-sm-4 mb-3">    
            <a class="card" href="{{ makeUrl('mining-pools') }}/{{ $pool->alias }}" title="{{ $pool->name }}">  
                @if(file_exists('public/storage/' . $pool->logo))
                <img class="img-fluid" src="{{URL::asset('public/storage/' . $pool->logo)}}" title="{{ $pool->name }}" alt="{{ $pool->name }}" style="width: 100%;border-bottom: 1px solid #eee;height: 182px;">
                @else
                <img class="img-fluid" src="{{ $pool->logo }}" title="{{ $pool->name }}" alt="{{ $pool->name }}" style="width: 100%;border-bottom: 1px solid #eee;height: 182px;">
                @endif
                <div class="card-body">
                <h5 class="mb-0"><strong>{{ str_limit(ucfirst(strtolower($pool->name)), 15) }}</strong></h5>
                </div>
            </a>
        </div>
        @endforeach
    </div>
</div>
@include('default.includes.disqus')
@stop
