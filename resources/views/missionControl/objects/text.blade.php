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

                </div>

                <aside class="gr-3 aside">

                    @include('templates.objects.actions')

                    <div class="more">
                        @if ($object->anonymous == false || Auth::isAdmin())
                            <p class="lowvisibility opacity">Uploaded by <span><a href="/users/{{ $object->user->username }}">{{ $object->user->username }}</a></span> on <span>{{ $object->created_at->toFormattedDateString() }}</span></p>
                        @elseif ($object->anonymous == true)
                            <p>Uploaded on {{ $object->created_at->toFormattedDateString() }}</p>
                        @endif
                        <ul>
                            <li>{{ $object->present()->subtype() }}</li>
                        </ul>
                    </div>

                    <div class="legal">
                        <p>Author: {{ $object->author }}</p>
                        <p>Attribution: {{ $object->attribution }}</p>
                    </div>

                    @if ($object->mission() !== null)
                        <!-- Mission stuff here -->
                    @endif

                    @if ($object->collections()->count() > 0)
                        <p>This image is part of {{ $object->collections()->count() }} collections</p>
                        <div class="collections">

                        </div>
                    @endif

                    <p>Image Details</p>
                    <ul class="exif">
                        <li>{{ $object->ISO }} ISO</li>
                    </ul>

                    <p>File Details</p>
                    <div class="file-details">
                        {{ $object->present()->size() }}
                    </div>
                </aside>
            </section>

            <h2>Summary</h2>
            <section class="summary">
                <h3>Tags</h3>
                @foreach ($object->tags as $tag)
                    <div class="tag"><a href="/missioncontrol/tags/{{ $tag->name }}">{{ $tag->name }}</a></div>
                @endforeach

                @include('templates.objects.notes')

            </section>

            @include('templates.objects.comments')

        </main>
    </div>
</body>
@stop