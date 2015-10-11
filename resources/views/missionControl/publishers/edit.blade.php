@extends('templates.main')
@section('title', 'Editing ' . {{ $publisher->name }})

@section('content')
    <body class="publisher-edit" ng-controller="publisherController">


    @include('templates.header')

    <div class="content-wrapper">
        <h1>Editing {{ $publisher->name }}</h1>
        <main>
        	<form name="editPublisherForm">
              	<label for="name">Name of Publisher</label>
        		<input type="text" ng-model="publisher.name" placeholder="New York Times, for example" required />

        		<label for="url">The URL of the publisher's webpage></label>
        		<input type="text" ng-model="publisher.url" placeholder="http://nytimes.com/" required /> 

        		<label for="description">Description of this publisher</label>
        		<textarea ng-model="publisher.description" required></textarea>

        		<input type="submit" value="Edit Publisher" ng-disabled="editPublisherForm.$invalid" />
        	</form>
        </main>
    </div>
    </body>
@stop