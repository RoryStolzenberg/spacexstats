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
                    <img id="object" src="{{ $object->media }}" />
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
                            <a href="{{ $object->media_download }}" target="_blank" download><i class="fa fa-download fa-2x" ng-click="incrementDownloads()"></i></a> {{ $object->downloads()->count() }} Downloads
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
                        Image taken {{ $object->present()->originDateAsString() }}
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

            <h2>{{ $object->comments->count() }} Comments</h2>
            <section class="comments" ng-controller="commentsController" ng-strict-di>
                @if (Auth::isSubscriber())
                    <form>
                        <textarea ng-model="newComment" minlength="10"></textarea>
                        <input type="submit" ng-click="addNewComment()" value="Add comment" />
                    </form>
                    <ul>
                        <li ng-repeat="child in comments">
                            <comment comment="child"></comment>
                        </li>
                    </ul>
                @else
                    <p>You need to be a Mission Control subscriber to comment. Sign up today!</p>
                @endif
            </section>

        </main>
    </div>
</body>
@stop