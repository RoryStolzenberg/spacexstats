(function() {
    var missionControlApp = angular.module("app", []);

    missionControlApp.controller("missionControlController", ["$scope", "missionControlService", function($scope, missionControlService) {
        $scope.hasSearchResults = false;
        $scope.isCurrentlySearching = false;
        $scope.pageTitle = "Mission Control";

        $scope.$on('startedSearching', function() {
            $scope.hasSearchResults = false;
            $scope.isCurrentlySearching = true;
            $scope.pageTitle = "Searching...";
        });

        $scope.$on('finishedSearching', function(event, arg) {
            $scope.hasSearchResults = true;
            $scope.isCurrentlySearching = false;
            $scope.pageTitle = '"' + arg + '" results';
        });

        $scope.$on('exitSearchMode', function(event, arg) {
            $scope.hasSearchResults = $scope.isCurrentlySearching = false;
            $scope.pageTitle = "Mission Control";
        });

        $scope.missioncontrol = {
            objects: {
                visibleSection: 'latest',
                show: function(sectionToShow) {
                    $scope.missioncontrol.objects.visibleSection = sectionToShow;
                }
            },
            leaderboards: {
                visibleSection: 'week',
                show: function(sectionToShow) {
                    $scope.missioncontrol.leaderboards.visibleSection = sectionToShow;
                }
            }
        }
    }]);

    missionControlApp.controller("searchController", ["$scope", "$rootScope", "missionControlService", function($scope, $rootScope, missionControlService) {

        $scope.search = function() {

            // Get query and broadcast
            var currentQuery = $scope.currentSearch.toQuery();
            $rootScope.$broadcast('startedSearching');

            // Make request
            missionControlService.search(currentQuery).then(function(response) {
                $rootScope.$broadcast('finishedSearching', currentQuery.searchTerm);
                $scope.searchResults = response.data;
            });
        };
    }]);

    missionControlApp.service("missionControlService", ["$http", function($http) {
        this.search = function(currentQuery) {
            return $http.post('/missioncontrol/search', { search: currentQuery });
        };
    }]);
})();