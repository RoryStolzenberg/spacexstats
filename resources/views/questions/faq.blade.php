@extends('templates.main')
@section('title', 'SpaceX Questions')

@section('content')
<body class="questions">

    @include('templates.flashMessage')
    @include('templates.header')

    <div class="content-wrapper">
        <h1>SpaceX Questions</h1>
        <main>
            <p>Here you can find a list of frequently asked questions ({{$questionCount}} of them!) many people have about SpaceX, the goals that push the company forward, the products and services it offers, its past, and its future!</p>
            <input type="type" data-bind="value: searchTerm, valueUpdate: 'afterkeydown', event: { keypress: clearLockedQuestion() }" placeholder="Start typing a question here..." />
            <section class="question-list" data-bind="visible: currentQuestions().length == 0">
                <ul>
                    @foreach ($questions as $question)
                        <li><a href="http://spacexstats/faq#{{ $question->slug }}" data-bind="click: retrieveLockedQuestion.bind(this, '{{ $question->slug }}')">{{ $question->title }}</a></li>
                    @endforeach
                </ul>
            </section>
            <section class="questions" data-bind="visible: currentQuestions().length > 0, template: { name: 'question-template', foreach: currentQuestions }">
            </section>
        </main>
    </div>
    {{ HTML::script('/js/viewmodels/questionViewModel.js') }}
    <script type="text/javascript">
        $(document).ready(function() {
            ko.applyBindings(new questionViewModel());
        });
    </script>
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

