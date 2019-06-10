@if(isset($global_data->total_market_cap_usd) && !Request::is('*/dashboard') && Request::path() != LaravelLocalization::getCurrentLocale())
 <div class="ui four item borderless menu" style="margin-top: 0; padding-top: 0; padding-bottom: 0;">
  <div class="col-sm-3 border-right item">
   <i class="big dollar sign icon"></i>
   <div class="description-block">

    <div class="description-header top-bar-market-cap">
     <span rel="{{ preg_replace('/[^0-9,.]/', '', str_replace(',', '', $global_data->total_market_cap_usd)) }}"></span>
    </div>

    <span class="description-text">@lang('menu.MARKET_CAP')</span>
   </div>

  </div>
  <div class="col-sm-3 border-right item">
   <i class="big signal icon"></i>
   <div class="description-block">
    <div class="description-header top-bar-day-vol">
     <span rel="{{ preg_replace('/[^0-9,.]/', '', str_replace(',', '', $global_data->total_24h_volume_usd  )) }}"></span>
    </div><span class="description-text">@lang('menu.24h_VOLUME')</span>
   </div>
  </div>
  <div class="col-sm-3 border-right item">
   <i class="big chart pie icon"></i>
   <div class="description-block">
    <div class="description-header">{{ $total_markets }}</div>
    <span class="description-text">@lang('menu.ACTIVE_CRYPTOCURRENCIES')</span>
   </div>
  </div>
  <div class="col-sm-3 item">
   <i class="big balance scale icon"></i>
   <div class="description-header">{{ $global_data->active_markets }}</div>
   <span class="description-text">@lang('menu.MARKETS')</span>
  </div>
 </div>
 </div>
@endif