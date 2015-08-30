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
                    <li class="grid-2">{{ $object->present()->type() }}</li>
                    <li class="grid-2">Comments</li>
                    @if (Auth::isSubscriber())
                        <li class="grid-2">Edit</li>
                    @endif
                </ul>
            </nav>

            <section class="details">
                <div class="grid-8">
                    @if($object->type == \SpaceXStats\Enums\MissionControlType::Image)
                        <img class="object" src="{{ $object->media }}" />
                    @elseif($object->type == \SpaceXStats\Enums\MissionControlType::Text)
                        <div>
                            {{ $object->summary }}
                        </div>
                    @endif
                </div>
                <aside class="grid-4">
                    <div class="actions container">
                        <span class="grid-4">
                            <i class="fa fa-eye"></i> {{ $object->views }} Views
                        </span>
                        <span class="grid-4">
                            <i class="fa fa-star" data-bind="css: { 'is-favorited': isFavorited() == true }, click: toggleFavorite"></i>
                            <span data-bind="text: favoritesText"></span>
                        </span>
                        <span class="grid-4">
                            <i class="fa fa-download" data-bind="click: download"></i> Downloads
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
                </aside>
            </section>

            <h2>Summary</h2>
            <section class="summary">
                @if ($object->type != \SpaceXStats\Enums\MissionControlType::Text)
                    <p>{{ $object->summary }}</p>
                @endif

                <h3>Tags</h3>
                <div class="tags">
                    @foreach ($object->tags as $tag)
                        <div><a href="/missioncontrol/tags/{{ $tag->name }}">{{ $tag->name }}</a></div>
                    @endforeach
                </div>

                <h3>Your Note</h3>
                @if (Auth::isSubscriber())
                    <div data-bind="visible: noteState() == 'read'">
                        <p data-bind="text: noteReadText"></p>
                        <button data-bind="click: changeNoteState, text: noteButtonText"></button>
                    </div>

                    <div data-bind="visible: noteState() == 'write'">
                        <textarea data-bind="getOriginalValue, value: note, valueUpdate: 'afterkeydown'">{{ $userNote->note or null }}</textarea>
                        <button data-bind="click: saveNote, disable: note().length == 0">Save Note</button>
                        <!-- ko if: originalNote() != "" -->
                        <button data-bind="click: deleteNote">Delete Note</button>
                        <!-- /ko -->
                    </div>
                @else
                    Sign up for Mission Control to leave personal notes about this.
                @endif

            </section>

            <h2>Comments</h2>
            <section class="comments">
                <div id="disqus_thread"></div>
                <script type="text/javascript">
                    /* * * CONFIGURATION VARIABLES * * */
                    var disqus_shortname = 'spacexstats';

                    /* * * DON'T EDIT BELOW THIS LINE * * */
                    (function() {
                        var dsq = document.createElement('script'); dsq.type = 'text/javascript'; dsq.async = true;
                        dsq.src = '//' + disqus_shortname + '.disqus.com/embed.js';
                        (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dsq);
                    })();
                </script>
                <noscript>Please enable JavaScript to view the <a href="https://disqus.com/?ref_noscript" rel="nofollow">comments powered by Disqus.</a></noscript>
            </section>
        </main>
    </div>
</body>
@stop