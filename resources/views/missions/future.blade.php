@extends('templates.main')
@section('title', 'Future Launches')

@section('content')
<body class="future-launches" ng-controller="missionsListController" ng-strict-di>


    @include('templates.header')

    <div class="content-wrapper">
        <h1>Future Launches</h1>
        <main>
            <p>Browse all upcoming SpaceX launches &amp; missions here! The next launch is @{{ nextLaunch().name }}. SpaceX has @{{ missionsInYear(currentYear(), "Upcoming") }} launches remaining in @{{ currentYear() }}, and is scheduled to launch @{{ missionsInYear(currentYear() + 1, "Upcoming") }} missions in @{{ currentYear() + 1 }}.</p>

            <form>
                <input type="text" ng-model="filter.name" placeholder="Filter by a launch name..." />
            </form>

            <section>
                <h2 ng-repeat-start="mission in missions | filter:filter as filteredMissions" ng-show="missions.indexOf(mission) == 0 && filteredMissions.length == missions.length">Next Launch</h2>
                <h2 ng-show="missions.indexOf(mission) == 1  && filteredMissions.length == missions.length">After That</h2>
                <mission-card ng-repeat-end mission="mission" size="large"></mission-card>

                <p class="exclaim" ng-show="filteredMissions.length == 0">No missions :(</p>
            </section>
        </main>
    </div>
</body>
@stop