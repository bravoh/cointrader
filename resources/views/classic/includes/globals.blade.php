<div class="top-triangle-social-bar">
  <div class="top-triangle-social-bar-content">
      <span style="float: left;text-align: left;">
        <a title="@lang('menu.DASHBOARD')" href="{{ makeUrl('/dashboard') }}">@lang('menu.DASHBOARD')</a>
        <a title="@lang('v7.EVENTS')" href="{{ makeUrl('events') }}">@lang('v7.EVENTS') </a>
        <a title="@lang('v5.MINING_POOLS')" href="{{ makeUrl('mining-pools') }}">@lang('v5.MINING_POOLS')</a>
        <a title="@lang('v7.WALLETS')" href="{{ makeUrl('wallets') }}">@lang('v7.WALLETS')</a>
        <a title="@lang('v7.ADVERTISE')" href="{{ makeUrl('advertise') }}">@lang('v7.ADVERTISE')</a>
      </span>
    <span style="float: right;margin-right: -10px;">
      @if(setting('social.facebook') != 'N/A')<a href="{{ setting('social.facebook') }}" target="_blank">Facebook</a>@endif
      @if(setting('social.twitter') != 'N/A')<a href="{{ setting('social.twitter') }}" target="_blank">Twitter</a>@endif
      @if(setting('social.telegram') != 'N/A')<a href="{{ setting('social.telegram') }}" target="_blank">Telegram</a>@endif
      @if(setting('social.reddit') != 'N/A')<a href="{{ setting('social.reddit') }}" target="_blank">Reddit</a>@endif
      @if(setting('social.youtube') != 'N/A')<a href="{{ setting('social.youtube') }}" target="_blank">Youtube</a>@endif
      </span>
  </div>
</div>
@if(isset($global_data->total_market_cap_usd))
  <span class="dropdown-global">
  <div class="ui label simple dropdown item" tabindex="0">
    <span class="top-bar-market-cap">
      <strong>@lang('menu.MARKET_CAP'):</strong> <span class="data" rel="{{ preg_replace('/[^0-9,.]/', '', str_replace(',', '', $global_data->total_market_cap_usd)) }}"></span>  <i class="dropdown icon"></i>
    </span>
    <div class="menu" tabindex="-1" style="z-index: 999999999999;border-radius: unset;">
      <div class="item info-label">
          <span class="top-bar-day-vol">
            <strong>@lang('menu.24h_VOLUME'):</strong> <span class="data" rel="{{ preg_replace('/[^0-9,.]/', '', str_replace(',', '', $global_data->total_24h_volume_usd)) }}"></span>
          </span>
      </div>
      <div class="item info-label">
        <strong>@lang('menu.ACTIVE_CRYPTOCURRENCIES'):</strong> <span class="data">{{ $total_markets }}</span>
      </div>
      <div class="item info-label">
        <strong>@lang('menu.MARKETS'):</strong> <span class="data">{{ $global_data->active_markets }}</span>
      </div>
    </div>
  </div>
  <span class="day-night-mode" @if(isset($_COOKIE['THEME_COLOR'])) @if($_COOKIE['THEME_COLOR'] == 'night') type="default" style="background-color: black; color: white;float: right;margin-top: unset!important;padding: 8px;height: 34px !important;" @else type="night" style="background-color: white; color: #337ab7;float: right;margin-top: unset!important;padding: 8px;height: 34px !important;" @endif @else type="night" style="background-color: white;float: right;margin-top: unset!important;padding: 8px;height: 34px !important;" @endif">
    <i class="fa fa-moon-o"></i>
  </span>
  </span>
@endif
<div class="top-bar-data ui attached segment" style="border-top: unset;border-left: unset;border-right: unset;padding: 1.5rem 1rem!important;">
  <a class="navbar-brand" title="@lang('constants.WEBSITE_NAME')" href="{{ URL::to('/') }}">
      <span class="logo-lg">
        <img title="@lang('constants.WEBSITE_NAME')" alt="@lang('constants.WEBSITE_NAME') logo" src="{{ URL::asset('public/storage/') . '/' . setting('site.logo')  }}" height="60">
      </span>
    <span class="logo-night">
        <img title="@lang('constants.WEBSITE_NAME')" alt="@lang('constants.WEBSITE_NAME') logo" src="{{ URL::asset('public/storage/') . '/' . setting('site.night_logo')  }}" height="60">
      </span>
  </a>
  <span class="top-bar-currencies-list">@include(getCurrentTemplate() . '.includes.currencies_list')</span>
  <div class="ui buttons classic-login-reg-buttons">
    @if(!Auth::user())
      <a href="{{ makeUrl( 'user/login') }}">
        <button class="ui button active logs bl" style="color: white;"><i class="sign in alternate icon" style="opacity: unset;"></i> @lang('user.LOGIN')</button>
      </a>
      <div class="or"></div>
      <a href="{{ makeUrl( 'user/register') }}">
        <button class="ui yellow button logs"style="color: white;"><i class="add user icon" style="opacity: unset;"></i> @lang('user.REGISTER')</button>
      </a>
    @else
      <a href="{{ makeUrl( 'user/profile') }}">
        <button class="ui button active logs bl"style="color: white;"><i class="user icon" style="opacity: unset;"></i> @lang('user.PROFILE')</button>
      </a>
      <div class="or"></div>
      <a href="{{ makeUrl( 'user/logout') }}">
        <button class="ui yellow button logs"style="color: white;"><i class="sign out alternate icon" style="opacity: unset;"></i>@lang('user.LOGOUT')</button>
      </a>
    @endif
  </div>
  <span class="day-night-mode classic-day-night" @if(isset($_COOKIE['THEME_COLOR'])) @if($_COOKIE['THEME_COLOR'] == 'night') type="default" style="background-color: black; color: white;" @else type="night" style="background-color: white; color: #337ab7" @endif @else type="night" style="background-color: white;" @endif">
  <i class="fa fa-moon-o"></i>
  </span>
</div>