@extends(getCurrentTemplate() . '.layouts.default')
@if(isset($market))
@section('meta_title')@lang('v6.COIN_DETAIL_TITLE', ['COIN' => $market->name])@stop
@section('meta_desc')@lang('v6.COIN_DETAIL_DESC', ['COIN' => $market->name])@stop
@else
@section('meta_title')@lang('v6.COIN_DETAIL_TITLE', ['COIN' => 'This coin'])@stop
@section('meta_desc')@lang('v6.COIN_DETAIL_DESC', ['COIN' => 'This coin'])@stop
@endif
@section('meta_link'){{ Request::url() }}@stop
@section('meta_image')
@if(isset($market)){{ $market->image }}@elseif(isset($market->symbol)){{ URL::asset('public/images/coins_icons') }}/{{ strtolower($market->symbol).'_.png' }}@endif
@stop
@section('styles')
<link href="{{ URL::asset('public/css/datatables/dataTables.bootstrap.css') }}" rel="stylesheet" />
<link href="{{ URL::asset('public/css/datatables/dataTables.responsive.css') }}" rel="stylesheet" />
<style type="text/css">
.coin-detail-social-buttons{float:right}.coin-detail-table th{background-color:#2c3b41!important}.coin-detail,.coin-detail:hover{color:#fff}.content{min-height:10px!important}.info-box{background:#FFF;border:1px solid #EEE;overflow:hidden;border-radius:0;margin-bottom:-1px;min-height:10px}.info-label{background:#f9f9f9;font-size:11px;color:#444;font-weight:700;border-bottom:1px solid #EEE}.info-box .info-text{font-size:12px;color:#777;white-space:nowrap;min-height:25px}.info-box .info-text,.info-label{line-height:25px;padding-left:10px;padding-right:10px}@media (max-width:767px){.coin-detail-wrapper{display:none}.partial-coin-detail-wrapper{display:block}}@media (min-width:767px){.partial-coin-detail-wrapper{display:none}}.coin-detail-page-header ul{list-style:none;margin-top:-35px;margin-bottom:-15px;padding:unset}.coin-detail-page-header ul li{display:inline-block;padding:4px;font-size:18px}div#markets .table-responsive,div#price_history .table-responsive{overflow-x:hidden!important}.social-container .reddit,.social-container .twitter{height:600px;overflow:auto}.social-container{padding-top:20px}.social-container .reddit{padding-left:25px}.ui.teal.label,.ui.teal.labels .label{background-color:#337ab7!important;border-color:#337ab7!important}.ui.ribbon.label:after{border-right-color:#337ab7!important}.ui.segment{margin-top:unset}.green{color: green;}.red{color: red;}
</style>
@stop
@section('scripts')
<script src="{{ URL::asset('public/js/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ URL::asset('public/js/datatables/dataTables.bootstrap.min.js') }}"></script>
<script src="{{ URL::asset('public/js/datatables/dataTables.responsive.js') }}"></script>
<script src="{{ URL::asset('public/js/amchart/core.js') }}"></script>
<script src="{{ URL::asset('public/js/amchart/charts.js') }}"></script>
<script src="{{ URL::asset('public/js/amchart/animated.js') }}"></script>
<script type="text/javascript">
    $(document).ready(function() {
        loadAreaChart('{{ $market->symbol }}');
        loadCandleChart('{{ $market->symbol }}');
        $('#dataTables-example').DataTable({
            responsive: true,
            "iDisplayLength": 20,
            "bFilter": false,
            "bLengthChange": false,
            "language": {
                "url": "{{ URL::asset('public/js/datatables/') }}/langs/" + $('.top-language-dropdown .item.selected').attr('name') + '.js'
            }
        });
        $('#dataTables-markets').DataTable({
            responsive: true,
            "iDisplayLength": 20,
            "bFilter": false,
            "bLengthChange": false,
            "language": {
                "url": "{{ URL::asset('public/js/datatables/') }}/langs/" + $('.top-language-dropdown .item.selected').attr('name') + '.js'
            }
        });
        $('ul.full-detail-page-tabs li a').click(function(){
            if($(this).attr('type') == 'area') {
                loadAreaChart('{{ $market->symbol }}');
            } else {
                loadCandleChart('{{ $market->symbol }}');
            }
        });
        $(".add-watchlist").click(function() {
            var coin = $(this).attr('coin');
            $.get(APP_URL + '/ajax-save-favorite-coin/'+coin, function(response) {
                if(response == 'true') {
                    $("#id_"+coin).addClass('favorite');
                } else {
                    $("#id_"+coin).removeClass('favorite');
                }
            });
        });
    });
    function loadSingleCoinHistoricalData(coin)
    {
        loadAreaChart('{{ $market->symbol }}');
        loadCandleChart('{{ $market->symbol }}');
    }
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
        var t = $(".time-frame :selected").val();
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
</script>
@stop
@section('content')
@if(isset($market))
      <div class="ui segment partial-coin-detail-wrapper">
        <div class="ui teal large ribbon label">
          <strong><span class="sr-only">{{ $market->name }} </span>@lang('tbl_headings.RANK') {{ $market->rank }}  </strong>
        </div>
        <a title="{{ $market->name }}" target="_blank" class="ui label">
            ${{ $market->price_usd }}
        </a>   
         <div class="ui label simple dropdown item" style="background: #f7931a;color: #fff;" tabindex="0">
            <i class="cart icon"></i> @lang('v5.BUY_SELL') <i class="dropdown icon"></i>
            <div class="menu" tabindex="-1">
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
      </div>
      <div class="ui segment coin-detail-wrapper">
         <div class="ui teal large ribbon label"><strong><span class="sr-only">{{ $market->name }} </span>@lang('tbl_headings.RANK') {{ $market->rank }}  </strong></div>
         @if(isset($coin_details->website_url))
          <a title="{{ $market->name }}" href="{{ $coin_details->website_url }}" target="_blank" class="ui label">
              <i class="linkify icon"></i> @lang('tbl_headings.WEBSITE')
          </a>   
          @endif
          @if(isset($coin_details->reddit) && $coin_details->reddit != '')
          <a href="{{ $coin_details->reddit }}" target="_blank" class="ui label">
              <i class="reddit alien icon"></i><span id="subreddit">Reddit</span>
          </a> 
          @endif 
          @if(isset($coin_details->twitter) && $coin_details->twitter != '')
          <a href="https://twitter.com/{{ $coin_details->twitter }}" target="_blank" class="ui label">
              <i class="twitter alien icon"></i><span id="subreddit">Twitter</span>
          </a> 
          @endif  
          <div class="ui label"> 
            <i class="anchor icon"></i>  {{ $market->available_supply }} {{ $market->symbol }}    
          </div>
         <div class="ui label simple dropdown item" style="background: #f7931a;color: #fff;" tabindex="0">
            <i class="cart icon"></i> @lang('v5.BUY_SELL') <i class="dropdown icon"></i>
            <div class="menu" tabindex="-1">
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
         <div class="row" style="float: right;">
          <div class="col-lg-12">
            @if(Auth::user())
              <a class="add-watchlist @if(in_array($market->symbol, $favorite_coins)) favorite @endif" 
              id="id_{{ $market->symbol }}" coin= "{{ $market->symbol }}"
              style="cursor: pointer;" title="add to watchlist">
                  <i class="fa fa-star fa-fw"></i>
              </a>
            @endif
          </div>
      </div>
       <div style="margin-top: 20px;" class="ui grid">
          <div class="four wide column">
             <h2 class="ui header">
                @if(isset($market))
                 <img alt="{{ $market->name }}" title="{{ $market->name }}" src="{{ str_replace('/thumbs', '', $market->image) }}" style="width: 45px; vertical-align: middle; float: left;margin: -1px 3px;" /> 
                @endif
                <div class="content">
                    {{ $market->name }}
                    <div id="code" class="sub header">
                        <em>
                            <b>
                                <acronym title="{{ $market->name }}"> 
                                    {{ $market->symbol }}
                                </acronym>
                            </b>
                        </em>
                    </div>
                </div>
             </h2>
          </div>
          <div class="twelve wide column right aligned">
             <div class="ui horizontal relaxed list">
                <!-- Price-->
                <div class="item">
                   <h3 id="usd" class="ui header">
                      <i id="usd" class="big dollar sign icon"></i>
                      <div class="content colored">
                         <span class="sr-only">{{ $market->name }} </span>@lang('tbl_headings.PRICE')
                         <div id="usd" class="sub header price colored">${{ number_format($market->price_usd, 2) }}</div>
                      </div>
                   </h3>
                </div>
                <!-- Volume-->
                <div class="item">
                   <h3 id="vol" class="ui header">
                      <i class="big signal icon"></i>
                      <div class="content colored">
                         <strong><span class="sr-only">{{ $market->name }} </span>24h Vol</strong>
                         <div id="vol" class="sub header price colored">${{ number_format($market->volume_usd_day) }}</div>
                      </div>
                   </h3>
                </div>
                <div class="item">
                   <h3 id="cap" class="ui header">
                      <i class="big line chart icon"></i>
                      <div class="content colored">
                         <span class="sr-only">{{ $market->name }} </span> @lang('menu.MARKET_CAP')
                         <div id="cap" class="sub header price">${{ number_format($market->market_cap_usd) }}</div>
                      </div>
                   </h3>
                </div>
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
       <div style="margin-top: 20px; margin-bottom: 20px;" class="ui grid center aligned">
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
          @elseif(isset($coin_details->reddit) && $coin_details->reddit!='')
          <div class="col-md-2 col-sm-3 col-xs-4">
             <div class="info-box">
                <div class="info-label">Reddit</div>
                <div class="info-text">  <a href="{{ $coin_details->reddit }}" target="_blank"> {{ $market->name }} </a>  </div>
             </div>
          </div>
          @else
          <div class="col-md-2 col-sm-3 col-xs-4">
             <div class="info-box">
                <div class="info-label">Reddit</div>
                <div class="info-text"> N/A </div>
             </div>
          </div>
          @endif
          @if(isset($coin_details->facebook) && $coin_details->facebook != '')
          <div class="col-md-2 col-sm-3 col-xs-4">
             <div class="info-box">
                <div class="info-label">Facebook</div>
                <div class="info-text"> <a href="{{ $coin_details->facebook }}" target="_blank"> {{ $market->name }} </a>  </div>
             </div>
          </div>
          @elseif(isset($coin_details->website_url) && $coin_details->website_url!='')
          <div class="col-md-2 col-sm-3 col-xs-4">
             <div class="info-box">
                <div class="info-label">@lang('tbl_headings.WEBSITE')</div>
                <div class="info-text">  <a href="{{ $coin_details->website_url }}" target="_blank"> {{ $market->name }} </a>  </div>
             </div>
          </div>
          @else
          <div class="col-md-2 col-sm-3 col-xs-4">
             <div class="info-box">
                <div class="info-label">@lang('tbl_headings.WEBSITE')</div>
                <div class="info-text">  N/A  </div>
             </div>
          </div>
          @endif
       </div>
       <div class="clear"></div>
        <div style="text-align: center;font-weight: bold;">Share {!! $market->name !!} Price</div>
        <h1 class="coin-detail-page-header" style="text-align: center;float: unset;">
            {!! Share::page(Request::url(), $market->name)->facebook()->twitter()->linkedin($market->name) !!}
        </h1>
    </div>
    @if(count($coin_historical_data) > 10)
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="box box-success table-heading-class">
                    <div class="box-header with-border">
                        <h3 class="box-title"><i class="fa fa-area-chart"> </i> @lang('menu.CHARTS')</h3>
                        <div class="pull-right time-frame-select-box" style="margin-top: -6px;margin-bottom: -10px;">
                            <div class="btn-group">
                                <select class="time-frame form-control" onchange="loadSingleCoinHistoricalData('{{ $market->symbol }}')">
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
                    </div>
                </div>
                <div class="panel-body">
                    <ul class="nav nav-tabs full-detail-page-tabs">
                        <li class="active"><a href="#area" type="area" data-toggle="tab" aria-expanded="true">@lang('menu.PRICE_CHART')</a></li>
                        <li class=""><a href="#candlestick" type="candlestick" data-toggle="tab" aria-expanded="false">@lang('menu.HIGH_LOW_CHART')</a></li>
                        <li class=""><a href="#price_history" type="price_history" data-toggle="tab" aria-expanded="false">@lang('menu.PRICE_HISTORY')</a></li>
                        <li class=""><a href="#markets" type="markets" data-toggle="tab" aria-expanded="false">@lang('menu.MARKETS')</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane fade active in" id="area">
                            <div id="price-area-chart" style="height: 400px;"></div>
                        </div>
                        <div class="tab-pane fade" id="candlestick">
                            <div id="container-candle" style="height: 400px;"></div>
                        </div>
                        <div class="tab-pane fade" id="price_history">
                            <div class="col-lg-12">
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
                                        <tbody>
                                            @foreach ($coin_historical_data as $historical_price)
                                            <tr>
                                                <td>{{ date("Y-m-d", strtotime($historical_price->time)) }}</td>
                                                <td>{{ formatHistoricalPrices($historical_price->open) }}</td>
                                                <td>{{ formatHistoricalPrices($historical_price->close) }}</td>
                                                <td>{{ formatHistoricalPrices($historical_price->high) }}</td>
                                                <td>{{ formatHistoricalPrices($historical_price->low) }}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        @if(count($markets) > 0)
                        <div class="tab-pane fade" id="markets">
                            <div class="col-lg-12">
                                <div class="table-responsive">
                                    <table style="width: 100%;" class="table table-bordered dataTable no-footer dtr-inline collapsed" id="dataTables-markets">
                                        <thead>
                                            <tr>
                                                <th>@lang('tbl_headings.PAIR')</th>
                                                <th>@lang('tbl_headings.EXCHANGE')</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($markets as $market_paiar)
                                            <tr>
                                                <td>{{ $market_paiar->pair }}</td>
                                                <td>{{ $market_paiar->exchange }}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12" style="margin-bottom: 15px;">
            @if($coin_details->twitter != '' || $coin_details->reddit !='')
                @if($coin_details->twitter != '')
                <div class="col-md-6" style="padding: 0px 15px 0px 0px;">
                    <div class="column">
                      <div class="ui segment">
                        <a class="ui left teal large ribbon label" href="{{ $coin_details->twitter }}">
                          {{ $market->name }}
                        </a>
                        <div style="pointer-events: none; overflow: hidden;" class="ui large teal right corner label"><i class="huge twitter icon"></i></div>
                        <div id="twitterFeed" style="height: 510px; overflow-y: scroll;" class="ui list">
                          <a class="twitter-timeline" href="https://twitter.com/{{$coin_details->twitter}}"></a> <script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
                        </div>
                      </div>
                    </div>
                </div>
                @else
                <div id="fb-root"></div>
                <script>(function(d, s, id) {
                  var js, fjs = d.getElementsByTagName(s)[0];
                  if (d.getElementById(id)) return;
                  js = d.createElement(s); js.id = id;
                  js.src = 'https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v3.0';
                  fjs.parentNode.insertBefore(js, fjs);
                }(document, 'script', 'facebook-jssdk'));</script>
                <div class="col-md-6" style="padding: 0px 15px 0px 0px;">
                    <div class="column">
                      <div class="ui segment">
                        <a class="ui left teal large ribbon label" href="{{ $coin_details->facebook }}">
                          {{ $market->name }}
                        </a>
                        <div style="pointer-events: none; overflow: hidden;" class="ui large teal right corner label"><i class="huge facebook icon"></i></div>
                        <div id="twitterFeed" style="height: 510px; overflow-y: scroll;" class="ui list">
                          <div class="fb-page" data-width="550" data-href="{{ $coin_details->facebook }}" data-tabs="timeline" data-small-header="false" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true"><blockquote cite="{{ $coin_details->facebook }}" class="fb-xfbml-parse-ignore"><a href="{{ $coin_details->facebook }}">Facebook</a></blockquote></div>
                        </div>
                      </div>
                    </div>
                </div>
                @endif
                @if($coin_details->reddit != '')
                <div class="col-md-6" style="padding: 0px 0px 0px 15px;">
                    <div class="column">
                      <div class="ui segment">
                        <a class="ui left teal large ribbon label" href="{{ $coin_details->reddit }}">
                          {{ $market->name }}
                        </a>
                        <div style="pointer-events: none; overflow: hidden;" class="ui large teal right corner label"><i class="huge reddit icon"></i></div>
                        <div id="twitterFeed" style="height: 510px; overflow-y: scroll;" class="ui list">
                          <script src="{{$coin_details->reddit}}/.embed?limit=50&t=all" type="text/javascript"></script>
                        </div>
                      </div>
                    </div>
                </div>
                @endif
            @endif
        </div>
    </div>
    @endif
@endif
@if (isset($coin_details->description) && $coin_details->description != '') 
    <div class="panel panel-default" style="clear: both;">
        <div class="panel-body">  
            <div class="ui teal large ribbon label">@lang('v5.DESC')
                <h3 class="sr-only">@lang('v5.DESC')</h3>
            </div>
            <div class="col-md-12">
            <br />{!! $coin_details->description !!} 
            <div class="col-md-6" style="padding: unset;">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover coin-detail-table">
                        <tbody>
                            <tr>
                                <th>@lang('tbl_headings.FULL_NAME')</th>
                                <td>
                                  @if(isset($coin_details->full_name))
                                    {{ $coin_details->full_name }} @else {{ $market->name }} 
                                  @endif
                                </td>
                            </tr>
                            <tr>
                                <th>@lang('tbl_headings.START_DATE')</th>
                                <td>@if($coin_details->start_date != 0) {{ date("Y-m-d", $coin_details->start_date) }} @else N/A @endif</td>
                            </tr>
                            <tr>
                                <th>@lang('tbl_headings.ALGORITHM')</th>
                                <td>@if($coin_details->algorithm != '') {{ $coin_details->algorithm }} @else N/A @endif</td>
                            </tr>
                            <tr>
                                <th>@lang('tbl_headings.PROOF_TYPE')</th>
                                <td>@if($coin_details->proof_type != '') {{ $coin_details->proof_type }} @else N/A @endif</td>
                            </tr>
                            <tr>
                                <th>@lang('tbl_headings.WEBSITE')</th>
                                <td>
                                    @if($coin_details->website_url != '')
                                        <a href="{{ $coin_details->website_url }}" target="_blank"> {{ $coin_details->website_url }} </a>
                                    @else N/A @endif
                                </td>
                            </tr>
                            <tr>
                                <th>@lang('tbl_headings.TWITTER')</th>
                                <td>
                                    @if($coin_details->twitter != '')
                                        <a href="https://twitter.com/{{ $coin_details->twitter }}" target="_blank"> {{ $coin_details->twitter }} </a>
                                    @else N/A @endif
                                </td>
                            </tr>
                            <tr>
                                <th>@lang('tbl_headings.FACEBOOK')</th>
                                <td>
                                    @if($coin_details->facebook != '')
                                        <a href="{{ $coin_details->facebook }}" target="_blank"> {{ $coin_details->facebook }} </a>
                                    @else N/A @endif
                                </td>
                            </tr>
                            <tr>
                                <th>@lang('tbl_headings.REDDIT')</th>
                                <td>
                                    @if($coin_details->reddit != '')
                                        <a href="{{ $coin_details->reddit }}" target="_blank"> {{ $coin_details->reddit }} </a>
                                    @else N/A @endif
                                </td>
                            </tr>
                            <tr>
                                <th>@lang('tbl_headings.BLOCK_NUMBER')</th>
                                <td>@if($coin_details->block_number != 0) {{ $coin_details->block_number }} @else N/A @endif</td>
                            </tr>
                            <tr>
                                <th>@lang('tbl_headings.BLOCK_TIME')</th>
                                <td>@if($coin_details->block_time != 0) {{ $coin_details->block_time }} @else N/A @endif</td>
                            </tr>
                            <tr>
                                <th>@lang('tbl_headings.BLOCK_REWARD')</th>
                                <td>@if($coin_details->block_reward != 0) {{ $coin_details->block_reward }} @else N/A @endif</td>
                            </tr>
                            @if(isset($market))
                            <tr>
                                <th>@lang('tbl_headings.TOTAL_COINS_MINED')</th>  
                                <td>
                                    @if($market->available_supply != 0) 
                                        {{ $market->available_supply }} {{ $market->symbol }} 
                                    @else 
                                        N/A 
                                    @endif
                                </td>
                            </tr>
                            @endif
                            <tr>
                                <th>@lang('tbl_headings.PREVIOUS_TOTAL')</th>
                                <td>@if($coin_details->previous_total_coins_mined != 0) {{ number_format($coin_details->previous_total_coins_mined) }} @else N/A @endif</td>
                            </tr>
                            <tr>
                                <th>@lang('tbl_headings.HASHES_PER_SECOND')</th>
                                <td>@if($coin_details->net_hases_per_second != 0) {{ number_format($coin_details->net_hases_per_second, 2) }} H/s @else N/A @endif</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
          </div>
        </div>
    </div>
@endif
@if (isset($coin_details->technology) && $coin_details->technology != '') 
    <div class="panel panel-default">
        <div class="panel-body"> 
          <div class="ui teal large ribbon label">@lang('v5.TECH')
            <h3 class="sr-only">@lang('v5.TECH')</h3>
          </div>
          <div class="col-md-12">
            <br />{!! $coin_details->technology !!} 
          </div>
        </div>
    </div>
@endif
@if (isset($coin_details->features) && $coin_details->features != '') 
    <div class="panel panel-default">
        <div class="panel-body">  
            <div class="ui teal large ribbon label">@lang('v5.FEATURES')
                <h3 class="sr-only">@lang('v5.FEATURES')</h3>
            </div>
            <div class="col-md-12">
                <br />{!! $coin_details->features !!} 
            </div>
        </div>
    </div> 
@endif
@if (isset($coin_details->ico_status) && $coin_details->ico_status != 'N/A')
<div class="panel panel-default">
    <div class="panel-body">  
        <div class="ui teal large ribbon label">@lang('v5.ICO_DETAILS')
            <h3 class="sr-only">@lang('v5.ICO_DETAILS')</h3>
        </div>
        <div class="col-md-12">
        <br />
        @if ($coin_details->ico_description != '') {!! $coin_details->ico_description !!} @endif
            <div class="col-md-6" style="padding: unset;">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover coin-detail-table">
                        <tbody>
                            <tr>
                                <th>@lang('tbl_headings.ICO_STATUS')</th>
                                <td>{!! $coin_details->ico_status !!}</td>
                            </tr>
                            <tr>
                                <th>@lang('tbl_headings.TOKEN_SUPPLY')</th>
                                <td>
                                    @if($coin_details->ico_token_supply != '' && $coin_details->ico_token_supply != 'N/A' ) 
                                        {{ $coin_details->ico_token_supply }} 
                                    @else 
                                        N/A 
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>@lang('tbl_headings.START_DATE')</th>
                                <td>@if($coin_details->ico_start_date != 0) {{ date("Y-m-d", $coin_details->ico_start_date) }} @else N/A @endif</td>
                            </tr>
                            <tr>
                                <th>@lang('tbl_headings.END_DATE')</th>
                                <td>@if($coin_details->ico_end_date != 0) {{ date("Y-m-d", $coin_details->ico_end_date) }} @else N/A @endif</td>
                            </tr>
                            <tr>
                                <th>@lang('tbl_headings.FUND_RAISED_BTC')</th>
                                <td>@if($coin_details->ico_fund_raised_btc != '') {{ $coin_details->ico_fund_raised_btc }} @else N/A @endif</td>
                            </tr>
                            <tr>
                                <th>@lang('tbl_headings.FUND_RAISED_USD')</th>
                                <td>@if($coin_details->ico_fund_raised_usd != '') {{ $coin_details->ico_fund_raised_usd }} @else N/A @endif</td>
                            </tr>
                            <tr>
                                <th>@lang('tbl_headings.START_PRICE')</th>
                                <td>@if($coin_details->ico_start_price != '') {{ $coin_details->ico_start_price }} @else N/A @endif</td>
                            </tr>
                            <tr>
                                <th>@lang('tbl_headings.AUDIT_COMPANY')</th>
                                <td>@if($coin_details->ico_security_audit_company != '') {{ $coin_details->ico_security_audit_company }} @else N/A @endif</td>
                            </tr>
                            <tr>
                                <th>@lang('tbl_headings.ICO_LEGAL')</th>
                                <td>@if($coin_details->ico_legal_form != '') {{ $coin_details->ico_legal_form }} @else N/A @endif</td>
                            </tr>
                            <tr>
                                <th>@lang('tbl_headings.ICO_JURISDICTION')</th>
                                <td>@if($coin_details->ico_jurisdiction != '') {{ $coin_details->ico_jurisdiction }} @else N/A @endif</td>
                            </tr>
                            <tr>
                                <th>@lang('tbl_headings.LEGAL_ADVISOR')</th>
                                <td>@if($coin_details->ico_legal_advisers != '') {{ $coin_details->ico_legal_advisers }} @else N/A @endif</td>
                            </tr>
                            <tr>
                                <th>@lang('tbl_headings.BLOG')</th>
                                <td>@if($coin_details->ico_blog != '') {{ $coin_details->ico_blog }} @else N/A @endif</td>
                            </tr>
                            <tr>
                                <th>@lang('tbl_headings.WHITE_PAPER')</th>
                                <td>
                                    @if($coin_details->ico_white_paper_link != '') 
                                        <a href="{{ $coin_details->ico_white_paper_link }}" target="_blank"> 
                                            {{ $coin_details->ico_white_paper_link }} 
                                        </a> 
                                    @else N/A @endif
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div> 
@endif
@if($crypto_news && count($crypto_news) > 4)
<div class="ui segment">
    <div class="ui teal large ribbon label">@if(isset($coin_details->full_name)){{ $coin_details->full_name }}@endif News</div>
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
    <div style="margin-top: 20px; margin-bottom: 20px;text-align: center;" class="ui grid center aligned">
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
</div>
@endif 
@stop