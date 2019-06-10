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
</span>
@endif
<div class="top-bar-data" style="height: 50px;">
  <div class="menu-top-new">
    <a title="@lang('menu.DASHBOARD')" href="{{ makeUrl('/dashboard') }}">@lang('menu.DASHBOARD')</a>
    <a title="@lang('v7.EVENTS')" href="{{ makeUrl('events') }}">@lang('v7.EVENTS') </a>
    <a title="@lang('v5.MINING_POOLS')" href="{{ makeUrl('mining-pools') }}">@lang('v5.MINING_POOLS')</a>
    <a title="@lang('v7.WALLETS')" href="{{ makeUrl('wallets') }}">@lang('v7.WALLETS')</a>
    <a title="@lang('v7.ADVERTISE')" href="{{ makeUrl('advertise') }}">@lang('v7.ADVERTISE')</a>
  </div>
  <span class="day-night-mode" @if(isset($_COOKIE['THEME_COLOR'])) @if($_COOKIE['THEME_COLOR'] == 'night') type="default" style="background-color: black; color: white;margin-top: -3px;" @else type="night" style="background-color: white; color: #337ab7;margin-top: -3px;" @endif @else type="night" style="background-color: white;margin-top: -3px;" @endif">
    <i class="fa fa-moon-o"></i>
  </span>
  <span class="dropdown user-account-settings" style="margin-top: -3px;margin-right: -2px;">
      <a class="dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="true"">
          <i class="fa fa-user fa-fw"></i> <i class="fa fa-caret-down"></i>
      </a>
      <ul class="dropdown-menu dropdown-user user-profile-ul">
          @if(!Auth::user())
          <li>
            <a href="{{ makeUrl('user/login') }}"><i class="fa fa-user fa-fw"></i> @lang('user.LOGIN')</a>
          </li>
          <li>
            <a href="{{ makeUrl('user/register') }}"><i class="fa fa-gear fa-fw"></i> @lang('user.REGISTER')</a>
          </li>
          <li>
              <a href="{{ makeUrl('user/blockfolio') }}"><i class="fa fa-bank fa-fw"></i> @lang('user.USER_BLOCKFOLIO')</a>
          </li>
          <li>
              <a href="{{ makeUrl('user/favorites-coins') }}"><i class="fa fa-desktop fa-fw"></i> @lang('user.FAVORITES_COINS')</a>
          </li>
          @else
          <li>
              <a><img class="img-responsive img-circle" src="{{ getProfileImage() }}" width="20" style="float: left;height: 20px;" /> &nbsp; @lang('user.HI'), {{ Auth::user()->name }}</a>
          </li>
          <li>
              <a href="{{ makeUrl('user/profile') }}"><i class="fa fa-user fa-fw"></i> @lang('user.PROFILE')</a>
          </li>
          <li>
              <a href="{{ makeUrl('user/blockfolio') }}"><i class="fa fa-bank fa-fw"></i> @lang('user.USER_BLOCKFOLIO')</a>
          </li>
          <li>
              <a href="{{ makeUrl('user/favorites-coins') }}"><i class="fa fa-desktop fa-fw"></i> @lang('user.FAVORITES_COINS')</a>
          </li>
          <li>
              <a href="{{ makeUrl('user/logout') }}"><i class="fa fa-sign-out fa-fw"></i> @lang('user.LOGOUT')</a>
          </li>
          @endif
      </ul>
  </span>
  <span class="top-bar-currencies-list" style="float: right;margin-top: -3px;">
    @include(getCurrentTemplate() . '.includes.currencies_list')
  </span>    
  @if(isset($global_data->total_market_cap_usd))
  <div class="ui label simple dropdown item new-top-bar-stats" tabindex="0">
    <span class="top-bar-market-cap" style="margin: 6px;display: block;">
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
  @endif
</div>