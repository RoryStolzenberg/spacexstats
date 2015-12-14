(function() {
    var app = angular.module('app');

    app.directive('tweet', ["$http", function($http) {
        return {
            restrict: 'E',
            scope: {
                tweet: '='
            },
            link: function($scope, element, attributes, ngModelCtrl) {

                $scope.retrieveTweet = function() {

                    // Check that the entered URL contains 'twitter' before sending a request (perform more thorough validation serverside)
                    if (typeof $scope.tweet.external_url !== 'undefined' && $scope.tweet.external_url.indexOf('twitter.com') !== -1) {

                        var explodedVals = $scope.tweet.external_url.split('/');
                        var id = explodedVals[explodedVals.length - 1];

                        $http.get('/missioncontrol/create/retrievetweet?id=' + id).then(function(response) {
                            // Set parameters
                            $scope.tweet.tweet_id = id;
                            $scope.tweet.tweet_text = response.data.text;
                            $scope.tweet.tweet_user_profile_image_url = response.data.user.profile_image_url.replace("_normal", "");
                            $scope.tweet.tweet_screen_name = response.data.user.screen_name;
                            $scope.tweet.tweet_user_name = response.data.user.name;
                            $scope.tweet.originated_at = moment(response.data.created_at, 'dddd MMM DD HH:mm:ss Z YYYY').utc().format('YYYY-MM-DD HH:mm:ss');

                        });
                    } else {
                        $scope.tweet = {};
                    }

                    if (angular.isDefined($scope.tweet.external_url)) {
                        $scope.tweetRetrievedFromUrl = $scope.tweet.external_url.indexOf('twitter.com') !== -1;
                    } else {
                        $scope.tweetRetrievedFromUrl = false;
                    }
                }
            },
            templateUrl: '/js/templates/tweet.html'
        }
    }]);
})();