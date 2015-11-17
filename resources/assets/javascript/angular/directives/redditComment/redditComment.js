(function() {
    var app = angular.module('app');

    app.directive('redditComment', ["$http", function($http) {
        return {
            replace: true,
            restrict: 'E',
            scope: {
                redditComment: '=ngModel'
            },
            link: function($scope, element, attributes) {

                $scope.retrieveRedditComment = function() {
                    if (typeof $scope.redditComment.external_url !== "undefined") {
                        $http.get('/missioncontrol/create/retrieveredditcomment?url=' + encodeURIComponent($scope.redditComment.external_url)).then(function(response) {

                            // Set properties on object
                            $scope.redditComment.summary = response.data.data.body;
                            $scope.redditComment.author = response.data.data.author;
                            $scope.redditComment.reddit_comment_id = response.data.data.name;
                            $scope.redditComment.reddit_parent_id = response.data.data.parent_id; // make sure to check if the parent is a comment or not
                            $scope.redditComment.reddit_subreddit = response.data.data.subreddit;
                            $scope.redditComment.originated_at = moment.unix(response.data.data.created_utc).format();
                        });
                    }
                }

            },
            templateUrl: '/js/templates/redditComment.html'
        }
    }]);
})();