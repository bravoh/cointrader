@extends(getCurrentTemplate() . '.layouts.default')
@if(isset($market->name))
@section('meta_title')@lang('v6.COIN_DETAIL_TITLE', ['COIN' => $market->name])@stop
@section('meta_desc')@lang('v6.COIN_DETAIL_DESC', ['COIN' => $market->name])@stop
@else
@section('meta_title')@lang('v6.COIN_DETAIL_TITLE', ['COIN' => 'This coin'])@stop
@section('meta_desc')@lang('v6.COIN_DETAIL_DESC', ['COIN' => 'This coin'])@stop
@endif
@section('meta_link'){{ Request::url() }}@stop
@section('meta_image')
@if(isset($market->image)){{ $market->image }}@elseif(isset($market->symbol)){{ URL::asset('public/images/coins_icons') }}/{{ strtolower($market->symbol).'_.png' }}@endif
@stop
@section('styles')
<link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap.min.css" rel="stylesheet" />
<link href="https://cdn.datatables.net/responsive/2.1.0/css/responsive.bootstrap.min.css" rel="stylesheet" />
<style>.price:after {display: none}</style>
@stop 
@section('scripts')
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap.min.js" async></script>
<script src="https://cdn.datatables.net/responsive/2.1.0/js/dataTables.responsive.min.js" async></script>
<script src="{{ URL::asset('public/js/amchart/core.js') }}"></script>
<script src="{{ URL::asset('public/js/amchart/charts.js') }}"></script>
<script src="{{ URL::asset('public/js/amchart/animated.js') }}"></script>
@if(isset($market->name))
<script type="text/javascript">
    function loadAreaChart(a) {
        var t = $(".time-frame :selected").val();
        $.getJSON('{{URL::to("/")}}/ajax-load-historical-data/' + a + "/" + t + "/USD", function(res_data) {
            am4core.useTheme(am4themes_animated);
            var chart = am4core.create("price-area-chart", am4charts.XYChart);
            chart.data = res_data;
            var dateAxis = chart.xAxes.push(new am4charts.DateAxis());
            var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
            var series = chart.series.push(new am4charts.LineSeries());
            series.dataFields.dateX = "date";
            series.dataFields.valueY = "visits";
            series.tooltipText = "${valueY.value}";
            chart.cursor = new am4charts.XYCursor();
            series.fillOpacity = 0.5;
            series.fill = am4core.color("#00b5ad");
            series.stroke = am4core.color("#00b5ad");
        });
    }

    function loadCandleChart(a) {
        var t = $(".time-frame-candle :selected").val();
        $.getJSON('{{URL::to("/")}}/ajax-load-historical-data-candle/' + a + "/" + t + "/USD", function(res_data) {
            am4core.useTheme(am4themes_animated);
            var chart = am4core.create("container-candle", am4charts.XYChart);
            var dateAxis = chart.xAxes.push(new am4charts.DateAxis());
            dateAxis.renderer.grid.template.location = 0;
            dateAxis.skipEmptyPeriods = true;
            dateAxis.renderer.axisFills.template.disabled = true;
            dateAxis.renderer.ticks.template.disabled = true;
            var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
            valueAxis.tooltip.disabled = true;
            valueAxis.renderer.axisFills.template.disabled = true;
            valueAxis.renderer.ticks.template.disabled = true;
            var series = chart.series.push(new am4charts.CandlestickSeries());
            series.dataFields.dateX = "date";
            series.dataFields.valueY = "close";
            series.dataFields.openValueY = "open";
            series.dataFields.lowValueY = "low";
            series.dataFields.highValueY = "high";
            series.tooltipText = "Open:${openValueY.value}\nLow:${lowValueY.value}\nHigh:${highValueY.value}\nClose:${valueY.value}";

            series.riseFromOpenState.properties.fill = am4core.color("#00b5ad");
            series.dropFromOpenState.properties.fill = am4core.color("#aa3939");
            series.riseFromOpenState.properties.stroke = am4core.color("#00b5ad");
            series.dropFromOpenState.properties.stroke = am4core.color("#aa3939");

            series.riseFromPreviousState.properties.fillOpacity = 1;
            series.dropFromPreviousState.properties.fillOpacity = 0;

            chart.cursor = new am4charts.XYCursor();
            chart.cursor.behavior = "panX";
            var lineSeries = chart.series.push(new am4charts.LineSeries());
            lineSeries.dataFields.dateX = "date";
            lineSeries.dataFields.valueY = "close";
            lineSeries.defaultState.properties.visible = false;
            lineSeries.hiddenInLegend = true;
            lineSeries.fillOpacity = 0.5;
            lineSeries.strokeOpacity = 0.5;

            chart.data = res_data;
        });
    }
    $(document).ready(function() {
        loadAreaChart("{{ $market->symbol }}");
        loadCandleChart("@if(isset($market->symbol)){{ $market->symbol }}@endif"); 
        $("#dataTables-example").DataTable({
            responsive: !0,
            iDisplayLength: 20,
            bFilter: !1,
            bLengthChange: !1,
            language: {
                url: "{{ URL::asset('public/js/datatables/') }}/langs/" + $(".top-language-dropdown .item.selected").attr("name") + ".js"
            }
        });
        $("#dataTables-markets").DataTable({
            responsive: !0,
            iDisplayLength: 20,
            bFilter: !1,
            bLengthChange: !1,
            language: {
                url: "{{ URL::asset('public/js/datatables/') }}/langs/" + $(".top-language-dropdown .item.selected").attr("name") + ".js"
            }
        });
        $("ul.full-detail-page-tabs li a").click(function() {
            "candlestick" == $(this).attr("type") && loadCandleChart("@if(isset($market->symbol)){{ $market->symbol }}@endif")
        });
        $(".add-watchlist").click(function() {
            var a = $(this).attr("coin");
            $.get(APP_URL + "/ajax-save-favorite-coin/" + a, function(t) {
                "true" == t ? $("#id_" + a).addClass("favorite") : $("#id_" + a).removeClass("favorite")
            })
        });
    });
    $('.descmenu .menu .item').tab();
</script>
@endif 
@stop 
@section('content')
<div class="ui segment">
    <div class="ui teal large ribbon label"><strong><span class="sr-only">{{ $market->name }} Crypto Coin </span>Rank @if($market->rank != 0) {{ $market->rank }} @endif </strong></div>

    @if(isset($coin_details->website_url) && $coin_details->website_url !='') <a title="{{ $market->name }}" href="{{ $coin_details->website_url }}" target="_blank" class="ui label cd coin-name-label"><i class="linkify icon"></i> @lang('tbl_headings.WEBSITE')</a> @endif 

    @if(isset($coin_details->ico_white_paper_link) && $coin_details->ico_white_paper_link != '') <a href="{{ $coin_details->ico_white_paper_link }}" class="ui label social-link-label" target="_blank"><i class="file alternative icon"></i> @lang('tbl_headings.WHITE_PAPER')</a> @endif 

    @if(isset($coin_details->reddit) && $coin_details->reddit != '') <a href="{{ $coin_details->reddit }}" target="_blank" class="ui label social-link-label"><i class="reddit alien icon"></i>r/<span id="subreddit">{{ $market->name }}</span></a> @endif

    <div class="ui label market-cap-btc-label">@if(isset($market->name)) <i class="anchor icon"></i> @if($market->available_supply != 0) {{ $market->available_supply }} {{ $market->symbol }} @else N/A @endif @endif </div> 

    @if(setting('3rdparty.buy_sell_coin') !='' )
    <div class="ui label cd simple dropdown item" style="background:#00b5ad;color:#fff;"><i class="credit card outline icon"></i>   @lang('v5.BUY_SELL') <i class="dropdown icon"></i>
        <div class="menu">
            @if(isset($affiliates))
              @foreach($affiliates as $affiliate)
               <div class="item">
                  <a href="{{ $affiliate->link }}" target="_blank" title="{{ $affiliate->name }}" alt="{{ $affiliate->name }}">
                    {{ $affiliate->name }}
                  </a>
              </div>
              @endforeach
            @endif  
        </div>
    </div> 
    @endif
    <div class="ui label cd simple dropdown item" style="background:#f06060;color:#fff;"><i class="google wallet icon"></i> Get Wallet <i class="dropdown icon"></i>
        <div class="menu">
            <div class="item">
                <a rel="nofollow" href="https://freewallet.org/currency/{{ strtolower($market->symbol) }}" target="_blank" title="Get Free {{$market->symbol}} Wallet" alt="Get Free {{$market->symbol}} Wallet">
                    @lang('v6.FREE_WALLET_1')
                </a>
                <p><small>@lang('v6.FREE_WALLET_SUB_1')</small></p>
            </div>
            <div class="item">
                <a rel="nofollow" href="https://www.blockchain.com/wallet" target="_blank" title="Get Free {{$market->symbol}} Wallet" alt="Get Free {{$market->symbol}} Wallet">
                    @lang('v6.FREE_WALLET_2')
                </a>
                <p><small>@lang('v6.FREE_WALLET_SUB_2')</small></p>
            </div>
        </div>
    </div>
    @if(Auth::user())
    <div style="display:inline-block;float:right"><a class="add-watchlist coin-detail @if(in_array($market->symbol, $favorite_coins)) favorite @endif" id="id_{{ $market->symbol }}" coin="{{ $market->symbol }}" style="cursor: pointer;"><i class="fa fa-heart fa-1.4x" title="add to watchlist" style="margin-left:5px;padding: 6px;border-radius:3px;border: 1px solid #e8e8e8;"></i></a></div>
    @endif
    <div style="margin-top: 10px;" class="ui grid">
        <div class="four wide column">
            <h2 class="ui header">@if(isset($market->name))<img alt="{{ $market->name }} " title="{{ $market->name }}" width="38" height="38" src="{{ str_replace('/thumbs', '', $market->image) }}" /> @endif <div class="content">@if(isset($market->name)) {{ $market->name }} @else {{ $market->name }} @endif <div id="code" class="sub header"><strong class="sr-only">{{ $market->symbol }} Coin Values</strong><em><b><acronym title="{{ $market->name }}"> {{ $market->symbol }}</acronym></b></em></div> </div> </h2> </div>
        <div class="twelve wide column right aligned">
            <div class="ui horizontal relaxed list">
                <!-- Price-->
                <div class="item">
                    <h3 id="usd" class="ui header"><i id="usd" class="big dollar sign icon"></i> <div class="content colored"><span class="sr-only">{{ $market->name }} values</span><acronym title="United States Dollar">USD</acronym> @lang('tbl_headings.PRICE') <div id="usd" class="sub header price colored">@if($market->price_usd < 0.9999) $ {{ number_format($market->price_usd, 4) }} @else $ {{ number_format($market->price_usd, 2) }}@endif</div> </div> </h3> </div>
                <!-- Price BTC-->
                <div class="item">
                    <h3 class="ui header"><i class="big bitcoin icon"></i> 
                        <div class="content colored">
                            <span class="sr-only">{{ $market->name }} </span>BTC    @lang('tbl_headings.PRICE')
                            <div id="vmc" class="sub header"> {{ formatBTCPrice($market->price_btc) }}
                            </div> 
                        </div> 
                    </h3> 
                </div>
                <!-- Volume-->
                <div class="item detail-page-market-stats">
                    <h3 id="vol" class="ui header"><i class="big signal icon"></i> <div class="content colored"><strong><span class="sr-only">{{ $market->name }} </span>@lang('tbl_headings.24h_VOLUME')</strong> <div id="vol" class="sub header price colored">$ {{ number_format($market->volume_usd_day) }}</div> </div> </h3> </div>
                <!-- Market Cap-->
                <div class="item detail-page-market-stats">
                    <h3 id="cap" class="ui header"><i class="big line chart icon"></i> <div class="content colored"><span class="sr-only">{{ $market->name }} </span> @lang('tbl_headings.MARKET_CAP') <div id="cap" class="sub header price">$ {{ number_format($market->market_cap_usd) }}</div> </div> </h3> </div>
            </div>
        </div>
    </div>
    <div class="ui divider"></div>
    <div style="margin-top: 20px; margin-bottom: 20px;" class="ui grid center aligned">
        <div class="row">
            <div class="four wide column detail-page-market-stats">
                <div class="ui mini statistic">
                    <div class="label">@lang('tbl_headings.24h_VOLUME')</div><span id="dailyHigh" class="value price-fiat">{{ number_format(($market->volume_usd_day/$market->price_usd)*$market->price_btc) }} BTC</span></div>
            </div>
            <div class="four wide column">
                <div class="ui mini statistic">
                    <div class="label">1 H</div><span id="dailyLow" class="value price-fiat">@if(isset($market->percent_change_hour)) @if($market->percent_change_hour >=0) <span class="green"> {{ $market->percent_change_hour }} % <i class="fa fa-long-arrow-up" aria-hidden="true"></i> </span> @else <span class="red"> {{ $market->percent_change_hour }} % <i class="fa fa-long-arrow-down" aria-hidden="true"></i></span> @endif @endif</span>
                </div>
            </div>
            <div class="four wide column">
                <div class="ui mini statistic">
                    <div class="label">24 H</div><span id="dailySpread" class="value">@if(isset($market->percent_change_day)) @if($market->percent_change_day >=0) <span class="green"> {{ $market->percent_change_day }} % <i class="fa fa-long-arrow-up" aria-hidden="true"></i></span> @else <span class="red"> {{ $market->percent_change_day }} % <i class="fa fa-long-arrow-down" aria-hidden="true"></i> </span> @endif @endif</span>
                </div>
            </div>
            <div class="four wide column">
                <div class="ui mini statistic">
                    <div class="label">7 d</div><span id="ath" class="value price-fiat">@if(isset($market->percent_change_week)) @if($market->percent_change_week >=0) <span class="green"> {{ $market->percent_change_week }} % <i class="fa fa-long-arrow-up" aria-hidden="true"></i></span> @else <span class="red"> {{ $market->percent_change_week }} % <i class="fa fa-long-arrow-down" aria-hidden="true"></i> </span> @endif @endif</span>
                </div>
            </div>
        </div>
    </div>
    <div class="ui divider"></div>
     <div class="descriptiond">@lang('seo.COIN_DES1') <strong><a href="{{ Request::url() }}" title="{{ $market->name }}">{{ $market->name }}</a></strong> @lang('seo.COIN_DES2') <strong> 
        @if($market->price_usd < 0.9999) {{ number_format($market->price_usd, 4) }} @else {{ number_format($market->price_usd, 2) }}@endif 

        USD</strong>, @lang('seo.COIN_DES3') <a href="{{ makeUrl('currencies/bitcoin') }}" title="@lang('seo.COIN_DES14')">@lang('seo.COIN_DES14')</a> @lang('seo.COIN_DES15') <strong>

        @if($market->price_btc < 0.999999){{ number_format($market->price_btc, 8) }} @else {{ number_format($market->price_btc, 2) }} @endif 

        <acronym title="Bitcoin">BTC</acronym></strong>. @lang('seo.COIN_DES4') <strong>{{ number_format(($market->market_cap_usd/$market->price_usd)*$market->price_btc) }} @lang('seo.COIN_DES5')</strong> @lang('seo.COIN_DES6') <i>{{ $market->name }}</i> @lang('seo.COIN_DES7') <strong> {{ $market->percent_change_day }} %</strong>@lang('seo.COIN_DES8') <a href="{{ makeUrl('currencies') }}" title="@lang('seo.COIN_DES9')">@lang('seo.COIN_DES9')</a> @lang('seo.COIN_DES10') <strong>{{ number_format($market->volume_usd_day/100000000, 3) }} M US dollars</strong> @lang('seo.COIN_DES11') <strong>{{ $market->name }}</strong> @lang('seo.COIN_DES12') <a href="{{ makeUrl('crypto-exchanges') }}" title="@lang('seo.COIN_DES13')">@lang('seo.COIN_DES13')</a>. @lang('v7.SEO_DESC14') {{ $market->name }}'s @lang('v7.SEO_DESC15') <a href="{{ makeUrl('user/favorites-coins') }}" title="Favorites Coins">@lang('v7.SEO_DESC16')</a> @lang('v7.SEO_DESC17') <a href="{{ makeUrl('user/blockfolio') }}" title="Portfolio">@lang('v7.SEO_DESC18')</a> @lang('v7.SEO_DESC19').</div>
    <div class="ui divider"></div>
    <div style="margin-top: 20px;" class="ui grid center aligned">
        <div class="detail-page-market-stats">
            <div class="col-md-2 col-sm-3 col-xs-4">
                 <div class="info-box">
                    <div class="info-label"> @lang('tbl_headings.FULL_NAME') </div>
                    <div class="info-text">{{ $market->name }}</div>
                 </div>
              </div>
              <div class="col-md-2 col-sm-3 col-xs-4">
                 <div class="info-box">
                    <div class="info-label"> @lang('v5.SYMBOL') </div>
                    <div class="info-text"> {{ $market->symbol }} </div>
                 </div>
              </div>
              <div class="col-md-2 col-sm-3 col-xs-4">
                 <div class="info-box">
                    <div class="info-label">@lang('v5.ALGO')</div>
                    <div class="info-text"> @if(isset($coin_details->algorithm)) {{ $coin_details->algorithm }} @else N/A @endif</div>
                 </div>
              </div>
              <div class="col-md-2 col-sm-3 col-xs-4">
                 <div class="info-box">
                    <div class="info-label">@lang('v5.BTC_PRICE')</div>
                    <div class="info-text"> @if(isset($market->price_btc)){{ formatBTCPrice($market->price_btc) }} BTC @else --- @endif  </div>
                 </div>
              </div>
              <div class="col-md-2 col-sm-3 col-xs-4">
                 <div class="info-box">
                    <div class="info-label">@lang('v5.BTC_MARKET')</div>
                    <div class="info-text"> @if(isset($market->price_btc)){{ number_format(($market->market_cap_usd/$market->price_usd)*$market->price_btc) }} BTC @else --- @endif </div>
                 </div>
              </div>
              <div class="col-md-2 col-sm-3 col-xs-4">
                 <div class="info-box">
                    <div class="info-label">BTC 24h Vol</div>
                    <div class="info-text"> @if(isset($market->price_btc)){{ number_format(($market->volume_usd_day/$market->price_usd)*$market->price_btc) }} BTC @else --- @endif</div>
                 </div>
              </div>
              <div class="col-md-2 col-sm-3 col-xs-4">
                 <div class="info-box">
                    <div class="info-label">@lang('tbl_headings.TOTAL_COINS_MINED')</div>
                    <div class="info-text">  @if(isset($market->price_btc)){{ $market->available_supply }} {{ $market->symbol }} @else --- @endif   </div>
                 </div>
              </div>
              <div class="col-md-2 col-sm-3 col-xs-4">
                 <div class="info-box">
                    <div class="info-label">1h</div>
                    <div class="info-text">
                      @if(isset($market->percent_change_hour))
                        @if($market->percent_change_hour >=0)
                            <span style="color: green">
                                {{ $market->percent_change_hour }} %
                            </span>
                        @else
                            <span style="color: red">
                                {{ $market->percent_change_hour }} %
                            </span>
                        @endif
                      @endif
                    </div>
                 </div>
              </div>
              <div class="col-md-2 col-sm-3 col-xs-4">
                 <div class="info-box">
                    <div class="info-label">24h</div>
                    <div class="info-text">
                      @if(isset($market->percent_change_day))
                        @if($market->percent_change_day >=0)
                            <span style="color: green">
                                {{ $market->percent_change_day }} %
                            </span>
                        @else
                            <span style="color: red">
                                {{ $market->percent_change_day }} %
                            </span>
                        @endif
                      @endif
                    </div>
                 </div>
              </div>
              <div class="col-md-2 col-sm-3 col-xs-4">
                 <div class="info-box">
                    <div class="info-label">7d</div>
                    <div class="info-text">
                      @if(isset($market->percent_change_week))
                        @if($market->percent_change_week >=0)
                            <span style="color: green">
                                {{ $market->percent_change_week }} %
                            </span>
                        @else
                            <span style="color: red">
                                {{ $market->percent_change_week }} %
                            </span>
                        @endif
                      @endif
                    </div>
                 </div>
              </div>
              @if(isset($coin_details->twitter) && $coin_details->twitter != '')
              <div class="col-md-2 col-sm-3 col-xs-4">
                 <div class="info-box">
                    <div class="info-label">Twitter</div>
                    <div class="info-text">  <a href="https://twitter.com/{{ $coin_details->twitter }}" target="_blank"> {{ $market->name }} </a>  </div>
                 </div>
              </div>
              @else
              <div class="col-md-2 col-sm-3 col-xs-4">
                 <div class="info-box">
                    <div class="info-label">Reddit</div>
                    <div class="info-text">  
                        @if(isset($coin_details->reddit))
                        <a href="{{ $coin_details->reddit }}" target="_blank"> {{ $market->name }} </a>  
                        @else
                        N/A
                        @endif
                    </div>
                 </div>
              </div>
              @endif
              @if(isset($coin_details->facebook) && $coin_details->facebook != '')
              <div class="col-md-2 col-sm-3 col-xs-4">
                 <div class="info-box">
                    <div class="info-label">Facebook</div>
                    <div class="info-text"> 
                        @if(isset($coin_details->facebook))
                        <a href="{{ $coin_details->facebook }}" target="_blank"> {{ $market->name }} </a>  
                        @else
                        N/A
                        @endif
                    </div>
                 </div>
              </div>
              @else
              <div class="col-md-2 col-sm-3 col-xs-4">
                 <div class="info-box">
                    <div class="info-label">@lang('tbl_headings.WEBSITE')</div>
                    <div class="info-text">  
                        @if(isset($coin_details->website_url))
                        <a href="{{ $coin_details->website_url }}" target="_blank"> {{ $market->name }} </a>  
                        @else
                        N/A
                        @endif
                    </div>
                 </div>
              </div>
              @endif
        </div>
        <div class="social-share">
            <h4>Share {!! $market->name !!} Price</h4>
            {!! Share::page(Request::url(), $market->name)->facebook()->twitter()->linkedin($market->name) !!} 
        </div>
    </div>
    <div class="clear"></div>
</div> 
@if(count($coin_historical_data) > 10)
<div class="ui segment">
    <div class="ui teal large ribbon label"><i class="fa fa-area-chart fa-fw"></i>{{ $market->symbol }} @lang('menu.CHARTS')
    <h3 class="sr-only">{{ $market->name }}  @lang('tbl_headings.PRICE') @lang('menu.CHARTS')</h3></div>
    <div class="pull-right time-frame-select-box" style="margin-top: 0px;">
        <div class="btn-group">
            <select class="time-frame form-control" style="font-size: unset;" onchange="loadAreaChart('{{ $market->symbol }}')">
                <option value="7 day">7 @lang('menu.DAYS')</option>
                <option value="1 months">1 @lang('menu.MONTH')</option>
                <option value="3 months">3 @lang('menu.MONTHS')</option>
                <option value="6 months" selected="selected">6 @lang('menu.6_MONTHS')</option>
                <option value="1 year">1 @lang('menu.YEAR')</option>
                <option value="2 year">2 @lang('menu.YEARS')</option>
                <option value="all">@lang('menu.ALL')</option>
            </select>
        </div>
    </div>
    <div id="price-area-chart" style="height: 400px;"></div>
</div>
<div class="descmenu">
    <div class="ui pointing secondary menu"><a class="m item active" data-tab="Hightlow"><i class="chart bar outline icon"></i>@lang('menu.HIGH_LOW_CHART')</a><a class="m item" data-tab="Historical"><i class="history icon"></i>@lang('menu.PRICE_HISTORY')</a><a class="m item" data-tab="Market"><i class="balance icon"></i>@lang('menu.MARKETS')</a></div>
    <div class="ui tab segment active" data-tab="Hightlow">
        <div class="ui teal large ribbon label">{{ $market->symbol }} @lang('menu.HIGH_LOW_CHART')
            <h3 class="sr-only">{{ $market->name }} @lang('tbl_headings.PRICE') @lang('menu.HIGH_LOW_CHART')</h3>
        </div>
        <div class="pull-right time-frame-select-box" style="margin-top: 0px;">
            <div class="btn-group">
                <select class="time-frame-candle form-control" style="font-size: unset;" onchange="loadCandleChart('{{ $market->symbol }}')">
                    <option value="7 day">7 @lang('menu.DAYS')</option>
                    <option value="1 months">1 @lang('menu.MONTH')</option>
                    <option value="3 months">3 @lang('menu.MONTHS')</option>
                    <option value="6 months" selected="selected">6 @lang('menu.6_MONTHS')</option>
                    <option value="1 year">1 @lang('menu.YEAR')</option>
                    <option value="2 year">2 @lang('menu.YEARS')</option>
                    <option value="all">@lang('menu.ALL')</option>
                </select>
            </div>
        </div>
        <div id="container-candle" style="height: 400px;"></div>
    </div>
    <div class="ui tab segment" data-tab="Historical">
        <div class="ui teal large ribbon label">@lang('menu.PRICE_HISTORY')
            <h4 class="sr-only">{{ $market->name }} Crypto Technology</h4></div>
        <div class="table-responsive">
            <table style="width: 100%;" class="table table-bordered dataTable no-footer dtr-inline collapsed" id="dataTables-example">
                <thead>
                    <tr>
                        <th>@lang('tbl_headings.DATE')</th>
                        <th>@lang('tbl_headings.OPEN')</th>
                        <th>@lang('tbl_headings.CLOSE')</th>
                        <th>@lang('tbl_headings.HIGH')</th>
                        <th>@lang('tbl_headings.LOW')</th>
                    </tr>
                </thead>
                <tbody> @foreach ($coin_historical_data as $historical_price)
                    <tr>
                        <td>{{ date("Y-m-d", strtotime($historical_price->time)) }}</td>
                        <td>{{ formatHistoricalPrices($historical_price->open) }}</td>
                        <td>{{ formatHistoricalPrices($historical_price->close) }}</td>
                        <td>{{ formatHistoricalPrices($historical_price->high) }}</td>
                        <td>{{ formatHistoricalPrices($historical_price->low) }}</td>
                    </tr> @endforeach </tbody>
            </table>
        </div>
    </div>
    @if(count($markets) > 0)
    <div class="ui tab segment" data-tab="Market">
        <div class="ui teal large ribbon label">@lang('menu.MARKETS')
            <h4 class="sr-only">{{ $market->name }} Crypto Market</h4></div>
        <table style="width: 100%;" class="table table-bordered dataTable no-footer dtr-inline collapsed" id="dataTables-markets">
            <thead>
                <tr>
                    <th>@lang('tbl_headings.PAIR')</th>
                    <th>@lang('tbl_headings.EXCHANGE')</th>
                </tr>
            </thead>
            <tbody> @foreach ($markets as $market_paiar)
                <tr>
                    <td>{{ $market_paiar->pair }}</td>
                    <td class="capital">{{ $market_paiar->exchange }}</td>
                </tr> @endforeach </tbody>
        </table>
    </div>
    @endif 
</div>
@endif
@if(isset($coin_details->full_name))
<div class="descmenu">
    <div class="ui pointing secondary menu"><a class="m item active" data-tab="Description"><i class="file alternate icon"></i>Description</a><a class="m item" data-tab="Technology"><i class="microchip icon"></i>Technology</a><a class="m item" data-tab="Features"><i class="qrcode icon"></i>Features</a></div>
    <div class="ui tab segment active" data-tab="Description">
        <div class="ui teal large ribbon label">Description
            <h4 class="sr-only">{{ $market->name }} Crypto ICO Description</h4></div>
        <div style="margin-top: 20px;" class="ui grid">
            <div class="descript">@if (isset($coin_details->description) && $coin_details->description != ''){!! $coin_details->description !!}
                <p><ins class="adsbygoogle" style="display:block" data-ad-client="ca-pub-1344864982877041" data-ad-slot="9431398314" data-ad-format="link" data-full-width-responsive="true"></ins></p> @else
                <p>Sorry, detailed description about {{ $market->name }} is not currently available </p> @endif </div>
        </div>
    </div>
    <div class="ui tab segment" data-tab="Technology">
        <div class="ui teal large ribbon label">@lang('v5.TECH')
            <h4 class="sr-only">{{ $market->name }} Crypto Technology</h4></div>
        <div style="margin-top: 20px;" class="ui grid descript"> @if (isset($coin_details->technology) && $coin_details->technology != ''){!! $coin_details->technology !!} @else
            <p>Sorry, detailed technology about {{ $market->name }} is not currently available</p> @endif</div>
    </div>
    <div class="ui tab segment" data-tab="Features" style="margin-bottom:1rem">
        <div class="ui teal large ribbon label">@lang('v5.FEATURES')
            <h4 class="sr-only">{{ $market->name }} Crypto Features</h4></div>
        <div style="margin-top: 20px;" class="ui grid descript">@if ($coin_details->features != '') {!! $coin_details->features !!} @else
            <p>Sorry, detailed features about {{ $market->name }} is not currently available</p> @endif</div>
    </div>
</div>
@endif
@if (isset($coin_details->ico_status) && $coin_details->ico_status != 'N/A')
<div class="ui segment">
    <div class="ui teal large ribbon label">ICO Status
        <h2 class="sr-only">{{ $market->name }} ICO Details</h2> </div>
    <div style="margin-top: 20px;" class="ui grid">
        <div class="col-md-2 col-sm-3 col-xs-4">
            <div class="info-box">
                <div class="info-label">@lang('tbl_headings.ICO_STATUS')</div>
                <div class="info-text">{!! $coin_details->ico_status !!}</div>
            </div>
        </div>
        <div class="col-md-2 col-sm-3 col-xs-4">
            <div class="info-box">
                <div class="info-label">@lang('tbl_headings.TOKEN_SUPPLY')</div>
                <div class="info-text">@if($coin_details->ico_token_supply != '' && $coin_details->ico_token_supply != 'N/A' ) {{ $coin_details->ico_token_supply }} @else N/A @endif </div>
            </div>
        </div>
        <div class="col-md-2 col-sm-3 col-xs-4">
            <div class="info-box">
                <div class="info-label">@lang('tbl_headings.START_DATE')</div>
                <div class="info-text">@if($coin_details->ico_start_date != 0) {{ date("Y-m-d", $coin_details->ico_start_date) }} @else N/A @endif</div>
            </div>
        </div>
        <div class="col-md-2 col-sm-3 col-xs-4">
            <div class="info-box">
                <div class="info-label">@lang('tbl_headings.END_DATE')</div>
                <div class="info-text">@if($coin_details->ico_end_date != 0) {{ date("Y-m-d", $coin_details->ico_end_date) }} @else N/A @endif</div>
            </div>
        </div>
        <div class="col-md-2 col-sm-3 col-xs-4">
            <div class="info-box">
                <div class="info-label">@lang('tbl_headings.FUND_RAISED_BTC')</div>
                <div class="info-text">@if($coin_details->ico_fund_raised_btc != '') {{ $coin_details->ico_fund_raised_btc }} @else N/A @endif</div>
            </div>
        </div>
        <div class="col-md-2 col-sm-3 col-xs-4">
            <div class="info-box">
                <div class="info-label">@lang('tbl_headings.FUND_RAISED_USD')</div>
                <div class="info-text">@if($coin_details->ico_fund_raised_usd != '') {{ $coin_details->ico_fund_raised_usd }} @else N/A @endif</div>
            </div>
        </div>
        <div class="col-md-2 col-sm-3 col-xs-4">
            <div class="info-box">
                <div class="info-label">@lang('tbl_headings.START_PRICE')</div>
                <div class="info-text">@if($coin_details->ico_start_price != '') {{ $coin_details->ico_start_price }} @else N/A @endif</div>
            </div>
        </div>
        <div class="col-md-2 col-sm-3 col-xs-4">
            <div class="info-box">
                <div class="info-label">@lang('tbl_headings.AUDIT_COMPANY')</div>
                <div class="info-text">@if($coin_details->ico_security_audit_company != '') {{ $coin_details->ico_security_audit_company }} @else N/A @endif</div>
            </div>
        </div>
        <div class="col-md-2 col-sm-3 col-xs-4">
            <div class="info-box">
                <div class="info-label">@lang('tbl_headings.ICO_LEGAL')</div>
                <div class="info-text">@if($coin_details->ico_legal_form != '') {{ $coin_details->ico_legal_form }} @else N/A @endif</div>
            </div>
        </div>
        <div class="col-md-2 col-sm-3 col-xs-4">
            <div class="info-box">
                <div class="info-label">@lang('tbl_headings.ICO_JURISDICTION')</div>
                <div class="info-text">@if($coin_details->ico_jurisdiction != '') {{ $coin_details->ico_jurisdiction }} @else N/A @endif</div>
            </div>
        </div>
        <div class="col-md-2 col-sm-3 col-xs-4">
            <div class="info-box">
                <div class="info-label">@lang('tbl_headings.LEGAL_ADVISOR')</div>
                <div class="info-text">@if($coin_details->ico_legal_advisers != '') {{ $coin_details->ico_legal_advisers }} @else N/A @endif</div>
            </div>
        </div>
        <div class="col-md-2 col-sm-3 col-xs-4">
            <div class="info-box">
                <div class="info-label">@lang('tbl_headings.WHITE_PAPER')</div>
                <div class="info-text">@if($coin_details->ico_white_paper_link != '') <a href="{{ $coin_details->ico_white_paper_link }}" target="_blank"> {{ $market->symbol }} Whitepaper </a> @else N/A @endif </div>
            </div>
        </div>
        <div style="margin-top: 20px;" class="descript">@if ($coin_details->ico_description != '') {!! $coin_details->ico_description !!} @endif</div>
    </div>
</div> 
@endif
@if($crypto_news && count($crypto_news) > 4)
<div class="ui segment">
    <div class="ui teal large ribbon label">{{ $market->name }} News</div>
    <div style="margin-top: 20px; margin-bottom: 20px;" class="ui grid center aligned">
       @foreach($crypto_news as $news)
      <div class="col-md-2">
         <div class="info-box" style="padding: 5px;">
            <a href="{{ URL::to('/crypto-news') }}/{{$news['id']}}/{{$news['alias']}}"> 
              @if(file_exists('public/storage/' . $news['urlToImage']))
              <img alt="{{$news['title']}}" title="{{$news['title']}}" src="{{URL::asset('public/storage/' . $news['urlToImage'])}}" height="170" style="width: 100%;"> 
              @else
              <img alt="{{$news['title']}}" title="{{$news['title']}}" src="{{$news['urlToImage']}}" height="170" style="width: 100%;"> 
              @endif
            </a>
            <br />
            <div class="media-body"> 
              <a href="{{ URL::to('/crypto-news') }}/{{$news['id']}}/{{$news['alias']}}" class="catg_title" style="color: #3c8dbc;"> 
                {{ str_limit(strip_tags($news['title']), 35) }}
              </a>
            </div>
         </div>
      </div>
      @endforeach
    </div>
</div>
@endif
@include('default.includes.disqus')
@if($related_coins)
<div class="ui segment">
    <div class="ui teal large ribbon label">@lang('v7.RELATED_COINS')</div>
    <div style="margin-top: 20px; margin-bottom: 20px;" class="ui grid center aligned">
       @foreach($related_coins as $coin)
      <div class="col-md-2">
         <div class="info-box">
            <a href="{{ URL::to('/currencies') }}/{{$coin['alias']}}" class="media-left" style="display: block;"> 
              @if(file_exists('public/storage/' . $coin['image']))
              <img alt="{{$coin['name']}}" title="{{$coin['name']}}" src="{{URL::asset('public/storage/' . $coin['image'])}}" height="170" style="display: block;margin-right: auto;margin-left: auto;"> 
              @else
              <img alt="{{$coin['name']}}" title="{{$coin['name']}}" src="{{ str_replace('/thumbs', '', $coin['image']) }}" height="170" style="display: block;margin-right: auto;margin-left: auto;"> 
              @endif
            </a>
            <hr style="padding: unset;margin: unset;">
            <div class="media-body"> 
              <a href="{{ URL::to('/currencies') }}/{{$coin['alias']}}" class="catg_title" style="color: #3c8dbc;margin: 2px;display: block;"> 
                {{ str_limit(strip_tags($coin['name']), 15) }}
              </a>
            </div>
         </div>
      </div>
      @endforeach
    </div>
</div><br />
@endif 
@stop