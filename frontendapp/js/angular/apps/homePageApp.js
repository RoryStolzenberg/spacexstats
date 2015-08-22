angular.module("homePageApp", ["directives.countdown"], ['$interpolateProvider', function($interpolateProvider) {
    $interpolateProvider.startSymbol('[[');
    $interpolateProvider.endSymbol(']]');

}]).controller("homePageController", ['$scope', function($scope) {
    $scope.statistics = laravel.statistics;
}]);
