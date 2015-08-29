angular.module("missionControlApp", ["directives.tags"], ['$interpolateProvider', function($interpolateProvider) {
    $interpolateProvider.startSymbol('[[');
    $interpolateProvider.endSymbol(']]');

}]).controller("missionControlController", ["$scope", function($scope) {
    $scope.tags = [];
    $scope.selectedTags = [];
}]);