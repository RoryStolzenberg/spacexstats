@extends('templates.main')
@section('title', $publisher->name)

@section('content')
    <body class="publisher-get">


    @include('templates.header')

    <div class="content-wrapper">
        <h1>{{ $publisher->name }}</h1>
        <main>
            <nav class="sticky-bar in-page">
                <ul class="container">
                    <li class="gr-2"><a href="#details">{{ $publisher->name }}</a></li>
                    <li class="gr-2"><a href="#articles">Articles</a></li>
                </ul>
            </nav>

            <section id="details" class="scrollto">
                <p>{{ $publisher->name }} has {{ $publisher->objects()->count() }} articles.</p>

                {{ $publisher->description or "No Description of the publisher has been created yet." }}
            </section>

            <h2>Articles published by {{ $publisher->name }}</h2>
            <section id="articles">
                @foreach ($publisher->objects as $object)
                    <a href="/missioncontrol/objects/{{ $object->object_id }}">{{ $object->title }}</a>
                @endforeach
            </section>
        </main>
    </div>
    </body>
@stop