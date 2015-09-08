angular.module('directives.datetime', []).directive('datetime', function() {
    return {
        require: 'ngModel',
        restrict: 'E',
        replace: true,
        scope: {
            type: '@',
            datetimevalue: '=ngModel',
            startYear: '@',
            nullableToggle: '@',
            isNull: '@'
        },
        link: function($scope, element, attrs, ctrl) {

            $scope.days = [];
            $scope.days.push({ value: 0, display: '-'});

            for (i = 1; i <= 31; i++) {
                $scope.days.push({ value: i, display: i });
            }

            $scope.months = [
                { value: 0, display: '-'},
                { value: 1, display: 'January'},
                { value: 2, display: 'February'},
                { value: 3, display: 'March'},
                { value: 4, display: 'April'},
                { value: 5, display: 'May'},
                { value: 6, display: 'June'},
                { value: 7, display: 'July'},
                { value: 8, display: 'August'},
                { value: 9, display: 'September'},
                { value: 10, display: 'October'},
                { value: 11, display: 'November'},
                { value: 12, display: 'December'}
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

            //convert data from view format to model format
            ctrl.$parsers.push(function(viewvalue) {

                console.log("parser");
                console.log(viewvalue);

                if (moment(viewvalue).isValid()) {
                    var value = moment({
                        year: viewvalue.year,
                        month: viewvalue.month - 1,
                        date: viewvalue.date,
                        hour: viewvalue.hour,
                        minute: viewvalue.minute,
                        second: viewvalue.second
                    }).format('YYYY-MM-DD HH:mm:ss');

                    console.log(value);
                    return value;
                } else {
                    return null;
                }
            });

            ctrl.$render = function() {

                console.log("render");
                console.log(ctrl.$viewValue);

                $scope.year = ctrl.$viewValue.year;
                $scope.month = ctrl.$viewValue.month;
                $scope.date = ctrl.$viewValue.date;
                $scope.hour = ctrl.$viewValue.hour;
                $scope.minute = ctrl.$viewValue.minute;
                $scope.second = ctrl.$viewValue.second;
            };

            //convert data from model format to view format
            ctrl.$formatters.push(function(data) {

                console.log("formatter");
                console.log(data);

                if (data != null) {
                    var dt = moment(data);

                    return {
                        year: dt.year(),
                        month: dt.month() + 1,
                        date: dt.date(),
                        hour: dt.hour(),
                        minute: dt.minute(),
                        second: dt.second()
                    }
                } else {
                    return {
                        year: moment().year(),
                        month: 0,
                        date: 0,
                        hour: 0,
                        minute: 0,
                        second: 0
                    }
                }
            });

            $scope.$watch('year + month + date + hour + minute + second', function() {
                console.log("watch");
                ctrl.$setViewValue({ year: $scope.year, month: $scope.month,date: $scope.date,hour: $scope.hour,minute: $scope.minute,second: $scope.second });
            });

        },
        templateUrl: '/js/templates/datetime.html'
    }
});

