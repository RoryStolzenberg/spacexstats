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
                placeholder: '@'
            },
            link: function($scope, element, attributes, ngModelCtrl) {

                ngModelCtrl.$viewChangeListeners.push(function() {
                    console.log('called');
                    $scope.$eval(attributes.ngChange);
                });

                $scope.$watch("data", function() {
                    $scope.options = $scope.data.map(function(option) {
                        var props = {
                            id: option[$scope.uniqueKey],
                            name: option[$scope.titleKey],
                            image: option.featuredImage ? option.featuredImage.media_thumb_small : option.media_thumb_small
                        };

                        if (typeof $scope.descriptionKey !== 'undefined') {
                            props.description = option[$scope.descriptionKey];
                        }

                        return props;
                    });
                });

                $scope.selectOption = function(option) {
                    attributes.ngModel = $scope.selectedOption = option;
                    $scope.dropdownIsVisible = false;
                };

                $scope.selectDefault = function() {
                    attributes.ngModel = $scope.selectedOption = null;
                    $scope.dropdownIsVisible = false;
                };

                $scope.toggleDropdown = function() {
                    $scope.dropdownIsVisible = !$scope.dropdownIsVisible;
                    if (!$scope.dropdownIsVisible) {
                        $scope.search = null;
                    }
                };

                $scope.dropdownIsVisible = false;
            },
            templateUrl: '/js/templates/selectList.html'
        }
    });
})();
