<ul class="nav navbar-top-links" style="display: none;border-bottom: 1px solid #ddd;">
    <li style="border-left: 1px solid #ccc;">
        <a class="@if(Request::is(['*/currencies'])) active @endif" href="{{ makeUrl('/currencies') }}">
            <i class="fa fa-money fa-fw"></i> <br />@lang('menu.COINS')
        </a>
    </li>
    <li>
        <a href="{{ makeUrl('crypto-exchanges') }}" @if(Request::is('/crypto-exchanges')) class="active" @endif>
            <i class="fa fa-exchange fa-fw"></i> <br />@lang('menu.EXCHANGES')
        </a>
    </li>
    <li>
        <a class="@if(Request::is(Request::is(['*/crypto-ico']))) active @endif" href="{{ makeUrl('crypto-ico') }}">
            <i class="fa fa-bullhorn fa-fw"></i> <br />@lang('menu.ICOS')
        </a>
    </li>
    <li>
        <a href="{{ makeUrl('crypto-coins-news-headlines') }}" @if(Request::is(['*/crypto-coins-news-headlines', '*/crypto-news/*'])) class="active" @endif>
            <i class="fa fa-newspaper-o fa-fw"></i> <br />@lang('menu.NEWS')
        </a>
    </li>
    <li>
        <a href="{{ makeUrl('blog') }}" @if(Request::is('*/blog')) class="active" @endif>
            <i class="fa fa-slack fa-fw"></i> <br />@lang('menu.BLOG')
        </a>
    </li>
    <li>
        <a href="{{ makeUrl('user/blockfolio') }}" @if(Request::is(['*/blockfolio'])) class="active" @endif>
            <i class="fa fa-bank"></i> <br />@lang('user.USER_BLOCKFOLIO')
        </a>
    </li>
    <li>
        <a href="{{ makeUrl('user/favorites-coins') }}" @if(Request::is(['*/favorites-coins'])) class="active" @endif>
            <i class="fa fa-desktop"></i> <br />@lang('user.FAVORITES_COINS')
        </a>
    </li>
    <li class="dropdown">
        <a class="dropdown-toggle @if(Request::is(Request::is(['*/cryptocurrency-converter', '*/cryptocurrency-widgets', '*/buy-sell-cryptocoins', '*/crypto-mining-equipment', '*/page/*', '*/block-explorer']))) active @endif" data-toggle="dropdown" href="#">
            <i class="fa fa-gears fa-fw"></i> <br />@lang('menu.TOOLS')<i class="fa fa-caret-down"></i>
        </a>
        <ul class="dropdown-menu">
            <li>
                <a href="{{ makeUrl('cryptocurrency-converter') }}" @if(Request::is('*/cryptocurrency-converter')) class="active" @endif>
                    <i class="fa fa-calculator fa-fw"></i> @lang('menu.CONVERTER')
                </a>
            </li>
            <li class="divider"></li>
            <li>
                <a href="{{ makeUrl('cryptocurrency-widgets') }}" @if(Request::is('*/cryptocurrency-widgets')) active @endif>
                    <i class="fa fa-th fa-fw"></i> @lang('menu.WIDGETS')
                </a>
            </li>
            <li class="divider"></li>
            <li>
                <a href="{{ makeUrl('buy-sell-cryptocoins') }}" @if(Request::is('*/buy-sell-cryptocoins')) class="active" @endif>
                    <i class="fa fa-random fa-fw"></i> @lang('menu.BUY_SELL')
                </a>
            </li>
            <li class="divider"></li>
            <li>
                <a href="{{ makeUrl('crypto-mining-equipment') }}" @if(Request::is('*/crypto-mining-equipment')) class="active" @endif>
                    <i class="fa fa-database fa-fw"></i> @lang('menu.MINING_EQUIPMENT')
                </a>
            </li>
            <li class="divider"></li>
            <li>
                <a href="{{ makeUrl('block-explorer') }}" @if(Request::is('*/block-explorer')) class="active" @endif>
                    <i class="fa fa-spinner fa-fw"></i> @lang('menu.BLOCKEXPLORER')
                </a>
            </li>
            @foreach($pages as $page) 
            <li class="divider"></li>
            <li style="float: unset;padding: unset;">
                <a title="{{ $page->title }} " href="{{ makeUrl('page') }}/{{  $page->slug }}">
                    <i class="fa fa-angle-double-right fa-fw"></i> {{ $page->title }} 
                </a>
            </li> 
            @endforeach
        </ul>
    </li>
    <li class="ui search focus" style="padding-left: 5px;margin-top: 16px;vertical-align: middle;float: right;">
        <div class="ui icon input">
          <input class="prompt" type="text" placeholder="@lang('menu.SEARCH_COIN')" autocomplete="off"><i class="search icon"></i>
        </div>
    </li>
</ul>