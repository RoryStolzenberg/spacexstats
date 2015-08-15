angular.module("editUserApp", ["directives.selectList"], ['$interpolateProvider', function($interpolateProvider) {
    $interpolateProvider.startSymbol('[[');
    $interpolateProvider.endSymbol(']]');

}]).controller("editUserController", ['$http', '$scope', function($http, $scope) {

    $scope.username = 'badddffffffdd';

    $scope.profile = {
        summary: laravel.profile.summary,
        twitter_account: laravel.profile.twitter_account,
        reddit_account: laravel.profile.reddit_account,
        favorite_quote: laravel.profile.favorite_quote,
        favorite_mission: laravel.profile.favorite_mission,
        favorite_patch: laravel.profile.favorite_patch
    };

    $scope.updateProfile = function() {
        $http.post('/users/' + $scope.username + '/edit/profile')
    }

}]);
