@extends('templates.main')
@section('title', $mission->name)

@section('content')
    <body class="future-mission">
        @include('templates.flashMessage')
        @include('templates.header')

        <div class="content-wrapper" ng-app="futureMissionApp" ng-controller="futureMissionController" ng-strict-di>
            <h1>{{ $mission->name }}</h1>
            <main>
                <nav class="sticky-bar">
                    <ul class="container">
                        <li class="grid-1">Countdown</li>
                        <li class="grid-1">Details</li>
                        <li class="grid-1">Timeline</li>
                        @if (Auth::isSubscriber())
                            <li class="grid-1">Articles</li>
                        @endif

                        <li class="grid-2 prefix-3 actions">
                            @if (Auth::isAdmin())
                                <a href="/missions/{{$mission->slug}}/edit"><i class="fa fa-pencil"></i></a>
                            @endif
                            <i class="fa fa-twitter"></i>
                            @if (Auth::isMember())
                                <a href="/users/{{Auth::user()->username}}/edit#email-notifications"><i class="fa fa-envelope-o"></i></a>
                            @else
                                <a href="/docs#email-notifications"><i class="fa fa-envelope-o"></i></a>
                            @endif
                            <i class="fa fa-calendar"></i>
                            <a href="http://www.google.com/calendar/render?cid={{ Request::url() }}"><i class="fa fa-google"></i></a>
                            <i class="fa fa-rss"></i>
                        </li>
                        <li class="grid-1">{{ $mission->status }}</li>
                    </ul>
                </nav>

                <section class="highlights">
                    <div class="webcast-status" ng-class="webcast.status" ng-if="isLaunchExact == true" ng-show="webcast.status != 'webcast-inactive'">
                        <span>@{{ webcast.publicStatus }}</span><span class="live-viewers" ng-show="webcast.status === 'webcast-live'">@{{ webcast.publicViewers }}</span>
                    </div>

                    @if(isset($pastMission))
                        <div class="past-mission-link">
                            {{ link_to_route('missions.get', $pastMission->name, $pastMission->slug) }}
                            <span>Previous Mission</span>
                        </div>
                    @endif
                    @if(isset($futureMission))
                        <div class="future-mission-link">
                            {{ link_to_route('missions.get', $futureMission->name, $futureMission->slug) }}
                            <span>Next Mission</span>
                        </div>
                    @endif

                    <div ng-if="isLaunchExact == true" class="display-date-time">
                        <div class="launch">@{{ launchDateTime }}</div>
                        <div class="timezone">
                            <span class="timezone-current">UTC</span>
                            <ul class="timezone-list">
                                <li class="timezone-option">Local</li>
                                <li class="timezone-option">ET</li>
                                <li class="timezone-option">PT</li>
                                <li class="timezone-option active">UTC</li>
                            </ul>
                        </div>
                    </div>
                </section>

                <section class="hero" id="countdown">
                    <countdown specificity="launchSpecificity" countdown-to="launchDateTime" callback="requestFrequencyMananger"></countdown>
                </section>
                <p>{{ $mission->summary }}</p>
                <h2>Details</h2>
                <section class="details">
                    <div id="live-tweets">

                    </div>
                </section>
                <h2>Timeline</h2>
                <section class="timeline">
                    <canvas></canvas>
                </section>
                @if (Auth::isSubscriber())
                    <h2>Articles</h2>
                    <section class="articles">
                        @foreach ($mission->articles() as $article)
                        @endforeach
                    </section>
                @endif
            </main>
        </div>
    </body>
@stop