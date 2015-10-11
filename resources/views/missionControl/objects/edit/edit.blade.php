@extends('templates.main')
@section('title', 'Editing ' . $object->title)

@section('content')
    <body class="review" ng-controller="editObjectController" ng-strict-di>


    @include('templates.header')

    <div class="content-wrapper">
        <h1>Editing {{ $object->title }}</h1>
        <main>
        </main>
    </div>
    </body>
@stop