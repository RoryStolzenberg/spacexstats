(function() {
    var aboutMissionControlApp = angular.module('app', []);

    aboutMissionControlApp.controller("subscriptionController", ["$scope", "subscriptionService", function($scope, subscriptionService) {
        $scope.createCollection = function() {
            collectionService.create($scope.newCollection);
        }
    }]);

    aboutMissionControlApp.service("subscriptionService", ["$http", function($http) {
    }]);

    aboutMissionControlApp.service("aboutMissionControlService", ["$http", function($http) {
    }]);
})();
