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
        $scope.currentSearch = {};

        $scope.search = function() {
            missionControlService.search($scope.currentSearch).then(function() {
                // Boradcast page title change
                console.log('broadcast');
                $rootScope.$broadcast('startedSearching', $scope.currentSearch.searchTerm);
            });
        };

        $scope.reset = function() {
            $rootScope.$broadcast('stoppedSearching');
        };
    }]);

    missionControlApp.service("missionControlService", ["$http", function($http) {
        this.search = function(currentSearch) {
            return $http.post('/missioncontrol/search', { search: currentSearch });
        };

        this.fetch = function() {
            return $http.get('/missioncontrol/fetch');
        };
    }]);
})();