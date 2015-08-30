angular.module('directives.deltaV', []).directive('deltaV', function() {
    return {
        restrict: 'A',
        scope: {
            deltaV: '='
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
        template: '<span>[[ calculatedValue ]] m/s of dV</span>'
    }
});

