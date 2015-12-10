(function() {
    var app = angular.module('app', []);

    app.directive("dropdown", function() {
        return {
            restrict: 'E',
            require: '^ngModel',
            scope: {
                data: '=options',
                uniqueKey: '@',
                titleKey: '@',
                imageKey: '@?',
                descriptionKey: '@?',
                searchable: '@',
                placeholder: '@',
                idOnly: '@?'
            },
            link: function($scope, element, attributes, ngModelCtrl) {

                $scope.search = {
                    name: ''
                };

                $scope.thumbnails = angular.isDefined($scope.imageKey);

                ngModelCtrl.$viewChangeListeners.push(function() {
                    $scope.$eval(attributes.ngChange);
                });

                $scope.mapData = function() {
                    if (!angular.isDefined($scope.data)) {
                        return;
                    }

                    return $scope.data.map(function(option) {
                        var props = {
                            id: option[$scope.uniqueKey],
                            name: option[$scope.titleKey],
                            image: option[$scope.imageKey]
                        };

                        if (typeof $scope.descriptionKey !== 'undefined') {
                            props.description = option[$scope.descriptionKey];
                        }

                        return props;
                    });
                };

                $scope.options = $scope.mapData();

                $scope.$watch("data", function() {
                    $scope.options = $scope.mapData();
                    ngModelCtrl.$setViewValue(ngModelCtrl.$viewValue);
                });

                ngModelCtrl.$render = function() {
                    $scope.selectedOption = ngModelCtrl.$viewValue;
                };

                ngModelCtrl.$parsers.push(function(viewValue) {
                    if ($scope.idOnly === 'true') {
                        return viewValue.id;
                    } else {
                        return viewValue;
                    }
                });

                ngModelCtrl.$formatters.push(function(modelValue) {
                        if ($scope.idOnly === 'true' && angular.isDefined($scope.options)) {
                            return $scope.options.filter(function(option) {
                                return option.id = modelValue;
                            }).shift();
                        } else {
                            return modelValue;
                        }
                });

                $scope.selectOption = function(option) {
                    $scope.selectedOption = option;
                    ngModelCtrl.$setViewValue(option);
                    $scope.dropdownIsVisible = false;
                };

                $scope.toggleDropdown = function() {
                    $scope.dropdownIsVisible = !$scope.dropdownIsVisible;
                    if (!$scope.dropdownIsVisible) {
                        $scope.search.name = '';
                    }
                };

                $scope.dropdownIsVisible = false;
            },
            templateUrl: '/js/templates/dropdown.html'
        }
    });
})();
