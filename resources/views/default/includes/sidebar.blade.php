<div class="navbar-default sidebar" role="navigation">
    <div class="sidebar-nav navbar-collapse collapse">
        <ul class="nav" id="side-menu">
            <li>
                <a href="{{ makeUrl('/dashboard') }}" class="@if(Request::is('*/')) active @endif">
                    <i class="fa fa-dashboard fa-fw"></i> @lang('menu.DASHBOARD')
                </a>
            </li>
            <li>
                <a href="{{ makeUrl('currencies') }}" @if(Request::is('/currencies')) class="active" @endif>
                    <i class="fa fa-video-camera fa-fw"></i> @lang('menu.COINS_LIVE_WATCH')
                </a>
            </li>
            <li>
                <a href="{{ makeUrl('top-gainers-crypto-currencies') }}" @if(Request::is('/top-gainers-crypto-currencies')) class="active" @endif>
                    <i class="fa fa-long-arrow-up fa-fw" style="color: green";></i> @lang('menu.TOP_GAINERS')
                </a>
            </li>
            <li>
                <a href="{{ makeUrl('top-losers-crypto-currencies') }}" @if(Request::is('/top-losers-crypto-currencies')) class="active" @endif>
                    <i class="fa fa-long-arrow-down fa-fw" style="color: red;"></i> @lang('menu.TOP_LOSERS')
                </a>
            </li>
            <li>
                <a href="{{ makeUrl('high-low-crypto-currencies') }}" @if(Request::is('/high-low-crypto-currencies')) class="active" @endif>
                    <i class="fa fa-flash fa-fw"></i> @lang('menu.HIGH_LOW_COINS')
                </a>
            </li>
            <li>
                <a href="{{ makeUrl('crypto-exchanges') }}" @if(Request::is('/crypto-exchanges')) class="active" @endif>
                    <i class="fa fa-exchange fa-fw"></i> @lang('menu.EXCHANGES')
                </a>
            </li>
            <li>
                <a href="{{ makeUrl('crypto-coins-news-headlines') }}" @if(Request::is(['*/crypto-coins-news-headlines', '*/crypto-news/*'])) class="active" @endif>
                    <i class="fa fa-newspaper-o fa-fw"></i> @lang('menu.NEWS')
                </a>
            </li>
            <li>
                <a href="{{ makeUrl('blog') }}" @if(Request::is('*/blog')) class="active" @endif>
                    <i class="fa fa-fw fa-slack"></i> @lang('menu.BLOG')
                </a>
            </li>
            <li>
                <a href="{{ makeUrl('crypto-ico') }}" @if(Request::is('/crypto-ico')) class="active" @endif>
                    <i class="fa fa-certificate fa-fw"></i> @lang('menu.ACTIVE_ICOS')
                </a>
            </li>
            <li>
                <a href="{{ makeUrl('events') }}" @if(Request::is('/events')) class="active" @endif>
                    <i class="fa fa-bell-o fa-fw"></i> @lang('v7.EVENTS')
                </a>
            </li>
            <li>
                <a href="{{ makeUrl('wallets') }}" @if(Request::is('/wallets')) class="active" @endif>
                    <i class="fa fa-barcode fa-fw"></i> @lang('v7.WALLETS')
                </a>
            </li>
            <li>
                <a href="{{ makeUrl('mining-pools') }}" @if(Request::is('*/mining-pools')) class="active" @endif>
                    <i class="fa fa-filter fa-fw"></i> @lang('v5.MINING_POOLS')
                </a>
            </li>
            <li>
                <a href="{{ makeUrl('cryptocurrency-converter') }}" @if(Request::is('*/cryptocurrency-converter')) class="active" @endif>
                    <i class="fa fa-calculator fa-fw"></i> @lang('menu.CONVERTER')
                </a>
            </li>
            <li>
                <a href="{{ makeUrl('cryptocurrency-widgets') }}" @if(Request::is('*/cryptocurrency-widgets')) active @endif>
                    <i class="fa fa-th fa-fw"></i> @lang('menu.WIDGETS')
                </a>
            </li>
            <li>
                <a href="{{ makeUrl('buy-sell-cryptocoins') }}" @if(Request::is('*/buy-sell-cryptocoins')) class="active" @endif>
                    <i class="fa fa-random fa-fw"></i> @lang('menu.BUY_SELL')
                </a>
            </li>
            <li>
                <a href="{{ makeUrl('user/blockfolio') }}" @if(Request::is('*/blockfolio')) class="active" @endif>
                    <i class="fa fa-fw fa-bank"></i> @lang('user.USER_BLOCKFOLIO')
                </a>
            </li>
            <li>
                <a href="{{ makeUrl('user/favorites-coins') }}" @if(Request::is('*/favorites-coins')) class="active" @endif>
                    <i class="fa fa-fw fa-desktop"></i> @lang('user.FAVORITES_COINS')
                </a>
            </li>
            <li>
                <a href="{{ makeUrl('block-explorer') }}" @if(Request::is('*/block-explorer')) class="active" @endif>
                    <i class="fa fa-fw fa-spinner"></i> @lang('menu.BLOCKEXPLORER')
                </a>
            </li>
            <li>
                <a href="{{ makeUrl('crypto-mining-equipment') }}" @if(Request::is('*/crypto-mining-equipment')) class="active" @endif>
                    <i class="fa fa-database fa-fw"></i> @lang('menu.MINING_EQUIPMENT')
                </a>
            </li>
            <li>
                <a title="@lang('v7.ADVERTISE')" href="{{ makeUrl('advertise') }}" @if(Request::is('*/advertise')) class="active" @endif>
                    <i class="fa fa-desktop fa-fw"></i> <span>@lang('v7.ADVERTISE')</span>
                </a>
            </li>
            <li>
                <a title="@lang('v7.CONTACT_US')" href="{{ makeUrl('contact-us') }}" @if(Request::is('*/contact-us')) class="active" @endif>
                    <i class="fa fa-pencil fa-fw"></i> <span>@lang('v7.CONTACT_US')</span>
                </a>
            </li>
            @if(!Auth::user())
            <li><a href="{{ makeUrl('user/login') }}" @if(Request::is('*/user/login')) class="active" @endif><i class="fa-fw sign in alternate icon"></i> @lang('user.LOGIN') </a></li> 
            <li><a href="{{ makeUrl('user/register') }}" @if(Request::is('*/user/register')) class="active" @endif><i class="fa-fw add user icon"></i> @lang('user.REGISTER') </a></li> 
            @else
            <li><a href="{{ makeUrl('user/profile') }}" @if(Request::is('*/user/profile')) class="active" @endif><i class="fa-fw user icon"></i> @lang('user.PROFILE') </a></li> 
            <li><a href="{{ makeUrl('user/logout') }}" @if(Request::is('*/user/logout')) class="active" @endif><i class="fa-fw sign out alternate icon"></i> @lang('user.LOGOUT') </a></li> 
            @endif
            @foreach($pages as $page)
            <li>
                <a href="{{ makeUrl('page') }}/{{  $page->slug }}">
                    <i class="fa fa-angle-double-right fa-fw"></i> {{ $page->title }}
                </a>
            </li>
            @endforeach
        </ul>
    </div>
</div>