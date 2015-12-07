(function() {
    var app = angular.module('app', []);

    app.controller('launchEventsController', ["$scope", "missionDataService", function($scope, missionDataService) {
        (function() {
            missionDataService.launchEvents($scope.$parent.mission.slug).then(function(response) {
                $scope.launchEvents = response.data;
            });
        })();
    }]);
})();