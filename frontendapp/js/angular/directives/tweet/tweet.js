(function() {
    var app = angular.module('app');

    app.directive('tweet', function() {
        return {
            restrict: 'E',
            scope: {
                state: '@',
                tweet: '='
            },
            link: function($scope, element, attributes, ngModelCtrl) {

            },
            templateUrl: '/js/templates/tweet.html'
        }
    });
})();