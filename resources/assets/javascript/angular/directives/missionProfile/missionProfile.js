(function() {
    var app = angular.module('app');

    app.directive('missionProfile', [function() {
        return {
            restrict: 'E',
            scope: {
                mission: '=ngModel'
            },
            link: function($scope, element, attributes) {

            },
            templateUrl: '/js/templates/missionProfile.html'
        }
    }]);
})();