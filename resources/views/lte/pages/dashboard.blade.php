@extends(getCurrentTemplate() . '.layouts.default')
@section('meta_title')@lang('seo.DASHBOARD_TITLE')@stop
@section('meta_desc')@lang('seo.DASHBOARD_DESCRIPTION')@stop
@section('meta_link'){{ Request::url() }}@stop
@section('meta_image'){{ URL::asset('public/images/pages/images') . '/dashboard.png' }}@stop
@section('styles')
<link href="{{ URL::asset('public/css/morris/morris.css') }}"" rel="stylesheet">
<style type="text/css">
.small-box h3 {font-size: 18px;font-weight: 600;}
.small-box .icon {font-size: 80px;}
.twitter-panel-class, .icos-panel-class {height: 440px; overflow: auto;}
@media (max-width:767px){.small-box h3 {font-size: 16px}}
.crypto-currencies-data tr.up {background-color: #C7FECF;}
.crypto-currencies-data tr.down {background-color: #FECBC7;}
.news h1 {margin-top: unset;margin-bottom: unset;}
</style>
@stop
@section('scripts')
<script src="{{ URL::asset('public/js/raphael/raphael.min.js') }}"></script>
<script src="{{ URL::asset('public/js/morrisjs/morris.min.js') }}"></script>
<script src="{{ URL::asset('public/js/morris-data.js') }}"></script>
<script src="{{ URL::asset('public/js/amchart/core.js') }}"></script>
<script src="{{ URL::asset('public/js/amchart/charts.js') }}"></script>
<script src="{{ URL::asset('public/js/amchart/animated.js') }}"></script>
<script src="{{ URL::asset('public/js/lte/custom-js/dashboard.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/2.0.4/socket.io.js"></script>
<script src="{{ URL::asset('public/js/ccc-streamer-utilities.js') }}"></script>
<script src="{{ URL::asset('public/js/lte/streaming-code.js') }}"></script>
<script>
$(document).ready(function() {
  $('#donut-chart-id').click(function() {
    $('.chart-selectors-dropdown').hide();
    setTimeout(function() { 
      cryptoDominanceDonut({!! $dominance_data !!});
    }, 250);
  });
  $('#area-chart-id, #markets-chart-id').click(function() {
    $('.chart-selectors-dropdown').show();
  });
  streaming([{!! $streaming_data !!}]);
  loadHistoricalData();
});
</script>
@stop
@section('content')
  <section class="content">
    <div class="row">
      <div class="col-lg-3 col-xs-6">
        <div class="small-box dashboard-top-boxes">
          <div class="inner">
            <h3><span class="dashboard-total-market-cap" rel="@if(isset($crypto_globals->total_market_cap_usd)) {{ preg_replace('/[^0-9,.]/', '', str_replace(',', '', $crypto_globals->total_market_cap_usd)) }} @endif">0</span></h3>
            <p>@lang('headings.TOTAL_MARKET_CAP')</p>
          </div>
          <div class="icon">
            <i class="ion ion-cash"></i>
          </div>
          <a href="{{ makeUrl('live-crypto-currencies-updates') }}" class="small-box-footer">@lang('buttons.MORE_INFO') <i class="fa fa-arrow-circle-right"></i></a>
        </div>
      </div>
      <div class="col-lg-3 col-xs-6">
        <div class="small-box dashboard-top-boxes">
          <div class="inner">
            <h3><span class="dashboard-total-market-cap-day" rel="@if(isset($crypto_globals->total_24h_volume_usd)) {{ preg_replace('/[^0-9,.]/', '', str_replace(',', '', $crypto_globals->total_24h_volume_usd)) }} @endif">0</span></h3>
            <p>@lang('headings.TOTAL_24_MARKET_CAP')</p>
          </div>
          <div class="icon">
            <i class="ion ion-stats-bars"></i>
          </div>
          <a href="{{ makeUrl('live-crypto-currencies-updates') }}" class="small-box-footer">@lang('buttons.MORE_INFO') <i class="fa fa-arrow-circle-right"></i></a>
        </div>
      </div>
      <div class="col-lg-3 col-xs-6">
        <div class="small-box dashboard-top-boxes">
          <div class="inner">
            <h3>{{{ $total_markets or '0' }}}</h3>
            <p>@lang('headings.TOTAL_ACTIVE_COINS')</p>
          </div>
          <div class="icon">
            <i class="ion ion-help-buoy"></i>
          </div>
          <a href="{{ makeUrl('live-crypto-currencies-updates') }}" class="small-box-footer">@lang('buttons.MORE_INFO') <i class="fa fa-arrow-circle-right"></i></a>
        </div>
      </div>
      <div class="col-lg-3 col-xs-6">
        <div class="small-box dashboard-top-boxes">
          <div class="inner">
            <h3>{{{ $crypto_globals['active_markets'] or '0' }}}</h3>
            <p>@lang('headings.TOTAL_ACTIVE_MARKETS')</p>
          </div>
          <div class="icon">
            <i class="ion ion-load-b"></i>
          </div>
          <a href="{{ makeUrl('live-crypto-currencies-updates') }}" class="small-box-footer">@lang('buttons.MORE_INFO') <i class="fa fa-arrow-circle-right"></i></a>
        </div>
      </div>
    </div>
    <div class="row">
      <section class="col-lg-8">
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs pull-right">
              <li class="active"><a href="#price-area-chart" id="area-chart-id" data-toggle="tab">@lang('menu.PRICE_CHART')</a></li>
              <li><a href="#morris-donut-chart" id="donut-chart-id" data-toggle="tab">@lang('headings.DOMINANCE_DONUT')</a></li>
              <li class="pull-left header"></li>
            </ul>
            <div class="tab-content no-padding">
              <div class="panel-heading chart-selectors-dropdown">
                <div class="pull-right top-trading-coins-select-box" style="margin-left: 6px;">
                    <div class="btn-group">
                        <select class="top-trading-coins-histo form-control" onchange="loadHistoricalData()">
                            @foreach($top_pairs as $pair)
                                <option value="{{$pair['symbol']}}">
                                    {{$pair['symbol']}}
                                </option>>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="pull-right time-frame-select-box">
                    <div class="btn-group">
                        <select class="time-frame form-control" onchange="loadHistoricalData()">
                            <option value="7 day">7 @lang('menu.DAYS')</option>
                            <option value="1 months">1 @lang('menu.MONTH')</option>
                            <option value="3 months">3 @lang('menu.MONTHS')</option>
                            <option value="6 months">6 @lang('menu.6_MONTHS')</option>
                            <option value="1 year" selected="selected">1 @lang('menu.YEAR')</option>
                            <option value="2 year">2 @lang('menu.YEARS')</option>
                            <option value="all"> @lang('menu.ALL')</option>
                        </select>
                    </div>
                </div>
              </div>
              <div class="chart tab-pane active" id="price-area-chart" style="position: relative; height: 306px;"></div>
              <div class="chart tab-pane" id="morris-donut-chart" style="position: relative; height: 350px;"></div>
            </div>
          </div>
          <div class="panel panel-default">
            <div class="box box-success table-heading-class">
                <div class="box-header with-border">
                    <h3 class="box-title"> <i class="fa fa-bar-chart-o fa-fw"></i>@lang('headings.TOP_10') </h3>
                </div>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-lg-12">                        
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>@lang('tbl_headings.NAME')</th>
                                        <th class="align-right">@lang('tbl_headings.PRICE')</th>
                                        <th class="align-right">@lang('tbl_headings.MARKET_CAP')</th>
                                        <th class="align-right">@lang('tbl_headings.24h_VOLUME')</th>
                                        <th class="align-right">@lang('tbl_headings.1H_CHANGE')</th>
                                        <th class="align-right">@lang('tbl_headings.24H_CHANGE')</th>
                                    </tr>
                                </thead>
                                <tbody class="crypto-currencies-data">
                                    @foreach ($crypto_top_markets as $market)
                                    <tr id="TABLE_ROW_{{$market->symbol}}">
                                        <td>{{$market->rank}}</td>
                                        <td>
                                            <a href="{{ URL::asset('currencies') }}/{{$market->alias}}">
                                                <img alt='{{ $market->name }} icon' title='{{ $market->name }}' src='{{ $market->image }}' width='20' /> {{$market->name}}
                                              </a>
                                        </td>
                                        <td class="price align-right" val="{{$market->price_usd}}" id="PRICE_{{$market->symbol}}"></td>
                                        <td class="market_cap_usd align-right" val="{{$market->market_cap_usd}}"></td>
                                        <td class="volume_usd_day align-right" val="{{$market->volume_usd_day}}"></td>
                                        <td class="percent_change_hour align-right">
                                            <span class="badge @if($market->percent_change_hour >= 0) bg-green @else bg-red @endif" style="width: 60px;">{{$market->percent_change_hour}}  %</span>
                                        </td>
                                        <td class="percent_change_day align-right">
                                            <span id="CHANGE24HOURPCT_{{$market->symbol}}" class="badge @if($market->percent_change_day >= 0) bg-green @else bg-red @endif" style="width: 60px;">{{$market->percent_change_day}}  %</span>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6" style="padding: unset; padding-right: 3px;">
          <div class="chat-panel panel panel-default">
            <div class="box box-success table-heading-class">
                <div class="box-header with-border">
                    <h3 class="box-title"> <i class="fa fa-rss fa-fw"></i> @lang('headings.TWITTER_FEED') </h3>
                </div>
            </div>
            <div class="panel-body twitter-panel-class">
                @if(setting('social.twitter') == 'N/A' || setting('social.twitter') == '')
                    Add Twitter Page Id.
                @else
                    <a class="twitter-timeline" href="{{ setting('social.twitter') }}"></a> <script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
                @endif
            </div>
          </div>
        </div> 
        <div class="col-lg-6" style="padding: unset; padding-left: 3px;">
          <div class="chat-panel panel panel-default">
            <div class="box box-success table-heading-class">
                <div class="box-header with-border">
                    <h3 class="box-title"> <i class="fa fa-bullhorn fa-fw"></i> @lang('headings.ACTIVE_ICOS') </h3>
                    <span style="float: right;"><a href="{{ makeUrl('crypto-ico/active') }}">@lang('menu.VIEW_ALL')</a></span>
                </div>
            </div>
            <div class="panel-body icos-panel-class">
                  <?php
                    $i = 0;
                    foreach($icos as $ico) {
                      if($i > 9) {
                          continue;
                      }
                  ?>
                      <div class="ico-detail-div">
                        @if(file_exists('public/storage/' . $ico->image))
                        <img class="image" alt="{{ $ico->name }} ico" title="{{ $ico->name }} ico" src="{{URL::asset('public/storage/' . $ico->image)}}" height="35">
                        @else
                        <img class="image" alt="{{ $ico->name }} ico" title="{{ $ico->name }} ico" src="{{ $ico->image }}" height="35">
                        @endif
                        <p> 
                          {{ $ico->description }} <br />
                          <a href="@if($ico->affiliate == '') {{$ico->website}} @else {{$ico->affiliate}} @endif" target="_blank" rel="nofollow noopener">
                            <i class="fa fa-hand-o-right fa-fw"></i> {{ $ico->name }}
                          </a>
                          <i class="fa fa-clock-o fa-fw"></i>{{ date("Y-m-d", strtotime($ico->start_time)) }} 
                        </p>
                      </div>
                      <hr style="clear: both;" />
                      <?php
                      $i++;
                  }
                ?>
            </div>
          </div>
        </div>
      </section>
      <section class="col-lg-4">
        <div class="panel panel-default">
          <div class="box box-success table-heading-class">
              <div class="box-header with-border">
                  <h3 class="box-title"> <i class="fa fa-cogs fa-fw"></i> @lang('headings.TRADING_PAIRS') </h3>
                  <div class="pull-right top-trading-pairs-select-box" style="margin-top: -6px;margin-bottom: -10px;">
                  <div class="btn-group">
                      <select class="top-trading-coins form-control" onchange="loadTradingPairs(this.value)">
                          @foreach($top_pairs as $pair)
                              <option value="@if($pair['symbol'] == 'MIOTA')IOT @else{{$pair['symbol']}}@endif">
                                  {{$pair['symbol']}}
                              </option>>
                          @endforeach
                      </select>
                  </div>
              </div>
              </div>
          </div>
          <div class="panel-body" style="height: 350px;">
              <div class="table-responsive">
                  <table class="table table-hover">
                      <thead>
                          <tr>
                              <th>@lang('tbl_headings.PAIR')</th>
                              <th class="align-right">@lang('tbl_headings.24h_VOLUME')</th>
                              <th class="align-right">@lang('tbl_headings.24h_VOLUME')</th>
                          </tr>
                      </thead>
                      <tbody class="top-currencies-trading-paires">
                          @foreach($pairs as $pair)
                          <tr>
                              <td>{{$pair['symbol']}}-{{$pair['pair']}}</td>
                              <td class="align-right">{{$pair['volume24h_from']}}</td>
                              <td class="align-right">{{$pair['volume24h_to']}}</td>
                          </tr>
                          @endforeach
                      </tbody>
                  </table>
              </div>
          </div>
        </div>
        @include(getCurrentTemplate() . '.ads.dashboard_ad')  
      </section>
      <section class="col-lg-4">
        <div class="panel panel-default">
          <div class="box box-success table-heading-class">
              <div class="box-header with-border">
                  <h3 class="box-title"> <i class="fa fa-newspaper-o fa-fw"></i> @lang('headings.LATEST_NEWS') </h3>
                  <span style="float: right;"><a href="{{ makeUrl('crypto-coins-news-headlines') }}">@lang('menu.VIEW_ALL')</a></span>
              </div>
          </div>
          <div class="panel-body" style="height: 739px;">
              <div class="latest-news">
                  @foreach($news_data as $news)
                  <div class="news" style="padding-bottom: 2px; height: 72px;">
                      @if(file_exists('public/storage/' . $news->urlToImage))
                      <img alt="{{$news->title}}" title="{{$news->title}}" src="{{ URL::asset('public/storage/' .  $news->urlToImage) }}" width="70" height="65" style="float: left;margin-right: 10px;">
                      @else
                      <img alt="{{$news->title}}" title="{{$news->title}}" src="{{ $news->urlToImage }}" width="70" height="65" style="float: left;margin-right: 10px;">
                      @endif
                      <h1 style="font-size: 16px;">
                          <a href="{{ URL::to('/crypto-news') }}/{{$news->id}}/{{$news->alias}}"> 
                            {{ str_limit(strip_tags($news->title), 45, '...') }}
                          </a>
                      </h1>
                      <p>
                          <span class="badge bg-green btn" style="border-radius: 10px; margin-top: 5px;"><i class="fa fa-clock-o fa-fw" style="font-size: 1em;"></i>{{ date("d M Y", strtotime($news->publishedAt)) }}</span>
                      </p>
                  </div>
                  <div style="clear: both;"></div>
                  @endforeach
              </div>
          </div>
        </div>
      </section>
    </div>
  </section>
@stop
