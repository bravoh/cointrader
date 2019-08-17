@extends(getCurrentTemplate() . '.layouts.default')

@section('meta_title'){{ $title }}@stop

@section('meta_desc'){{ $desc }}@stop

@section('meta_link'){{ Request::url() }}@stop

@section('meta_image'){{ URL::asset('public/images/pages/images') . '/live.png' }}@stop

@section('json-ld')
    <script type="application/ld+json"> { "@context": "http://schema.org", "@type": "Table", "about": "Cryptocurrency Prices Today" } </script>
@stop

@section('styles')
    <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdn.datatables.net/responsive/2.1.0/css/responsive.bootstrap.min.css" rel="stylesheet" />
@stop

@section('scripts')
    <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.1.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/2.0.4/socket.io.js"></script>
    <script src="{{ URL::asset('public/js/ccc-streamer-utilities.js') }}"></script>
    <script src="{{ URL::asset('public/js/default/streaming-code.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#dataTables-example').DataTable({
                responsive: true,
                "bPaginate": false,
                "columnDefs": [
                    {
                        "orderable": false,
                        "targets": [9]
                    }
                ], "language": {
                    "url": "{{ URL::asset('public/js/datatables/') }}/langs/" + $('.top-language-dropdown .item.selected').attr('name') + '.js' } }); streaming([{!! $streaming_data !!}]); });$(".add-watchlist").click(function() { var a = $(this).attr("coin"); $.get(APP_URL + "/ajax-save-favorite-coin/" + a, function(t) { "true" == t ? $("#id_" + a).addClass("favorite") : $("#id_" + a).removeClass("favorite") }) });
    </script>

@stop

@section('content')
    <div class="panel panel-default live">
        <div class="panel-heading sr-only">
            <div class="ui teal large ribbon label">
                <i class="tag icon"></i>
            </div>
            <h1>{{ $sub_heading }}</h1>
            <h2>{{ $sub_heading }}</h2>
            <p>{{ $desc }}</p>
            <b>@lang('seo.SEO2_HIDE1')</b>
            <h2>Coin Market Cap</h2>
            <p>@lang('seo.SEO2_HIDE2')<p>
                <b>@lang('seo.SEO2_HIDE3')</b>
        </div>

        <div class="panel-body all-currencies-page top-currencies-page live" style="padding-top:0">
            @if($all_markets->links() != '')
                <ul class="custom-pagination">
                    <li style="list-style-type:none">
                        <a href="{{ makeUrl('currencies') }}">
                            @lang('pagination.FIRST')
                        </a>
                    </li>
                </ul>
            @endif
                {{ $all_markets->links() }}

                <table width="100%" class="table table-bordered dataTable no-footer dtr-inline collapsed white" id="dataTables-example">
                    <thead>
                    <tr>
                        <th class="center">
                            <span class="paddi">
                                @lang('tbl_headings.RANK')
                            </span>
                        </th>

                        <th class="center">
                            @lang('tbl_headings.NAME')
                        </th>

                        <th class="left" style="width:35px">
                            <i class="fa fa-heart" title="Add to Watchlist"></i>
                        </th>

                        <th class="center">
                            @lang('tbl_headings.PRICE')
                        </th>

                        <th class="center">
                            @lang('tbl_headings.MARKET_CAP')
                        </th>

                        <th class="center">
                            @lang('tbl_headings.24h_VOLUME')
                        </th>

                        <th class="center">@lang('tbl_headings.1H_CHANGE')</th>

                        <th class="center">@lang('tbl_headings.24H_CHANGE')</th>

                        <th class="center">@lang('v5.7D_CHANGE')</th><th class="center">@lang('tbl_headings.AVAILABLE_SUPPLY')</th><th class="center">@lang('v5.BUY_SELL')</th></tr></thead><tbody class="crypto-currencies-data"> @foreach ($all_markets as $market) <tr class="odd gradeX" id="TABLE_ROW_{{$market->symbol}}"><td>{{$market->rank}}</td><td><h3 class="ui image header"><img alt='{{ $market->name }} icon' title='{{ $market->name }} ' src='{{ $market->image }}' height='25' width='25' /><div class="content">@if(isset($market->coinDetails))<a href="{{ URL::asset('currencies') }}/{{$market->coinDetails->alias}}" title="{{ $market->name }} ({{$market->symbol}}) Price, Charts & Market Cap">@endif {{$market->name}} <span class="sr-only">{{ $market->name }} ({{$market->symbol}}) Price, Charts and Market Cap</span><div class="sub header"><b><acronym title="{{ $market->name }}">{{$market->symbol}}</acronym></b></div></a></h3></td><td><a class="add-watchlist @if(isset($market->symbol, $favorite_coins)) favorite @endif" id="id_{{ $market->symbol }}" coin="{{ $market->symbol }}" style="cursor: pointer;"><i class="fa fa-heart" title="add to watchlist"></i></a></td><td class="price right" title="{{$market->symbol}} @lang('tbl_headings.PRICE')" val="{{$market->price_usd}}" id="PRICE_{{$market->symbol}}" @foreach($market->coinRates as $rate) {{$rate['f_currency']}} = "{{$rate['price']}}" @endforeach></td><td class="market_cap_usd right" title="{{$market->symbol}} @lang('tbl_headings.MARKET_CAP')" val="{{$market->market_cap_usd}}"></td><td class="volume_usd_day right" val="{{$market->volume_usd_day}}"></td><td class="percent_change_hour right" style="color:@if($market->percent_change_hour >= 0) green @else red @endif">{{$market->percent_change_hour}} % @if($market->percent_change_hour>= 0) <i class="fa fa-long-arrow-up" aria-hidden="true"></i> @else <i class="fa fa-long-arrow-down" aria-hidden="true"></i> @endif</td><td class="right" id="CHANGE24HOURPCT_{{$market->symbol}}" style="color:@if($market->percent_change_day >= 0) green @else red @endif">{{$market->percent_change_day}} %</td><td class="percent_change_week right" style="color: @if($market->percent_change_week >= 0) green @else red @endif">{{$market->percent_change_week}} % @if($market->percent_change_week>= 0) <i class="fa fa-long-arrow-up" aria-hidden="true"></i> @else <i class="fa fa-long-arrow-down" aria-hidden="true"></i> @endif </td><td class="right">{{$market->available_supply}} {{$market->symbol}}</td><td><div class="ui label" style="background:#00b5ad;color:#fff;"><div class="ui simple dropdown item"><i class="cart icon"></i> @lang('v5.BUY_SELL') <i class="dropdown icon"></i><div class="menu"><div class="item"><a href="https://www.livecointrackers.com/en/buy-sell-cryptocoins" rel="follow" target="_blank" title="Buy/Sell instantly " alt="Buy Sell instantly"> Instantly</a></div><div class="item"><a href="https://changelly.com/exchange/BTC/{{$market->symbol}}/1?ref_id=2c73908de163" rel="nofollow" target="_blank" title="Buy/Sell {{ $market->name }} {{$market->symbol}} on Changelly" alt="Buy Sell {{ $market->name }} {{$market->symbol}} on Changelly"> Changelly</a></div><div class="item"><a href="https://www.bibox.com/signPage?id=11483472&lang=en" target="_blank" rel="nofollow" title="Buy/Sell {{ $market->name }} {{$market->symbol}} on Bibox" alt="Buy Sell {{ $market->name }} {{$market->symbol}} on Bibox"> Bibox</a></div><div class="item"><a href="https://www.binance.com/?ref=35056213" target="_blank" title="Buy/Sell {{ $market->name }} {{$market->symbol}} on Binance" rel="nofollow" alt="Buy Sell {{ $market->name }} {{$market->symbol}} on Binance"> Binance</a></div><div class="item"><a href="https://www.kucoin.com/#/?r=MJ5g5c" target="_blank" title="Buy/Sell {{ $market->name }} {{$market->symbol}} on KuCoin" rel="nofollow" alt="Buy Sell {{ $market->name }} {{$market->symbol}} on KuCoin"> Kucoin</a></div><div class="item"><a href="https://www.cryptopia.co.nz/Register?referrer=wahyu243" target="_blank" rel="nofollow" title="Buy/Sell {{ $market->name }} {{$market->symbol}} on Cryptopia" alt="Buy Sell {{ $market->name }} {{$market->symbol}} on Cryptopia"> Cryptopia</a></div></div></div></div></td></tr> @endforeach </tbody></table> @if($all_markets->links() != '') <ul class="custom-pagination"><li style="list-style-type:none"><a href="{{ makeUrl('currencies') }}">@lang('pagination.FIRST')</a></li></ul> @endif {{ $all_markets->links() }}<em>*Live updates are integrated by using coinmarketcap and cryptocompare APIs. </em></div></div> @stop
