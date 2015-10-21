@extends('templates.main')
@section('title', 'Collections')

@section('content')
    <body class="review" ng-app="collectionsApp" ng-strict-di>

    @include('templates.header')

    <div class="content-wrapper">
        <h1>Collections</h1>
        <main>
            <h2>Create</h2>
            <section ng-controller="createCollectionController">

            </section>

            <h2>Popular</h2>
            <h2>Recently Updated</h2>
        </main>
    </div>
    </body>
@stop