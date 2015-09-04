@extends('templates.main')
@section('title', 'Future Launches')

@section('content')
<body class="future-launches" ng-app="missionsListApp" ng-controller="missionsListController" ng-strict-di>

    @include('templates.flashMessage')
    @include('templates.header')

    <div class="content-wrapper">
        <h1>Future Launches</h1>
        <main>
            <p>Browse all upcoming SpaceX launches &amp; missions here! The next launch is [[ nextLaunch().name ]]. SpaceX has [[ missionsInYear(currentYear(), "Upcoming") ]] launches remaining in [[ currentYear() ]], and is scheduled to launch [[ missionsInYear(currentYear() + 1, "Upcoming") ]] missions in [[ currentYear() + 1 ]].</p>

            <p>Filter a launch: <input type="text" ng-model="x.name" placeholder="Type a launch name here" /></p>

            <h2 ng-repeat-start="mission in missions | filter:x as search" ng-show="missions.indexOf(mission) == 0 && search.length == missions.length">Next Launch</h2>
            <h2 ng-show="missions.indexOf(mission) == 1  && search.length == missions.length">More Missions</h2>
            <mission-card ng-repeat-end mission="mission" size="large"></mission-card>
        </main>
    </div>
</body>
@stop