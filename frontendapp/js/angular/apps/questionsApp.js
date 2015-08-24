angular.module('questionsApp', [], ['$interpolateProvider', function($interpolateProvider) {
    $interpolateProvider.startSymbol('[[');
    $interpolateProvider.endSymbol(']]');

}]).controller("questionsController", ["$scope", function($scope) {
    $scope
}]);
