@extends('templates.main')
@section('title', $publisher->name)

@section('content')
    <body class="publisher-get">

    @include('templates.flashMessage')
    @include('templates.header')

    <div class="content-wrapper">
        <h1>{{ $publisher->name }}</h1>
        <main>
            <nav class="sticky-bar">
                <ul class="container">
                    <li class="gr-2">{{ $publisher->name }}</li>
                </ul>
            </nav>

            <p>{{ $publisher->name }} has {{ $publisher->objects()->count() }} articles.</p>

            <section class="details">
                {{ $publisher->description or "No Description of the publisher has been created yet." }}
            </section>

            <h2>Articles published by {{ $publisher->name }}</h2>
            <section class="objects">
                @foreach ($publisher->objects as $object)
                    <a href="/missioncontrol/objects/{{ $object->object_id }}">{{ $object->title }}</a>
                @endforeach
            </section>
        </main>
    </div>
    </body>
@stop