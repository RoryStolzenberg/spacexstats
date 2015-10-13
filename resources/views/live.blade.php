@extends('templates.main')
@section('title', 'Live')

@section('content')
    <body class="live" ng-controller="liveController" ng-strict-di>
    <!-- Custom Header -->
    <div class="content-wrapper">
        <h1>SpaceX Stats Live</h1>
        <main>
            <section>
                <div ng-if="auth == true">
                    You are the launch controller.
                    <button ng-click="turnOnSpaceXStatsLive()">Turn it on</button>
                </div>
                <form>
                    <input type="text" ng-model="update.message" />
                    <input type="submit" ng-click="sendMessage()" />
                </form>
            </section>
        </main>
    </div>

        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/1.3.7/socket.io.js"></script>
    </body>
@stop