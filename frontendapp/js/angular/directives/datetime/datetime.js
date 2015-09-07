angular.module('directives.datetime', []).directive('datetime', function() {
    return {
        restrict: 'E',
        replace: true,
        scope: {
            type: '@',
            datetimevalue: '=ngModel',
            startYear: '@',
            isNullable: '@'
        },
        link: function($scope) {

            if ($scope.datetimevalue != null) {
                var current = moment($scope.datetimevalue);

                $scope.datetime = {
                    year: current.year(),
                    month: current.month(),
                    day: current.month(),
                    hour: current.hour(),
                    minute: current.minute(),
                    second: current.second()
                };

            } else {
                $scope.datetime = {
                    year: null,
                    month: null,
                    day: null,
                    hour: null,
                    minute: null,
                    second: null
                };
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

                var currentYear = moment().year();

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

            $scope.changeNull = function() {
                console.log($scope.isNull);
                $scope.datetime = {
                    year: null,
                    month: null,
                    day: null,
                    hour: null,
                    minute: null,
                    second: null
                };
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

