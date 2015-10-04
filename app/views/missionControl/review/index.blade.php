@extends('templates.main')
@section('title', 'Review Queue')

@section('content')
<body class="review" ng-controller="reviewController" ng-strict-di>

    @include('templates.flashMessage')
    @include('templates.header')

    <div class="content-wrapper">
        <h1>Review Queue</h1>
        <main>
            <p class="review-queue-lengths"><span>@{{ objectsToReview.length }}</span> items to review.</p>
            <table>
                <tr ng-repeat-start="object in objectsToReview">
                    <td><img ng-attr-src="@{{object.media_thumb_small}}" /></td>
                    <td><a ng-attr-href="@{{ object.linkToObject }}">@{{ object.title }}</a></td>
                    <td>@{{ object.textType() }}</td>
                    <td>@{{ object.textSubtype() }}</td>
                    <td>Uploaded by <a ng-attr-href="object.linkToUser">@{{ object.user.username }}</a></td>
                    <td ng-attr-title="@{{ object.created_at }}">@{{ object.createdAtRelative }}</td>
                    <td><select ng-model="object.visibility" ng-options="visibility for visibility in visibilities"></select></td>
                    <td>
                        <button ng-click="action(object, 'Published')">Publish</button>
                    </td>
                    <td>
                        <button ng-click="action(object, 'Deleted')">Remove</button>
                    </td>
                </tr>
                <tr class="obect-extra-details" ng-repeat-end>
                    <td colspan="7" data-bind="text: summary"></td>
                </tr>
            </table>
        </main>
    </div>
</body>
@stop