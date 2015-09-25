@extends('templates.main')
@section('title', 'DataViews')

@section('content')
    <body class="dataviews" ng-controller="dataViewController" ng-strict-di>

    @include('templates.flashMessage')
    @include('templates.header')

    <div class="content-wrapper">
        <h1>DataViews</h1>
        <main>
            <nav></nav>
            <h2>Create a DataView</h2>
            <form name="createDataViewForm" novalidate>
                <label for="name">DataView Name</label>
                <input type="text" name="name" ng-model="newDataview.name" required />

                <label>Column Titles</label>
                <ul>
                    <li ng-repeat="title in dataview.titles">
                        <input type="text" name="@{{ 'title' + $index }}" ng-model="newDataview.titles[$index]" />
                    </li>
                </ul>

                <label>Select a banner image</label>
                <select-list options="data.bannerImages" has-default-option="false" unique-key="object_id" title-key="title" searchable="true" ng-model="newDataview.banner_image"></select-list>

                <label for="query">Query</label>
                <textarea name="query" ng-model="newDataview.query" required></textarea>
                <button ng-click="testQuery(dataview.query)">Test Query</button>

                <label for="summary">Summary</label>
                <textarea name="summary" ng-model="newDataview.summary" required></textarea>

                <input type="submit" ng-disabled="createDataViewForm.$invalid" />
            </form>

            <h2>Current DataViews</h2>
            <section ng-repeat="dataView in dataViews">

            </section>
        </main>
    </div>
    </body>
@stop

