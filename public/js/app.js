angular.module("homePageApp", ["directives.countdown"], ['$interpolateProvider', function($interpolateProvider) {
    $interpolateProvider.startSymbol('[[');
    $interpolateProvider.endSymbol(']]');

}]).controller("homePageController", ['$scope', function($scope) {
    $scope.statistics = laravel.statistics;
}]);

angular.module("futureMissionApp", ["directives.countdown", "flashMessageService"], ['$interpolateProvider', function($interpolateProvider) {
    $interpolateProvider.startSymbol('[[');
    $interpolateProvider.endSymbol(']]');

}]).controller("futureMissionController", ['$http', '$scope', 'flashMessage', function($http, $scope, flashMessage) {

    $scope.missionSlug = laravel.slug;
    $scope.launchDateTime = laravel.launchDateTime;
    $scope.launchSpecificity = laravel.launchSpecificity;

    $scope.$watch("launchSpecificity", function(newValue) {
        $scope.isLaunchExact =  (newValue == 6 || newValue == 7);
    });

    $scope.$watchCollection('[isLaunchExact, launchDateTime]', function(newValues) {
        if (newValues[0] === true) {
            $scope.launchUnixSeconds =  (moment(newValues[1]).unix());
        }
        $scope.launchUnixSeconds =  null;
    });

    $scope.lastRequest = moment().unix();
    $scope.secondsSinceLastRequest = 0;

    $scope.secondsToLaunch;

    $scope.requestFrequencyManager = function() {
        $scope.secondsSinceLastRequest = Math.floor($.now() / 1000) - $scope.lastRequest;
        $scope.secondsToLaunch = $scope.launchUnixSeconds - Math.floor($.now() / 1000);

        /*
         Make requests to the server for launchdatetime and webcast updates at the following frequencies:
         >24hrs to launch    =   1hr / request
         1hr-24hrs           =   15min / request
         20min-1hr           =   5 min / request
         <20min              =   30sec / request
         */
        var aRequestNeedsToBeMade = ($scope.secondsToLaunch >= 86400 && $scope.secondsSinceLastRequest >= 3600) ||
            ($scope.secondsToLaunch >= 3600 && $scope.secondsToLaunch < 86400 && $scope.secondsSinceLastRequest >= 900) ||
            ($scope.secondsToLaunch >= 1200 && $scope.secondsToLaunch < 3600 && $scope.secondsSinceLastRequest >= 300) ||
            ($scope.secondsToLaunch < 1200 && $scope.secondsSinceLastRequest >= 30);

        if (aRequestNeedsToBeMade === true) {
            // Make both requests then update the time since last request
            $scope.requestLaunchDateTime();
            $scope.requestWebcastStatus();
            $scope.lastRequest = moment().unix();
        }
    }

    $scope.requestLaunchDateTime = function() {
        $http.get('/missions/' + $scope.missionSlug + '/requestlaunchdatetime')
            .then(function(response) {
                // If there has been a change in the launch datetime, update
                if ($scope.launchDateTime !== response.data.launchDateTime) {
                    $scope.launchDateTime = response.data.launchDateTime;
                    $scope.launchSpecificity = response.data.launchSpecificity;

                    flashMessage.add({ type: 'success', contents: 'Launch time updated!' });
                }
            });
    }

    $scope.requestWebcastStatus = function() {
        $http.get('/webcast/getstatus')
            .then(function(response) {
                $scope.webcast.isLive = response.data.isLive;
                $scope.webcast.viewers = response.data.viewers;
            });
    }

    $scope.webcast = {
        isLive: laravel.webcast.isLive,
        viewers: laravel.webcast.viewers
    }

    $scope.$watchCollection('[webcast.isLive, secondsToLaunch]', function(newValues) {
        if (newValues[1] < (60 * 60 * 24) && newValues[0] == 'true') {
            $scope.webcast.status = 'webcast-live';
        } else if (newValues[1] < (60 * 60 * 24) && newValues[0] == 'false') {
            $scope.webcast.status = 'webcast-updates';
        } else {
            $scope.webcast.status = 'webcast-inactive';
        }
    });

    $scope.$watch('webcast.status', function(newValue) {
        if (newValue === 'webcast-live') {
            $scope.webcast.publicStatus = 'Live Webcast'
        } else if (newValue === 'webcast-updates') {
            $scope.webcast.publicStatus = 'Launch Updates'
        }
    }),

    $scope.$watch('webcast.viewers', function(newValue) {
        $scope.webcast.publicViewers = ' (' + newValue + ' viewers)';
    })

}]);

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


// Original jQuery countdown timer written by /u/EchoLogic, improved and optimized by /u/booOfBorg.
// Rewritten as an Angular directive for SpaceXStats 4
angular.module('directives.countdown', []).directive('countdown', ['$interval', function($interval) {
    return {
        restrict: 'E',
        scope: {
            specificity: '=',
            countdownTo: '=',
            callback: '&'
        },
        link: function($scope) {

            $scope.isLaunchExact = ($scope.specificity == 6 || $scope.specificity == 7);

            $scope.$watch('specificity', function(newValue) {
                $scope.isLaunchExact = (newValue == 6 || newValue == 7);
            });

            (function() {
                if ($scope.isLaunchExact) {

                    $scope.launchUnixSeconds = moment($scope.countdownTo).unix();


                    $scope.countdownProcessor = function() {

                        var launchUnixSeconds = $scope.launchUnixSeconds;
                        var currentUnixSeconds = Math.floor($.now() / 1000);

                        if (launchUnixSeconds >= currentUnixSeconds) {
                            $scope.secondsAwayFromLaunch = launchUnixSeconds - currentUnixSeconds;

                            var secondsBetween = $scope.secondsAwayFromLaunch;
                            // Calculate the number of days, hours, minutes, seconds
                            $scope.days = Math.floor(secondsBetween / (60 * 60 * 24));
                            secondsBetween -= $scope.days * 60 * 60 * 24;

                            $scope.hours = Math.floor(secondsBetween / (60 * 60));
                            secondsBetween -= $scope.hours * 60 * 60;

                            $scope.minutes = Math.floor(secondsBetween / 60);
                            secondsBetween -= $scope.minutes * 60;

                            $scope.seconds = secondsBetween;

                            $scope.daysText = $scope.days == 1 ? 'Day' : 'Days';
                            $scope.hoursText = $scope.hours == 1 ? 'Hour' : 'Hours';
                            $scope.minutesText = $scope.minutes == 1 ? 'Minute' : 'Minutes';
                            $scope.secondsText = $scope.seconds == 1 ? 'Second' : 'Seconds';

                            // Stop the countdown, count up!
                        } else {
                        }

                        if ($scope.callback && typeof $scope.callback === 'function') {
                            $scope.callback();
                        }
                    };

                    $interval($scope.countdownProcessor, 1000);
                } else {
                    $scope.countdownText = $scope.countdownTo;
                }
            })();

        },
        templateUrl: '/js/templates/countdown.html'
    }
}]);
