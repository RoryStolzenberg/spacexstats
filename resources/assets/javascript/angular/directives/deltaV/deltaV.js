(function() {
    var app = angular.module('app');

    app.directive('deltaV', function() {
        return {
            restrict: 'E',
            scope: {
                deltaV: '=ngModel'
            },
            link: function($scope, element, attributes) {

                $scope.constants = {
                    SECONDS_PER_DAY: 86400,
                    DELTAV_TO_DAY_CONVERSION_RATE: 1000
                };

                $scope.$watch("deltaV", function(object) {
                    if (typeof object !== 'undefined') {
                        var calculatedValue = $scope.calculate(object);
                        $scope.setCalculatedValue(calculatedValue);
                    }
                }, true);

                $scope.calculate = function(object) {
                    console.log(object);
                    var internalValue = 0;
                    Object.getOwnPropertyNames(object).forEach(function(key) {
                        if (key == 'mission_id') {
                            if (typeof key !== 'undefined') {
                                //internalValue
                            }
                        }
                    });
                    return internalValue;
                };

                $scope.setCalculatedValue = function(calculatedValue) {
                    $scope.calculatedValue.deltaV = calculatedValue;

                    var seconds = $scope.calculatedValue.deltaV * ($scope.constants.SECONDS_PER_DAY / $scope.constants.DELTAV_TO_DAY_CONVERSION_RATE);

                    $scope.calculatedValue.time = seconds + ' seconds';
                };

                $scope.calculatedValue = {
                    deltaV: 0,
                    time: 0
                };
            },
            templateUrl: '/js/templates/deltaV.html'
        }
    });
})();