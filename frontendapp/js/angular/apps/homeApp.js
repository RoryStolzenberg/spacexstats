(function() {
    var app = angular.module('app', ['duScroll']);

    app.value('duScrollDuration', 1000);

    app.controller("homeController", ['$scope', 'Statistic', function($scope, Statistic) {
        $scope.statistics = [];
        $scope.activeStatistic = false;

        $scope.goToClickedStatistic = function(statisticType) {
            history.replaceState('', document.title, '#' + statisticType);
            $scope.activeStatistic = statisticType;
        };

        $scope.goToNeighborStatistic = function(index) {
            if (index >= 0 && index < $scope.statistics.length) {
                var stat = $scope.statistics[index];

                history.replaceState('', document.title, '#' + stat.camelCaseType);
                $scope.activeStatistic = stat.camelCaseType;

                return stat.camelCaseType;
            } else {
                $scope.goHome();
            }
        };

        $scope.goToFirstStatistic = function() {

        };

        $scope.goHome = function() {
            history.replaceState('', document.title, window.location.pathname);
            $scope.activeStatistic = false;
            return 'home';
        };

        /*$window.on('scroll',
            $.debounce(100, function() {
                $('div[data-stat]').fracs('max', 'visible', function(best) {
                    $scope.activeStatistic($(best).data('stat'));
                });
            })
        );*/

        (function() {
            laravel.statistics.forEach(function(statistic) {
                $scope.statistics.push(new Statistic(statistic));
            });

            if (window.location.hash) {
                $scope.activeStatistic = window.location.hash.substring(1);
            }
        })();
    }]);

    app.factory('Statistic', function() {
        return function(statistic) {

            var self = {};

            self.changeSubstatistic = function(newSubstatistic) {
                self.activeSubstatistic = newSubstatistic;
            };

            statistic.forEach(function(substatistic) {

                if (!self.substatistics) {

                    self.substatistics = [];
                    self.activeSubstatistic = substatistic;
                    self.type = substatistic.type;
                    self.camelCaseType = self.type.replace(" ", "");
                }

                self.substatistics.push(substatistic);
            });

            return self;
        }
    });
})();