(function() {
    var missionControlApp = angular.module("app", []);

    missionControlApp.controller("missionControlController", ["$scope", "missionControlService", function($scope, missionControlService) {
        $scope.hasSearchResults = false;
        $scope.pageTitle = "Mission Control";

        $scope.$on('startedSearching', function(event, arg) {
            $scope.hasSearchResults = true;
            $scope.pageTitle = '"' + arg + '" results';
        });

        $scope.$on('stoppedSearching', function(event, arg) {
            $scope.hasSearchResults = false;
            $scope.pageTitle = "Mission Control";
        });

        (function() {
            missionControlService.fetch();
        })();
    }]);

    missionControlApp.controller("searchController", ["$scope", "$rootScope", "missionControlService", function($scope, $rootScope, missionControlService) {

        $scope.search = function() {
            var currentQuery = $scope.currentSearch.toQuery();
            missionControlService.search(currentQuery).then(function() {
                $rootScope.$broadcast('startedSearching', currentQuery.searchTerm);
            });
        };

        $scope.reset = function() {
            $rootScope.$broadcast('stoppedSearching');
        };
    }]);

    missionControlApp.service("missionControlService", ["$http", function($http) {
        this.search = function(currentQuery) {
            return $http.post('/missioncontrol/search', { search: currentQuery });
        };

        this.fetch = function() {
            return $http.get('/missioncontrol/fetch');
        };
    }]);
})();