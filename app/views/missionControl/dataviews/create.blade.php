@extends('templates.main')
@section('title', 'Create DataView')

@section('content')
    <body class="dataview-create" ng-controller="dataViewController">

    @include('templates.flashMessage')
    @include('templates.header')

    <div class="content-wrapper">
        <h1>Create A DataView</h1>
        <main>
            <form name="dataViewForm" novalidate>
                <label for="name">DataView Name</label>
                <input type="text" name="name" ng-model="dataview.name" required />

                <ul>
                    <li ng-repeat="title in dataview.titles">
                        <input type="text" name="{{ 'title' + $i }}" ng-model="dataview.titles[$i]" />
                    </li>
                </ul>

                <select-list options="images" has-default-option="false" unique-key="object_id" title-key="title" searchable="true" ng-model="dataview.banner_image"></select-list>

                <textarea name="query" ng-model="dataview.query"></textarea>
                <button ng-click="testQuery()">Test Query</button>

                <textarea name="summary" ng-model="dataview.summary" required></textarea>
            </form>
        </main>
    </div>
    </body>
@stop

