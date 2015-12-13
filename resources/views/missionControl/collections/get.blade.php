@extends('templates.main')
@section('title', $collection->title . ' Collection')

@section('content')
    <body class="collection">

    @include('templates.header')

    <div class="content-wrapper">
        <h1>{{ $collection->title }} Collection</h1>
        <main>
            <nav class="in-page sticky-bar">
                <ul class="container">
                    <li class="gr-2" ng-click="is.editingCollection = true">
                        <i class="fa fa-pencil"></i> Edit this Collection
                    </li>
                    @if (Auth::isAdmin() || $collection->user_id == Auth::id())
                        <li class="gr-2" ng-click="deleteCollection()">
                            <a href="">Delete</a>
                        </li>
                    @endif
                    @if(Auth::isAdmin())
                        <li class="gr-2" ng-click="mergeCollection()">
                            <a href="">Merge</a>
                        </li>
                    @endif
                </ul>
            </nav>

            <section ng-if="is.editingCollection">
                <form name="editingCollectionForm">
                    <fieldset>

                    </fieldset>
                    <button ng-click="editCollection()">Edit</button>
                </form>
            </section>

            <section ng-if="is.deletingCollection">
                <h3>Delete this collection</h3>
                <p>Warning: this action is permanent and cannot be undone!</p>
                <button class="warning">Delete</button>
            </section>

            <section ng-if="is.mergingCollection">
                <h3>Merge this collection</h3>
                <p>Warning: this action is permanent and cannot be undone</p>
            </section>

            <p>{{ $collection->summary }}</p>
            <h2>{{ $collection->objects->count() }} submissions in this collection</h2>
            <section>
                @if($collection->objects->count() == 0)
                    <p class="exclaim">No submissions in this collection. <a ng-click="is.editingCollection = true">Add some!</a></p>
                @else
                    @foreach($collection->objects as $object)
                        @include('templates.cards.objectCard', ['object' => $object])
                    @endforeach
                @endif
            </section>
        </main>
    </div>
    </body>
@stop
