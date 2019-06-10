<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">

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

<link href="{{ URL::asset('public/css/bootstrap/bootstrap.min.css') }}" rel="stylesheet">
<link href="{{ URL::asset('public/css/sb-admin-2.css') }}" rel="stylesheet">
<link href="{{ URL::asset('public/css/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">
<link href="{{ URL::asset('public/css/semantic-ui/semantic.min.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ URL::asset('public/css/cookieconsent/cookieconsent.min.css') }}" />
<link href="{{ URL::asset('public/css/default_template.css') }}" rel="stylesheet" />
<link rel="stylesheet" type="text/css" href="{{ URL::asset('public/css/scroll_top_button.css') }}">
<link rel="stylesheet" id="color-scheme-css" href="{{ URL::asset('public/css/color_schemes') }}/{{{ $_COOKIE['THEME_COLOR'] or 'default' }}}.css" />

@yield('styles')

<!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
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