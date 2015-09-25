@extends('templates.main')
@section('title', {{ $collection->title }} . ' Collection')

@section('content')
    <body class="collection">

    @include('templates.flashMessage')
    @include('templates.header')

    <div class="content-wrapper">
        <h1>{{ $scollection->title }} Collection</h1>
        <main>
        </main>
    </div>
    </body>
@stop
