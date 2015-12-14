(function() {
    var app = angular.module('app');

    app.directive('deltaV', function() {
        return {
            restrict: 'E',
            scope: {
                object: '=ngModel',
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

                $scope.$watch("object", function(object) {
                    if (typeof object !== 'undefined') {
                        var calculatedValue = $scope.calculate(object);
                        $scope.setCalculatedValue(calculatedValue);
                    }
                }, true);

                $scope.calculate = function(object) {
                    var internalValue = 0;

                    // typeRegime
                    internalValue += baseTypeScores[$scope.hint];

                    // specialTypeRegime
                    if (object.subtype !== null) {
                        if (object.subtype in specialTypeMultiplier) {
                            internalValue *= specialTypeMultiplier[object.subtype];
                        }
                    }

                    // resourceQualityRegime
                    switch ($scope.hint) {
                        case 'Image':
                            internalValue += subscores.megapixels(object);
                            break;

                        case 'GIF':
                            internalValue += subscores.megapixels(object) * subscores.minutes(object);
                            break;

                        case 'Video':
                            internalValue += subscores.megapixels(object) * subscores.minutes(object);
                            break;

                        case 'Audio':
                            internalValue += subscores.minutes(object);
                            break;

                        case 'Document':
                            internalValue += subscores.pages(object);
                            break;
                    }

                    // metadataRegime
                    if (object.summary) {
                        internalValue += object.summary.length * metadataScore.summary.perCharacter;
                    }
                    if (object.author) {
                        internalValue += object.author.length * metadataScore.author.perCharacter;
                    }
                    if (object.attribution) {
                        internalValue += object.attribution.length * metadataScore.attribution.perCharacter;
                    }
                    if (object.tags) {
                        internalValue += object.tags.length * metadataScore.tags.perTag;
                    }

                    // dateAccuracyRegime
                    if (object.originated_at) {
                        var month = object.originated_at.substr(5, 2);
                        var date = object.originated_at.substr(8, 2);
                        var datetime = object.originated_at.substr(11, 8);

                        if (datetime !== '00:00:00' && datetime !== '') {
                            internalValue *= dateAccuracyMultiplier.datetime;
                        } else if (date !== '00') {
                            internalValue *= dateAccuracyMultiplier.date;
                        } else if (month !== '00') {
                            internalValue *= dateAccuracyMultiplier.month;
                        } else {
                            internalValue *= dateAccuracyMultiplier.year;
                        }
                    }

                    // dataSaverRegime
                    if (object.external_url) {
                        internalValue *= dataSaverMultiplier.hasExternalUrl;
                    }

                    // originalContentRegime
                    if (object.original_content === true) {
                        internalValue *= originalContentMultiplier.isOriginalContent;
                    }

                    return Math.round(internalValue);
                };

                $scope.setCalculatedValue = function(calculatedValue) {
                    $scope.calculatedValue.deltaV = calculatedValue;
                    var seconds = Math.round($scope.calculatedValue.deltaV * ($scope.constants.SECONDS_PER_DAY / $scope.constants.DELTAV_TO_DAY_CONVERSION_RATE));
                    $scope.calculatedValue.time = seconds + ' seconds';
                };

                $scope.calculatedValue = {
                    deltaV: 0,
                    time: 0
                };

                var subscores = {
                    megapixels: function(object) {
                        if (object.dimension_width && object.dimension_height) {
                            var megapixels = (object.dimension_width * object.dimension_height) / 1000000;
                            return resourceQuality.multipliers.perMegapixel * megapixels;
                        }
                        return 0;
                    },
                    minutes: function(object) {
                        if (object.duration) {
                            return resourceQuality.multipliers.perMinute * (object.duration / 60);
                        }
                        return 0;
                    },
                    pages: function(object) {
                        if (object.page_count) {
                            return resourceQuality.scores.perPage * object.page_count;
                        }
                        return 0;
                    }
                }
            },
            templateUrl: '/js/templates/deltaV.html'
        }
    });
})();