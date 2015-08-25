angular.module("uploadApp", ["directives.upload"], ['$interpolateProvider', function($interpolateProvider) {
    $interpolateProvider.startSymbol('[[');
    $interpolateProvider.endSymbol(']]');

}]).controller("uploadAppController", ["$scope", function($scope) {
    $scope.activeSection = "upload";

    $scope.changeSection = function(section) {
        $scope.activeSection = section;
    }

}]).controller("uploadController", ["$scope", function($scope) {
    $scope.activeUploadSection = "dropzone";

    $scope.buttonText = "Next";
    $scope.uploadedFiles = [];

    $scope.$watch("uploadedFiles", function() {
        console.log('called');
    });

    $scope.someFunc = function() {
        console.log('lol');
    }

}]).controller("postController", ["$scope", function($scope) {

}]).controller("writeController", ["$scope", function($scope) {

}]).run(['$rootScope', function($rootScope) {
    $rootScope.postToMissionControl = function() {

    }
}]);
