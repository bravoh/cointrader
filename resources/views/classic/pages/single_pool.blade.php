@extends(getCurrentTemplate() . '.layouts.default')
@section('meta_title')@lang('v5.POOLS_PAGE_TITLE')@stop
@section('meta_desc')@lang('v7.MINING_POOL_SEO_DESC', [
    'name' => $pool->name,
    'locations ' => "$pool->server_locations ",
    'coins' => "$pool->coins ",
    'payment_types ' => "$pool->payment_types ",
    'average_fee ' => "$pool->average_fee ",
    'fee_expanded' => "$pool->fee_expanded ",
    'pool_features ' => "$pool->pool_features ",
    'minimum_payout ' => "$pool->minimum_payout",
    'not ' => $pool->merged_mining == 0 ? 'not ' : '',
    'doesnot ' => $pool->tx_fee_shared_with_miner == 0 ? 'does not ' : ''
])@stop
@section('meta_link'){{ Request::url() }}@stop
@section('meta_image'){{ $pool->logo }}@stop
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
}.pool-detail img{width: 115px;float: left;margin: 0 10px 0 0;border: 1px solid #eee;}
.pool-detail p {font-size: 20px; font-weight: 500;line-height: 29px;}
.pool-detail button {color: white!important;} 
</style>
@stop
@section('content')
<div class="ui segment">
    <div class="coins_page_headings latest-block-btn">
        <div class="ui teal large ribbon label"><i class="tag icon"></i></div>
        <h1>@lang('v7.MINING_POOL'): {{ $pool->name }}</h1>
    </div>
    <div class="ui divider"></div>
    <div class="row">
        <div class="col-md-5 pool-detail">
            @if(file_exists('public/storage/' . $pool->logo))
            <img class="img-fluid" src="{{URL::asset('public/storage/' . $pool->logo)}}" title="{{ $pool->name }}" alt="{{ $pool->name }}">
            @else
            <img class="img-fluid" src="{{ $pool->logo }}" title="{{ $pool->name }}" alt="{{ $pool->name }}">
            @endif
            <div style="">
                <p style="font-size: 30px;">{{ $pool->name }}</p>
                <p>@lang('v7.MINING_POOL'): {{ $pool->average_fee }}</p>
                <p>
                    <a href="{{ $pool->affiliate_url }}" target="_blank" rel="nofollow noopener" style="font-size: 18px;">
                        <button class="ui button active logs bl">@lang('v7.MINING_POOL')</button>
                    </a>
                </p>
            </div>
        </div>
    </div><br />
    <p>
        @lang('v7.MINING_POOL_DESC', [
            'name' => "<strong>$pool->name</strong> ",
            'locations ' => "<strong>$pool->server_locations</strong> ",
            'coins' => "<strong>$pool->coins</strong> ",
            'payment_types ' => "<strong>$pool->payment_types</strong> ",
            'average_fee ' => "<strong>$pool->average_fee</strong> ",
            'fee_expanded' => "<strong>$pool->fee_expanded</strong> ",
            'pool_features ' => "<strong>$pool->pool_features</strong> ",
            'minimum_payout ' => "<strong>$pool->minimum_payout</strong>",
            'not ' => $pool->merged_mining == 0 ? 'not ' : '',
            'doesnot ' => $pool->tx_fee_shared_with_miner == 0 ? 'does not ' : '',
            'affiliate_url ' => $pool->affiliate_url
        ])
    </p>
    <div style="margin-top: 20px;" class="ui grid aligned">
        <div class="col-md-3 col-sm-12 col-xs-12">
            <div class="info-box">
                <div class="info-label">@lang('v7.MERGED_MINING') </div>
                <div class="info-text"> 
                    @if($pool->merged_mining == 0)
                        <span style="color: red;">False</span>
                    @else
                        <span style="color: green;">True</span>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-12 col-xs-12">
            <div class="info-box">
                <div class="info-label">@lang('v7.SHARED_FEE')</div>
                <div class="info-text">
                    @if($pool->tx_fee_shared_with_miner == 0)
                        <span style="color: red;">False</span>
                    @else
                        <span style="color: green;">True</span>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-12 col-xs-12">
            <div class="info-box">
                <div class="info-label"> @lang('v7.FEATURED') </div>
                <div class="info-text">
                    @if($pool->featured == 0)
                        <span style="color: red;">No</span>
                    @else
                        <span style="color: green;">Yes</span>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-12 col-xs-12">
            <div class="info-box">
                <div class="info-label">Twitter</div>
                <div class="info-text">  <a href="https://twitter.com/{{ $pool->twitter }}" target="_blank"> {{ $pool->name }} </a>  </div>
            </div>
        </div>
    </div><br /><br />
    <p>
        <strong>@lang('v7.COINS')</strong>
        <?php
            $coins = explode(',', $pool->coins);
            foreach ($coins as $key => $value) {
                ?>
                    <span class="ui label">{{ $value }}</span>
                <?php
            }
        ?>
    </p>
    <p>
        <strong>@lang('v7.POOL_FEATURES')</strong>
        <?php
            $coins = explode(',', $pool->pool_features);
            foreach ($coins as $key => $value) {
                ?>
                    <span class="ui label">{{ $value }}</span>
                <?php
            }
        ?>
    </p>
    <p>
        <strong>@lang('v7.LOCATIONS')</strong>
        <?php
            $coins = explode(',', $pool->server_locations);
            foreach ($coins as $key => $value) {
                ?>
                    <span class="ui label">{{ $value }}</span>
                <?php
            }
        ?>
    </p>
    <p>
        <strong>@lang('v7.PAYMENTS')</strong>
        <?php
            $coins = explode(',', $pool->payment_types);
            foreach ($coins as $key => $value) {
                ?>
                    <span class="ui label">{{ $value }}</span>
                <?php
            }
        ?>
    </p>
    <p>
        <strong>@lang('v7.PAYOUT')</strong>
        {{ $pool->minimum_payout }}
    </p>
    <p>
        <strong>@lang('v7.EXPANDED_FEE')</strong>
        {{ $pool->fee_expanded }}
    </p>
    @if($pool->merged_mining_coins != '')
    <p>
        <strong>@lang('v7.MERGED_MINING_COINS')</strong>
        {{ $pool->merged_mining_coins }}
    </p>
    @endif
</div>
@if($pools)
<div class="ui segment">
    <div class="coins_page_headings latest-block-btn">
        <div class="ui teal large ribbon label"><i class="tag icon"></i></div>
        <h2>@lang('v7.RELATED_POOLS')</h2>
    </div>
    <div class="ui divider"></div>
    <p>@lang('v7.RELATED_POOLS_DESC')</p>
</div>
<div class="row">
    @foreach ($pools as $pool)
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
@endif
@include('default.includes.disqus')
@stop
