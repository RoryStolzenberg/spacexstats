(function() {
    var app = angular.module('app');

    app.directive('missionCard', function() {
        return {
            restrict: 'E',
            replace: true,
            scope: {
                mission: '='
            },
            link: function($scope) {
            },
            templateUrl: '/js/templates/missionCard.html'
        }
    });
})();