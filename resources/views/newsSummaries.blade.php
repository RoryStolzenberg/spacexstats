@extends('templates.main')
@section('title', 'News Summaries')

@section('content')
    <body class="news-summaries">

    @include('templates.header')

    <div class="content-wrapper">
        <h1>Monthly News Summaries</h1>
        <main>
            <p>SpaceX Stats also publishes monthly news summaries to catch up with SpaceX news over the past month at a glance.</p>
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