(function() {
    var app = angular.module('app');

    app.directive('redditComment', ["$http", function($http) {
        return {
            restrict: 'E',
            scope: {
                redditComment: '=ngModel'
            },
            link: function($scope, element, attributes) {

                $scope.$watch('redditComment.external_url', function() {
                    $scope.retrieveRedditComment();
                });

                $scope.retrieveRedditComment = function() {
                    if (typeof $scope.redditComment.external_url !== "undefined") {
                        $http.get('/missioncontrol/create/retrieveredditcomment?url=' + encodeURIComponent($scope.redditComment.external_url)).then(function(response) {
                            console.log(response);
                        });
                    }
                }

            },
            templateUrl: '/js/templates/redditComment.html'
        }
    }]);
})();