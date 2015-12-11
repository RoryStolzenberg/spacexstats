@extends('templates.main')
@section('title', 'Publishers')

@section('content')
    <body class="publisher-index" ng-controller="publishersController">

        @include('templates.header')

        <div class="content-wrapper">
            <h1>Publishers</h1>
            <main>
                <p>SpaceXStats currently has an archive of @{{ articleCount }} articles from @{{ publishers.length }} publishers.</p>
                <h2 ng-click="createPublisherFormToggle = !createPublisherFormToggle" class="cursor-pointer">Create A Publisher <small><i class="fa" ng-class="{ 'fa-minus-circle': createPublisherFormToggle, 'fa-plus-circle':!createPublisherFormToggle }"></i></small></h2>
                <p>If a publisher of an article is not present in Mission Control, you can add them here!</p>
                <form name="createPublisherForm" ng-show="createPublisherFormToggle">
                    <ul>
                        <li>
                            <label for="name">Name of Publisher</label>
                            <input type="text" ng-model="newPublisher.name" placeholder="New York Times, for example" required />
                        </li>
                        <li>
                            <label for="url">The URL of the publisher's webpage</label>
                            <input type="text" ng-model="newPublisher.url" placeholder="http://nytimes.com/" ng-pattern="/https?://(www\.)?/" required />
                        </li>
                        <li>
                            <label for="description">Description of this publisher</label>
                            <textarea ng-model="newPublisher.description" ng-minlength="1000" required></textarea>
                        </li>
                        <li>
                            <input type="submit" value="Create Publisher" ng-disabled="createPublisherForm.$invalid || isCreatingPublisher" ng-click="createPublisher(newPublisher, createPublisherForm)" />
                        </li>
                    </ul>
                </form>

                <h2>All Publishers</h2>

                <form>
                    <input type="text" ng-model="filter.name" placeholder="Filter publishers by name..." />
                </form>

                <ul class="segmented-control">
                    <li>Sort Alphabetically</li>
                    <li>Sort by Article Count</li>
                </ul>

                <span>Sort Alphabetically or by Article Count</span>

                <div class="gr-6 gr-12@small publisher" ng-repeat="publisher in publishers | filter:filter">
                    <h3><img src="@{{ publisher.favicon }}"> @{{ publisher.name }} <i class="fa fa-pencil" ng-click="publisher.isEditing = !publisher.isEditing"></i></h3>
                    <h4>@{{ publisher.articleCount }} articles</h4>
                    <p>@{{ publisher.description }}</p>

                    <span><a href="/missioncontrol/publishers/@{{ publisher.publisher_id }}">More Info</a></span>

                    <form name="@{{'editPublisherForm' + $index }}" ng-show="publisher.isEditing">
                        <ul>
                            <li>
                                <label for="name">Name of Publisher</label>
                                <input type="text" ng-model="publisher.name" placeholder="New York Times, for example" required />
                            </li>
                            <li>
                                <label for="url">The URL of the publisher's webpage></label>
                                <input type="text" ng-model="publisher.url" placeholder="http://nytimes.com/" required />
                            </li>
                            <li>
                                <label for="description">Description of this publisher</label>
                                <textarea ng-model="publisher.description" required></textarea>
                            </li>
                            <li>
                                <input type="submit" value="Edit Publisher" ng-disabled="editPublisherForm.$pristine || editPublisherForm.$invalid || isEditingPublisher" ng-click="editPublisher(publisher)" />
                            </li>
                        </ul>
                    </form>
                </div>
            </main>
        </div>
    </body>
@stop