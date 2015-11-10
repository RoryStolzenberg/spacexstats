@extends('templates.main')
@section('title', 'DataViews')

@section('content')
    <body class="dataviews" ng-controller="dataViewController" ng-strict-di>


    @include('templates.header')

    <div class="content-wrapper">
        <h1>DataViews</h1>
        <main>
            <nav></nav>
            <h2>Create a DataView</h2>
            <form name="createDataViewForm" novalidate>
                <ul>
                    <li class="gr-6">
                        <label for="name">DataView Name</label>
                        <input type="text" name="name" ng-model="newDataView.name" required />
                    </li>

                    <li class="gr-6">
                        <label>Select a banner image</label>
                        <dropdown options="data.bannerImages" has-default-option="false" unique-key="object_id" title-key="title" searchable="true" ng-model="newDataView.banner_image"></dropdown>
                    </li>

                    <li class="gr-4 suffix-8">
                        <label>Column Titles</label>
                        <ul>
                            <li ng-repeat="column_title in newDataView.column_titles">
                                <input type="text" name="title" ng-model="column_title" />
                            </li>
                            <li>
                                <input type="text" ng-blur="newDataView.addTitle(newDataView.newTitle)" ng-model="newDataView.newTitle" />
                            </li>
                        </ul>
                    </li>

                    <li class="gr-6">
                        <label for="query">Query</label>
                        <textarea class="code" name="query" ng-model="newDataView.query" required></textarea>
                        <button ng-click="newDataView.testQuery(dataview.query)">Test Query</button>
                    </li>

                    <li class="gr-6">
                        <label>Query Output</label>
                        <pre class="testquery">
                            <code class="code json">
                                @{{ newDataView.testQueryOutput | jsonPrettify }}
                            </code>
                        </pre>
                    </li>

                    <li class="gr-12">
                        <label for="summary">Summary</label>
                        <textarea name="summary" ng-model="newDataView.summary" required></textarea>
                    </li>

                    <li class="gr-12">
                        <input type="submit" ng-disabled="createDataViewForm.$invalid" ng-click="create(newDataView)" />
                    </li>
                </ul>
            </form>

            <h2>Current DataViews</h2>
            <section ng-repeat="dataView in dataViews">

            </section>
        </main>
    </div>
    </body>
@stop

