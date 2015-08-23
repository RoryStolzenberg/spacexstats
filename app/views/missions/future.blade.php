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
            <mission-card ng-repeat="mission in missions | filter:search" mission="mission" size="large"></mission-card>
        </main>
    </div>
</body>
@stop