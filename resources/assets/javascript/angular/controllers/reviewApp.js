(function() {
    var reviewApp = angular.module('app', []);

    reviewApp.controller("reviewController", ["$scope", 'reviewService', function($scope, reviewService) {
        $scope.isLoading = true;
        $scope.objectsToReview = [];

        $scope.visibilities = ['Default', 'Public', 'Hidden'];

        $scope.action = function(object, status) {

            object.status = status;

            if (status == 'Published') {
                object.isBeingPublished = true;
            } else if (status == 'Deleted') {
                object.isBeingDeleted = true;
            }

            reviewService.review(object).then(function() {
                $scope.objectsToReview.splice($scope.objectsToReview.indexOf(object), 1);

            }, function(response) {
                alert('An error occurred');
                console.log(response);
            })
        };

        $scope.reviewPageSubheading = function() {
            if ($scope.isLoading) {
                return 'Loading Queued Objects...';
            } else {
                if (angular.isDefined($scope.objectsToReview))
                    return '<span>' + $scope.objectsToReview.length + '</span> objects to review';
            }
        };

        (function() {
            reviewService.fetch().then(function(response) {
                console.log(response);
                $scope.objectsToReview = response;
                $scope.isLoading = false;
            });
        })();
    }]);

    reviewApp.service('reviewService', ["$http", "ObjectToReview", function($http, ObjectToReview) {
        this.fetch = function() {
            return $http.get('/missioncontrol/review/get').then(function(response) {

                return response.data.map(function(objectToReview) {
                    return new ObjectToReview(objectToReview);
                });
            });
        };

        this.review = function(object) {
            return $http.post('/missioncontrol/review/update/' + object.object_id, {
                visibility: object.visibility, status: object.status
            });
        };
    }]);

    reviewApp.factory("ObjectToReview", function() {
        return function (object) {
            var self = object;

            self.visibility = "Default";

            self.linkToObject = '/missioncontrol/object/' + self.object_id;
            self.linkToUser = '/users/' + self.user.username;

            self.createdAtRelative = moment.utc(self.created_at).fromNow();

            self.size = self.size / 1000 + ' KB';

            self.isBeingPublished = false;
            self.isBeingDeleted = false;

            return self;
        }
    });
})();