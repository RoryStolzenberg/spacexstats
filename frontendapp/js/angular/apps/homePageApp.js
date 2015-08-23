angular.module("homePageApp", ["directives.countdown"], ['$interpolateProvider', function($interpolateProvider) {
    $interpolateProvider.startSymbol('[[');
    $interpolateProvider.endSymbol(']]');

}]).controller("homePageController", ['$scope', 'Statistic', function($scope, Statistic) {
    $scope.statistics = [];

    $scope.activeStatistic;

    laravel.statistics.forEach(function(statistic) {
        $scope.statistics.push(new Statistic(statistic));
    });

    $scope.goToClickedStatistic = function() {

    }

    $scope.goToPreviousStatistic = function() {

    }

    $scope.goToNextStatistic = function() {

    }
}])

.factory('Statistic', ['Substatistic', function(Substatistic) {
    return function(statistic) {

        var self = {};

        self.substatistics = [];

        statistic.forEach(function(substatistic) {
             self.substatistics.push(new Substatistic(substatistic));
        });

        self.isActiveStatistic = false;

        self.activeSubstatistic = 0;

        self.changeSubstatistic = function() {

        }

        return self;
    }
}])

.factory('Substatistic', function() {
    return function(substatistic) {

        var self = substatistic;

        return self;
    }
});
