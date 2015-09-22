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

                    // Check that the entered URL contains 'twitter' before sending a request (perform more thorough validation serverside)
                    if ($scope.tweet.external_url.indexOf('twitter.com') !== -1) {

                        var explodedVals = $scope.tweet.external_url.split('/');
                        var id = explodedVals[explodedVals.length - 1];

                        $http.get('/missioncontrol/retrievetweet').then(function(response) {
                            // Set parameters
                            self.tweet.tweet_text(response.text);
                            self.tweet.tweet_user_profile_image_url(response.user.profile_image_url.replace("_normal", ""));
                            self.tweet.tweet_user_screen_name(response.user.screen_name);
                            self.tweet.tweet_user_name(response.user.name);
                            self.tweet.tweet_created_at(moment(response.created_at).format());

                        });
                    }
                    // Toggle disabled state somewhere around here
                }
            },
            templateUrl: '/js/templates/tweet.html'
        }
    }]);
})();