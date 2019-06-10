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
<div class="ui pointing secondary menu" style="border-bottom: unset;">
    <a class="m item" href="{{ makeUrl('mining-pools') }}" style="background: #ddd; border-radius: 2px;margin-right: 5px;">
        <i class="file alternate icon"></i>@lang('v7.MINING_POOLS')
    </a>
    <a class="m item active" href="{{ makeUrl('mining-pools') }}/hashrate-distribution" style="background: #ddd; border-radius: 2px;">
        <i class="microchip icon"></i>@lang('blockexplorer.HASRATE_DISTRIBUTION')
    </a>
</div>
<div class="box box-success table-heading-class">
    <div class="box-header with-border">
        <h3 class="box-title">@lang('blockexplorer.HASRATE_DISTRIBUTION')</h3>
        <h1 class="sr-only">@lang('blockexplorer.HASRATE_DISTRIBUTION')</h1>
        <h2 class="sr-only">A complete list of mining pools</h2>
        <h2 class="sr-only">Compare Bitcoin, Ethereum and Litecoin Mining Pools</h2>
        <h2 class="sr-only">Bitcoin, Ethereum and Litecoin Mining Pools</h2>
    </div>
    <p style="padding: 10px;">@lang('blockexplorer.HASRATE_DISTRIBUTION_PAGE')</p>
</div>
<div class="ui segment">
    @if(count($pools) > 0)
    <div class="pool-pie">
        <div id="container" style="min-width: 310px; height: 425px; max-width: 80%; margin: 0 auto"></div>
    </div> 
</div>
<div class="box box-success table-heading-class">
    <div class="box-header with-border">
        <h3 class="box-title">@lang('blockexplorer.KNOWN_BTC')</h3>
        <h1 class="sr-only">@lang('blockexplorer.KNOWN_BTC')</h1>
        <h2 class="sr-only">A complete list of mining pools</h2>
        <h2 class="sr-only">Compare Bitcoin, Ethereum and Litecoin Mining Pools</h2>
        <h2 class="sr-only">Bitcoin, Ethereum and Litecoin Mining Pools</h2>
    </div>
</div>
<div class="ui segment">
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
