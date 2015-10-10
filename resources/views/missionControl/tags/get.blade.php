@extends('templates.main')
@section('title', $tag->name . ' Tag')

@section('content')
    <body class="">

    @include('templates.flashMessage')
    @include('templates.header')

    <div class="content-wrapper">
        <h1>{{ $tag->name }} Tag</h1>
        <main>
            <nav class="sticky-bar">
                <ul class="container">
                    <li class="gr-2">{{ $tag->name }}</li>
                </ul>
            </nav>

            <p>The tag <span class="tag">{{ $tag->name }}</span> is used in {{ $tag->objects()->count() }} objects.</p>

            <section class="details">
                {{ $tag->description or "No Description." }}
            </section>

            <h2>Objects with the tag '{{ $tag->name }}'</h2>
            <section class="objects">
                @foreach ($tag->objects as $object)
                    <a href="/missioncontrol/objects/{{ $object->object_id }}">{{ $object->title }}</a>
                @endforeach
            </section>
        </main>
    </div>
    </body>
@stop