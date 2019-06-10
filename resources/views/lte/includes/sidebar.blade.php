<section class="sidebar">
    <li class="ui search focus" style="list-style: none;">
        <div class="ui icon input sidebar-form">
          <input class="form-control prompt coin-search-input" type="text" placeholder="@lang('menu.SEARCH_COIN')" autocomplete="off"><i class="search icon"></i>
        </div>
    </li>
    <ul class="sidebar-menu" data-widget="tree">
        <li class="treeview @if(Request::is(['*/crypto-currencies', '*/top-gainers-crypto-currencies', '*/top-losers-crypto-currencies', '*/live-crypto-currencies-updates', '*/high-low-crypto-currencies'])) active @endif"">
            <a href="#">
                <i class="fa fa-money"></i>
                <span>@lang('menu.COINS')</span>
                <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
            </a>
            <ul class="treeview-menu">
                <li><a href="{{ makeUrl('currencies') }}"><i class="fa fa-video-camera"></i> @lang('menu.COINS_LIVE_WATCH')</a></li>
                <li><a href="{{ makeUrl('top-gainers-crypto-currencies') }}"><i class="fa fa-line-chart"></i> @lang('menu.TOP_GAINERS')</a></li>
                <li><a href="{{ makeUrl('top-losers-crypto-currencies') }}"><i class="fa fa-long-arrow-down"></i> @lang('menu.TOP_LOSERS')</a></li>
                <li><a href="{{ makeUrl('high-low-crypto-currencies') }}"><i class="fa fa-flash"></i> @lang('menu.HIGH_LOW_COINS')</a></li>
            </ul>
        </li>
        <li class="@if(Request::is('*/crypto-exchanges')) active @endif">
            <a href="{{ makeUrl('crypto-exchanges') }}">
                <i class="fa fa-exchange"></i> <span>@lang('menu.EXCHANGES')</span>
            </a>
        </li>
        <li class="@if(Request::is('*/crypto-ico')) active @endif">
            <a href="{{ makeUrl('crypto-ico') }}">
                <i class="fa fa-bullhorn"></i><span>@lang('menu.ICOS')</span>
            </a>
        </li>
        <li class="@if(Request::is('*/crypto-coins-news-headlines')) active @endif">
            <a href="{{ makeUrl('crypto-coins-news-headlines') }}">
                <i class="fa fa-newspaper-o"></i> <span>@lang('menu.NEWS')</span>
            </a>
        </li>
        <li class="@if(Request::is('*/blog')) active @endif">
            <a href="{{ makeUrl('blog') }}">
                <i class="fa fa-slack"></i> <span>@lang('menu.BLOG')</span>
            </a>
        </li>
        <li class="@if(Request::is('*/blockfolio')) active @endif">
            <a href="{{ makeUrl('user/blockfolio') }}">
                <i class="fa fa-bank"></i> <span>@lang('user.USER_BLOCKFOLIO')</span>
            </a>
        </li>
        <li class="@if(Request::is('*/favorites-coins')) active @endif">
            <a href="{{ makeUrl('user/favorites-coins') }}">
                <i class="fa fa-desktop"></i> <span>@lang('user.FAVORITES_COINS')</span>
            </a>
        </li>
        <li class="@if(Request::is('*/events')) active @endif">
            <a title="@lang('v7.EVENTS')" href="{{ makeUrl('events') }}">
                <i class="fa fa-bell-o"></i> <span>@lang('v7.EVENTS')</span>
            </a>
        </li>
        <li class="@if(Request::is('*/mining-pools')) active @endif">
            <a title="@lang('v5.MINING_POOLS')" href="{{ makeUrl('mining-pools') }}">
                <i class="fa fa-microchip"></i> <span>@lang('v5.MINING_POOLS')</span>
            </a>
        </li>
        <li class="@if(Request::is('*/wallets')) active @endif">
            <a title="@lang('v7.WALLETS')" href="{{ makeUrl('wallets') }}">
                <i class="fa fa-barcode"></i> <span>@lang('v7.WALLETS')</span>
            </a>
        </li>
        <li class="treeview @if(Request::is(Request::is(['*/cryptocurrency-converter', '*/cryptocurrency-widgets']))) active @endif"">
            <a href="#">
                <i class="fa fa-gear"></i>
                <span>@lang('menu.TOOLS')</span>
                <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
            </a>
            <ul class="treeview-menu">
                <li class="@if(Request::is('*/cryptocurrency-converter')) active @endif">
                    <a href="{{ makeUrl('cryptocurrency-converter') }}">
                        <i class="fa fa-calculator"></i> <span>@lang('menu.CONVERTER')</span>
                    </a>
                </li>
                <li class="@if(Request::is('*/cryptocurrency-widgets')) active @endif">
                    <a href="{{ makeUrl('cryptocurrency-widgets') }}">
                        <i class="fa fa-th"></i> <span>@lang('menu.WIDGETS')</span>
                    </a>
                </li>
                <li class="@if(Request::is('*/buy-sell-cryptocoins')) active @endif">
                    <a href="{{ makeUrl('buy-sell-cryptocoins') }}">
                        <i class="fa fa-random"></i> <span>@lang('menu.BUY_SELL')</span>
                    </a>
                </li>
                <li class="@if(Request::is('*/crypto-mining-equipment')) active @endif">
                    <a href="{{ makeUrl('crypto-mining-equipment') }}">
                        <i class="fa fa-database"></i> <span>@lang('menu.MINING_EQUIPMENT')</span>
                    </a>
                </li>
                <li class="@if(Request::is('*/block-explorer')) active @endif">
                    <a href="{{ makeUrl('block-explorer') }}">
                        <i class="fa fa-spinner"></i> <span>@lang('menu.BLOCKEXPLORER')</span>
                    </a>
                </li>
            </ul>
        </li>
        <li class="treeview @if(Request::is(Request::is(['*/page/*']))) active @endif">
            <a href="#">
                <i class="fa fa-cube"></i>
                <span>@lang('menu.MORE')</span>
                <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
            </a>
            <ul class="treeview-menu">
                <li>
                    <a title="@lang('v7.ADVERTISE')" href="{{ makeUrl('advertise') }}">
                        <i class="fa fa-desktop"></i> <span>@lang('v7.ADVERTISE')</span>
                    </a>
                </li>
                <li>
                    <a title="@lang('v7.CONTACT_US')" href="{{ makeUrl('contact-us') }}">
                        <i class="fa fa-pencil"></i> <span>@lang('v7.CONTACT_US')</span>
                    </a>
                </li>
                @foreach($pages as $page)
                <li class="@if(Request::is('*/page/*')) active @endif">
                    <a href="{{ makeUrl('page') }}/{{  $page->slug }}">
                        <i class="fa fa-angle-double-right"></i> <span>{{ $page->title }}</span>
                    </a>
                </li>
                @endforeach
            </ul>
        </li>
    </ul>
</section>