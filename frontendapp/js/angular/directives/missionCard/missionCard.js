angular.module('directives.missionCard', []).directive('missionCard', function() {
    return {
        restrict: 'E',
        scope: {
            size: '@',
            mission: '='
        },
        link: function($scope) {
        },
        templateUrl: '/js/templates/missionCard.html'
    }
});
