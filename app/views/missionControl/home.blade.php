@extends('templates.main')
@section('title', 'Mission Control')

@section('content')
<body class="missioncontrol" ng-app="missionControlApp" ng-controller="missionControlController">
    @include('templates.flashMessage')
    @include('templates.header')

    <div class="content-wrapper">
        <h1>@{{ pageTitle }}</h1>
        <main>
            <form>
                <search></search>
                <input type="submit" class="search" value="Search" ng-click="search()" ng-disabled="currentSearch == null || currentSearch.searchTerm == ''" />
                <input type="reset" value="Reset" ng-click="reset()" />
            </form>

            <section ng-show="activeSection == 'searchResults'">

            </section>

            <section ng-show="activeSection == 'missionControl'">
                <div class="grid-8">
                    <h2>Uploads - New | Hot | Top</h2>
                </div>

                <div class="grid-4">
                    <h2>Community Leaderboards</h2>
                </div>

                <h2>Recent Comments</h2>

                <h2>Recent Favorites</h2>
            </section>
        </main>
    </div>
</body>
@stop

