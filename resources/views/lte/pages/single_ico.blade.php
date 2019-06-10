@extends(getCurrentTemplate() . '.layouts.default')
@section('meta_title'){{ $ico->name }} ICO @stop
@section('meta_desc'){{ $ico->description }}@stop
@section('meta_link'){{ Request::url() }}@stop
@section('meta_image'){{ $ico->image }}@stop
@section('styles')<style>.card {
    box-shadow: 1px 3px 15px 0px rgba(0, 0, 0, 0.14);
    border: none;
}
.card {
    position: relative;
    display: flex;
    flex-direction: column;
    min-width: 0;
    word-wrap: break-word;
    background-color: #fff;
    background-clip: border-box;
    border: 1px solid rgba(0, 0, 0, 0.125);
    border-radius: 0.25rem;
}.card-body {
    flex: 1 1 auto;
    padding: 0 .25rem;
    text-align: center;
    font-weight: 700;
}.mb-3, .my-3 {
    margin-bottom: 1.5rem !important;
}.pool-detail img{width: 115px;float: left;margin: 0 10px 0 0;border: 1px solid #eee;}
.pool-detail p {font-size: 20px; font-weight: 500;line-height: 29px;}
.pool-detail button {color: white!important;} 
.coin-detail-social-buttons{float:right}.coin-detail-table th{background-color:#2c3b41!important}.coin-detail,.coin-detail:hover{color:#fff}.content{min-height:10px!important}.info-box{background:#FFF;border:1px solid #EEE;overflow:hidden;border-radius:0;margin-bottom:-1px;min-height:10px}.info-label{background:#f9f9f9;font-size:11px;color:#444;font-weight:700;border-bottom:1px solid #EEE}.info-box .info-text{font-size:12px;color:#777;white-space:nowrap;min-height:25px}.info-box .info-text,.info-label{line-height:25px;padding-left:10px;padding-right:10px}@media (max-width:767px){.coin-detail-wrapper{display:none}.partial-coin-detail-wrapper{display:block}}@media (min-width:767px){.partial-coin-detail-wrapper{display:none}}.coin-detail-page-header ul{list-style:none;margin-top:-35px;margin-bottom:-15px;padding:unset}.coin-detail-page-header ul li{display:inline-block;padding:4px;font-size:18px}div#markets .table-responsive,div#price_history .table-responsive{overflow-x:hidden!important}.social-container .reddit,.social-container .twitter{height:600px;overflow:auto}.social-container{padding-top:20px}.social-container .reddit{padding-left:25px}.ui.teal.label,.ui.teal.labels .label{background-color:#337ab7!important;border-color:#337ab7!important}.ui.ribbon.label:after{border-right-color:#337ab7!important}.ui.segment{margin-top:unset}.green{color: green;}.red{color: red;}
</style>
@stop
@section('content')
<div class="box box-success table-heading-class">
    <div class="box-header with-border">
        <h3 class="box-title">{{ $ico->name }}</h3>
        <h1 class="sr-only">{{ $ico->name }}</h1>
    </div>
</div>
<div class="ui segment">
    <div class="row">
        <div class="col-md-5 pool-detail">
            @if(file_exists('public/storage/' . $ico->image))
            <img class="img-fluid" src="{{URL::asset('public/storage/' . $ico->image)}}" title="{{ $ico->name }}" alt="{{ $ico->name }}" style="width: 220px;">
            @else
            <img class="img-fluid" src="{{ $ico->image }}" title="{{ $ico->name }}" alt="{{ $ico->name }}" style="width: 220px;">
            @endif
        </div>
    </div><br />
    <p>{{ $ico->description }}.</p>
    <div style="margin-top: 20px;" class="ui grid aligned">
        <div class="col-md-3 col-sm-12 col-xs-12">
            <div class="info-box">
                <div class="info-label">@lang('tbl_headings.START_TIME') </div>
                <div class="info-text"> 
                    <span style="color: green;">{{ $ico->start_time }}</span>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-12 col-xs-12">
            <div class="info-box">
                <div class="info-label">@lang('tbl_headings.END_TIME')</div>
                <div class="info-text">
                    <span style="color: green;">{{ $ico->end_time }}</span>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-12 col-xs-12">
            <div class="info-box">
                <div class="info-label"> @lang('v7.FEATURED') </div>
                <div class="info-text">
                    @if($ico->featured == 0)
                        <span style="color: red;">No</span>
                    @else
                        <span style="color: green;">Yes</span>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-12 col-xs-12">
            <div class="info-box">
                <div class="info-label">@lang('v7.ICO_STATUS')</div>
                <div class="info-text">
                    @if($ico->status == 0)
                        <span style="color: red;">Active</span>
                    @elseif($ico->status == 1)
                        <span style="color: green;">Upcoming</span>
                    @elseif($ico->status == 2)
                        <span style="color: red;">Finished</span>
                    @endif
                </div>
            </div>
        </div>
    </div><br /><br />
    <a href="@if($ico->affiliate == '') {{$ico->icowatchlist_url}} @else {{$ico->affiliate}} @endif" target="_blank" title="{{ $ico->name }}" rel="nofollow noopener noreferrer">
        <button class="btn btn-primary">@lang('tbl_headings.ICO_DETAILS')</button>
    </a>
</div>
@if($icos)
<div class="box box-success table-heading-class">
    <div class="box-header with-border">
        <h3 class="box-title">@lang('v7.RELATED_ICOS')</h3>
        <h1 class="sr-only">@lang('v7.RELATED_ICOS')</h1>
    </div>
    <p style="margin: 10px;">@lang('v7.RELATED_ICOS_DESC')</p>
</div>
<div class="row">
    @foreach ($icos as $ico)
    <div class="col-4 col-xl-2 col-lg-2 col-md-3 col-sm-4 mb-3">    
        <a class="card" href="{{ makeUrl('crypto-ico') }}/{{ $ico->alias }}" title="{{ $ico->name }}">  
            @if(file_exists('public/storage/' . $ico->image))
            <img class="img-fluid" src="{{URL::asset('public/storage/' . $ico->image)}}" title="{{ $ico->name }}" alt="{{ $ico->name }}" style="width: 100%;border-bottom: 1px solid #eee;height: 60px;">
            @else
            <img class="img-fluid" src="{{ $ico->image }}" title="{{ $ico->name }}" alt="{{ $ico->name }}" style="width: 100%;border-bottom: 1px solid #eee;height: 60px;">
            @endif
            <div class="card-body">
            <h5 class="mb-0"><strong>{{ str_limit(ucfirst(strtolower($ico->name)), 15) }}</strong></h5>
            </div>
        </a>
    </div>
    @endforeach
</div>
@endif
@include('default.includes.disqus')
@stop
