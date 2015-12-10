@extends('templates.main')
@section('title', 'Collections')

@section('content')
    <body class="review" ng-app="collectionsApp" ng-strict-di>

    @include('templates.header')

    <div class="content-wrapper">
        <h1>Collections</h1>
        <main>
            <p>A collection is a grouping of similar Mission control submissions that anyone can create. Submissions can be related by a mission ("CRS-1" for example), by someone who created then (a collection of photos by a photographer), or by anything else (a collection of high resolution pictures of Elon Musk).</p>
            <h2>Create</h2>
            <section ng-controller="createCollectionController">
                <form name="createCollectionForm" novalidate>
                    <ul>
                        <li>
                            <label>Title</label>
                            <input type="text" name="title" ng-model="newCollection.title" minlength="10" placeholder="A descriptive title for the collection" required>
                        </li>
                        <li>
                            <label>Summary</label>
                            <textarea name="description" ng-model="newCollection.summary" ng-minlength="100" placeholder="A short summary of what this collection is about" required character-counter></textarea>
                        </li>
                    </ul>

                    <input type="submit" ng-click="createCollection()" ng-disabled="createCollectionForm.$invalid || is.creatingCollection" value="Create & Add Items" />
                </form>
            </section>

            <h2>Popular Collections</h2>
            <h2>Recently Updated</h2>
            <h2>Recently Created</h2>
        </main>
    </div>
    </body>
@stop