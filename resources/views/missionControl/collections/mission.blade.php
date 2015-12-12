@extends('templates.main')
@section('title', $collection->name . ' Mission Collection')

@section('content')
    <body class="collection">

    @include('templates.header')

    <div class="content-wrapper">
        <nav class="sticky in-page">
            <ul>
                <li class="gr-3"><a href="/missions/{{ $collection->name }}">Go to {{ $collection->name }}</a></li>
            </ul>
        </nav>
        <h1>{{ $collection->name }} Mission Collection</h1>
        <main>
            <p>This is a collection of items relating to the {{ $collection->summary }}</p>
            <h2>{{ $collection->objects->count() }} submissions in this Collection</h2>
            <section>
                @if($collection->objects->count() == 0)
                    <p class="exclaim">No submissions in this collection.</p>
                @endif
            </section>
        </main>
    </div>
    </body>
@stop
