@extends('templates.main')
@section('title', 'Review Queue')

@section('content')
<body class="review" ng-controller="reviewController" ng-strict-di>


    @include('templates.header')

    <div class="content-wrapper">
        <h1>Review Queue</h1>
        <main>
            <h2 class="review-queue-lengths" ng-bind-html="reviewPageSubheading()"></h2>

            <p class="exclaim" ng-show="!isLoading && objectsToReview.length == 0">Review queue empty!</p>

            <table>
                <tr ng-repeat-start="object in objectsToReview">
                    <td>
                        <img ng-attr-src="@{{object.media_thumb_small}}" />
                    </td>

                    <td>
                        <span>@{{ object.deltaV }} m/s of dV</span>
                    </td>

                    <td>
                        <a ng-attr-href="@{{ object.linkToObject }}">@{{ object.title }}</a>
                    </td>

                    <td>
                        <span>@{{ object.type }}</span>
                    </td>

                    <td>
                        <span>@{{ object.subtype }}</span>
                    </td>

                    <td>
                        <span>Uploaded by <a ng-attr-href="object.linkToUser">@{{ object.user.username }}</a></span>
                    </td>

                    <td ng-attr-title="@{{ object.created_at }}">
                        <span>@{{ object.createdAtRelative }}</span>
                    </td>

                    <td>
                        <select ng-model="object.visibility" ng-options="visibility for visibility in visibilities"></select>
                    </td>

                    <td>
                        <button ng-click="action(object, 'Published')" ng-disabled="object.isBeingActioned">@{{ object.isBeingActioned ? 'Publishing...' : 'Publish' }}</button>
                    </td>

                    <td>
                        <button ng-click="action(object, 'Deleted')" ng-disabled="object.isBeingActioned">@{{ object.isBeingActioned ? 'Deleting...' : 'Delete' }}</button>
                    </td>
                </tr>

                <tr class="object-extra-details" ng-repeat-end>
                    <td colspan="7">@{{ object.summary }}</td>
                </tr>
            </table>
        </main>
    </div>
</body>
@stop