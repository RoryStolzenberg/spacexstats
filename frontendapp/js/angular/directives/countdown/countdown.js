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
