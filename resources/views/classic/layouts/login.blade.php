<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" itemscope itemtype=http://schema.org/Product>

<head>

	@include(getCurrentTemplate() . '.includes.header')

</head>

<body>

    <div class="body">

        <div class="">
        	@include(getCurrentTemplate() . '.includes.globals')@include(getCurrentTemplate() . '.includes.navbars')
    	</div>

        <div id="wrapper">

            <div class="center">

	            @include(getCurrentTemplate() . '.ads.header_ad')

	        </div>
	        
	        @include(getCurrentTemplate() . '.includes.top_bar')

	        <div id="page-wrapper">

	        	@yield('content')

	        </div>
	        
        </div>

    	@include(getCurrentTemplate() . '.ads.footer_ad')@include(getCurrentTemplate() . '.includes.footer')

	</div>
   
</body>

</html>