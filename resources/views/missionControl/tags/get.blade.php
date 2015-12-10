@extends('templates.main')
@section('title', $tag->name . ' Tag')

@section('content')
    <body class="get-tag">

    @include('templates.header')

    <div class="content-wrapper">
        <h1>{{ $tag->name }} Tag</h1>
        <main>
            <p>The tag <span class="tag">{{ $tag->name }}</span> is used in {{ $tag->objects->count() }} {{ str_plural('submission', $tag->objects->count()) }}.</p>

            <section class="details">
                {{ $tag->description or "No Description." }}
            </section>

            <h2>Submissions with the tag '{{ $tag->name }}'</h2>
            <section class="objects">
                @foreach ($tag->objects as $object)
                    @include('templates.cards.objectCard', ['object' => $object])
                @endforeach
            </section>
        </main>
    </div>
    </body>
@stop