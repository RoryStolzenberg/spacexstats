@extends('templates.main')
@section('title', 'News Summaries')

@section('content')
    <body class="news-summaries">

    @include('templates.header')

    <div class="content-wrapper">
        <h1>Monthly News Summarues</h1>
        <main>
            <section>
                @foreach($newsSummaries as $newsSummary)
                    <div>
                        <img src="{{ $newsSummary->media_thumb_small }}" />
                    </div>
                @endforeach
            </section>
        </main>
    </div>
    </body>
@stop