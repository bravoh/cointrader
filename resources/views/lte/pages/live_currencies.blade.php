@extends(getCurrentTemplate() . '.layouts.default')
@section('meta_title'){{ $title }}@stop
@section('meta_desc'){{ $desc }}@stop
@section('meta_link'){{ Request::url() }}@stop
@section('meta_image'){{ URL::asset('public/images/pages/images') . '/live.png' }}@stop
@section('styles')
<link href="{{ URL::asset('public/css/datatables/dataTables.bootstrap.css') }}" rel="stylesheet" />
<link href="{{ URL::asset('public/css/datatables/dataTables.responsive.css') }}" rel="stylesheet" />
<style type="text/css">
.crypto-currencies-data tr.up {background-color: #C7FECF;}
.crypto-currencies-data tr.down {background-color: #FECBC7;}
</style>
@stop
@section('scripts')
<script src="{{ URL::asset('public/js/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ URL::asset('public/js/datatables/dataTables.responsive.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/2.0.4/socket.io.js"></script>
<script src="{{ URL::asset('public/js/ccc-streamer-utilities.js') }}"></script>
<script src="{{ URL::asset('public/js/lte/streaming-code.js') }}"></script>
<script>
$(document).ready(function() {
    $('#dataTables-example').DataTable({
        responsive: true,
        "bPaginate": false,
        bFilter: false,
        "aaSorting": [],
        "columnDefs": [
            { "orderable": false, "targets": [9, 10] }
        ],
        "language": {
            "url": "{{ URL::asset('public/js/datatables/') }}/langs/" + $('.top-language-dropdown .item.selected').attr('name') + '.js'
        }
    });
    $('#dataTables-example').on('click', '.add-watchlist', function() {
        var coin = $(this).attr('coin');
        $.get(APP_URL + '/ajax-save-favorite-coin/'+coin, function(response) {
            if(response == 'true') {
                $("#id_"+coin).addClass('favorite');
            } else {
                $("#id_"+coin).removeClass('favorite');
            }
        });
    });
    streaming([{!! $streaming_data !!}]);
});
</script>
@stop 
@section('content')
<div class="panel panel-default">
    <div class="box box-success table-heading-class">
        <div class="box-header with-border">
            <h3 class="box-title">{{ $sub_heading }}</h3>
        </div>
    </div>
    <div class="panel-body all-currencies-page top-currencies-page">
        <table width="100%" class="table dataTable no-footer dtr-inline collapsed" id="dataTables-example">
            <thead>
                <tr>
                    <th style="width: 50px;">#</th>
                    <th>@lang('tbl_headings.NAME')</th>
                    <th class="align-right">@lang('tbl_headings.PRICE')</th>
                    <th class="align-right">@lang('tbl_headings.MARKET_CAP')</th>
                    <th class="align-right">@lang('tbl_headings.24h_VOLUME')</th>
                    <th class="align-right">@lang('tbl_headings.1H_CHANGE')</th>
                    <th class="align-right">@lang('tbl_headings.24H_CHANGE')</th>
                    <th class="align-right">@lang('v5.7D_CHANGE')</th>
                    <th class="align-right">@lang('tbl_headings.AVAILABLE_SUPPLY')</th>
                    <th class="align-right">@lang('v5.BUY_SELL')</th>
                    @if(Auth::user())
                    <th class="align-right">
                    </th>
                    @endif
                </tr>
            </thead>
            <tbody class="crypto-currencies-data">
                    @if($sponsored_markets)
                    @foreach ($sponsored_markets as $market)
                        <tr class="odd gradeX" id="TABLE_ROW_{{$market->symbol}}" style="background: wheat;">
                            <td>{{$market->rank}}</td>
                            <td>
                                <a href="{{ URL::asset('currencies') }}/{{$market->alias}}">
                                <img alt='{{ $market->name }} icon' title='{{ $market->name }}' src='{{ $market->image }}' width='20' /> {{$market->name}}
                                <small style="background: #ccc;border-radius: 5px;padding: 2px;">Sponsored</small>
                                </a>
                            </td>
                            <td class="price align-right" val="{{$market->price_usd}}" id="PRICE_{{$market->symbol}}"></td>
                            <td class="market_cap_usd align-right" val="{{$market->market_cap_usd}}"></td>
                            <td class="volume_usd_day align-right" val="{{$market->volume_usd_day}}"></td>
                            <td class="percent_change_hour align-right">
                                <span class="badge @if($market->percent_change_hour >= 0) bg-green @else bg-red @endif" style="width: 60px;">{{$market->percent_change_hour}}%</span>
                            </td>
                            <td class="percent_change_day align-right">
                                <span id="CHANGE24HOURPCT_{{$market->symbol}}" class="badge @if($market->percent_change_day >= 0) bg-green @else bg-red @endif" style="width: 60px;">{{ $market->percent_change_day }}%</span>
                            </td>
                            <td class="percent_change_week align-right">
                                <span class="badge @if($market->percent_change_week >= 0) bg-green @else bg-red @endif" style="width: 60px;">{{$market->percent_change_week}}%</span>
                            </td>
                            <td class="align-right">{{$market->available_supply}} {{$market->symbol}}</td>
                            <td class="align-right">
                                <div class="ui label simple dropdown item" tabindex="0">
                                    <i class="cart icon"></i>@lang('v5.BUY_SELL') <i class="dropdown icon"></i>
                                    <div class="menu" tabindex="-1">
                                        @if(isset($affiliates))
                                          @foreach($affiliates as $affiliate)
                                           <div class="item info-label">
                                              <a href="{{ $affiliate->link }}" target="_blank" title="{{ $affiliate->name }}" alt="{{ $affiliate->name }}">
                                                {{ $affiliate->name }}
                                              </a>
                                          </div>
                                          @endforeach
                                      @endif
                                    </div>
                                </div>
                            </td>
                            @if(Auth::user())
                            <td class="align-right">
                                <a class="add-watchlist @if(in_array($market->symbol, $favorite_coins)) favorite @endif" 
                                id="id_{{ $market->symbol }}" coin= "{{ $market->symbol }}"
                                style="cursor: pointer;">
                                    <i class="fa fa-star fa-fw" title="add to favorites"></i>
                                </a>
                            </td>
                            @endif
                        </tr>
                @endforeach
                @endif
                @foreach ($all_markets as $market)
                <tr class="odd gradeX" id="TABLE_ROW_{{$market->symbol}}">
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
                        <span class="badge @if($market->percent_change_hour >= 0) bg-green @else bg-red @endif" style="width: 60px;">{{$market->percent_change_hour}}%</span>
                    </td>
                    <td class="percent_change_day align-right">
                        <span id="CHANGE24HOURPCT_{{$market->symbol}}" class="badge @if($market->percent_change_day >= 0) bg-green @else bg-red @endif" style="width: 60px;">{{ $market->percent_change_day }}%</span>
                    </td>
                    <td class="percent_change_week align-right">
                        <span class="badge @if($market->percent_change_week >= 0) bg-green @else bg-red @endif" style="width: 60px;">{{$market->percent_change_week}}%</span>
                    </td>
                    <td class="align-right">{{$market->available_supply}} {{$market->symbol}}</td>
                    <td class="align-right">
                        <div class="ui label simple dropdown item" tabindex="0">
                            <i class="cart icon"></i>@lang('v5.BUY_SELL') <i class="dropdown icon"></i>
                            <div class="menu" tabindex="-1">
                                @if(isset($affiliates))
                                  @foreach($affiliates as $affiliate)
                                   <div class="item info-label">
                                      <a href="{{ $affiliate->link }}" target="_blank" title="{{ $affiliate->name }}" alt="{{ $affiliate->name }}">
                                        {{ $affiliate->name }}
                                      </a>
                                  </div>
                                  @endforeach
                              @endif
                            </div>
                        </div>
                    </td>
                    @if(Auth::user())
                    <td class="align-right">
                        <a class="add-watchlist @if(in_array($market->symbol, $favorite_coins)) favorite @endif" 
                        id="id_{{ $market->symbol }}" coin= "{{ $market->symbol }}"
                        style="cursor: pointer;">
                            <i class="fa fa-star fa-fw" title="add to favorites"></i>
                        </a>
                    </td>
                    @endif
                </tr>
                @endforeach
            </tbody>
        </table>
        {{ $all_markets->links() }} <br />
    </div>
</div>
@stop