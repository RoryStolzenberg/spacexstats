(function() {
    var app = angular.module('app');

    app.directive('deltaV', function() {
        return {
            restrict: 'E',
            scope: {
                deltaV: '=ngModel'
            },
            link: function($scope, element, attributes) {

                $scope.$watch("deltaV", function(files) {
                    if (typeof files !== 'undefined') {
                        files.forEach(function(file) {
                            console.log(Object.prototype.toString.call(file));
                        });
                    }
                });

                $scope.calculatedValue = 0;
            },
            templateUrl: '/js/templates/deltaV.html'
        }
    });
})();