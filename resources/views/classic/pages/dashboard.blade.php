@extends(getCurrentTemplate() . '.layouts.default')
@section('meta_title')@lang('seo.DASHBOARD_TITLE')@stop
@section('meta_desc')@lang('seo.DASHBOARD_DESCRIPTION')@stop
@section('meta_link'){{ Request::url() }}@stop
@section('meta_image'){{ URL::asset('public/images/pages/images') . '/dashboard.png' }}@stop
@section('styles')
<link href="https://cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick-theme.min.css" rel="stylesheet">
@stop
@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>
<script src="{{ URL::asset('public/js/morris-data.js') }}"></script>
<script src="{{ URL::asset('public/js/amchart/core.js') }}"></script>
<script src="{{ URL::asset('public/js/amchart/charts.js') }}"></script>
<script src="{{ URL::asset('public/js/amchart/animated.js') }}"></script>
<script src="{{ URL::asset('public/js/custom-js/dashboard.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/2.0.4/socket.io.js"></script>
<script src="{{ URL::asset('public/js/ccc-streamer-utilities.js') }}"></script>
<script src="{{ URL::asset('public/js/default/streaming-code.js') }}"></script>
<script>cryptoDominanceDonut({!! $dominance_data !!})</script>
<script type="text/javascript">
    $(document).ready(function(){
      $('.ico-carousel').slick({
            slidesToShow: 6,
            slidesToScroll: 1,
            autoplay: true,
            autoplaySpeed: 1500,
            centerMode: true,
      });
      $('.mobile-ico-carousel').slick({
            slidesToShow: 1,
            slidesToScroll: 1,
            autoplay: true,
            autoplaySpeed: 1500,
            centerMode: true,
      });
      $('.ico-carousel').hide();
      streaming([{!! $streaming_data !!}]);
      loadHistoricalData();
    });
  </script>
@stop
@section('content')

<div class="row">
    <div class="col-lg-3 col-md-6">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-4">
                        <i class="fa fa-usd fa-3x"></i><i class="fa fa-usd fa-2x" style="inline"></i>
                    </div>
                    <div class="col-xs-8 text-right">
                        <div class="huge"><span class="dashboard-total-market-cap"></span></div>
                        <div>@lang('headings.TOTAL_MARKET_CAP')</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-money fa-3x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <div class="huge"><span class="dashboard-total-market-cap-day"></span></div>
                        <div>@lang('headings.TOTAL_24_MARKET_CAP')</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-support fa-3x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <div class="huge">{{{ $total_markets or '0' }}}</div>
                        <div>@lang('headings.TOTAL_ACTIVE_COINS')</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-institution fa-3x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <div class="huge">{{{ $crypto_globals['active_markets'] or '0' }}}</div>
                        <div>@lang('headings.TOTAL_ACTIVE_MARKETS')</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-8">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-bar-chart-o fa-fw"></i> @lang('headings.TOP_10')<h2 class="sr-only">@lang('headings.TOP_10')</h2>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>@lang('tbl_headings.RANK')</th>
                                        <th>@lang('tbl_headings.NAME')</th>
                                        <th class="right">@lang('tbl_headings.PRICE')</th>
                                        <th class="right">@lang('tbl_headings.MARKET_CAP')</th>
                                        <th class="right">@lang('tbl_headings.24h_VOLUME')</th>
                                        <th class="right">@lang('tbl_headings.1H_CHANGE')</th>
                                        <th class="right">@lang('tbl_headings.24H_CHANGE')</th>
                                    </tr>
                                </thead>
                                <tbody class="crypto-currencies-data">
                                    @foreach ($crypto_top_markets as $market)
                                    <tr id="TABLE_ROW_{{$market->symbol}}">
                                        <td>{{$market->rank}}</td>
                                        <td> 
                                            <h3 class="ui image header">
                                              <img alt='{{ $market->name }} icon' title='{{ $market->name }} ' src='{{ $market->image }}' width='25' />
                                              <div class="content">
                                                <a href="{{ makeUrl('currencies') }}/{{ $market->alias }}" title="{{ $market->name }} ({{$market->symbol}}) Price, Charts & Market Cap">
                                                  {{$market->name}} 
                                                  <span class="sr-only">{{ $market->name }} ({{$market->symbol}}) Price, Charts and Market Cap</span>
                                                  <div class="sub header"><b>
                                                    <acronym title="{{ $market->name }}">{{$market->symbol}}</acronym></b>
                                                  </div>
                                                </a>
                                              </div>
                                            </h3>
                                        </td>
                                        <td class="price" val="{{$market->price_usd}}" id="PRICE_{{$market->symbol}}"></td>
                                        <td class="market_cap_usd" val="{{$market->market_cap_usd}}"></td>
                                        <td class="volume_usd_day" val="{{$market->volume_usd_day}}"></td>
                                        <td class="percent_change_hour" style="color: @if($market->percent_change_hour >= 0) green @else red @endif">
                                            {{$market->percent_change_hour}}  %
                                        </td>
                                        <td class="percent_change_day" id="CHANGE24HOURPCT_{{$market->symbol}}" style="color: @if($market->percent_change_day >= 0) green @else red @endif">
                                            {{$market->percent_change_day}}  %
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
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-area-chart fa-fw"></i> @lang('headings.CHART')
                <div class="pull-right top-trading-coins-select-box">
                    <div class="btn-group">
                        <select class="top-trading-coins-histo form-control" onchange="loadHistoricalData()">
                            @foreach($top_pairs as $pair)
                                <option value="@if($pair['symbol'] == 'MIOTA')IOT @else{{$pair['symbol']}}@endif">
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
            <div class="panel-body">
                <div id="price-area-chart" style="height: 350px;"></div>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-newspaper-o fa-fw"></i> @lang('headings.LATEST_NEWS')<h2 class="sr-only">@lang('headings.LATEST_NEWS')</h2>
            </div>
            <div class="panel-body">
                <div class="latest-news">
                    @foreach($news_data as $news)
                    <div class="news">
                        <img alt="{{$news->title}}" title="{{$news->title}}" src="{{ $news->urlToImage }}" width="105" height="100" style="float: left;margin-right: 10px;">
                        <h3 style="font-size: 16px;">
                            <a href="{{ URL::to('/crypto-news') }}/{{$news->id}}/{{$news->alias}}"> {{$news->title}} </a>
                        </h3>
                        <p>{{ str_limit(strip_tags($news->description), 200, '...') }}</p>
                        <p>
                            <i class="fa fa-clock-o fa-fw" style="font-size: 1em;"></i>
                            @lang('headings.PUBLISHED_AT'): {{$news->publishedAt}}
                        </p>
                    </div>
                    <div style="clear: both;"></div> <hr />
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    @include(getCurrentTemplate() . '.ads.dashboard_ad')  
    <div class="col-md-4" style="margin-bottom: 15px;">
        <div class="single_sidebar wow fadeInDown">
          @if(setting('videos.news_page_video') != '' && setting('videos.news_page_video') != 'novideo')
            <div class="news-page-video">
            @if(strpos(setting('videos.news_page_video'), 'youtube.com') !== false)
              <iframe src="{!! setting('videos.news_page_video') !!}" frameborder="0" allowfullscreen></iframe>
            @else
              <iframe src="https://player.vimeo.com/video/{!! setting('videos.news_page_video') !!}" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
              <script src="https://player.vimeo.com/api/player.js"></script>
            @endif
            </div>
          @endif
        </div>
    </div>
    <div class="col-lg-4">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-cogs fa-fw"></i> @lang('headings.TRADING_PAIRS')<h2 class="sr-only">@lang('headings.TRADING_PAIRS')</h2>
                <div class="pull-right top-trading-pairs-select-box">
                    <div class="btn-group">
                        <select class="top-trading-coins form-control" onchange="loadTradingPairs(this.value)">
                            @foreach($top_pairs as $pair)
                                <option value="{{$pair['symbol']}}">
                                    {{$pair['symbol']}}
                                </option>>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="panel-body">
                <div class="list-group">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>@lang('tbl_headings.PAIR')</th>
                                <th>@lang('tbl_headings.24h_VOLUME')</th>
                                <th>@lang('tbl_headings.24h_VOLUME')</th>
                            </tr>
                        </thead>
                        <tbody class="top-currencies-trading-paires">
                            @foreach($pairs as $pair)
                            <tr>
                                <td>{{$pair['symbol']}}-{{$pair['pair']}}</td>
                                <td>{{$pair['volume24h_from']}}</td>
                                <td>{{$pair['volume24h_to']}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-pie-chart fa-fw"></i> @lang('headings.DOMINANCE_DONUT')<h2 class="sr-only">@lang('headings.DOMINANCE_DONUT')</h2>
            </div>
            <div class="panel-body">
                <div id="morris-donut-chart"></div>
            </div>
        </div>
        <div class="chat-panel panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-rss fa-fw"></i> @lang('headings.TWITTER_FEED')
            </div>
            <div class="panel-body form-section" style="min-height: 530px;">
                @if(setting('social.twitter') == 'N/A' || setting('social.twitter') == '')
                    Add Twitter Page Id.
                @else
                    <a class="twitter-timeline" href="{{ setting('social.twitter') }}"></a> <script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
                @endif
            </div>
        </div>
    </div>
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-bullhorn fa-fw"></i> <h2 class="sr-only">@lang('headings.DOMINANCE_DONUT')</h2>@lang('headings.ACTIVE_ICOS')
            </div>
            <div class="panel-body" style="padding: 25px;">
                <div class="ico-carousel">
                    @foreach($icos as $ico)
                        <div class="dashboard-active-icos">
                            <a href="{{ makeUrl('crypto-ico') }}/{{ $ico->alias }}" title="{{ $ico->name }}">
                                <img class="image" alt="{{ $ico->name }} ico" title="{{ $ico->name }} ico" src="{{ $ico->image }}" height="30">
                                <p>
                                    <i class="fa fa-hand-o-right fa-fw"></i>
                                    {{ str_limit($ico->name, 11) }}
                                </p>
                                <p>
                                    <i class="fa fa-clock-o fa-fw"></i>
                                    {{ $ico->start_time }}
                                </p>
                            </a>
                        </div>
                    @endforeach
                </div>
                <div class="mobile-ico-carousel" style="display: none;">
                    @foreach($icos as $ico)
                        <div class="dashboard-active-icos">
                            <a href="{{ makeUrl('crypto-ico') }}/{{ $ico->alias }}" title="{{ $ico->name }}">
                                <img alt="{{ $ico->name }} ico" title="{{ $ico->name }} ico" src="{{ $ico->image }}" height="30">
                                <p>
                                    <i class="fa fa-clock-o fa-fw"></i>
                                    {{ str_limit($ico->name, 11) }}
                                </p>
                                <p>
                                    <i class="fa fa-clock-o fa-fw"></i>
                                    {{ $ico->start_time }}
                                </p>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@stop
