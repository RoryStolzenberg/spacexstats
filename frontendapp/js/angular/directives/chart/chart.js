(function() {
    var app = angular.module('app');

    app.directive('chart', [function() {
        return {
            restrict: 'E',
            scope: {
                chartData: '=',
                xAxisKey: '@',
                yAxisKey: '@'
            },
            link: function($scope, attr, elem) {

            },
            templateUrl: '/js/templates/chart.html'
        }
    }]);
})();