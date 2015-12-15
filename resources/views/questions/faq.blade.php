@extends('templates.main')
@section('title', 'SpaceX FAQ')

@section('content')
<body class="questions" ng-app="questionsApp" ng-controller="questionsController" ng-strict-di>

    @include('templates.header')

    <div class="content-wrapper">
        <h1>SpaceX FAQ</h1>
        <main>
            <p>Here you can find a list of frequently asked questions ({{$questionCount}} of them!) many people have about SpaceX, the goals that push the company forward, the products and services it offers, its past, and its future!
            This FAQ is refreshed every 24 hours from the <a href="http://reddit.com/r/spacex/wiki/faq">/r/SpaceX Reddit Community FAQ</a>, all content courtesy the respective contributors.</p>

            <form>
                <input type="type" ng-model="x.question" ng-keypress="clearPinnedQuestion()" placeholder="Type your question here!" />
            </form>

            <section ng-repeat="question in questions | filter:x as search">

                <h2><img ng-src="question.icon" alt="@{{ question.type }}" />@{{ question.question }}</h2>

                <a ng-click="pinQuestion(question)">Pin this question</a>

                <div class="md" ng-bind-html="question.answer">
                </div>

            </section>

            <p class="exclaim" ng-show="search.length == 0">No questions matched! :(</p>
        </main>
    </div>
</body>
@stop

