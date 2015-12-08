(function() {
    var missionsListApp = angular.module('app', []);

    missionsListApp.controller("missionsListController", ['$scope', function($scope) {
        $scope.missions = laravel.missions;

        // Cheap way to get the next launch (only use on future mission page)
        $scope.nextLaunch = function() {
            return $scope.missions[0];
        };

        // Cheap way to get the previous launch (only use on past mission page)
        $scope.lastLaunch = function() {
            return $scope.missions[$scope.missions.length - 1];
        };

        $scope.currentYear = function() {
            return moment().year();
        };

        $scope.missionsInYear = function(year, completeness) {
            return $scope.missions.filter(function(mission) {
                return moment(mission.launch_date_time).year() == year && mission.status == completeness;
            }).length;
        };
    }]);
})();