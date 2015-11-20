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
                <tbody ng-repeat="object in objectsToReview">
                    <tr>
                        <td colspan="7">
                            <h3><a ng-attr-href="@{{ object.linkToObject }}">@{{ object.title }}</a></h3>
                            <span ng-attr-title="@{{ object.created_at }}">Uploaded by <a ng-attr-href="@{{ object.linkToUser }}">@{{ object.user.username }}</a> (@{{ object.createdAtRelative }})</span>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <img ng-attr-src="@{{object.media_thumb_small}}" />
                        </td>

                        <td>
                            <span>@{{ object.deltaV }} m/s of dV</span>
                        </td>

                        <td>
                            <p>@{{ object.type }} <span ng-if="object.subtype">(@{{ object.subtype }})</span></p>
                        </td>

                        <td>
                            <span>@{{ object.size }}</span>
                        </td>
                        <td>
                            <select ng-model="object.visibility" ng-options="visibility for visibility in visibilities"></select>
                        </td>

                        <td>
                            <button ng-click="action(object, 'Published')" ng-disabled="object.isBeingPublished" ng-hide="object.isBeingDeleted">@{{ object.isBeingPublished ? 'Publishing...' : 'Publish' }}</button>
                        </td>

                        <td>
                            <button class="warning" ng-click="action(object, 'Deleted')" ng-disabled="object.isBeingDeleted" ng-hide="object.isBeingPublished">@{{ object.isBeingDeleted ? 'Deleting...' : 'Delete' }}</button>
                        </td>
                    </tr>

                    <tr class="object-extra-details" ng-repeat-end>
                        <td colspan="7">@{{ object.summary }}</td>
                    </tr>
                </tbody>
            </table>
        </main>
    </div>
</body>
@stop