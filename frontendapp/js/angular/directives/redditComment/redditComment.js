angular.module('directives.redditComment', []).directive('redditComment', function() {
    return {
        restrict: 'E',
        scope: {
            redditComment: '=ngModel'
        },
        link: function($scope, element, attributes) {

            $scope.retrieveRedditComment = function() {
                $http.get('/missioncontrol/create/retrieveredditcomment?url=' + encodeURIComponent($scope.redditcomment.external_url));
            }

        },
        templateUrl: '/js/templates/redditComment.html'
    }
});


