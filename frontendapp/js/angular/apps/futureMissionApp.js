angular.module("editUserApp", ["directives.selectList", "flashMessageService"], ['$interpolateProvider', function($interpolateProvider) {
    $interpolateProvider.startSymbol('[[');
    $interpolateProvider.endSymbol(']]');

}]).controller("editUserController", ['$http', '$scope', 'flashMessage', function($http, $scope, flashMessage) {

}]);
