@extends('templates.main')

@section('title', $object->title)
@section('bodyClass', 'object')

@section('scripts')
    <script data-main="/src/js/common" src="/src/js/require.js"></script>
    <script>
        require(['common'], function() {
            require(['knockout', 'viewmodels/ObjectViewModel'], function(ko, ObjectViewModel) {

                ko.applyBindings(new ObjectViewModel({{ $object->object_id  }}));
            });
        });
    </script>
@stop

@section('content')
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
                    <img class="object" src="{{ $object->filename }}" />
                </div>
                <aside class="grid-4">
                    <div class="actions container">
                        <span class="grid-4">
                            <i class="fa fa-eye"></i> Views
                        </span>
                        <span class="grid-4">
                            <i class="fa fa-star" data-bind="click: toggleFavorite"></i> Favorites
                        </span>
                        <span class="grid-4">
                            <i class="fa fa-download" data-bind="click: download"></i> Downloads
                        </span>
                    </div>
                    @if ($object->anonymous == false || Auth::isAdmin())
                        <p>Uploaded by {{ link_to_route('users.get', $object->user->username, array('username' => $object->user->username)) }}<br/>
                            On {{ $object->present()->created_at() }}</p>
                    @elseif ($object->anonymous == true)
                        <p>Uploaded on {{ $object->present()->created_at() }}</p>
                    @endif
                    <ul>
                        <li>{{ $object->present()->subtype() }}</li>
                    </ul>
                </aside>
            </section>

            <h2>Summary</h2>
            <section class="summary">
                <p>{{ $object->summary }}</p>

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

            </section>
        </main>
    </div>
@stop