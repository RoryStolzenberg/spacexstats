angular.module("editUserApp", ["directives.selectList"], ['$interpolateProvider', function($interpolateProvider) {
    $interpolateProvider.startSymbol('[[');
    $interpolateProvider.endSymbol(']]');

}]).controller("editUserController", ['$http', '$scope', function($http, $scope) {

    $scope.username = laravel.user.username;

    $scope.missions = laravel.missions;

    $scope.profile = {
        summary: laravel.user.profile.summary,
        twitter_account: laravel.user.profile.twitter_account,
        reddit_account: laravel.user.profile.reddit_account,
        favorite_quote: laravel.user.profile.favorite_quote,
        favorite_mission: laravel.user.profile.favorite_mission,
        favorite_patch: laravel.user.profile.favorite_patch
    };

    $scope.updateProfile = function() {
        $http.post('/users/' + $scope.username + '/edit/profile')
    }

    $scope.emailNotifications = {
        launchTimeChange: laravel.notifications.launchTimeChange,
        newMission: laravel.notifications.newMission,
        tMinus24HoursEmail: laravel.notifications.tMinus24HoursEmail,
        tMinus3HoursEmail: laravel.notifications.tMinus3HoursEmail,
        tMinus1HourEmail: laravel.notifications.tMinus1HourEmail,
        newsSummaries: laravel.notifications.newsSummaries
    }

    $scope.updateEmailNotifications = function() {
        $http.post('/users/' + $scope.username + '/edit/emailnotifications')
    }

    $scope.SMSNotification = {
        mobile: laravel.user.mobile,
        status: laravel.notifications.tMinus1HourSMS
    }

    $scope.updateSMSNotifications = function() {
        $http.post('/users/' + $scope.username + '/edit/smsnotifications')
    }

}]);

angular.module("directives.selectList", []).directive("selectList", function() {
    return {
        restrict: 'E',
        scope: {
            options: '=',
            hasDefaultOption: '@',
            selectedOption: '=',
            uniqueKey: '@',
            searchable: '@'
        },
        link: function($scope, element, attributes) {

            $scope.optionsObj = $scope.options.map(function(option) {
                return {
                    id: option[$scope.uniqueKey],
                    name: option.name,
                    image: option.featuredImage ? option.featuredImage.media_thumb_small : null
                };
            });

            $scope.$watch("selectedOption", function(newValue) {
                $scope.selectedOptionObj = $scope.optionsObj
                    .filter(function(option) {
                    return option['id'] == newValue;
                }).shift();
            });

            $scope.selectOption = function(option) {
                $scope.selectedOption = option['id'];
                $scope.dropdownIsVisible = false;
            }

            $scope.toggleDropdown = function() {
                $scope.dropdownIsVisible = !$scope.dropdownIsVisible;
            }

            $scope.$watch("dropdownIsVisible", function(newValue) {
                if (!newValue) {
                    $scope.search = "";
                }
            });

            $scope.isSelected = function(option) {
                return option.id == $scope.selectedOption;
            }

            $scope.dropdownIsVisible = false;
        },
        templateUrl: '/src/js/angular/directives/selectList/selectList.html'
    }
});

