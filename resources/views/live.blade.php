@extends('templates.main')
@section('title', 'Live')

@section('content')
    <body class="live" ng-controller="liveController" ng-strict-di>
    <!-- Custom Header -->
    <div class="content-wrapper">
        <h1>SpaceX Stats Live</h1>
        <main>
            <nav class="sticky-bar">
                <ul class="container">
                    <li class="gr-1">Stuff</li>
                </ul>
            </nav>
            <section class="highlights">
            </section>
            <section>
            </section>
        </main>
    </div>

        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/1.3.7/socket.io.js"></script>
    </body>
@stop