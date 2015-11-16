@extends('templates.main')
@section('title', 'Publishers')

@section('content')
    <body class="publisher-index" ng-controller="publishersController">

        @include('templates.header')

        <div class="content-wrapper">
            <h1>Publishers</h1>
            <main>
                <h2>Create A Publisher</h2>
                <form name="createPublisherForm">
                    <label for="name">Name of Publisher</label>
                    <input type="text" ng-model="publisher.name" placeholder="New York Times, for example" required />

                    <label for="url">The URL of the publisher's webpage></label>
                    <input type="text" ng-model="publisher.url" placeholder="http://nytimes.com/" required />

                    <label for="description">Description of this publisher</label>
                    <textarea ng-model="publisher.description" required></textarea>

                    <input type="submit" value="Create Publisher" ng-disabled="createPublisherForm.$invalid" ng-click="createPublisher(publisher)" />
                </form>

                <h2>All Publishers</h2>
                <div ng-repeat="publisher in publishers">
                    <form name="@{{'editPublisherForm' + $index }}">
                        <label for="name">Name of Publisher</label>
                        <input type="text" ng-model="publisher.name" placeholder="New York Times, for example" required />

                        <label for="url">The URL of the publisher's webpage></label>
                        <input type="text" ng-model="publisher.url" placeholder="http://nytimes.com/" required />

                        <label for="description">Description of this publisher</label>
                        <textarea ng-model="publisher.description" required></textarea>

                        <input type="submit" value="Edit Publisher" ng-disabled="editPublisherForm.$pristine && " ng-click="editPublisher(publisher)" />
                    </form>
                </div>
            </main>
        </div>
    </body>
@stop