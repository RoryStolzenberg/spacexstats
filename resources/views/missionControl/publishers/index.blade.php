@extends('templates.main')
@section('title', 'Publishers')

@section('content')
    <body class="publisher-index" ng-controller="publishersController">

        @include('templates.header')

        <div class="content-wrapper">
            <h1>Publishers</h1>
            <main>
                <p>SpaceXStats currently has an archive of articles from @{{ publishers.length }} publishers with over 14 years of content.</p>
                <h2 ng-click="isCreatingPublisher = !isCreatingPublisher">Create A Publisher</h2>
                <form name="createPublisherForm" ng-show="isCreatingPublisher">
                    <label for="name">Name of Publisher</label>
                    <input type="text" ng-model="publisher.name" placeholder="New York Times, for example" required />

                    <label for="url">The URL of the publisher's webpage</label>
                    <input type="text" ng-model="publisher.url" placeholder="http://nytimes.com/" required />

                    <label for="description">Description of this publisher</label>
                    <textarea ng-model="publisher.description" required></textarea>

                    <input type="submit" value="Create Publisher" ng-disabled="createPublisherForm.$invalid || isCreatingPublisher" ng-click="createPublisher(publisher)" />
                </form>

                <h2>All Publishers</h2>
                <span>Sort Alphabetically or by Article Count</span>
                <div ng-repeat="publisher in publishers">
                    <h3>@{{ publisher.name }} <i class="fa fa-pencil" ng-click="publisher.isEditing = !publisher.isEditing"></i></h3>
                    <h4>@{{ publisher.articleCount }} articles</h4>
                    <p>@{{ publisher.description }}</p>
                    <a href="/missioncontrol/publishers/@{{ publisher.publisher_id }}">See More Info</a>
                    <form name="@{{'editPublisherForm' + $index }}" ng-show="publisher.isEditing">
                        <label for="name">Name of Publisher</label>
                        <input type="text" ng-model="publisher.name" placeholder="New York Times, for example" required />

                        <label for="url">The URL of the publisher's webpage></label>
                        <input type="text" ng-model="publisher.url" placeholder="http://nytimes.com/" required />

                        <label for="description">Description of this publisher</label>
                        <textarea ng-model="publisher.description" required></textarea>

                        <input type="submit" value="Edit Publisher" ng-disabled="editPublisherForm.$pristine || editPublisherForm.$invalid || isEditingPublisher" ng-click="editPublisher(publisher)" />
                    </form>
                </div>
            </main>
        </div>
    </body>
@stop