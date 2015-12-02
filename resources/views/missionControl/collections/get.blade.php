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
                    <li class="gr-2" ng-click="editCollection()">
                        <i class="fa fa-pencil"></i> Edit this Collection
                    </li>
                    @if(Auth::isAdmin())
                        <li class="gr-2" ng-click="deleteCollection()">
                            <a href="">Delete</a>
                        </li>
                        <li class="gr-2" ng-click="mergeCollection()">
                            <a href="">Merge</a>
                        </li>
                    @endif
                </ul>
            </nav>

            <section ng-if="is.editingCollection">

            </section>

            <section ng-if="is.deletingCollection">

            </section>

            <section ng-if="is.mergingCollection">

            </section>

            <p>{{ $collection->summary }}</p>
            <h2>Objects in this Collection</h2>
            <section>
                @if($collection->objects->count() == 0)
                    <p class="exclaim">No objects in this collection. Add some!</p>
                @endif
            </section>
        </main>
    </div>
    </body>
@stop
