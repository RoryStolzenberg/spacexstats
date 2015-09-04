angular.module('directives.missionCard', []).directive('missionCard', function() {
    return {
        restrict: 'E',
        scope: {
            size: '@',
            mission: '='
        },
        link: function($scope) {
            console.log($scope.mission);
        },
        templateUrl: '/js/templates/missionCard.html'
    }
});
