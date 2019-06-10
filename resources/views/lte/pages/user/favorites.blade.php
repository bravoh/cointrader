@extends(getCurrentTemplate() . '.layouts.default')
@section('meta_title')@lang('user.FAVORITES_PAGE_TITLE')@stop
@section('meta_desc')@lang('user.FAVORITES_PAGE_DESC')@stop
@section('meta_link'){{ Request::url() }}@stop
@section('meta_image'){{ URL::asset('public/images/pages/images') . '/watchlist.png' }}@stop
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
<script src="{{ URL::asset('public/js/datatables/dataTables.bootstrap.min.js') }}"></script>
<script src="{{ URL::asset('public/js/datatables/dataTables.responsive.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/2.0.4/socket.io.js"></script>
<script src="{{ URL::asset('public/js/ccc-streamer-utilities.js') }}"></script>
<script src="{{ URL::asset('public/js/lte/streaming-code.js') }}"></script>
<script>
$(document).ready(function() {
    $('#dataTables-example').DataTable({
        responsive: true,
        "bPaginate": false,
        "language": {
            "url": "{{ URL::asset('public/js/datatables/') }}/langs/" + $('.top-language-dropdown .item.selected').attr('name') + '.js'
        }
    });
    streaming([{!! $streaming_data !!}]);
});
</script>
@stop
@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="box box-success table-heading-class">
                  <div class="box-header with-border">
                      <h3 class="box-title"> @lang('user.FAVORITES_PAGE_HEADING') </h3>
                  </div>
              </div>
            <div class="panel-body">
                <ul class="nav nav-tabs full-detail-page-tabs">
                    <li class="active"><a href="#table" type="table" data-toggle="tab" aria-expanded="true">@lang('user.FAVORITES_COINS_LIST')</a></li>
                    <!-- <li class=""><a href="#graph" type="graph" data-toggle="tab" aria-expanded="false">@lang('headings.CHART')</a></li> -->
                </ul>
                <div class="tab-content">
                    <div class="tab-pane fade active in" id="table">
                        <div class="panel panel-default favorite-coins-table-tab" style="border-top: unset; border-top-left-radius: unset;border-top-right-radius: unset;">
                            <div class="panel-body top-currencies-page">
                                <table width="100%" class="table table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th style="width: 50px;">#</th>
                                            <th>@lang('tbl_headings.NAME')</th>
                                            <th class="align-right">@lang('tbl_headings.PRICE')</th>
                                            <th class="align-right">@lang('tbl_headings.MARKET_CAP')</th>
                                            <th class="align-right">@lang('tbl_headings.24h_VOLUME')</th>
                                            <th class="align-right">@lang('tbl_headings.1H_CHANGE')</th>
                                            <th class="align-right">@lang('tbl_headings.24H_CHANGE')</th>
                                            <th class="align-right">@lang('tbl_headings.AVAILABLE_SUPPLY')</th>
                                        </tr>
                                    </thead>
                                    <tbody class="crypto-currencies-data">
                                        @foreach ($favorite_coins as $market)
                                        <tr class="odd gradeX" id="TABLE_ROW_{{$market->symbol}}">
                                            <td>
                                                {{$market->rank}}
                                            </td>
                                            <td>
                                                <a href="{{ URL::asset('currencies') }}/{{$market->alias}}">
                                                <img alt='{{ $market->name }} icon' title='{{ $market->name }}' src='{{ $market->image }}' width='20' /> {{$market->name}}
                                                </a>
                                            </td>
                                            <td class="price align-right" val="{{$market->price_usd}}" id="PRICE_{{$market->symbol}}"></td>
                                            <td class="market_cap_usd align-right" val="{{$market->market_cap_usd}}"></td>
                                            <td class="volume_usd_day align-right" val="{{$market->volume_usd_day}}"></td>
                                            <td class="percent_change_hour align-right">
                                                <span class="badge @if($market->percent_change_hour >= 0) bg-green @else bg-red @endif" style="width: 60px;">{{$market->percent_change_hour}} %</span>
                                            </td>
                                            <td class="percent_change_day align-right">
                                                <span id="CHANGE24HOURPCT_{{$market->symbol}}" class="badge @if($market->percent_change_day >= 0) bg-green @else bg-red @endif" style="width: 60px;">{{$market->percent_change_day}} %</span>
                                            </td>
                                            <td class="align-right">{{$market->available_supply}} {{$market->symbol}}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="graph">
                        <div class="panel panel-default favorite-coins-graph-tab">
                            <div class="panel-body top-currencies-page">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop