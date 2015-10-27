@extends('templates.main')
@section('title', 'Editing ' . $object->title)

@section('content')
    <body class="review" ng-controller="editObjectController" ng-strict-di>

    @include('templates.header')

    <div class="content-wrapper">
        <h1>Editing {{ $object->title }}</h1>
        <main>
            <h2>Edit</h2>
            <form name="editObjectForm">
                <ul>
                    <li class="gr-12">
                        <label for="title">Title</label>
                        <input type="text" id="title" name="title" ng-model="object.title" required minlength="10" varchar="tiny" />
                    </li>
                    <li>
                        <label for="summary">Summary</label>
                        <textarea id="summary" name="summary" ng-model="object.summary" minlength="100" required>
                        </textarea>
                    </li>
                    <li>
                        <label for="author">Author</label>
                        <input type="text" id="author" name="author" ng-model="object.author" required />
                    </li>
                    <li>
                        <label for="attribution">Attribution</label>
                        <input type="text" id="attribution" name="attribution" ng-model="object.attribution" required />
                    </li>

                    <li>
                        <label for="changes">Edit Summary</label>
                        <input type="text" placeholder="Briefly explain your changes" ng-model="metadata.changelog" minlength="10" required />
                    </li>
                </ul>
                <input type="submit" value="Edit" ng-disabled="editObjectForm.$invalid" ng-click="edit()" />
            </form>

            <h2>Revert</h2>
        </main>
    </div>
    </body>
@stop