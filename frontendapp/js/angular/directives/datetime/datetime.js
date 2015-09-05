angular.module('directives.datetime', []).directive('datetime', function() {
    return {
        restrict: 'E',
        scope: {
            type: '@',
            datetimevalue: '=ngModel',
            startYear: '@',
            nullable: '@'
        },
        link: function($scope) {
            if ($scope.datetimevalue != null) {
                var current = moment($scope.datetimevalue);

                $scope.datetime.year = current.year();
                $scope.datetime.month = current.month();
                $scope.datetime.day = current.day();
                $scope.datetime.hour = current.hour();
                $scope.datetime.minute = current.minute();
                $scope.datetime.second = current.second();

            } else {

            }

            $scope.days = function() {
                var days = [];
                days.push({ value: '00', display: '-'});

                for (i = 1; i <= 31; i++) {
                    days.push({ value: ('0' + i).slice(-2), display: i });
                }

                return days;
            };

            $scope.months = [
                { value: '00', display: '-'},
                { value: '01', display: 'January'},
                { value: '02', display: 'February'},
                { value: '03', display: 'March'},
                { value: '04', display: 'April'},
                { value: '05', display: 'May'},
                { value: '06', display: 'June'},
                { value: '07', display: 'July'},
                { value: '08', display: 'August'},
                { value: '09', display: 'September'},
                { value: '10', display: 'October'},
                { value: '11', display: 'November'},
                { value: '12', display: 'December'}
            ];

            $scope.years = function() {
                var years = [];

                var initialYear = moment().year();
                var currentYear = initialYear;

                if (typeof $scope.startYear !== 'undefined') {
                    var startYear = $scope.startYear;
                } else {
                    var startYear = 1950;
                }

                while (currentYear >= startYear) {
                    years.push({ value: currentYear, display: currentYear });
                    currentYear--;
                }

                return years;
            };

            $scope.$watch('datetime', function() {
                if ($scope.type == 'datetime') {

                } else if ($scope.type == 'date') {

                }
            });

        },
        templateUrl: '/js/templates/datetime.html'
    }
});

