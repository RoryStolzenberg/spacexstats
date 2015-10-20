@extends('templates.main')
@section('title', $object->title)

@section('content')
<body class="object" ng-app="objectApp" ng-controller="objectController" ng-strict-di>


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
                <div class="gr-9 content">
                    @if ($object->external_url != null)
                        <iframe width="100%" src="{{ $object->external_url }}" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
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
                    <form name="commentForm">
                        <textarea ng-model="newComment" minlength="10" required></textarea>
                        <input type="submit" ng-click="addTopLevelComment(commentForm)" ng-disabled="commentForm.$invalid" value="Add comment" />
                    </form>
                    <p ng-if="!commentsAreLoaded">Comments are loading...</p>
                    <div ui-tree data-nodrop-enabled="true" data-drag-enabled="false">
                        <ul ui-tree-nodes="" ng-model="comments">
                            <li ng-repeat="comment in comments" class="@{{ 'comment-depth-' + comment.depth }}" ui-tree-node ng-include="'nodes_renderer.html'"></li>
                        </ul>
                    </div>
                @else
                    <p>You need to be a Mission Control subscriber to comment. Sign up today!</p>
                @endif
            </section>

        </main>
    </div>

    <!-- Nested node template -->
    <script type="text/ng-template" id="nodes_renderer.html">
        <div ui-tree-handle>

            <span class="comment-owner">
                <a href="@{{ '/users/' + comment.user.username }}">@{{ comment.user.username }}</a>
            </span>

            <p class="comment-body">@{{ comment.comment }}</p>

            <ul class="comment-actions">
                <li ng-click="comment.toggleReplyState()">Reply</li>
                <li ng-click="comment.toggleEditState()">Edit</li>
                <li ng-click="comment.toggleDeleteState()">Delete</li>
            </ul>

            <div ng-if="comment.isReplying === true" ng-form="commentReplyForm">
                <textarea ng-model="comment.replyText" minlength="10" required></textarea>

                <button type="submit" ng-click="comment.reply()" ng-disabled="commentReplyForm.$invalid">Reply</button>
                <button type="reset" ng-click="comment.toggleReplyState()">Cancel</button>
            </div>

            <div ng-if="comment.isEditing === true" ng-form="commentEditForm">
                <textarea ng-model="comment.editText" minlength="10" required></textarea>

                <button type="submit" ng-click="comment.edit()" ng-disabled="commentEditForm.$invalid">Edit</button>
                <button type="reset" ng-click="comment.toggleEditState()">Cancel</button>
            </div>

            <div ng-if="comment.isDeleting === true">
                <button type="submit" ng-click="comment.delete(this)">Delete</button>
                <button type="reset" ng-click="comment.toggleDeleteState()">Cancel</button>
            </div>

        </div>
        <ul ui-tree-nodes="" ng-model="comment.children">
            <li ng-repeat="comment in comment.children" class="@{{ 'comment-depth-' + comment.depth }}" ui-tree-node ng-include="'nodes_renderer.html'"></li>
        </ul>
    </script>

    <link href="http://vjs.zencdn.net/4.12/video-js.css" rel="stylesheet">
    <script src="http://vjs.zencdn.net/4.12/video.js"></script>
</body>
@stop