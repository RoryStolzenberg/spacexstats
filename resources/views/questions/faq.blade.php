@extends('templates.main')
@section('title', 'SpaceX FAQ')

@section('content')
<body class="questions" ng-app="questionsApp" ng-controller="questionsController" ng-strict-di>

    @include('templates.header')

    <div class="content-wrapper">
        <h1>SpaceX FAQ</h1>
        <main>
            <p>Here you can find a list of frequently asked questions ({{$questionCount}} of them!) many people have about SpaceX, the goals that push the company forward, the products and services it offers, its past, and its future!</p>

            <input type="type" ng-model="x.question" ng-keypress="clearPinnedQuestion()" placeholder="Start typing question keywords here..." />

            <section ng-repeat="question in questions | filter:x as search">
                <h2>@{{ question.question }}</h2>
                <a ng-click="pinQuestion(question)">Pin this question</a>
                <div>@{{ question.answer }}</div>
            </section>

            <p ng-show="search.length == 0">No questions matched!</p>
        </main>
    </div>
    <script type="text/html" id="question-template">
        <div data-bind="visible: $root.lockedQuestion() == $data || $root.lockedQuestion() == ''">
            <h3><a data-bind="text: title, attr: { name : slug }"></a></h3>
            <input type="text" data-bind="value: 'http://spacexstats.com/faq#' + slug" dir="rtl" onclick="this.select()" readonly/>
            <button data-bind="click: $root.lockQuestion.bind($data)">Lock this question</button>
            <p data-bind="text: answer"></p>
        </div>
    </script>
</body>
@stop

