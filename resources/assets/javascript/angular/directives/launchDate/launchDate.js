// Original jQuery countdown timer written by /u/EchoLogic, improved and optimized by /u/booOfBorg.
// Rewritten as an Angular directive for SpaceXStats 4
(function() {
    var app = angular.module('app');

    app.directive('launchDate', ['$interval', function($interval) {
        return {
            restrict: 'E',
            scope: {
                isLaunchExact: '=',
                launchDateTime: '='
            },
            link: function($scope, elem, attrs) {
                /*
                 *   Timezone stuff.
                 */
                // Get the IANA Timezone identifier and format it into a 3 letter timezone.
                $scope.localTimezone = moment().tz(jstz.determine().name()).format('z');
                $scope.currentFormat = 'h:mm:ssa MMMM d, yyyy';
                $scope.currentTimezone;
                $scope.currentTimezoneFormatted = "Local ("+ $scope.localTimezone +")";

                $scope.setTimezone = function(timezoneToSet) {
                    if (timezoneToSet === 'local') {
                        $scope.currentTimezone = null;
                        $scope.currentTimezoneFormatted = "Local ("+ $scope.localTimezone +")";
                    } else if (timezoneToSet === 'ET') {
                        $scope.currentTimezone = moment().tz("America/New_York").format('z');
                        $scope.currentTimezoneFormatted = 'Eastern';
                    } else if (timezoneToSet === 'PT') {
                        $scope.currentTimezone = moment().tz("America/Los_Angeles").format('z');
                        $scope.currentTimezoneFormatted = 'Pacific';
                    } else {
                        $scope.currentTimezoneFormatted = $scope.currentTimezone = 'UTC';
                    }
                };

                $scope.displayDateTime = function() {
                    if ($scope.isLaunchExact) {
                        return $filter('date')($scope.launchDateTime.toDate(), $scope.currentFormat, $scope.currentTimezone);
                    } else {
                        return $scope.launchDateTime;
                    }

                };
            },
            templateUrl: '/js/templates/launchDate.html'
        }
    }]);
})();