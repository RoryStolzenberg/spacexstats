<!DOCTYPE html>
<html lang="en" ng-app="app">
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
    <link rel="stylesheet" type="text/css" href="/css/styles.css" />

    <!-- JS -->
        <!-- jQuery& jQuery plugins -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
        <script src="//cdn.jsdelivr.net/stickynavbar.js/1.3.2/jquery.stickyNavbar.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-fracs/0.15.1/jquery.fracs.js"></script>

        <!-- Angular -->
        <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.4.7/angular.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/angular.js/1.4.7/angular-animate.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/angular-scroll/0.7.3/angular-scroll.js"></script>
        <script src="/js/angular-ui-tree.js"></script>

        <!-- Moment.js -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.6/moment.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment-timezone/0.4.0/moment-timezone-with-data.js"></script>

        <!-- d3.js -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/d3/3.5.6/d3.min.js"></script>

    <script src="/js/jstz-1.0.4.min.js"></script>
    <script src="/js/dropzone.js"></script>

        <!-- Frontend App -->
        <script src="/js/app.js"></script>
        <script src="/js/spacexstatsApp.js"></script>
    
        <script>
            $(document).ready(function() {
                // Mobile left hand side drawer
                var mobileNavigation = $('.nav-mobile');
                var contentToPush = $('body');

                $('i.toggleMobileNavigation').on('click', function() {
                    console.log('click');
                    contentToPush.toggleClass('nav-open');
                });

                // Stickybar
                $('nav.sticky-bar').stickyNavbar();

            });
        </script>

    <!-- Fonts -->
	<link href='https://fonts.googleapis.com/css?family=Noto+Sans' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Source+Code+Pro' rel='stylesheet' type='text/css'>
</head>
@yield('content')
</html>