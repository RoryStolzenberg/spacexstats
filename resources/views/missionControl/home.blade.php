@extends('templates.main')
@section('title', 'Mission Control')

@section('content')
<body class="missioncontrol" ng-app="missionControlApp" ng-controller="missionControlController">

    @include('templates.header')

    <div class="content-wrapper">
        <h1>@{{ pageTitle }}</h1>
        <main>
            <form id="search">
                <search></search>
            </form>

            <section ng-show="activeSection == 'searchResults'">

            </section>

            <section ng-show="activeSection == 'missionControl'">
                <div class="gr-8">
                    <h2>Uploads</h2>
                    <ul>
                        <li>Latest</li>
                        <li>Hot</li>
                        <li></li>
                    </ul>
                </div>

                <div class="gr-4">
                    <h2>Community Leaderboards</h2>
                    <ul>
                        <li>Last Week</li>
                        <li>Last Month</li>
                        <li>Last Year</li>
                        <li>All Time</li>
                    </ul>
                </div>

                <div class="gr-4">
                    <h2>Recent Comments</h2>
                </div>

                <div class="gr-4">
                    <h2>Recent Favorites</h2>
                </div>

                <div class="gr-4">
                    <h2>Recent Downloads</h2>
                </div>
            </section>
        </main>
    </div>
</body>
@stop

