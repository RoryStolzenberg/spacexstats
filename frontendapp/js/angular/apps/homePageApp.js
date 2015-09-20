(function() {
    var app = angular.module('app', []);

    app.controller("homePageController", ['$scope', 'Statistic', function($scope, Statistic) {
        $scope.statistics = [];

        $scope.activeStatistic = false;

        laravel.statistics.forEach(function(statistic) {
            $scope.statistics.push(new Statistic(statistic));
        });

        $scope.goToClickedStatistic = function(statisticType) {
            $scope.activeStatistic = statisticType;
        }

        $scope.goToPreviousStatistic = function() {

        }

        $scope.goToNextStatistic = function() {

        }

        $scope.$watch("activeStatistic", function(newValue, oldValue) {

        });
    }]);

    app.factory('Statistic', ['Substatistic', function(Substatistic) {
        return function(statistic) {

            var self = {};

            statistic.forEach(function(substatistic) {

                var substatisticObject = new Substatistic(substatistic);

                if (!self.substatistics) {

                    self.substatistics = [];
                    self.activeSubstatistic = substatisticObject;
                    self.type = substatisticObject.type;
                }

                self.substatistics.push(substatisticObject);
            });

            self.changeSubstatistic = function(newSubstatistic) {
                self.activeSubstatistic = newSubstatistic;
            };

            return self;
        }
    }]);

    app.factory('Substatistic', function() {
        return function(substatistic) {

            var self = substatistic;
            return self;
        }
    });
})();