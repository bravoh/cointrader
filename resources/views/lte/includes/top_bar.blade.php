@if(isset($global_data->total_market_cap_usd) && !Request::is('*/dashboard') && Request::path() != LaravelLocalization::getCurrentLocale())
<style type="text/css">
.top-bar-wrapper-content{padding-bottom: 15px;}
.widget-user {border-top: 3px solid;}
</style>
<div class="row top-bar-wrapper ">
  <div class="col-md-12 col-md-offset-0 top-bar-wrapper-content">
    <div class="box box-widget widget-user table-heading-class">
      <div class="row">
        <div class="col-sm-3 border-right">
          <div class="description-block">
            <h5 class="description-header top-bar-market-cap">
              <span rel="{{ preg_replace('/[^0-9,.]/', '', str_replace(',', '', $global_data->total_market_cap_usd)) }}"></span>
            </h5>
            <span class="description-text">@lang('menu.MARKET_CAP')</span>
          </div>
        </div>
        <div class="col-sm-3 border-right">
          <div class="description-block">
            <h5 class="description-header top-bar-day-vol">
              <span rel="{{ preg_replace('/[^0-9,.]/', '', str_replace(',', '', $global_data->total_24h_volume_usd  )) }}"></span>
            </h5>
            <span class="description-text">@lang('menu.24h_VOLUME')</span>
          </div>
        </div>
        <div class="col-sm-3 border-right">
          <div class="description-block">
            <h5 class="description-header">{{ $total_markets }}</h5>
            <span class="description-text">@lang('menu.ACTIVE_CRYPTOCURRENCIES')</span>
          </div>
        </div>
        <div class="col-sm-3">
          <div class="description-block">
            <h5 class="description-header">{{ $global_data->active_markets }}</h5>
            <span class="description-text">@lang('menu.MARKETS')</span>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endif
