@extends('templates.main')
@section('title', $mission->name)

@section('content')
<body class="past-mission" ng-controller="pastMissionController" ng-strict-di>

    @include('templates.header', array('backgroundImage' => !is_null($mission->featuredImage) ? $mission->featuredImage->media : ''))

    <div class="content-wrapper">
        <h1>{{ $mission->name }}</h1>
        <main>
            <nav class="in-page sticky-bar">
                <ul class="container">
                    <li class="gr-1">
                        <a href="#article">Article</a>
                    </li>
                    <li class="gr-1">
                        <a href="#details">Details</a>
                    </li>
                    <li class="gr-1">
                        <a href="#timeline">Timeline</a>
                    </li>
                    <li class="gr-1">
                        <a href="#images">Images</a>
                    </li>
                    <li class="gr-1">
                        <a href="#videos">Videos</a>
                    </li>
                    <li class="gr-1">
                        <a href="#documents">Documents</a>
                    </li>
                    <li class="gr-1">
                        <a href="#articles">Articles</a>
                    </li>
                    <li class="gr-1">
                        <a href="#analytics">Analytics</a>
                    </li>
                    <li class="gr-1 actions">
                        <a class="link" href="/missions/{{ $mission->slug }}/edit"><i class="fa fa-pencil"></i></a>
                    </li>
                    <li class="gr-1 float-right">
                        <span class="status complete"><i class="fa fa-flag"></i> {{ $mission->status }}</span>
                    </li>
                    <li class="gr-1 float-right">
                        @if ($mission->outcome == 'Success')
                            <span class="outcome success"><i class="fa fa-check"></i> Success</span>
                        @else
                            <span class="outcome failure"><i class="fa fa-cross"></i> Failure</span>
                        @endif
                    </li>
                </ul>
            </nav>

            <section class="highlights">
                @if(isset($pastMission))
                    <a href="/missions/{{ $pastMission->slug }}">
                        <div class="mission-link past-mission-link">
                            <span class="placeholder">Previous Mission</span>
                            <span class="link"><i class="fa fa-arrow-left"></i> {{ $pastMission->name }}</span>
                        </div>
                    </a>
                @endif
                @if(isset($futureMission))
                    <a href="/missions/{{ $futureMission->slug }}">
                        <div class="mission-link future-mission-link">
                            <span class="link">{{ $futureMission->name }} <i class="fa fa-arrow-right"></i></span>
                            <span class="placeholder">Next Mission</span>
                        </div>
                    </a>
                @endif
            </section>

            {!! $mission->present()->article() !!}

            <h2>Details</h2>
            <section id="details" class="scrollto">
                @include('templates.missionCard', ['size' => 'large', 'mission' => $mission])
                <div class="gr-8">
                    <h3>Flight Details</h3>
                    <mission-profile></mission-profile>

                    @if(count($mission->spacecraftFlight))
                        <h3>{{ $mission->spacecraftFlight->spacecraft->name }}</h3>
                        @include('templates.spacecraftCard')
                    @endif
                    <h3>Satellites</h3>
                    <h3>Upper Stage</h3>
                </div>
                <div class="gr-4">
                    <h3>Library</h3>
                    <ul class="library">

                        <li id="launch-video">
                            <span>Watch the Launch</span>
                        </li>

                        @if($mission->missionPatch()->count() == 1)
                            <li id="mission-patch">
                                <img src="{{ $mission->missionPatch->thumb_small }}"/>
                                <span>{{ $mission->name }} Mission Patch</span>
                            </li>
                        @endif

                        <li id="press-kit">
                            <span>Press Kit</span>
                        </li>

                        @if($mission->spacecraftFlight()->count() == 1)
                            <li id="cargo-manifest">
                                <span>Cargo Manifest</span>
                            </li>
                        @endif

                        <li id="prelaunch-press-conference">
                            <span>Prelaunch Press Conference</span>
                        </li>

                        <li id="postlaunch-press-conference">
                            <span>Postlaunch Press Conference</span>
                        </li>

                        <li id="reddit-discussion">
                            <span>/r/SpaceX Reddit Live Thread</span>
                        </li>

                        <li id="flightclub-link">
                            <span>FlightClub Simulation</span>
                        </li>

                        <li id="raw-data-download">
                            <span><a href="/missions/{{ $mission->slug }}/raw">Raw Data Download</a></span>
                        </li>

                        <li id="mission-collection">
                            <span>{{ $mission->name }} Mission Collection</span>
                        </li>
                    </ul>
                </div>
            </section>

            <h2>Images</h2>
            <section id="images" class="scrollto">
            </section>

            <h2>Videos</h2>
            <section id="videos" class="scrollto">
            </section>

            <h2>Documents</h2>
            <section id="documents" class="scrollto">
            </section>

            <h2>Articles</h2>
            <section id="articles" class="scrollto">
                @foreach ($mission->articles() as $article)
                @endforeach
            </section>

            <h2>Timeline</h2>
            <section id="timeline" class="scrollto">
                <h3>Prelaunch</h3>
                    <table>
                        <tr>
                            <th>Occurred At</th>
                            <th>Event Type</th>
                            <th>Summary</th>
                            <th>Scheduled Lauch at time of event</th>
                        </tr>
                        @foreach ($mission->prelaunchEvents as $prelaunchEvent)
                            <tr>
                                <td>{{ $prelaunchEvent->occurred_at }}</td>
                                <td>{{ $prelaunchEvent->event }}</td>
                                <td>{{ $prelaunchEvent->summary }}</td>
                                <td>{{ $prelaunchEvent->scheduled_launch_date_time }}</td>
                            </tr>
                        @endforeach
                    </table>

                <h3>Launch</h3>
                    <p>The following data represents telemetry and readouts from the launch loop at SpaceX's Hawthorne HQ.</p>
                    <table>
                        <tr>
                            <th>Timestamp</th>
                            <th>Telemetry</th>
                        </tr>
                        @foreach($mission->telemetries as $telemetry)
                            <tr>
                                <td>{{ $telemetry->timestamp }}</td>
                                <td>{{ $telemetry->telemetry }}</td>
                            </tr>
                        @endforeach
                    </table>
                <h3>Postlaunch</h3>
            </section>

            <h2>Analytics</h2>
            <section id="analytics" class="scrollto container">
                <div class="gr-4">
                    <chart class="dataplot" data="altitudeVsTime.data" settings="altitudeVsTime.settings" width="100%" height="400px"></chart>
                </div>
                <div class="gr-4">
                    <chart class="dataplot" data="velocityVsTime.data" settings="velocityVsTime.settings" width="100%" height="400px"></chart>
                </div>
                <div class="gr-4">
                    <chart class="dataplot" data="downrangeVsTime.data" settings="downrangeVsTime.settings" width="100%" height="400px"></chart>
                </div>
                <div class="gr-4">
                    <chart class="dataplot" data="altitudeVsDownrange.data" settings="altitudeVsDownrange.settings" width="100%" height="400px"></chart>
                </div>
                <ul>
                    <li>Upper Stage Tracking</li>
                    <li>Estimators for Data plots</li>
                </ul>
            </section>
        </main>
    </div>
</body>
@stop