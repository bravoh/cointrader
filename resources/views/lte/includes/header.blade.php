<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

<title>@yield('meta_title') | @lang('constants.WEBSITE_NAME')</title>
<meta name="description" content="@yield('meta_desc')">

<meta itemprop="name" content="@yield('meta_title')">
<meta itemprop="description" content="@yield('meta_desc')">
<meta itemprop="image" content="@yield('meta_image')">

<meta name="twitter:card" content="summary">
<meta name="twitter:site" content="{{ env('SITE_URL') }}">
<meta name="twitter:title" content="@yield('meta_title')">
<meta name="twitter:description" content="@yield('meta_desc')">
<meta name="twitter:image" content="@yield('meta_image')">

<meta property="og:url" content="@yield('meta_link')" />
<meta property="og:type" content="article" />
<meta property="og:title" content="@yield('meta_title')" />
<meta property="og:description" content="@yield('meta_desc')" />
<meta property="og:image" content="@yield('meta_image')" />
<meta property="og:site_name" content="{{ env('SITE_URL') }}" />
<meta property="og:image:width" content="1200">
<meta property="og:image:height" content="630">

<link rel="apple-touch-icon" sizes="180x180" href="{{ URL::asset('public/images/favicon/apple-touch-icon.png') }}">
<link rel="icon" type="image/png" sizes="32x32" href="{{ URL::asset('public/images/favicon/favicon-32x32.png') }}">
<link rel="icon" type="image/png" sizes="16x16" href="{{ URL::asset('public/images/favicon/favicon-16x16.png') }}">
<link rel="manifest" href="{{ URL::asset('public/images/favicon/site.webmanifest') }}">
<link rel="mask-icon" href="{{ URL::asset('public/images/favicon/safari-pinned-tab.svg') }}" color="#5bbad5">
<meta name="msapplication-TileColor" content="#da532c">
<meta name="theme-color" content="#ffffff">

<meta name="csrf-token" content="{{ csrf_token() }}" />

<link rel="canonical" href="{{ Request::url() }}" />

@foreach($available_languages as $language)
@if(LaravelLocalization::getCurrentLocale() != $language->code)
<link rel="alternate" href="{{ str_replace('/'.LaravelLocalization::getCurrentLocale().'/', '/'.$language->code.'/', Request::url()) }}" hreflang="{{ $language->code }}" />
@endif
@endforeach
<link rel="alternate" href="{{ Request::url() }}" hreflang="x-default" />

<script type='application/ld+json'>{"@context":"https://schema.org","@type":"WebSite","@id":"{{ env('SITE_URL') }}/#website","url":"{{ env('SITE_URL') }}","name":"{{ setting('site.site_name') }}","potentialAction":{"@type":"SearchAction","target":"{{ env('SITE_URL') }}/?s={search_term_string}","query-input":"required name=search_term_string"}}</script>

<link rel="stylesheet" href="{{ URL::asset('public/bower_components/bootstrap/dist/css/bootstrap.min.css') }}">
<link rel="stylesheet" href="{{ URL::asset('public/bower_components/font-awesome/css/font-awesome.min.css') }}">
<link rel="stylesheet" href="{{ URL::asset('public/bower_components/Ionicons/css/ionicons.min.css') }}">
<link rel="stylesheet" href="{{ URL::asset('public/dist/css/AdminLTE.min.css') }}">
<link rel="stylesheet" href="{{ URL::asset('public/dist/css/skins/_all-skins.min.css') }}">
<link href="{{ URL::asset('public/css/semantic-ui/semantic.min.css') }}" rel="stylesheet">
<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
<link rel="stylesheet" href="{{ URL::asset('public/css/cookieconsent/cookieconsent.min.css') }}" />
<link rel="stylesheet" type="text/css" href="{{ URL::asset('public/dist/css/custom.css') }}">
<link rel="stylesheet" type="text/css" href="{{ URL::asset('public/css/scroll_top_button.css') }}">

@yield('styles')

@if(setting('ads.google_adsense') != 'N/A')
{!! setting('ads.google_adsense') !!}
@endif
@if(setting('3rdparty.google_analytics_tracking_id') != 'N/A')
<script async src="https://www.googletagmanager.com/gtag/js?id={{ setting('3rdparty.google_analytics_tracking_id') }}"></script>
<script>
  	window.dataLayer = window.dataLayer || [];
  	function gtag(){dataLayer.push(arguments);}
  	gtag('js', new Date());
  	gtag('config', "{{ setting('3rdparty.google_analytics_tracking_id') }}");
</script>
@endif
<script>var APP_URL = "{{ URL::to('/') }}";</script>

