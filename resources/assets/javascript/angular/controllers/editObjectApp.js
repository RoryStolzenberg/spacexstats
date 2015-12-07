(function() {
    var editObjectApp = angular.module('app', []);

    editObjectApp.controller("editObjectController", ["$scope", "editObjectService", function($scope, editObjectService) {

        $scope.edit = function() {
            editObjectService.edit($scope.object, $scope.metadata);
        };

        $scope.revert = function() {
            editObjectService.revert($scope.object, $scope.selectedRevision);
        };

        (function() {
            $scope.object = laravel.object;
            $scope.revisions = laravel.revisions;
        })();
    }]);

    editObjectApp.service("editObjectService", ["$http", function($http) {
        this.edit = function(object, metadata) {
            return $http.patch('/missioncontrol/objects/' + object.object_id + '/edit', {
                metadata: metadata,
                object: object
            }).then(function(response) {
                window.location.href = '/missioncontrol/objects/' + object.object_id;
            });
        };

        this.revert = function(object, revertTo) {
            return $http.patch('/missioncontrol/objects/' + object.object_id + '/revert/' + revertTo.object_revision_id).then(function(response) {
                window.location.href = '/missioncontrol/objects/' + object.object_id;
            });
        };

        this.addToCollection = function(object, collection) {

        };
    }]);
})();