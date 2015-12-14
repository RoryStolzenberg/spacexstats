(function() {
    var app = angular.module('app');

    app.directive('objectCard', function() {
        return {
            restrict: 'E',
            replace: true,
            scope: {
                object: '='
            },
            link: function($scope) {
            },
            templateUrl: '/js/templates/objectCard.html'
        }
    });
})();