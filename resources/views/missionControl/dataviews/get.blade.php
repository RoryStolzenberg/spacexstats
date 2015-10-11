@extends('templates.main')
@section('title', $dataview->name . ' DataView')

@section('content')
    <body class="">


    @include('templates.header')

    <div class="content-wrapper">
        <h1>{{ $dataview->name }} DataView</h1>
        <main>
            <nav></nav>
            <div class="dataview" style="background-color:{{ $dataview->dark_color }}">
                <div class="head" style="background-image:url({{ $dataview->bannerImage->media_thumb_large }})">
                    <span>{{ $dataview->name  }}</span>
                </div>
                {{ $dataview->summary }}
            </div>

            <h2>Other DataViews</h2>
        </main>
    </div>
    </body>
@stop

