(function() {
    var missionControlApp = angular.module("app", []);

    missionControlApp.controller("missionControlController", ["$scope", "missionControlService", function($scope, missionControlService) {
        $scope.activeSection = 'missionControl';
        $scope.pageTitle = "Mission Control";

        $scope.search = function() {
            missionControlService.search($scope.currentSearch);
            $scope.activeSection = 'searchResults';
        }

        $scope.reset = function() {
            $scope.currentSearch
            $scope.activeSection = 'missionControl';
        }
    }]);

    missionControlApp.service("missionControlService", ["$http", function($http) {
        this.search = function(currentSearch) {
            return $http.post('/missioncontrol/search', { search: currentSearch });
        }
    }]);
})();