@extends('templates.main')
@section('title', 'Create a Publisher')

@section('content')
    <body class="publisher-create" ng-controller="publisherController">


    @include('templates.header')

    <div class="content-wrapper">
        <h1>Create a Publisher</h1>
        <main>
        	<form name="createPublisherForm">
        		<label for="name">Name of Publisher</label>
        		<input type="text" ng-model="publisher.name" placeholder="New York Times, for example" required />

        		<label for="url">The URL of the publisher's webpage></label>
        		<input type="text" ng-model="publisher.url" placeholder="http://nytimes.com/" required /> 

        		<label for="description">Description of this publisher</label>
        		<textarea ng-model="publisher.description" required></textarea>

        		<input type="submit" value="Create Publisher" ng-disabled="createPublisherForm.$invalid" />
        	</form>
        </main>
    </div>
    </body>
@stop