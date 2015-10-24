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
                <form name="createCollectionForm" novalidate>
                    <label>Title</label>
                    <input type="text" name="title" ng-model="newCollection.title" minlength="10" required>
                    <label>Description</label>
                    <textarea name="description" ng-model="newCollection.summary" minlength="100" required>
                    </textarea>

                    <input type="submit" ng-click="createCollection()" ng-disabled="createCollectionForm.$invalid" value="Create & Add Items" />
                </form>
            </section>

            <h2>Popular</h2>
            <h2>Recently Updated</h2>
            <h2>Recently Created</h2>
        </main>
    </div>
    </body>
@stop