angular.module("editUserApp", ["directives.selectList", "flashMessageService"], ['$interpolateProvider', function($interpolateProvider) {
    $interpolateProvider.startSymbol('[[');
    $interpolateProvider.endSymbol(']]');

}]).controller("editUserController", ['$http', '$scope', 'flashMessage', function($http, $scope, flashMessage) {

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
        $http.post('/users/' + $scope.username + '/edit/profile', $scope.profile)
            .then(function(response) {
                 console.log(response);
            });
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
        console.log(laravel);
        console.log($scope.emailNotifications);

        $http.post('/users/' + $scope.username + '/edit/emailnotifications',
            { 'emailNotifications': $scope.emailNotifications }
        )
            .then(function(response) {
                console.log(response);
            });
    }

    $scope.SMSNotification = {
        mobile: laravel.user.mobile
    }

    if (laravel.notifications.tMinus24HoursSMS === true) {
        $scope.SMSNotification.status = "tMinus24HoursSMS";
    } else if (laravel.notifications.tMinus3HoursSMS === true) {
        $scope.SMSNotification.status = "tMinus3HoursSMS";
    } else if (laravel.notifications.tMinus1HourSMS === true) {
        $scope.SMSNotification.status = "tMinus1HourSMS";
    } else {
        $scope.SMSNotification.status = null;
    }

    $scope.updateSMSNotifications = function() {
        $http.post('/users/' + $scope.username + '/edit/smsnotifications',
            { 'SMSNotification': $scope.SMSNotification }
        )
            .then(function(response) {
                flashMessage.add(response.data);
            });
    }

}]);

angular.module('flashMessageService', [])
    .service('flashMessage', function() {
        this.add = function(data) {
            $('#flash-message-container').append('<p class="flash-message ' + data.type + '">' + data.contents + '</p>');
            setTimeout(function() {
                $('.flash-message').slideUp(500, function() {
                   $(this).remove();
                });
            }, 3000);
        };
    });

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
        templateUrl: '/js/templates/selectList.html'
    }
});

