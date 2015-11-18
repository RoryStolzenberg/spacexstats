@extends('templates.main')
@section('title', 'Past Launches')

@section('content')
<body class="past-launches" ng-app="missionsListApp" ng-controller="missionsListController" ng-strict-di>


    @include('templates.header')

    <div class="content-wrapper">
        <h1>Past Launches</h1>
        <main>
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

            <form>
                <input type="text" ng-model="filter.name" placeholder="Filter by a launch name..." />
            </form>

            <h2 ng-repeat-start="mission in missions | filter:filter as search" ng-show="missions.indexOf(mission) == 0 && search.length == missions.length">Previous Launch</h2>
            <h2 ng-show="missions.indexOf(mission) == 1  && search.length == missions.length">More Missions</h2>
            <mission-card ng-repeat-end mission="mission" size="large"></mission-card>

            <p class="exclaim" ng-show="search.length = 0">No missions :(</p>
        </main>
    </div>
</body>
@stop