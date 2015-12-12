@extends('templates.main')
@section('title', 'Mission Control')

@section('content')
<body class="missioncontrol" ng-app="missionControlApp" ng-controller="missionControlController">

    @include('templates.header')

    <div class="content-wrapper">
        <h1>@{{ pageTitle }}</h1>
        <main>
            <div ng-controller="searchController">
                <form id="search-form">
                    <search></search>
                </form>
                <section ng-show="isCurrentlySearching">
                    <p class="exclaim">Searching...</p>
                </section>

                <h2 ng-show="hasSearchResults">Results</h2>
                <section ng-show="hasSearchResults" class="search-results">
                    <p class="result-count">@{{ searchResults.hits.total }} results</p>
                    <p class="search-time">Search took: @{{ searchResults.took }} ms</p>
                    <p class="exclaim" ng-if="searchResults.hits.total == 0">
                        No results :(
                    </p>
                    <div ng-repeat="result in searchResults.hits.hits">
                        <object-card object="result._source"></object-card>
                    </div>
                </section>
            </div>

            <section id="missioncontrol" ng-show="!hasSearchResults && !isCurrentlySearching">
                <div class="gr-8 gr-12@small gr-12@medium">
                    <h2>Mission Control</h2>
                    <ul class="in-page container missioncontrol-views">
                        <li class="gr-3" ng-class="{ 'active': missioncontrol.objects.visibleSection == 'latest' }" ng-click="missioncontrol.objects.show('latest')">Latest</li>
                        <li class="gr-3" ng-class="{ 'active': missioncontrol.objects.visibleSection == 'hot' }" ng-click="missioncontrol.objects.show('hot')">Hot</li>
                        <li class="gr-3" ng-class="{ 'active': missioncontrol.objects.visibleSection == 'discussions' }" ng-click="missioncontrol.objects.show('discussions')">Discussions</li>
                        @if ($upcomingMission)
                            <li class="gr-3" ng-class="{ 'active': missioncontrol.objects.visibleSection == 'mission' }" ng-click="missioncontrol.objects.show('mission')">From {{ $upcomingMission->name }}</li>
                        @endif
                    </ul>

                    <div ng-show="missioncontrol.objects.visibleSection == 'latest'">
                        @foreach($objects['latest'] as $latest)
                            @include('templates.cards.objectCard', ['object' => $latest])
                        @endforeach
                    </div>

                    <div ng-show="missioncontrol.objects.visibleSection == 'hot'">
                        @foreach($objects['hot'] as $hot)
                            @include('templates.cards.objectCard', ['object' => $hot])
                        @endforeach
                    </div>

                    <div ng-show="missioncontrol.objects.visibleSection == 'discussions'">
                        @foreach($objects['discussions'] as $discussions)
                            @include('templates.cards.objectCard', ['object' => $discussions])
                        @endforeach
                    </div>

                    @if ($upcomingMission)
                        <div ng-show="missioncontrol.objects.visibleSection == 'mission'">
                            @foreach($objects['mission'] as $missions)
                                @include('templates.cards.objectCard', ['object' => $missions])
                            @endforeach
                        </div>
                    @endif
                </div>

                <div class="gr-4 gr-12@small gr-12@medium">
                    <h2>Community Leaderboards</h2>
                    <ul class="in-page container missioncontrol-views">
                        <li class="gr-3" ng-class="{ 'active': missioncontrol.leaderboards.visibleSection == 'week' }" ng-click="missioncontrol.leaderboards.show('week')">Last Week</li>
                        <li class="gr-3" ng-class="{ 'active': missioncontrol.leaderboards.visibleSection == 'month' }" ng-click="missioncontrol.leaderboards.show('month')">Last Month</li>
                        <li class="gr-3" ng-class="{ 'active': missioncontrol.leaderboards.visibleSection == 'year' }" ng-click="missioncontrol.leaderboards.show('year')">Last Year</li>
                        <li class="gr-3" ng-class="{ 'active': missioncontrol.leaderboards.visibleSection == 'alltime' }" ng-click="missioncontrol.leaderboards.show('alltime')">All Time</li>
                    </ul>

                    <div ng-show="missioncontrol.leaderboards.visibleSection == 'week'">
                        @foreach($leaderboards['week'] as $leader)
                        @endforeach
                    </div>

                    <div ng-show="missioncontrol.leaderboards.visibleSection == 'month'">
                        @foreach($leaderboards['month'] as $leader)
                        @endforeach
                    </div>

                    <div ng-show="missioncontrol.leaderboards.visibleSection == 'year'">
                        @foreach($leaderboards['year'] as $leader)
                        @endforeach
                    </div>

                    <div ng-show="missioncontrol.leaderboards.visibleSection == 'alltime'">
                        @foreach($leaderboards['alltime'] as $leader)
                        @endforeach
                    </div>
                </div>

                <div class="gr-6 gr-12@small">
                    <h2>Recent Collections</h2>
                </div>

                <div class="gr-6 gr-12@small">
                    <h2>Random Uploads</h2>
                    @foreach($objects['random'] as $randomObject)
                        @include('templates.cards.objectCard', ['object' => $randomObject])
                    @endforeach
                </div>

                <div class="gr-4 gr-6@medium gr-12@small">
                    <h2>Recent Comments</h2>
                    @foreach($comments as $comment)
                    @endforeach
                </div>

                <div class="gr-4 gr-6@medium gr-12@small">
                    <h2>Recent Favorites</h2>
                    @foreach($favorites as $favorite)
                    @endforeach
                </div>

                <div class="gr-4 gr-6@medium gr-12@small">
                    <h2>Recent Downloads</h2>
                    @foreach($downloads as $download)
                    @endforeach
                </div>
            </section>
        </main>
    </div>
</body>
@stop

