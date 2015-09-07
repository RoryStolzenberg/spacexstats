angular.module('directives.datetime', []).directive('datetime', function() {
    return {
        restrict: 'E',
        replace: true,
        scope: {
            type: '@',
            datetimevalue: '=ngModel',
            startYear: '@',
            nullableToggle: '@',
            isNull: '@'
        },
        link: function($scope) {

            $scope.days = [];
            $scope.days.push({ value: '00', display: '-'});

            for (i = 1; i <= 31; i++) {
                $scope.days.push({ value: ('0' + i).slice(-2), display: i });
            }

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
                    years.push(currentYear);
                    currentYear--;
                }

                return years;
            };

            // Internal functions to change ngModel
            $scope.changeModel = {
                year: function() {
                    if ($scope.type == 'datetime') {

                    } else if ($scope.type == 'date') {

                    }
                },
                month: function() {
                    console.log($scope.datetime.month);
                    if ($scope.type == 'datetime') {

                    } else if ($scope.type == 'date') {

                    }
                },
                date: function() {
                    if ($scope.type == 'datetime') {

                    } else if ($scope.type == 'date') {

                    }
                },
                hour: function() {
                    if ($scope.type == 'datetime') {

                    } else if ($scope.type == 'date') {

                    }
                },
                minute: function() {
                    if ($scope.type == 'datetime') {

                    } else if ($scope.type == 'date') {

                    }
                },
                second: function() {
                    if ($scope.type == 'datetime') {

                    } else if ($scope.type == 'date') {

                    }
                }
            };

            // Watch for external changes and rerun the original function
            $scope.$watch('datetimevalue', function() {
                if ($scope.type == 'datetime') {
                    initialize();
                } else if ($scope.type == 'date') {
                    initialize();
                }
            }, true);

            // Set the initial datetime values
            var initialize = function() {
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
                        year: moment().year(),
                        month: '00',
                        day: '00',
                        hour: null,
                        minute: null,
                        second: null
                    };
                }
            };

            initialize();

        },
        templateUrl: '/js/templates/datetime.html'
    }
});

