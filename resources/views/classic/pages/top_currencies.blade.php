@extends(getCurrentTemplate() . '.layouts.default')
@section('meta_title'){{ $title }}@stop
@section('meta_desc'){{ $desc }}@stop
@section('meta_link'){{ Request::url() }}@stop
@section('meta_image'){{ URL::asset('public/images/pages/images') . '/top_coins.png' }}@stop
@section('styles')
<link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap.min.css" rel="stylesheet" />
<link href="https://cdn.datatables.net/responsive/2.1.0/css/responsive.bootstrap.css" rel="stylesheet" />
@stop
@section('scripts')
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.1.0/js/dataTables.responsive.min.js"></script>
<script>
$(document).ready(function() {
    $('#dataTables-example').DataTable({
        "responsive": true,
        "bPaginate": false,
        "bInfo" : false,
        "bFilter": false,
        "aaSorting": [],
        @if(Auth::user())
        "columnDefs": [
            { "orderable": false, "targets": [9,10] }
        ],
        @else
        "columnDefs": [
            { "orderable": false, "targets": [9] }
        ],
        @endif
        "order": [],
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
});
</script>
@stop
@section('content')
<div class="ui segment"><div class="ui teal large ribbon label"><i class="tag icon"></i></div><h1>{{ $sub_heading }}</h1></div>
<div class="panel panel-default live">
    <div class="panel-heading sr-only">
      <h1>{{ $sub_heading }}</h1>
    </div>
    <div class="panel-body all-currencies-page top-currencies-page live" style="padding-top:0">
        {{ $crypto_top_markets->links() }}
        @if($crypto_top_markets->links() != '')
        <ul class="custom-pagination" style="float: right;">
            <li style="list-style-type: none;"><a href="{{ makeUrl($link) }}">@lang('pagination.FIRST')</a></li>
        </ul>
        @endif
        <div class="ui pointing secondary menu currencies-page-tabs" style="float: left;margin-top: 0px;">
           <a class="m item @if(Request::is( '*/top-gainers-crypto-currencies')) active @endif" href="{{ makeUrl('top-gainers-crypto-currencies') }}">
             <i class="level up alternate icon"></i>@lang('menu.TOP_GAINERS')
           </a>
           <a class="m item @if(Request::is( '*/top-losers-crypto-currencies')) active @endif" href="{{ makeUrl('top-losers-crypto-currencies') }}">
             <i class="level down alternate icon"></i>@lang('menu.TOP_LOSERS')
           </a>
           <a class="m item @if(Request::is( '/high-low-crypto-currencies')) active @endif" href="{{ makeUrl('high-low-crypto-currencies') }}">
             <i class="certificate icon"></i>@lang('menu.HIGH_LOW_COINS')
           </a>
         </div>
        <table width="100%" class="table table-bordered table-hover white" id="dataTables-example">
            <thead>
                <tr>
                    <th style="width: 50px;">@lang('tbl_headings.RANK')</th>
                    <th>@lang('tbl_headings.NAME')</th>
                    <th class="right">@lang('tbl_headings.PRICE')</th>
                    <th class="right">@lang('tbl_headings.MARKET_CAP')</th>
                    <th class="right">@lang('tbl_headings.24h_VOLUME')</th>
                    <th class="right">@lang('tbl_headings.1H_CHANGE')</th>
                    <th class="right">@lang('tbl_headings.24H_CHANGE')</th>
                    <th class="right">@lang('v5.7D_CHANGE')</th>
                    <th class="right">@lang('tbl_headings.AVAILABLE_SUPPLY')</th>
                    <th class="right">@lang('v5.BUY_SELL')</th>
                    @if(Auth::user())
                    <th class="right"><i class="fa fa-desktop fa-fw" title="add to favorites"></i></th>
                    @endif
                </tr>
            </thead>
            <tbody class="crypto-currencies-data">
                @foreach ($crypto_top_markets as $market)
                <tr class="odd gradeX">
                    <td>
                        {{$market->rank}}
                    </td>
                    <td> 
                        <h3 class="ui image header">
                        <img alt='{{ $market->name }} icon' title='{{ $market->name }}' src="{{ $market->image }}" width='20' />
                        <div class="content">
                            <a href="{{ URL::asset('currencies') }}/{{$market->alias}}"> 
                                {{ str_limit($market->name, 12) }}
                                <span class="sr-only">{{$market->name}}</span>
                                <div class="sub header">
                                    <b><acronym title="{{$market->symbol}}">{{$market->symbol}} </acronym></b>
                                </div>
                            </a>
                        </div>
                    </h3>     
                    </td>
                    <td class="price right" val="{{$market->price_usd}}"></td>
                    <td class="market_cap_usd  right" val="{{$market->market_cap_usd}}"></td>
                    <td class="volume_usd_day  right" val="{{$market->volume_usd_day}}"></td>
                    <td class="percent_change_hour right" style="color: @if($market->percent_change_hour >= 0) green @else red @endif">
                        {{$market->percent_change_hour}} %
                    </td>
                    <td class="percent_change_day right" style="color: @if($market->percent_change_day >= 0) green @else red @endif">
                        {{$market->percent_change_day}} %
                    </td>
                    <td class="percent_change_week right" style="color: @if($market->percent_change_week >= 0) green @else red @endif">
                        {{$market->percent_change_week}} %
                    </td>
                    <td class="right">{{$market->available_supply}} {{$market->symbol}}</td>
                    <td class="right">
                        <div class="ui label simple dropdown item" style="background: #00b5ad;color: #fff;" tabindex="0">       
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
                    <td class="right">
                        <a class="add-watchlist @if(in_array($market->symbol, $favorite_coins)) favorite @endif" 
                        id="id_{{ $market->symbol }}" coin= "{{ $market->symbol }}"
                        style="cursor: pointer;">
                            <i class="fa fa-heart fa-fw"></i>
                        </a>
                    </td>
                    @endif
                </tr>
                @endforeach
            </tbody>
        </table>
        {{ $crypto_top_markets->links() }}
        @if($crypto_top_markets->links() != '')
        <ul class="custom-pagination" style="float: right;">
            <li style="list-style-type: none;"><a href="{{ makeUrl($link) }}">@lang('pagination.FIRST')</a></li>
        </ul>
        @endif <br /> <br /> <br />
        <div class="well">
            <h4>@lang('headings.CRYPTO_CURRENCIES')</h4>
            <p>
                @lang('constants.TOP_CRYPTO_FOOTER_TEXT')
            </p>
        </div>
    </div>
</div>
@stop
