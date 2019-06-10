@extends(getCurrentTemplate() . '.layouts.default')
@section('meta_title')@lang('v7.HASHRATE_PAGE_TITLE')@stop
@section('meta_desc')@lang('v7.HASHRATE_PAGE_DESC')@stop
@section('meta_link'){{ Request::url() }}@stop
@section('meta_image'){{ URL::asset('public/images/pages/images') . '/pools.png' }}@stop
@section('scripts')
<script src="{{ URL::asset('public/js/amchart/core.js') }}"></script>
<script src="{{ URL::asset('public/js/amchart/charts.js') }}"></script>
<script src="{{ URL::asset('public/js/amchart/animated.js') }}"></script>
<script type="text/javascript">
am4core.useTheme(am4themes_animated);
var chart = am4core.create("container", am4charts.PieChart);
chart.data = {!! $pie_data !!};
chart.innerRadius = am4core.percent(50);
var series = chart.series.push(new am4charts.PieSeries());
series.dataFields.value = "value";
series.dataFields.category = "pool";
series.slices.template.cornerRadius = 10;
series.slices.template.innerCornerRadius = 7;
series.hiddenState.properties.opacity = 1;
series.hiddenState.properties.endAngle = -90;
series.hiddenState.properties.startAngle = -90;
</script>
@stop
@section('content')
<div class="ui pointing secondary menu">
    <a class="m item" href="{{ makeUrl('mining-pools') }}">
        <i class="file alternate icon"></i>@lang('v7.MINING_POOLS')
    </a>
    <a class="m item active" href="{{ makeUrl('mining-pools') }}/hashrate-distribution">
        <i class="microchip icon"></i>@lang('blockexplorer.HASRATE_DISTRIBUTION')
    </a>
</div>
<div class="ui segment">
    <div class="coins_page_headings latest-block-btn">
        <div class="ui teal large ribbon label"><i class="tag icon"></i></div>
        <h1>@lang('blockexplorer.HASRATE_DISTRIBUTION')</h1>
    </div>
    <div class="ui divider"></div>
    <p>
        @lang('blockexplorer.HASRATE_DISTRIBUTION_PAGE')
    </p>
    @if(count($pools) > 0)
    <div class="pool-pie">
        <div id="container" style="min-width: 310px; height: 425px; max-width: 80%; margin: 0 auto"></div>
    </div> 
</div>
<div class="ui segment">
    <div class="ui teal large ribbon label"><i class="tag icon"></i></div>
    <h1>@lang('blockexplorer.KNOWN_BTC')</h1>
    <div class="ui divider"></div>
    <div class="table-responsive table-wrapper">
        <table width="80%" class="table table-hover">
             <thead>
                <tr>
                    <th style="text-align: left; width: 55%;">@lang('blockexplorer.RELAYED')</th>
                    <th>@lang('blockexplorer.COUNT')</th>
                </tr>
            </thead>
            <tbody class="pool-data">
                @foreach($pools as $pool => $count)
                <tr>
                    <td>{{ $pool }}</td>
                    <td>{{ $count }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif
</div>
@include('default.includes.disqus')
@stop
