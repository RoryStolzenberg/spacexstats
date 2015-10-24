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
                    <li>Edit this Collection</li>
                </ul>
                <p>{{ $collection->summary }}</p>
                <h2>Object in this Collection</h2>
                <section>

                </section>
            </nav>
        </main>
    </div>
    </body>
@stop
