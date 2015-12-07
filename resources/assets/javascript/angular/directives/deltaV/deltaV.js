(function() {
    var app = angular.module('app');

    app.directive('deltaV', function() {
        return {
            restrict: 'E',
            scope: {
                deltaV: '=ngModel',
                hint: '@'
            },
            link: function($scope, element, attributes) {

                $scope.constants = {
                    SECONDS_PER_DAY: 86400,
                    DELTAV_TO_DAY_CONVERSION_RATE: 1000
                };

                var baseTypeScores = {
                    Image: 10,
                    GIF: 10,
                    Audio: 20,
                    Video: 20,
                    Document: 20,
                    Tweet: 5,
                    Article: 10,
                    Comment: 5,
                    Webpage: 10,
                    Text: 10
                };

                var specialTypeMultiplier = {
                    "Mission Patch": 2,
                    "Photo": 1.1,
                    "Launch Video": 2,
                    "Press Kit": 2,
                    "Weather Forecast": 2,
                    "Press Conference": 1.5
                };

                var resourceQuality = {
                    multipliers: {
                        perMegapixel: 5,
                        perMinute: 2
                    },
                    scores: {
                        perPage: 2
                    }
                };

                var metadataScore = {
                    summary: {
                        perCharacter: 0.02
                    },
                    author: {
                        perCharacter: 0.2
                    },
                    attribution: {
                        perCharacter: 0.1
                    },
                    tags: {
                        perTag: 1
                    }
                };

                var dateAccuracyMultiplier = {
                    year: 1,
                    month: 1.05,
                    date: 1.1,
                    datetime: 1.2
                };

                var dataSaverMultiplier = {
                    hasExternalUrl: 2
                };

                var originalContentMultiplier = {
                    isOriginalContent: 1.5
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