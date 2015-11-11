@extends('templates.main')
@section('title', $mission->name)

@section('content')
    <body class="future-mission">

        @include('templates.header', array('backgroundImage' => !is_null($mission->featuredImage) ? $mission->featuredImage->media : ''))

        <div class="content-wrapper" ng-controller="futureMissionController" ng-strict-di>
            <h1>{{ $mission->name }}</h1>
            <main>
                <nav class="sticky-bar">
                    <ul class="container">
                        <li class="gr-1">Countdown</li>
                        <li class="gr-1">Details</li>
                        <li class="gr-1">Timeline</li>
                        <li class="gr-1">Articles</li>

                        <li class="gr-2 prefix-3 actions">
                            @if (Auth::isAdmin())
                                <a class="link" href="/missions/{{ $mission->slug }}/edit">
                                    <i class="fa fa-pencil"></i>
                                </a>
                            @endif
                            <i class="fa fa-twitter"></i>
                            @if (Auth::isMember())
                                <a class="link" href="/users/{{Auth::user()->username}}/edit#email-notifications"><i class="fa fa-envelope-o"></i></a>
                            @else
                                <a class="link" href="/docs#email-notifications"><i class="fa fa-envelope-o"></i></a>
                            @endif
                            <a class="link" href="/calendars/{{ $mission->slug }}">
                                <i class="fa fa-calendar"></i>
                            </a>
                            <a href="http://www.google.com/calendar/render?cid={{ Request::url() }}">
                                <i class="fa fa-google"></i>
                            </a>
                            <a href="">
                                <i class="fa fa-rss"></i>
                            </a>
                        </li>
                        <li class="gr-1">
                            @if ($mission->status == 'Complete')
                                <span class="status complete"><i class="fa fa-check"></i> Complete</span>
                            @elseif ($mission->status == 'In Progress')
                                <span class="status in-progress"><i class="fa fa-check"></i> In Progress</span>
                            @else
                                <span class="status upcoming"><i class="fa fa-cross"></i> Upcoming</span>
                            @endif
                        </li>
                    </ul>
                </nav>

                <section class="highlights">
                    <div class="webcast-status" ng-class="webcast.status" ng-if="isLaunchExact == true" ng-show="webcast.status != 'webcast-inactive'">
                        <span>@{{ webcast.publicStatus }}</span><span class="live-viewers" ng-show="webcast.status === 'webcast-live'">@{{ webcast.publicViewers }}</span>
                    </div>

                    @if(isset($pastMission))
                        <div class="past-mission-link">
                            <a href="/missions/{{ $pastMission->slug }}">{{ $pastMission->name }}</a>
                            <span>Previous Mission</span>
                        </div>
                    @endif
                    @if(isset($futureMission))
                        <div class="future-mission-link">
                            <a href="/missions/{{ $futureMission->slug }}">{{ $futureMission->name }}</a>
                            <span>Next Mission</span>
                        </div>
                    @endif

                    <div ng-if="isLaunchExact == true" class="display-date-time">
                        <div class="launch">@{{ launchDateTime | date:currentFormat:currentTimezone}}</div>
                        <div class="timezone">
                            <span class="timezone-current">@{{ currentTimezoneFormatted }}</span>
                            <ul class="timezone-list">
                                <li class="timezone-option" ng-click="setTimezone('local')">Local (@{{ localTimezone }})</li>
                                <li class="timezone-option" ng-click="setTimezone('ET')">ET</li>
                                <li class="timezone-option" ng-click="setTimezone('PT')">PT</li>
                                <li class="timezone-option" ng-click="setTimezone('UTC')">UTC</li>
                            </ul>
                        </div>
                    </div>
                </section>

                <section class="hero" id="countdown">
                    <countdown specificity="launchSpecificity" countdown-to="launchDateTime" callback="requestFrequencyManager"></countdown>
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
                <h2>Articles</h2>
                <section class="articles">
                    @foreach ($mission->articles() as $article)
                    @endforeach
                </section>
            </main>
        </div>
    </body>
@stop