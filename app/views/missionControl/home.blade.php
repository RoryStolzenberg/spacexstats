@extends('templates.main')
@section('title', 'Mission Control')

@section('content')
<body class="missioncontrol" ng-app="missionControlApp" ng-controller="missionControlController">
    @include('templates.flashMessage')
    @include('templates.header')

    <div class="content-wrapper">
        <h1>Mission Control</h1>
        <main>
            <form method="GET" action="/missioncontrol/search">
                <input type="search" placeholder="Search..." />
                <input type="submit" value="Search" />
            </form>

            <div class="grid-8">
                <h2>Uploads - New | Hot | Top</h2>
            </div>

            <div class="grid-4">
                <h2>Community Leaderboards</h2>
            </div>

            <h2>Recent Comments</h2>

            <h2>Recent Favorites</h2>
            <tags available-tags="tags" selected-tags="selectedTags"></tags>
        </main>
    </div>
</body>
@stop

