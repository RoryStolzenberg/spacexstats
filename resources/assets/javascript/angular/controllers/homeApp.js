(function() {
    var app = angular.module('app', ['duScroll', 'ngAnimate']);

    app.controller("homeController", ['$scope', '$rootScope', '$document', '$window', 'Statistic', function($scope, $rootScope, $document, $window, Statistic) {
        $scope.statistics = [];
        $scope.activeStatistic = null;

        $scope.goToClickedStatistic = function(statistic) {
            $scope.scrollToAndMakeActive(statistic);
        };

        $scope.goToFirstStatistic = function() {
            $scope.scrollToAndMakeActive($scope.statistics[0]);
        };

        $scope.goToNeighborStatistic = function(index) {
            if (index >= 0 && index < $scope.statistics.length) {
                $scope.scrollToAndMakeActive($scope.statistics[index]);
                return $scope.activeStatistic.camelCaseType;

            } else {
                $scope.goHome();
            }
        };

        $scope.goHome = function() {
            $scope.scrollToAndMakeActive(null, true);
        };

        $scope.keypress = function(event) {
            // Currently using jQuery.event.which to detect keypresses, keyCode is deprecated, use KeyboardEvent.key eventually:
            // https://developer.mozilla.org/en-US/docs/Web/API/KeyboardEvent/key

            // event.key == down
            if (event.which == 40) {
                if ($scope.activeStatistic == null) {
                    $scope.goToFirstStatistic();

                } else if ($scope.activeStatistic == $scope.statistics[$scope.statistics.length - 1]) {
                    $scope.goHome();

                } else {
                    $scope.scrollToAndMakeActive($scope.statistics[$scope.statistics.indexOf($scope.activeStatistic) + 1]);
                }
            }

            // event.key == up
            else if (event.which == 38) {
                if ($scope.activeStatistic == null) {
                    $scope.scrollToAndMakeActive($scope.statistics[$scope.statistics.length - 1]);

                } else if ($scope.activeStatistic == $scope.statistics[0]) {
                    $scope.goHome();

                } else {
                    $scope.scrollToAndMakeActive($scope.statistics[$scope.statistics.indexOf($scope.activeStatistic) - 1]);
                }
            }

            // event.key == left
            else if (event.which == 37) {
                if ($scope.activeStatistic == null) {
                    return;
                }

                if ($scope.activeStatistic.activeSubstatistic == $scope.activeStatistic.substatistics[0]) {
                    $scope.activeStatistic.changeSubstatistic($scope.activeStatistic.substatistics[$scope.activeStatistic.substatistics.length - 1]);

                } else {
                    $scope.activeStatistic.changeSubstatistic($scope.activeStatistic.substatistics[$scope.activeStatistic.substatistics.indexOf($scope.activeStatistic.activeSubstatistic) - 1]);
                }
            }

            else if (event.which == 39) {
                if ($scope.activeStatistic == null) {
                    return;
                }

                if ($scope.activeStatistic.activeSubstatistic == $scope.activeStatistic.substatistics[$scope.activeStatistic.substatistics.length - 1]) {
                    $scope.activeStatistic.changeSubstatistic($scope.activeStatistic.substatistics[0]);

                } else {
                    $scope.activeStatistic.changeSubstatistic($scope.activeStatistic.substatistics[$scope.activeStatistic.substatistics.indexOf($scope.activeStatistic.activeSubstatistic) + 1]);
                }
            }

        };

        $scope.scrollToAndMakeActive = function(statistic, setToDefault) {
            if (setToDefault === true) {
                history.replaceState('', document.title, window.location.pathname);
                $scope.activeStatistic = null;
                $document.scrollToElement(angular.element(document.getElementById('home')), 0, 1000);;
            } else {
                $scope.activeStatistic = statistic;
                $document.scrollToElement(angular.element(document.getElementById(statistic.camelCaseType)), 0, 1000);
            }
            return $scope.activeStatistic;
        };

        $rootScope.$on('duScrollspy:becameActive', function($event, $element, $target) {
            if ($element.prop('id') == 'home') {
                history.replaceState('', document.title, window.location.pathname);
                $scope.activeStatistic = null;
            } else {
                $scope.activeStatistic = $scope.statistics.filter(function(statistic) {
                    return statistic.camelCaseType == $element.prop('id');
                })[0];
                history.replaceState('', document.title, '#' + $scope.activeStatistic.camelCaseType);
            }
            $scope.$apply();
        });

        (function() {
            laravel.statistics.forEach(function(statistic) {
                $scope.statistics.push(new Statistic(statistic));
            });

            // If a hash exists, preset it
            if (window.location.hash) {
                $scope.activeStatistic = $scope.statistics.filter(function(statistic) {
                    return statistic.camelCaseType == window.location.hash.substring(1);
                })[0];
            }
        })();
    }]);

    app.factory('Statistic', ["$timeout", "$rootScope", function($timeout, $rootScope) {
        return function(statistic) {

            var self = {};

            self.show = true;

            self.changeSubstatistic = function(newSubstatistic) {
                self.show = false;

                var done = $timeout(function () {
                    self.activeSubstatistic = newSubstatistic;
                    self.show = true;
                    $rootScope.$apply();

                }, 300);

                if (newSubstatistic.display == 'barchart') {
                    done.then(function() {
                        $rootScope.$broadcast('chart:rerender');
                    });
                }
            };

            statistic.forEach(function(substatistic) {

                if (!self.substatistics) {

                    self.substatistics = [];
                    self.activeSubstatistic = substatistic;
                    self.type = substatistic.type;
                    self.camelCaseType = self.type.replace(/\W/g, "");
                }

                if (substatistic.display == 'barchart') {
                    substatistic.chartType = 'bar';
                }

                self.substatistics.push(substatistic);
            });

            return self;
        }
    }]);
})();