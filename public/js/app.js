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
                flashMessage.add(response.data);
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

angular.module("editUserApp", ["directives.selectList", "flashMessageService"], ['$interpolateProvider', function($interpolateProvider) {
    $interpolateProvider.startSymbol('[[');
    $interpolateProvider.endSymbol(']]');

}]).controller("editUserController", ['$http', '$scope', 'flashMessage', function($http, $scope, flashMessage) {

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

// Original jQuery countdown timer written by /u/EchoLogic, improved and optimized by /u/booOfBorg.
// Rewritten as an Angular directive for SpaceXStats 4
angular.module('directives.countdown', []).directive('countdown', function() {
    return {
        restrict: 'E',
        scope: {
            specificity: '@',
            countdownTo: '=',
            callback: '&'
        },
        link: function($scope) {

            $scope.isLaunchExact = $scope.$watch('specificity', function(newValue) {
                return (newValue == 6 || newValue == 7);
            });

            self.init = (function() {
                if ($scope.isLaunchExact()) {
                    $scope.launchUnixSeconds = moment($scope.countdownTo).unix();

                    $scope.days = null;
                    $scope.hours = null;
                    $scope.minutes = null;
                    $scope.seconds = null;

                    $scope.daysText = null;
                    $scope.hoursText = null;
                    $scope.minutesText = null;
                    $scope.secondsText = null;

                    $scope.countdownProcessor = function() {
                        var launchUnixSeconds = $scope.launchUnixSeconds();
                        var currentUnixSeconds = Math.floor($.now() / 1000);


                        if (launchUnixSeconds >= currentUnixSeconds) {
                            $scope.secondsAwayFromLaunch(launchUnixSeconds - currentUnixSeconds);
                            var secondsBetween = $scope.secondsAwayFromLaunch();
                            // Calculate the number of days, hours, minutes, seconds
                            $scope.days(Math.floor(secondsBetween / (60 * 60 * 24)));
                            secondsBetween -= $scope.days() * 60 * 60 * 24;

                            $scope.hours(Math.floor(secondsBetween / (60 * 60)));
                            secondsBetween -= $scope.hours() * 60 * 60;

                            $scope.minutes(Math.floor(secondsBetween / 60));
                            secondsBetween -= $scope.minutes() * 60;

                            $scope.seconds(secondsBetween);

                            $scope.daysText($scope.days() == 1 ? 'Day' : 'Days');
                            $scope.hoursText($scope.hours() == 1 ? 'Hour' : 'Hours');
                            $scope.minutesText($scope.minutes() == 1 ? 'Minute' : 'Minutes');
                            $scope.secondsText($scope.seconds() == 1 ? 'Second' : 'Seconds');

                            // Stop the countdown, count up!
                        } else {

                        }

                        if (params.callback && typeof params.callback === 'function') {
                            params.callback();
                        }
                    };

                    setInterval($scope.countdownProcessor, 1000);
                } else {
                    $scope.countdownText = $scope.countdownTo;
                }
            })();

        },
        templateUrl: '/js/templates/countdown.html'
    }
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

