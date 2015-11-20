(function() {
    var reviewApp = angular.module('app', []);

    reviewApp.controller("reviewController", ["$scope", 'reviewService', function($scope, reviewService) {
        $scope.isLoading = true;

        $scope.visibilities = ['Default', 'Public', 'Hidden'];

        $scope.action = function(object, status) {

            object.status = status;
            object.isBeingActioned = true;

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
                return '<span>' + $scope.objects.length + '</span> objects to review';
            }
        };

        $scope.on('reviewPageLoaded', function() {
            $scope.isLoading = false;
        });

        (function() {
            $scope.objectsToReview = reviewService.fetch();
        })();
    }]);

    reviewApp.service('reviewService', ["$http", "$rootScope", "ObjectToReview", function($http, $rootScope, ObjectToReview) {
        this.fetch = function() {
            return $http.get('/missioncontrol/review/get').then(function(response) {

                $rootScope.broadcast('reviewPageLoaded');

                return response.data.forEach(function(objectToReview) {
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

            self.linkToUser = 'users/' + self.user.username;

            self.createdAtRelative = moment.utc(self.created_at).fromNow();

            self.isBeingActioned = false;

            return self;
        }
    });
})();