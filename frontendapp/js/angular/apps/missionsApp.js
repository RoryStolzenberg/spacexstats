angular.module("missionsApp", ["directives.missionCard"], ['$interpolateProvider', function($interpolateProvider) {
    $interpolateProvider.startSymbol('[[');
    $interpolateProvider.endSymbol(']]');

}]).controller("missionsController", ['$scope', function($scope) {
    $scope.missions = laravel.missions;
}]);