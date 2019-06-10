<a href="{{ URL::to('/') }}" class="logo" style="padding: unset;">
    <span class="logo-mini">
        <img 
            title="@lang('constants.WEBSITE_NAME')" 
            alt="@lang('constants.WEBSITE_NAME') logo" 
            src="{{ URL::asset('public/storage/') . '/' . setting('site.site_small_logo')  }}" height="40" width="40">
    </span>
    <span class="logo-lg">
        <img 
        title="@lang('constants.WEBSITE_NAME')" 
        alt="@lang('constants.WEBSITE_NAME') logo" 
        src="{{ URL::asset('public/storage/') . '/' . setting('site.logo')  }}" height="50" width="230" style="vertical-align: unset;">
    </span>
</a>
<nav class="navbar navbar-static-top">
    <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
    </a>
    <a href="{{ makeUrl('dashboard') }}" style="float: left;background-image: none;padding: 15px 15px;color: white;">
        Home
    </a>
    <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
            @include(getCurrentTemplate() . '.includes.available_languages')
            @include(getCurrentTemplate() . '.includes.currencies_list')
            <li class="dropdown user user-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    <img src="{{ getProfileImage() }}" class="user-image" alt="User Image">
                    <span class="hidden-xs">@lang('user.HI'),  @if(!Auth::user()) Guest @else {{ Auth::user()->name }} @endif</span>
                </a>
                <ul class="dropdown-menu">
                    <li class="user-header">
                        <img src="{{ getProfileImage() }}" class="img-circle" alt="User Image">
                        <p>
                            @if(!Auth::user())
                            Register / Login here to explore customize features.
                            @else
                            {{ Auth::user()->name }}
                            <small>Member since: {{ date("M, Y", strtotime(Auth::user()->created_at)) }}</small>
                            @endif
                        </p>
                    </li>
                    @if(!Auth::user())
                    <li class="user-footer">
                        <div class="pull-left">
                            <a href="{{ makeUrl('user/login') }}" class="btn btn-default btn-flat">@lang('user.LOGIN')</a>
                        </div>
                        <div class="pull-right">
                            <a href="{{ makeUrl('user/register') }}" class="btn btn-default btn-flat">@lang('user.REGISTER')</a>
                        </div>
                    </li>
                    @else
                    <li class="user-footer">
                        <div class="pull-left">
                            <a href="{{ makeUrl('user/profile') }}" class="btn btn-default btn-flat">@lang('user.PROFILE')</a>
                        </div>
                        <div class="pull-right">
                            <a href="{{ makeUrl('user/logout') }}" class="btn btn-default btn-flat">@lang('user.LOGOUT')</a>
                        </div>
                    </li>
                    @endif
                </ul>
            </li>
            @if(setting('site.show_color_gear'))
            <li>
                <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
            </li>
            @endif
        </ul>
    </div>
</nav>