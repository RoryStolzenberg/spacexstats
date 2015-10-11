@extends('templates.main')
@section('title', 'Past Launches')

@section('content')
<body class="past-launches" ng-app="missionsListApp" ng-controller="missionsListController" ng-strict-di>


    @include('templates.header')

    <div class="content-wrapper">
        <h1>Past Launches</h1>
        <main>
            <p>Browse all past launches here</p>
            <h2>Previous Launch</h2>
            <p>Detailed previous launch, reddit discussion thread, article, etc etc</p>
            <p>Have a "ribbon/badge beneath upcoming/previous launch count</p>
            <h2>Past Launches</h2>
            <p>Every other launch</p>

            <p>Browse all the previous SpaceX launches &amp; missions here! The last launch was @{{ lastLaunch().name }}. SpaceX has completed
                <ng-pluralize
                        count="missionsInYear(currentYear(), 'Complete')"
                        when="{
                        'one': '1 mission',
                        'other': '{} missions'
                     }">
                </ng-pluralize> in @{{ currentYear() }} so far, and  completed
                <ng-pluralize
                        count="missionsInYear(currentYear() - 1, 'Complete')"
                        when="{
                        'one': '1 mission',
                        'other': '{} missions'
                     }">
                </ng-pluralize> in @{{ currentYear() - 1 }}.</p>

            <p>Filter a launch: <input type="text" ng-model="x.name" placeholder="Type a launch name here" /></p>

            <h2 ng-repeat-start="mission in missions | filter:x as search" ng-show="missions.indexOf(mission) == 0 && search.length == missions.length">Next Launch</h2>
            <h2 ng-show="missions.indexOf(mission) == 1  && search.length == missions.length">More Missions</h2>
            <mission-card ng-repeat-end mission="mission" size="large"></mission-card>
        </main>
    </div>
</body>
@stop