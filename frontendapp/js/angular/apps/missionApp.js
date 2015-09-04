angular.module("missionApp", [], ['$interpolateProvider', function($interpolateProvider) {
    $interpolateProvider.startSymbol('[[');
    $interpolateProvider.endSymbol(']]');

}]).controller("missionController", ['$scope', function($scope) {
    $scope.mission = new Mission();
    $scope.data = {

    }


}]).factory("Mission", function() {
    return function (mission) {
        var self = mission;

        return self;
    }
});


