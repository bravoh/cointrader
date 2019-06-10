<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" itemscope itemtype="http://schema.org/Product">
<head>

    @include(getCurrentTemplate() . '.includes.header')

</head>
<body class="hold-transition @if(isset($_COOKIE['THEME_SKIN'])) @if($_COOKIE['THEME_SKIN'] != '') {{ $_COOKIE['THEME_SKIN'] }} @else {{ setting('site.template_color') }} @endif @else {{ setting('site.template_color') }} @endif sidebar-mini sidebar-collapse">

    <div class="wrapper">

        <header class="main-header">

            @include(getCurrentTemplate() . '.includes.topbar')
        
        </header>

        <aside class="main-sidebar">
       
            @include(getCurrentTemplate() . '.includes.sidebar')
        
        </aside>
        
        <div class="content-wrapper @if(Request::is('*/dashboard') || Request::path() == LaravelLocalization::getCurrentLocale()) dashboard-content-clsass @else content-wrapper-start @endif">

            @include(getCurrentTemplate() . '.includes.slider')

            @include(getCurrentTemplate() . '.includes.top_bar')
            
            @include(getCurrentTemplate() . '.ads.header_ad')

            @yield('content')

            @include(getCurrentTemplate() . '.ads.footer_ad')

        </div>

        <aside class="control-sidebar control-sidebar-light">

            @include(getCurrentTemplate() . '.includes.right-sidebar')    

        </aside>

        @include(getCurrentTemplate() . '.includes.footer')
        
        <div class="control-sidebar-bg"></div>

    </div>

</body>
</html>
