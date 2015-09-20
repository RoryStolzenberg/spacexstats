angular.module("missionControlApp", ["directives.tags"]).controller("missionControlController", ["$scope", function($scope) {
    $scope.tags = [];
    $scope.selectedTags = [];
}]);