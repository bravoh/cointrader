<nav class="navbar navbar-default navbar-static-top" role="navigation">
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>

        <div class="ui search focus mobile-search-bar">
            <img title="@lang('constants.WEBSITE_NAME') logo" alt="@lang('constants.WEBSITE_NAME') logo" src="{{ URL::asset('public/storage/') . '/' . setting('site.site_small_logo')  }}" height="40" width="40" class="mobile"/>
            <div class="ui icon input">
                <input class="prompt" type="text" placeholder="@lang('menu.SEARCH_COIN')..." autocomplete="off">
                <i class="search icon"></i>
            </div>
        </div>
    </div>
    @include(getCurrentTemplate() . '.includes.topbar')
    @include(getCurrentTemplate() . '.includes.sidebar')
    @include(getCurrentTemplate() . '.includes.slider')
</nav>
