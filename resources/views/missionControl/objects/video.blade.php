@extends('templates.main')
@section('title', $object->title)

@section('content')
<body class="object" ng-app="objectApp" ng-controller="objectController" ng-strict-di>

    @include('templates.header')

    <div class="content-wrapper">
        <h1>{{ $object->title }}</h1>
        <main>

            @include('templates.objects.navigation')

            <section class="details">
                <div class="gr-9 content">
                    @if ($object->present()->youtubeExternalUrl() !== false)
                        <div class="video-container">
                            <iframe width="100%" src="https://www.youtube.com/embed/{{ $object->present()->youtubeExternalUrl() }}" frameborder="0"
                                    webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
                        </div>

                    @elseif ($object->present()->vimeoExternalUrl() !== false)
                        <div class="video-container">
                            <iframe width="100%" src="https://player.vimeo.com/video/{{ $object->present()->vimeoExternalUrl() }}?title=0&byline=0&portrait=0"
                                    frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
                        </div>
                    @else
                        <video id="object" class="video-js vjs-default-skin" controls
                               preload="none" data-setup="{}" width="auto" height="auto">
                            <source src="{{ $object->media }}" type="{{ $object->mimetype }}">
                        </video>
                    @endif
                </div>

                <aside class="gr-3 aside">
                    <div class="actions container">
                        <span class="gr-4">
                            <i class="fa fa-eye fa-2x"></i> {{ $object->views }} Views
                        </span>
                        <span class="gr-4">
                            <i class="fa fa-star fa-2x" ng-click="toggleFavorite()" ng-class="{ 'is-favorited' : isFavorited === true }"></i>
                            <span>@{{ favoritesText }}</span>
                        </span>
                        <span class="gr-4">
                            <a href="" target="_blank" download><i class="fa fa-download fa-2x" ng-click="incrementDownloads()"></i></a> {{ $object->downloads()->count() }} Downloads
                        </span>
                    </div>
                    <div class="more">
                        @if ($object->anonymous == false || Auth::isAdmin())
                            <p class="lowvisibility opacity">Uploaded by <span><a href="/users/{{ $object->user->username }}">{{ $object->user->username }}</a></span> on <span>{{ $object->created_at->toFormattedDateString() }}</span></p>
                        @elseif ($object->anonymous == true)
                            <p>Uploaded on {{ $object->created_at->toFormattedDateString() }}</p>
                        @endif
                        <ul>
                            <li>{{ $object->present()->subtype() }}</li>
                        </ul>
                        Video taken {{ $object->present()->originDateAsString() }}
                    </div>

                    <div class="legal">
                        <p>Author: {{ $object->author }}</p>
                        <p>Attribution: {{ $object->attribution }}</p>
                    </div>

                    @if ($object->mission() !== null)
                        <!-- Mission stuff here -->
                    @endif

                    @if ($object->collections()->count() > 0)
                        <p>This video is part of {{ $object->collections()->count() }} collections</p>
                        <div class="collections">

                        </div>
                    @endif

                    <p>File Details</p>
                    <div class="file-details">
                        {{ $object->present()->size() }}
                    </div>
                </aside>
            </section>

            <h2>Summary</h2>
            <section class="summary">
                <p>{{ $object->summary }}</p>

                <h3>Tags</h3>
                @foreach ($object->tags as $tag)
                    <div class="tag"><a href="/missioncontrol/tags/{{ $tag->name }}">{{ $tag->name }}</a></div>
                @endforeach

                @include('templates.objects.notes')

            </section>

            @include('templates.objects.comments')

        </main>
    </div>

    <link href="http://vjs.zencdn.net/4.12/video-js.css" rel="stylesheet">
    <script src="http://vjs.zencdn.net/4.12/video.js"></script>
</body>
@stop