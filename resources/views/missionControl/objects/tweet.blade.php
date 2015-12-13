@extends('templates.main')
@section('title', $object->title)

@section('content')
    <body class="object" ng-app="objectApp" ng-controller="objectController" ng-strict-di>

    @include('templates.header')

    <div class="content-wrapper">
        <h1>{{ $object->title }}</h1>
        <main>

            @include('templates.objects.navigation')

            <section id="details" class="details scrollto">
                <div class="gr-9 content scrollto">
                    <div id="object-container">
                        <div class="card twitter-card">
                        </div>
                    </div>

                    <h2>Summary</h2>
                    <section id="summary" class="summary container scrollto">
                        <p>{{ $object->summary }}</p>

                        <div class="gr-7">
                            @include('templates.objects.notes')
                        </div>
                        <div class="gr-5">
                            <h3>Tags</h3>
                            @foreach ($object->tags as $tag)
                                <div class="tag"><a href="/missioncontrol/tags/{{ $tag->name }}">{{ $tag->name }}</a></div>
                            @endforeach
                        </div>
                    </section>
                </div>

                <aside class="gr-3 aside">

                    @include('templates.objects.actions')

                    <div class="more">
                        <p class="lowvisibility opacity">Posted by <span><a href="/users/{{ $object->user->username }}">{{ $object->user->username }}</a></span> on <span>{{ $object->created_at->toFormattedDateString() }}</span></p>
                    </div>

                    @if ($object->mission() !== null)
                            <!-- Mission stuff here -->
                    @endif

                    @if ($object->collections()->count() > 0)
                        <p>This tweet is part of {{ $object->collections()->count() }} collections</p>
                        <div class="collections">

                        </div>
                    @endif

                    @if (count($moreLikeThis) > 0)
                        <h3>More Like This</h3>
                        <div class="more-like-this">
                            <ul>
                                @foreach($moreLikeThis as $likeThis)
                                    <li class="like-this-list-item">
                                        <a href="/missioncontrol/objects/{{ $likeThis['_source']['object_id'] }}">
                                            {{ $likeThis['_source']['title'] }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </aside>
            </section>

            @include('templates.objects.comments')
        </main>
    </div>
    </body>
@stop