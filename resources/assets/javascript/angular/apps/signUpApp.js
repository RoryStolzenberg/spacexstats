(function() {
    var signUpApp = angular.module('app', []);

    signUpApp.controller("signUpController", ["$scope", function($scope) {
        $scope.togglePassword = function() {
            console.log('test');
        }
    }]);
})();