@extends(getCurrentTemplate() . '.layouts.default')
@section('meta_title')@lang('seo.WIDGETS_PAGE_TITLE')@stop
@section('meta_desc')@lang('seo.WIDGETS_PAGE_TITLE')@stop
@section('meta_link'){{ Request::url() }}@stop
@section('meta_image'){{ URL::asset('public/images/pages/images') . '/widgets.png' }}@stop
@section('scripts')
<script type="text/javascript">
/**
 * Top 10 coins ticker
 */
$('#tab_1 .header-color').change(function() {
    $('#tab_1 .ticker-iframe').attr('src', '{{ makeUrl("widget/ticker") }}?hcolor='+$(this).val()+'&tcolor='+$("#tab_1 .text-color option:selected").val());
    $('#tab_1 textarea').html('<iframe src="{{ makeUrl("widget/ticker") }}?hcolor='+$(this).val()+'&tcolor='+$("#tab_1 .text-color option:selected").val()+'" style="width: 100%; overflow: hidden;scroll-behavior: unset;height: 525px;border: unset;"></iframe>');
});
$('#tab_1 .text-color').change(function() {
    $('#tab_1 .ticker-iframe').attr('src', '{{ makeUrl("widget/ticker") }}?hcolor='+$("#tab_1 .header-color option:selected").val()+'&tcolor='+$(this).val());    
    $('#tab_1 textarea').html('<iframe src="{{ makeUrl("widget/ticker") }}?hcolor='+$("#tab_1 .header-color option:selected").val()+'&tcolor='+$(this).val()+'" style="width: 100%; overflow: hidden;scroll-behavior: unset;height: 525px;border: unset;"></iframe>');
});  
$('#tab_1 .ticker-iframe').attr('src', '{{ makeUrl("widget/ticker") }}?hcolor=000000&tcolor=ffffff');
$('#tab_1  textarea').html('<iframe src="{{ makeUrl("widget/ticker") }}?hcolor=000000&tcolor=ffffff" style="width: 100%; overflow: hidden;scroll-behavior: unset;height: 525px;border: unset;"></iframe>');

/**
 * Single coin price ticker
 */
$('#tab_2 .header-color').change(function() {
    $('#tab_2 .price-ticker-iframe').attr('src', '{{ makeUrl("widget/ticker") }}/'+$("#tab_2 .crypto-coin option:selected").val()+'?hcolor='+$(this).val()+'&tcolor='+$("#tab_2 .text-color option:selected").val());
    $('#tab_2 textarea').html('<iframe src="{{ makeUrl("widget/ticker") }}/'+$("#tab_2 .crypto-coin option:selected").val()+'?hcolor='+$(this).val()+'&tcolor='+$("#tab_2 .text-color option:selected").val()+'" style="width: 100%; overflow: hidden;scroll-behavior: unset;height: 525px;border: unset;"></iframe>');
});
$('#tab_2 .text-color').change(function() {
    $('#tab_2 .price-ticker-iframe').attr('src', '{{ makeUrl("widget/ticker") }}/'+$("#tab_2 .crypto-coin option:selected").val()+'?hcolor='+$("#tab_2 .header-color option:selected").val()+'&tcolor='+$(this).val());    
    $('#tab_2 textarea').html('<iframe src="{{ makeUrl("widget/ticker") }}/'+$("#tab_2 .crypto-coin option:selected").val()+'?hcolor='+$("#tab_2 .header-color option:selected").val()+'&tcolor='+$(this).val()+'" style="width: 100%; overflow: hidden;scroll-behavior: unset;height: 525px;border: unset;"></iframe>');
});
$('#tab_2 .crypto-coin').change(function() {
    $('#tab_2 .price-ticker-iframe').attr('src', '{{ makeUrl("widget/ticker") }}/'+$(this).val()+'?hcolor='+$("#tab_2 .header-color option:selected").val()+'&tcolor='+$("#tab_2 .text-color option:selected").val());    
    $('#tab_2 textarea').html('<iframe src="{{ makeUrl("widget/ticker") }}/'+$(this).val()+'?hcolor='+$("#tab_2 .header-color option:selected").val()+'&tcolor='+$("#tab_2 .text-color option:selected").val()+'" style="width: 100%; overflow: hidden;scroll-behavior: unset;height: 525px;border: unset;"></iframe>');
});
$('#tab_2 .price-ticker-iframe').attr('src', '{{ makeUrl("widget/ticker/BTC") }}?hcolor=000000&tcolor=ffffff');
$('#tab_2 textarea').html('<iframe src="{{ makeUrl("widget/ticker/BTC") }}?hcolor=000000&tcolor=ffffff" style="width: 100%; overflow: hidden;scroll-behavior: unset;height: 525px;border: unset;"></iframe>');
</script>
@stop
@section('styles')
<style type="text/css">
textarea{z-index: auto; position: relative; line-height: 20px; font-size: 14px; transition: none; background: transparent !important;}
.ticker-iframe, .price-ticker-iframe, .dominance-iframe {width: 100%; overflow: hidden;scroll-behavior: unset;height: 550px;border: unset;}
</style>
@stop
@section('content')
<div class="row">
    <div class="col-md-12">
      <div class="ui segment coins_page_headings">
          <div class="ui teal large ribbon label"><i class="tag icon"></i></div>
          <h1>@lang('menu.WIDGETS')</h1>
      </div>
      <div class="nav-tabs-custom">
        <ul class="nav nav-tabs">
          <li class="active"><a href="#tab_1" data-toggle="tab">@lang('widgets.TICKER')</a></li>
          <li><a href="#tab_2" data-toggle="tab">@lang('widgets.SINGLE_TICKER')</a></li>
          <li><a href="#tab_3" data-toggle="tab">@lang('widgets.DONUT_CHART')</a></li>
        </ul>
        <div class="tab-content" style="padding-top: 10px;">
          <div class="tab-pane active" id="tab_1">
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                      <label>@lang('widgets.TABLE_HEADER_COLOR')</label>
                      <select class="form-control header-color">
                        <option value="111111">@lang('widgets.BLACK')</option>
                        <option value="d2d6de">@lang('widgets.GRAY')</option>
                        <option value="3c8dbc">@lang('widgets.BLUE')</option>
                        <option value="f56954">@lang('widgets.RED')</option>
                        <option value="00a65a">@lang('widgets.GREEN')</option>
                        <option value="605ca8">@lang('widgets.PURPLE')</option>
                        <option value="D81B60">@lang('widgets.MAROON')</option>
                      </select>
                    </div>
                    <div class="form-group">
                      <label>@lang('widgets.TEXT_COLOR')</label>
                      <select class="form-control text-color">
                        <option value="ffffff">@lang('widgets.WHITE')</option>
                        <option value="000000">@lang('widgets.BLACK')</option>
                        <option value="d2d6de">@lang('widgets.GRAY')</option>
                      </select>
                    </div>
                    <div class="form-group">
                      <label>@lang('widgets.TICKER_INSTRUCTION')</label>
                      <textarea class="form-control" rows="6"></textarea>
                    </div>                    
                </div>
                <div class="col-md-8">
                    <iframe src="" class="ticker-iframe"></iframe>
                </div>
              </div>
          </div>
          <div class="tab-pane" id="tab_2">
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                      <label>@lang('widgets.TABLE_HEADER_COLOR')</label>
                      <select class="form-control header-color">
                        <option value="111111">@lang('widgets.BLACK')</option>
                        <option value="d2d6de">@lang('widgets.GRAY')</option>
                        <option value="3c8dbc">@lang('widgets.BLUE')</option>
                        <option value="f56954">@lang('widgets.RED')</option>
                        <option value="00a65a">@lang('widgets.GREEN')</option>
                        <option value="605ca8">@lang('widgets.PURPLE')</option>
                        <option value="D81B60">@lang('widgets.MAROON')</option>
                      </select>
                    </div>
                    <div class="form-group">
                      <label>@lang('widgets.TEXT_COLOR')</label>
                      <select class="form-control text-color">
                        <option value="ffffff">@lang('widgets.WHITE')</option>
                        <option value="000000">@lang('widgets.BLACK')</option>
                        <option value="d2d6de">@lang('widgets.GRAY')</option>
                      </select>
                    </div>
                    <div class="form-group">
                      <label>@lang('widgets.SELECT_COIN')</label>
                      <select class="form-control crypto-coin">
                        @foreach($coins as $coin)
                        <option value="{{ $coin->symbol }}">{{ $coin->symbol }}</option>
                        @endforeach
                      </select>
                    </div>
                    <div class="form-group">
                      <label>@lang('widgets.TICKER_INSTRUCTION')</label>
                      <textarea class="form-control" rows="6"></textarea>
                    </div>                    
                </div>
                <div class="col-md-8">
                    <iframe src="" class="price-ticker-iframe"></iframe>
                </div>
            </div>
          </div>
          <div class="tab-pane" id="tab_3">
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                      <label>@lang('widgets.DONUT_INSTRUCTION')</label>
                      <textarea class="form-control" rows="6"><iframe src="{{ makeUrl("widget/dominance-chart") }}" style="width: 100%; overflow: hidden;scroll-behavior: unset;height: 525px;border: unset;"></iframe></textarea>
                    </div>                    
                </div>
                <div class="col-md-8">
                    <iframe src="{{ makeUrl('widget/dominance-chart') }}" class="dominance-iframe"></iframe>
                </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@stop
