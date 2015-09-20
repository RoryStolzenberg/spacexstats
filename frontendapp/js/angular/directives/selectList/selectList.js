(function() {
    var app = angular.module('app', []);

    app.directive("selectList", function() {
        return {
            restrict: 'E',
            scope: {
                options: '=',
                selectedOption: '=ngModel',
                uniqueKey: '@',
                titleKey: '@',
                imageKey: '@?',
                descriptionKey: '@?',
                searchable: '@',
                placeholder: '@'
            },
            link: function($scope, element, attributes) {

                $scope.optionsObj = $scope.options.map(function(option) {
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

                $scope.$watch("selectedOption", function(newValue) {
                    if (newValue !== null) {
                        $scope.selectedOptionObj = $scope.optionsObj
                            .filter(function(option) {
                                return option['id'] == newValue;
                            }).shift();
                    } else {
                        $scope.selectedOptionObj = null;
                    }
                });

                $scope.selectOption = function(option) {
                    $scope.selectedOption = option['id'];
                    $scope.dropdownIsVisible = false;
                };

                $scope.selectDefault = function() {
                    $scope.selectedOption = null;
                    $scope.dropdownIsVisible = false;
                };

                $scope.toggleDropdown = function() {
                    $scope.dropdownIsVisible = !$scope.dropdownIsVisible;
                };

                $scope.$watch("dropdownIsVisible", function(newValue) {
                    if (!newValue) {
                        $scope.search = "";
                    }
                });

                $scope.isSelected = function(option) {
                    return option.id == $scope.selectedOption;
                };

                $scope.dropdownIsVisible = false;
            },
            templateUrl: '/js/templates/selectList.html'
        }
    });
})();
