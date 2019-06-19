<ul class="nav navbar-top-links">
{{--    <li>--}}
{{--        <a title="All Coin" href="{{ makeUrl('currencies') }}" @if(Request::is( '*/currencies')) class="active" @endif>--}}
{{--            <i class="fa fa-money fa-fw"></i><br />Currencies--}}
{{--        </a>--}}
{{--    </li>--}}
    <li>
        <a title="@lang('menu.EXCHANGES') " href="{{ makeUrl('crypto-exchange') }}" @if(Request::is( '/crypto-exchange')) class="active" @endif>
            <i class="fa fa-exchange fa-fw"></i><br />
            @lang('menu.EXCHANGE')
        </a>
    </li>
    <li>
        <a title="@lang('menu.EXCHANGES') " href="{{ makeUrl('tbc-exchange') }}" @if(Request::is( '/tbc-exchange')) class="active" @endif>
            <i class="fa fa-exchange fa-fw"></i><br />
            TBC Exchange
        </a>
    </li>
{{--    <li class="dropdown">--}}
{{--        <a title="" class="@if(Request::is(Request::is(['*/crypto-ico', '*/crypto-ico/*']))) active @endif" href="{{ makeUrl('crypto-ico') }}">--}}
{{--            <i class="fa fa-bullhorn fa-fw"></i><br />--}}
{{--            @lang('menu.ICOS')--}}
{{--        </a>--}}
{{--    </li>--}}
{{--    <li>--}}
{{--        <a title="@lang('menu.NEWS') " href="{{ makeUrl('crypto-coins-news-headlines') }}" @if(Request::is([ '*/crypto-coins-news-headlines', '*/crypto-news/*'])) class="active" @endif>--}}
{{--            <i class="fa fa-newspaper-o fa-fw"></i><br />@lang('menu.NEWS') </a>--}}
{{--    </li>--}}
    <li>
        <a title="@lang('menu.BLOG')" href="{{ makeUrl('blog') }}" @if(Request::is( '*/blog')) class="active" @endif>
            <i class="fa fa-slack fa-fw"></i><br /> @lang('menu.BLOG')</a>
    </li>
{{--    <li>--}}
{{--        <a title="@lang('user.USER_BLOCKFOLIO')" href="{{ makeUrl('user/blockfolio') }}" @if(Request::is([ '*/blockfolio'])) class="active" @endif>--}}
{{--            <i class="fa fa-bank fa-fw"></i><br />@lang('user.USER_BLOCKFOLIO') </a>--}}
{{--    </li>--}}
{{--    <li>--}}
{{--        <a title="@lang('user.FAVORITES_COINS')" href="{{ makeUrl('user/favorites-coins') }}" @if(Request::is([ '*/favorites-coins'])) class="active" @endif>--}}
{{--            <i class="fa fa-desktop fa-fw"></i><br />@lang('user.FAVORITES_COINS')--}}
{{--        </a>--}}
{{--    </li>--}}
{{--    <li class="dropdown">--}}
{{--        <a title="" class="dropdown-toggle @if(Request::is(Request::is(['*/cryptocurrency-converter', '*/cryptocurrency-widgets', '*/buy-sell-cryptocoins', '*/crypto-mining-equipment', '*/page/*', '*/block-explorer']))) active @endif" data-toggle="dropdown" href="#">--}}
{{--            <i class="fa fa-gears fa-fw"></i><br />@lang('menu.TOOLS')<i class="fa fa-caret-down"></i>--}}
{{--        </a>--}}
{{--        <ul class="dropdown-menu">--}}
{{--            <li>--}}
{{--                <a title="@lang('menu.CONVERTER')" href="{{ makeUrl('cryptocurrency-converter') }}" @if(Request::is( '*/cryptocurrency-converter')) class="active" @endif>--}}
{{--                    <i class="fa fa-calculator fa-fw"></i> @lang('menu.CONVERTER') </a>--}}
{{--            </li>--}}
{{--            <li class="divider"></li>--}}
{{--            <li>--}}
{{--                <a title=" @lang('menu.WIDGETS')" href="{{ makeUrl('cryptocurrency-widgets') }}" @if(Request::is( '*/cryptocurrency-widgets')) active @endif>--}}
{{--                    <i class="fa fa-th fa-fw"></i> @lang('menu.WIDGETS')--}}
{{--                </a>--}}
{{--            </li>--}}
{{--            <li class="divider"></li>--}}
{{--            <li>--}}
{{--                <a title="@lang('menu.BUY_SELL')" href="{{ makeUrl('buy-sell-cryptocoins') }}" @if(Request::is( '*/buy-sell-cryptocoins')) class="active" @endif>--}}
{{--                    <i class="fa fa-random fa-fw"></i> @lang('menu.BUY_SELL')--}}
{{--                </a>--}}
{{--            </li>--}}
{{--            <li class="divider"></li>--}}
{{--            <li>--}}
{{--                <a title=" @lang('menu.MINING_EQUIPMENT')" href="{{ makeUrl('crypto-mining-equipment') }}" @if(Request::is( '*/crypto-mining-equipment')) class="active" @endif>--}}
{{--                    <i class="fa fa-database fa-fw"></i> @lang('menu.MINING_EQUIPMENT')--}}
{{--                </a>--}}
{{--            </li>--}}
{{--            <li class="divider"></li>--}}
{{--            <li style="float:none;padding:0">--}}
{{--                <a title="@lang('menu.BLOCKEXPLORER')" href="{{ makeUrl('block-explorer') }}" @if(Request::is( '*/block-explorer')) class="active" @endif>--}}
{{--                    <i class="fa fa-spinner fa-fw"></i>--}}
{{--                    @lang('menu.BLOCKEXPLORER') </a>--}}
{{--            </li>--}}
{{--            @foreach($pages as $page)--}}
{{--                <li class="divider"></li>--}}
{{--                <li style="float: unset;padding: unset;">--}}
{{--                    <a title="{{ $page->title }} " href="{{ makeUrl('page') }}/{{  $page->slug }}">--}}
{{--                        <i class="fa fa-angle-double-right fa-fw"></i>--}}
{{--                        {{ $page->title }} </a>--}}
{{--                </li>--}}
{{--            @endforeach--}}
{{--        </ul>--}}
{{--    </li>--}}
    <li class="ui search focus">
        <div class="ui icon input">
            <input class="prompt" type="text" placeholder="@lang('menu.SEARCH_COIN')..." autocomplete="off">
            <i class="search icon"></i>
        </div>
    </li>
</ul>