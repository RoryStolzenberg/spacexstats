@extends('templates.main')
@section('title', $collection->title . ' Collection')

@section('content')
    <body class="collection">

    @include('templates.header')

    <div class="content-wrapper">
        <h1>{{ $collection->title }} Collection</h1>
        <main>
            <nav>
                <ul>
                    <li class="gr-2">Edit this Collection</li>
                    @if(Auth::isAdmin())
                        <li class="gr-2">Delete</li>
                        <li class="gr-2">Merge</li>
                    @endif
                </ul>
            </nav>
            <p>{{ $collection->summary }}</p>
            <h2>Objects in this Collection</h2>
            <section>
                @if($collection->objects()->count() == 0)
                    <span>No objects in this collection. Add some!</span>
                @endif
            </section>
        </main>
    </div>
    </body>
@stop
