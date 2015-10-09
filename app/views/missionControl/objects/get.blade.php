@extends('templates.main')
@section('title', $object->title)

@section('content')
<body class="object" ng-app="objectApp" ng-controller="objectController" ng-strict-di>

    @include('templates.flashMessage')
    @include('templates.header')

    <div class="content-wrapper">
        <h1>{{ $object->title }}</h1>
        <main>

            <nav class="sticky-bar">
                <ul class="container">
                    <li class="gr-2">{{ $object->present()->type() }}</li>
                    <li class="gr-2">Summary</li>
                    <li class="gr-2">Comments</li>
                    @if (Auth::isSubscriber())
                        <li class="gr-2">Edit</li>
                    @endif
                </ul>
            </nav>

            <section class="details">
                <div class="gr-8 content">
                    @if($object->type == \SpaceXStats\Enums\MissionControlType::Image)
                        <img id="object" src="{{ $object->media }}" />
                    @elseif($object->type == \SpaceXStats\Enums\MissionControlType::GIF)
                        <img id="object" src="{{ $object->media }}" />
                    @elseif($object->type == \SpaceXStats\Enums\MissionControlType::Audio)
                        <audio id="object" class="video-js vjs-default-skin" controls
                               preload="none" data-setup="{}" width="100%">
                            <source src="{{ $object->media }}" type="{{ $object->mimetype }}">
                        </audio>

                    @elseif($object->type == \SpaceXStats\Enums\MissionControlType::Video)
                        @if ($object->external_url != null)
                            <iframe width="100%" src="{{ $object->embed_url }}" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
                        @else
                            <video id="object" class="video-js vjs-default-skin" controls
                                   preload="none" data-setup="{}" width="100%">
                                <source src="{{ $object->media }}" type="{{ $object->mimetype }}">
                            </video>
                        @endif

                    @elseif($object->type == \SpaceXStats\Enums\MissionControlType::Document)
                        <object data="{{ $object->media }}" type="application/pdf" width="100%" height="100%">
                            <p>Alternative text - include a link <a href="{{ $object->media }}">to the PDF!</a></p>
                        </object>

                    @elseif($object->type == \SpaceXStats\Enums\MissionControlType::Text)
                        <div>
                            {{ $object->summary }}
                        </div>
                    @endif
                </div>
                <aside class="gr-4 aside">
                    <div class="actions container">
                        <span class="gr-4">
                            <i class="fa fa-eye"></i> {{ $object->views }} Views
                        </span>
                        <span class="gr-4">
                            <i class="fa fa-star" ng-click="toggleFavorite()" ng-class="{ 'is-favorited' : isFavorited === true }"></i>
                            <span>@{{ favoritesText }}</span>
                        </span>
                        <span class="gr-4">
                            <a href="" target="_blank" download><i class="fa fa-download" ng-click="incrementDownloads()"></i></a> {{ $object->downloads()->count() }} Downloads
                        </span>
                    </div>
                    <div class="more">
                        @if ($object->anonymous == false || Auth::isAdmin())
                            <p>Uploaded by {{ link_to_route('users.get', $object->user->username, array('username' => $object->user->username)) }}<br/>
                                On {{ $object->present()->created_at() }}</p>
                        @elseif ($object->anonymous == true)
                            <p>Uploaded on {{ $object->present()->created_at() }}</p>
                        @endif
                        <ul>
                            <li>{{ $object->present()->subtype() }}</li>
                        </ul>
                    </div>
                    <div class="legal">
                        {{ $object->author }}
                        {{ $object->attribution }}
                    </div>
                    @if ($object->type == \SpaceXStats\Enums\MissionControlType::Image)
                        <ul class="exif">
                            <li>{{ $object->ISO }} ISO</li>
                        </ul>
                    @endif
                    <div class="file-details">
                        {{ $object->present()->size() }}
                    </div>
                </aside>
            </section>

            <h2>Summary</h2>
            <section class="summary">
                @if ($object->type != \SpaceXStats\Enums\MissionControlType::Text)
                    <p>{{ $object->summary }}</p>
                @endif

                <h3>Tags</h3>
                @foreach ($object->tags as $tag)
                    <div class="tag"><a href="/missioncontrol/tags/{{ $tag->name }}">{{ $tag->name }}</a></div>
                @endforeach

                <h3>Your Note</h3>
                @if (Auth::isSubscriber())
                    <form>
                        <div ng-show="noteState === 'read'">
                            <p>@{{ noteReadText }}</p>
                            <button ng-click="changeNoteState()">@{{ noteButtonText }}</button>
                        </div>

                        <div ng-show="noteState === 'write'">
                            <textarea ng-model="note"></textarea>
                            <button ng-click="saveNote()" data-bind="disable: note().length == 0">Save Note</button>
                            <button class="delete" ng-if="originalNote !== ''" ng-click="deleteNote()">Delete Note</button>
                        </div>
                    </form>
                @else
                    Sign up for Mission Control to leave personal notes about this.
                @endif
            </section>

            <h2>Comments</h2>
            <section class="comments">
                @if (Auth::isSubscriber())
                    <p>Comments coming soon!</p>
                @else
                    <p>You need to be a Mission Control subscriber to comment. Sign up today!</p>
                @endif
            </section>

        </main>
    </div>

    <link href="http://vjs.zencdn.net/4.12/video-js.css" rel="stylesheet">
    <script src="http://vjs.zencdn.net/4.12/video.js"></script>
</body>
@stop