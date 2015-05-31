<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<title>@yield('title') | SpaceX Stats</title>

    <!-- Iconography -->
    <link rel="apple-touch-icon" sizes="57x57" href="/apple-touch-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="/apple-touch-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="/apple-touch-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="/apple-touch-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="/apple-touch-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="/apple-touch-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="/apple-touch-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="/apple-touch-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon-180x180.png">
    <link rel="icon" type="image/png" href="/favicon-32x32.png" sizes="32x32">
    <link rel="icon" type="image/png" href="/favicon-194x194.png" sizes="194x194">
    <link rel="icon" type="image/png" href="/favicon-96x96.png" sizes="96x96">
    <link rel="icon" type="image/png" href="/android-chrome-192x192.png" sizes="192x192">
    <link rel="icon" type="image/png" href="/favicon-16x16.png" sizes="16x16">
    <link rel="manifest" href="/manifest.json">
    <meta name="apple-mobile-web-app-title" content="SpaceX Stats">
    <meta name="application-name" content="SpaceX Stats">
    <meta name="msapplication-TileColor" content="#ccac55">
    <meta name="msapplication-TileImage" content="/mstile-144x144.png">
    <meta name="theme-color" content="#ccac55">

    <!-- CSS -->
	{{ HTML::style('/assets/css/reset.styles.css') }}
	{{ HTML::style('/assets/css/font-awesome.css') }}
	{{ HTML::style('/assets/css/styles.css') }}

    <!-- JS -->
	{{ HTML::script('/assets/js/isAppleDevice.js') }}
	{{ HTML::script('/assets/js/jquery-1.9.1.js') }}
    {{ HTML::script('/assets/js/jquery-ui.min.js') }}
	{{ HTML::script('/assets/js/knockout-3.2.0.debug.js') }}
	{{ HTML::script('/assets/js/moment.js') }}
	{{ HTML::script('/assets/js/moment-timezone-with-data.js') }}
	{{ HTML::script('/assets/js/jstz-1.0.4.min.js') }}
	{{ HTML::script('/assets/js/sticky.js') }}
	{{ HTML::script('/assets/js/richSelect.js') }}
	{{ HTML::script('/assets/js/suggest.js') }}
	<script>
		$(document).ready(function() {
			var mobileNavigation = $('.nav-mobile');
			var contentToPush = $('body');

			$('i.toggleMobileNavigation').on('click', function() {
				console.log('click');
				contentToPush.toggleClass('nav-open');
			});
		});
	</script>
	<link href='http://fonts.googleapis.com/css?family=Noto+Sans' rel='stylesheet' type='text/css'>

	@yield('scripts')

</head>
<body class="@yield('bodyClass')">

@if (Session::has('flashMessage'))
    <p class="flash-message {{ Session::get('flashMessage.type') }}">{{ Session::get('flashMessage.contents') }}</p>
@endif

@include('templates.header')
@yield('content')
</body>
</html>