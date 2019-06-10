<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" itemscope itemtype="http://schema.org/Product">

<head>

    @include(getCurrentTemplate() . '.includes.header')

</head>

<body>
	
	@include(getCurrentTemplate() . '.includes.top_bar')

    <div id="wrapper">

        @include(getCurrentTemplate() . '.includes.navbars')

        <div id="page-wrapper" style="padding: 0 15px;">
            
            @yield('content')

        </div>

    </div>

    @include(getCurrentTemplate() . '.includes.footer')

</body>

</html>
