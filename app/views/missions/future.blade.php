@extends('templates.main')
@section('title', 'Future Launches')

@section('content')
<body class="future-launches" ng-app="missionsApp" ng-controller="missionsController" ng-strict-di>

    @include('templates.flashMessage')
    @include('templates.header')

    <div class="content-wrapper">
        <h1>Future Launches</h1>
        <main>
            <p>Browse all upcoming SpaceX launches &amp; missions here.</p>

            <p>Filter a launch: <input type="text" ng-model="search.name" /></p>

            <h2 ng-repeat-start="mission in missions | filter:search" ng-if="missions.indexOf(mission) == 0">Next Launch</h2>
            <h2 ng-if="missions.indexOf(mission) == 1">More Missions</h2>
            <mission-card ng-repeat-end mission="mission" size="large"></mission-card>
        </main>
    </div>
</body>
@stop