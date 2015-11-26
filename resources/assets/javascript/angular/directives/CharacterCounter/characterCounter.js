(function() {
    var app = angular.module('app');

    app.directive('characterCoutner', function() {
        return {
            restrict: 'E',
            scope: {
                model: '=ngModel'
            },
            link: function($scope, element, attributes) {
            },
            template: '<p>{{ characterCounterOutput }}</p>'
        }
    });
})();