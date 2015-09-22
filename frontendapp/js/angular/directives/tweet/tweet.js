(function() {
    var app = angular.module('app');

    app.directive('tweet', ["$http", function($http) {
        return {
            restrict: 'E',
            scope: {
                action: '@',
                tweet: '='
            },
            link: function($scope, element, attributes, ngModelCtrl) {

                $scope.retrieveTweet = function() {
                    $http.get('/missioncontrol/retrievetweet').then(function(response) {

                    });
                }
            },
            templateUrl: '/js/templates/tweet.html'
        }
    }]);
})();