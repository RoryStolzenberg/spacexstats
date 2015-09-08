@extends('templates.main')
@section('title', 'Review Queue')

@section('content')
    <body class="review" ng-app="reviewApp" ng-controller="reviewController" ng-strict-di>

    @include('templates.flashMessage')
    @include('templates.header')

    <div class="content-wrapper">
        <h1>Collections</h1>
        <main>
            <nav class="sticky-bar">
            </nav>
            <h2>Popular</h2>
            <h2>Recently Updated</h2>
        </main>
    </div>
    </body>
@stop