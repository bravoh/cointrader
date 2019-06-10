@extends(getCurrentTemplate() . '.layouts.default')
@section('meta_title'){{ $title }}@stop
@section('meta_desc'){{ $desc }}@stop
@section('meta_link'){{ Request::url() }}@stop
@section('meta_image'){{ URL::asset('public/images/pages/images') . '/high_low.png' }}@stop
@section('styles')
<link href="{{ URL::asset('public/css/datatables/dataTables.bootstrap.css') }}" rel="stylesheet" />
<link href="{{ URL::asset('public/css/datatables/dataTables.responsive.css') }}" rel="stylesheet" />
<link href="{{ URL::asset('public/css/default_table.css') }}" rel="stylesheet" />
@stop
@section('scripts')
<script src="{{ URL::asset('public/js/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ URL::asset('public/js/datatables/dataTables.bootstrap.min.js') }}"></script>
<script src="{{ URL::asset('public/js/datatables/dataTables.responsive.js') }}"></script>
<script>
$(document).ready(function() {
    $('#dataTables-example').DataTable({
        responsive: true,
        bFilter: false,
        "bPaginate": false,
        bInfo: false,
        "order": [],
        "language": {
            "url": "{{ URL::asset('public/js/datatables/') }}/langs/" + $('.top-language-dropdown .item.selected').attr('name') + '.js'
        }
    });
});
</script>
@stop
@section('content')
<div class="ui segment coins_page_headings">
    <div class="ui teal large ribbon label"><i class="tag icon"></i></div>
    <h1>
        @lang('headings.AT_HIGH_LOW_PAGE')
    </h1>
</div>
<div class="top-currencies-page">
   {{ $markets->links() }}
    <ul class="custom-pagination" style="float: right;">
      <li style="list-style-type:none"><a href="{{ makeUrl('currencies') }}">@lang('pagination.FIRST')</a></li>
    </ul>
    <div class="ui pointing secondary menu currencies-page-tabs" style="float: left;margin-top: 0px;border-bottom: unset;">
       <a class="m item @if(Request::is('*/top-gainers-crypto-currencies')) active @endif" href="{{ makeUrl('top-gainers-crypto-currencies') }}">
         <i class="level up alternate icon"></i>@lang('menu.TOP_GAINERS')
       </a>
       <a class="m item @if(Request::is('*/top-losers-crypto-currencies')) active @endif" href="{{ makeUrl('top-losers-crypto-currencies') }}">
         <i class="level down alternate icon"></i>@lang('menu.TOP_LOSERS')
       </a>
       <a class="m item @if(Request::is('*/high-low-crypto-currencies')) active @endif" href="{{ makeUrl('high-low-crypto-currencies') }}">
         <i class="certificate icon"></i>@lang('menu.HIGH_LOW_COINS')
       </a>
     </div>
    <table width="100%" class="table dataTable no-footer dtr-inline collapsed table-hover" id="dataTables-example">
        <thead>
            <tr>
                <th style="width: 50px;">@lang('tbl_headings.RANK')</th>
                <th>@lang('tbl_headings.NAME')</th>
                <th>@lang('tbl_headings.PRICE')</th>
                <th>@lang('tbl_headings.24H_LOW')</th>
                <th>@lang('tbl_headings.24H_HIGH')</th>
                <th>@lang('tbl_headings.AT_LOW')</th>
                <th>@lang('tbl_headings.AT_HIGH')</th>
            </tr>
        </thead>
        <tbody class="crypto-currencies-data">
            @foreach ($markets as $market)
            <tr class="odd gradeX">
                <td>{{$market->rank}}</td>
                <td>
                    <h3 class="ui image header">
                        <img alt='{{ $market->name }} icon' title='{{ $market->name }}' src="{{ str_replace('/thumbs', '', $market->image) }}" width='20' />
                        <div class="content">
                            <a href="{{ URL::asset('crypto-currencies') }}/{{$market->alias}}"> 
                                {{ str_limit($market->name, 12) }}
                                <span class="sr-only">{{$market->name}}</span>
                                <div class="sub header">
                                    <b><acronym title="{{$market->symbol}}">{{$market->symbol}} </acronym></b>
                                </div>
                            </a>
                        </div>
                    </h3>     
                </td>
                <td class="price" val="{{$market->price_usd}}"></td>
                <td class="latest_low" style="color: red;" val="{{{ $latest_high_low[$market->symbol]->latest_low or 'N/A' }}}"></td>
                @if(isset($latest_high_low[$market->symbol]->latest_high) && $market->price_usd > $latest_high_low[$market->symbol]->latest_high)
                <td class="latest_high" style="color: green;" val="{{{ $market->price_usd or 'N/A' }}}"></td>
                @else
                <td class="latest_high" style="color: green;" val="{{{ $latest_high_low[$market->symbol]->latest_high or 'N/A' }}}"></td>
                @endif
                <td class="all_time_low" style="color: red;" val="{{{ $all_time_high_low[$market->symbol]->low or 'N/A' }}}"></td>
                <td class="all_time_high" style="color: green;" val="{{{ $all_time_high_low[$market->symbol]->high or 'N/A' }}}"></td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @if($markets->links() != '')
    <ul class="custom-pagination">
        <li style="list-style-type: none;"><a href="{{ URL::asset('/high-low-crypto-currencies') }}">@lang('pagination.FIRST')</a></li>
    </ul>
    @endif
    {{ $markets->links() }} <br /> <br /> <br />
    <div class="well">
        <h4>@lang('headings.AT_HIGH_LOW_PAGE')</h4>
        <p>
            @lang('constants.AHL_CRYPTO_FOOTER_TEXT')
        </p>
    </div>
</div>
@stop
