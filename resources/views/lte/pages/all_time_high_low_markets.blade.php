@extends(getCurrentTemplate() . '.layouts.default')
@section('meta_title'){{ $title }}@stop
@section('meta_desc'){{ $desc }}@stop
@section('meta_link'){{ Request::url() }}@stop
@section('meta_image'){{ URL::asset('public/images/pages/images') . '/high_low.png' }}@stop
@section('styles')
<link href="{{ URL::asset('public/css/datatables/dataTables.bootstrap.css') }}" rel="stylesheet" />
<link href="{{ URL::asset('public/css/datatables/dataTables.responsive.css') }}" rel="stylesheet" />
@stop
@section('scripts')
<script src="{{ URL::asset('public/js/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ URL::asset('public/js/datatables/dataTables.responsive.js') }}"></script>
<script>
$(document).ready(function() {
    $('#dataTables-example').DataTable({
        responsive: true,
        "bPaginate": false,
        bFilter: false,
        "order": [],
        "language": {
            "url": "{{ URL::asset('public/js/datatables/') }}/langs/" + $('.top-language-dropdown .item.selected').attr('name') + '.js'
        }
    });
});
</script>
@stop
@section('content')
<div class="panel panel-default">
    <div class="box box-success table-heading-class">
        <div class="box-header with-border">
            <h3 class="box-title">@lang('headings.AT_HIGH_LOW_PAGE')</h3>
        </div>
    </div>
    <div class="panel-body top-currencies-page">
        <table width="100%" class="table table-hover" id="dataTables-example">
            <thead>
                <tr>
                    <th style="width: 50px;">#</th>
                    <th>@lang('tbl_headings.NAME')</th>
                    <th class="align-right">@lang('tbl_headings.PRICE')</th>
                    <th class="align-right">@lang('tbl_headings.24H_LOW')</th>
                    <th class="align-right">@lang('tbl_headings.24H_HIGH')</th>
                    <th class="align-right">@lang('tbl_headings.AT_LOW')</th>
                    <th class="align-right">@lang('tbl_headings.AT_HIGH')</th>
                </tr>
            </thead>
            <tbody class="crypto-currencies-data">
                @foreach ($markets as $market)
                <tr class="odd gradeX">
                    <td>{{$market->rank}}</td>
                    <td>
                        <a href="{{ URL::asset('crypto-currencies') }}/{{$market->alias}}">
                            <img alt='{{ $market->name }} icon' title='{{ $market->name }}' src='{{ $market->image }}' width='20' /> {{$market->name}}
                        </a>
                    </td>
                    <td class="price align-right" val="{{$market->price_usd}}"></td>
                    @if(isset($latest_high_low[$market->symbol]->latest_low) && $market->price_usd < $latest_high_low[$market->symbol]->latest_low)
                    <td class="latest_high align-right" style="color: red;" val="{{{ $market->price_usd or 'N/A' }}}"></td>
                    @else
                    <td class="latest_low align-right" style="color: red;" val="{{{ $latest_high_low[$market->symbol]->latest_low or 'N/A' }}}"></td>
                    @endif
                    @if(isset($latest_high_low[$market->symbol]->latest_high) && $market->price_usd > $latest_high_low[$market->symbol]->latest_high)
                    <td class="latest_high align-right" style="color: green;" val="{{{ $market->price_usd or 'N/A' }}}"></td>
                    @else
                    <td class="latest_high align-right" style="color: green;" val="{{{ $latest_high_low[$market->symbol]->latest_high or 'N/A' }}}"></td>
                    @endif
                    <td class="all_time_low align-right" style="color: red;" val="{{{ $all_time_high_low[$market->symbol]->low or 'N/A' }}}"></td>
                    <td class="all_time_high align-right" style="color: green;" val="{{{ $all_time_high_low[$market->symbol]->high or 'N/A' }}}"></td>
                </tr>
                @endforeach
            </tbody>
        </table>
        {{ $markets->links() }} <br />
        <div class="well">
            <h4>@lang('headings.AT_HIGH_LOW_PAGE')</h4>
            <p>
                @lang('constants.AHL_CRYPTO_FOOTER_TEXT')
            </p>
        </div>
    </div>
</div>
@stop
