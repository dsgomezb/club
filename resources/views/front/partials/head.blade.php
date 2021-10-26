<meta charset="utf-8">
@hasSection('title')
	<title>@yield('title') -  {{ config('app.name') }}</title>
@else
	<title>{{ config('app.name') }}</title>
@endif
<meta name="_token" content="{{csrf_token()}}">
<!-- SEO Meta Tags-->
<meta name="description" content="@yield('description', 'Comunidad Fichap')">
<!-- Mobile Specific Meta Tag-->
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<!-- Favicon and Apple Icons-->
{{--
<link rel="icon" type="image/x-icon" href="/favicon.ico">
<link rel="icon" type="image/png" href="/favicon.png">
<link rel="apple-touch-icon" href="/touch-icon-iphone.png">
<link rel="apple-touch-icon" sizes="152x152" href="/touch-icon-ipad.png">
<link rel="apple-touch-icon" sizes="180x180" href="/touch-icon-iphone-retina.png">
<link rel="apple-touch-icon" sizes="167x167" href="/touch-icon-ipad-retina.png">
--}}
<!-- Vendor Styles including: Bootstrap, Font Icons, Plugins, etc.-->
<link rel="stylesheet" media="screen" href="/css/vendor.min.css">
<!-- Main Template Styles-->
<link rel="stylesheet" type="text/css" href="/summernote/summernote.min.css">
<link id="mainStyles" rel="stylesheet" media="screen" href="/css/styles.min.css">
<link id="mainStyles" rel="stylesheet" media="screen" href="/css/club.css">
<link id="mainStyles" rel="stylesheet" media="screen" href="/css/calendar.css">