@extends(getCurrentTemplate() . '.layouts.default') @section('meta_title')@lang('seo.MINING_TITLE')@stop @section('meta_desc')@lang('seo.MINING_DESCRIPTION')@stop @section('meta_link'){{ Request::url() }}@stop @section('meta_image'){{ URL::asset('public/images/pages/images') . '/mining.png' }}@stop @section('content')  <div class="ui segment"><div class="ui teal large ribbon label"><i class="tag icon"></i></div><h1>{{ $sub_heading }}</h1> </div> <div class="ui five cards"> @foreach ($mining_equipments as $equipment)  <div class="card"> <div class="image"> <img class="image" src="{{ $equipment->logo }}"> </div> <div class="content"> <div class="header">{{ $equipment->name }}</div><div class="ui divider"></div> <div class="description">  <div class="ui list">  <div class="item"> <i class="microchip icon"></i> <div class="content"> <div class="header">Algorithm</div> <div class="description">{{ $equipment->algorithm }}</div> </div> </div>  <div class="item"> <i class="slack hash icon"></i> <div class="content"> <div class="header">Hashes Per Second</div> <div class="description">{{ $equipment->hashes_per_second }}</div> </div> </div>  <div class="item"> <i class="dollar sign icon"></i> <div class="content"> <div class="header">Cost</div> <div class="description">{{ $equipment->cost }} {{ $equipment->currency }}</div> </div> </div>  <div class="item"> <i class="hdd icon"></i> <div class="content"> <div class="header">Type</div> <div class="description">{{ $equipment->type }}</div> </div> </div> <div class="item"> <i class="power off icon"></i> <div class="content"> <div class="header">Power Consumption</div> <div class="description">{{ $equipment->power_consumption }}</div> </div> </div> <div class="item"> <i class="bitcoin icon"></i> <div class="content"> <div class="header">Currencies Available</div> <div class="description">{{ $equipment->currencies_available }}</div> </div> </div>  </div> </div> </div>   <a href="@if($equipment->affiliate == '') {{ $equipment->url }} @else {{ $equipment->affiliate }}  @endif" target="_blank" style="color:#fff"><button class="fluid ui button orange" style="color:#fff">Buy Now</button> </a>  </div> @endforeach </div> <br /><br />@stop 