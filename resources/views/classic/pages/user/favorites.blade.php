@extends(getCurrentTemplate() . '.layouts.default')
@section('meta_title')@lang('user.FAVORITES_PAGE_TITLE')@stop
@section('meta_desc')@lang('user.FAVORITES_PAGE_DESC')@stop
@section('meta_link'){{ Request::url() }}@stop
@section('meta_image'){{ URL::asset('public/images/pages/images') . '/watchlist.png' }}@stop
@section('styles')
<link href="{{ URL::asset('public/css/datatables/dataTables.bootstrap.css') }}" rel="stylesheet" />
<link href="{{ URL::asset('public/css/datatables/dataTables.responsive.css') }}" rel="stylesheet" />
<link href="{{ URL::asset('public/css/default_table.css') }}" rel="stylesheet" />
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
<script src="{{ URL::asset('public/js/default/streaming-code.js') }}"></script>
<script>
$(document).ready(function() {
    $('#dataTables-example').DataTable({
        responsive: true,
        "bPaginate": false,
        "bInfo" : false,
        bFilter: false,
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
        <div class="ui segment coins_page_headings">
            <div class="ui teal large ribbon label"><i class="tag icon"></i></div>
            <h1>@lang('user.FAVORITES_PAGE_HEADING')</h1>
        </div>
        <ul class="nav nav-tabs full-detail-page-tabs">
            <li class="active"><a href="#table" type="table" data-toggle="tab" aria-expanded="true">@lang('headings.TABLE')</a></li>
            <!-- <li class=""><a href="#graph" type="graph" data-toggle="tab" aria-expanded="false">@lang('headings.CHART')</a></li> -->
        </ul>
        <div class="tab-content">
            <div class="tab-pane fade active in" id="table">
                <div class="panel panel-default favorite-coins-table-tab">
                    <div class="panel-body top-currencies-page">
                        <table width="100%" class="table table-bordered table-hover" id="dataTables-example">
                            <thead>
                                <tr>
                                    <th style="width: 50px;">@lang('tbl_headings.RANK')</th>
                                    <th>@lang('tbl_headings.NAME')</th>
                                    <th class="right">@lang('tbl_headings.PRICE')</th>
                                    <th class="right">@lang('tbl_headings.MARKET_CAP')</th>
                                    <th class="right">@lang('tbl_headings.24h_VOLUME')</th>
                                    <th class="right">@lang('tbl_headings.1H_CHANGE')</th>
                                    <th class="right">@lang('tbl_headings.24H_CHANGE')</th>
                                    <th class="right">@lang('tbl_headings.AVAILABLE_SUPPLY')</th>
                                </tr>
                            </thead>
                            <tbody class="crypto-currencies-data">
                                @foreach ($favorite_coins as $market)
                                <tr class="odd gradeX" id="TABLE_ROW_{{$market->symbol}}">
                                    <td>
                                        {{$market->rank}}
                                    </td>
                                    <td>
                                        <h3 class="ui image header">
                                            <img alt='{{ $market->name }} icon' title='{{ $market->name }}' src="{{ str_replace('/thumbs', '', $market->image) }}" width='20' />
                                            <div class="content">
                                                <a href="{{ makeUrl('currencies') }}/{{$market->alias}}"> 
                                                    {{ str_limit($market->name, 12) }} 
                                                    <span class="sr-only">{{$market->name}}</span>
                                                    <div class="sub header">
                                                        <b><acronym title="{{$market->symbol}}">{{$market->symbol}} </acronym></b>
                                                    </div>
                                                </a>
                                            </div>
                                        </h3>      
                                    </td>
                                    <td class="price right" val="{{$market->price_usd}}" id="PRICE_{{$market->symbol}}"></td>
                                    <td class="market_cap_usd right" val="{{$market->market_cap_usd}}"></td>
                                    <td class="volume_usd_day right" val="{{$market->volume_usd_day}}"></td>
                                    <td class="percent_change_hour right" style="color: @if($market->percent_change_hour >= 0) green @else red @endif">
                                        {{$market->percent_change_hour}} %
                                    </td>
                                    <td id="CHANGE24HOURPCT_{{$market->symbol}}" class="percent_change_day right" style="color: @if($market->percent_change_day >= 0) green @else red @endif">
                                        {{$market->percent_change_day}} %
                                    </td>
                                    <td class="right">{{$market->available_supply}} {{$market->symbol}}</td>
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
@stop