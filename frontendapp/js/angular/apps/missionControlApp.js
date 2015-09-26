(function() {
    var missionControlApp = angular.module("app", []);

    missionControlApp.controller("missionControlController", ["$scope", function($scope) {
        $scope.tags = [];
        $scope.selectedTags = [];
    }]);
})();