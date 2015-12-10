(function() {
    var app = angular.module('app');

    app.directive('datetime', function() {
        return {
            require: 'ngModel',
            restrict: 'E',
            scope: {
                type: '@',
                datetimevalue: '=ngModel',
                startYear: '@',
                isNull: '=',
                disabled: '=?ngDisabled'
            },
            link: function($scope, element, attrs, ngModelController) {

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
                    var startYear = angular.isDefined($scope.startYear) ? $scope.startYear : 1950;

                    while (currentYear >= startYear) {
                        years.push(currentYear);
                        currentYear--;
                    }
                    return years;
                };

                //convert data from view format to model format
                ngModelController.$parsers.push(function(viewvalue) {

                    if ($scope.isNull == true) {
                        return null;
                    }

                    if (typeof data !== 'undefined' && moment(viewvalue).isValid()) {

                        if ($scope.type == 'datetime') {
                            var value = moment({
                                year: viewvalue.year,
                                month: viewvalue.month - 1,
                                date: viewvalue.date,
                                hour: viewvalue.hour,
                                minute: viewvalue.minute,
                                second: viewvalue.second
                            }).format('YYYY-MM-DD HH:mm:ss');

                        } else if ($scope.type == 'date') {
                            var value = moment({
                                year: viewvalue.year,
                                month: viewvalue.month - 1,
                                date: viewvalue.date
                            }).format('YYYY-MM-DD');
                        }
                    } else {

                        if ($scope.type == 'datetime') {
                            var value = viewvalue.year + "-"
                                + ("0" + viewvalue.month).slice(-2) + "-"
                                + ("0" + viewvalue.date).slice(-2) + " "
                                + ("0" + viewvalue.hour).slice(-2) + ":"
                                + ("0" + viewvalue.minute).slice(-2) + ":"
                                + ("0" + viewvalue.second).slice(-2);

                        } else {
                            var value = viewvalue.year + "-"
                                + ("0" + viewvalue.month).slice(-2) + "-"
                                + ("0" + viewvalue.date).slice(-2);
                        }
                    }
                    return value;
                });

                //convert data from model format to view format
                ngModelController.$formatters.push(function(data) {

                    // If the value is not undefined and the value is valid,
                    if (typeof data !== 'undefined' && moment(data).isValid()) {

                        var dt = moment(data);

                        if ($scope.type == 'datetime') {
                            return {
                                year: dt.year(),
                                month: dt.month() + 1,
                                date: dt.date(),
                                hour: dt.hour(),
                                minute: dt.minute(),
                                second: dt.second()
                            }
                        } else if ($scope.type == 'date') {
                            return {
                                year: dt.year(),
                                month: dt.month() + 1,
                                date: dt.date()
                            }
                        }
                    } else {

                        if ($scope.type == 'datetime') {
                            return {
                                year: moment().year(),
                                month: 0,
                                date: 0,
                                hour: 0,
                                minute: 0,
                                second: 0
                            }
                        } else if ($scope.type == 'date') {
                            return {
                                year: moment().year(),
                                month: 0,
                                date: 0
                            }
                        }
                    }
                });

                ngModelController.$render = function() {
                    $scope.year = ngModelController.$viewValue.year;
                    $scope.month = ngModelController.$viewValue.month;
                    $scope.date = ngModelController.$viewValue.date;

                    if ($scope.type == 'datetime') {
                        $scope.hour = ngModelController.$viewValue.hour;
                        $scope.minute = ngModelController.$viewValue.minute;
                        $scope.second = ngModelController.$viewValue.second;
                    }
                };

                $scope.dateIsComplete = function() {
                    return $scope.month !== 0 && $scope.date !== 0;
                };

                $scope.$watch('datetimevalue', function(value) {
                    if (typeof value === null) {
                        $scope.isNull = true;
                    }
                });

                $scope.$watch('year + month + date + hour + minute + second + isNull', function() {
                    ngModelController.$setViewValue({ year: $scope.year, month: $scope.month,date: $scope.date,hour: $scope.hour,minute: $scope.minute,second: $scope.second });
                });
            },
            templateUrl: '/js/templates/datetime.html'
        }
    });
})();