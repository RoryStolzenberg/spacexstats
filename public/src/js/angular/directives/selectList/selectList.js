angular.module("directives.selectList", []).directive("selectList", function() {
    return {
        restrict: 'E',
        scope: {
            options: '=',
            hasDefaultOption: '@',
            selectedOption: '=',
            uniqueKey: '@',
            searchable: '@'
        },
        link: function($scope, element, attributes) {

            $scope.optionsObj = $scope.options.map(function(option) {
                return {
                    id: option[$scope.uniqueKey],
                    name: option.name,
                    isSelected: $scope.selectedOption == option[$scope.uniqueKey],
                    image: option.featuredImage ? option.featuredImage.media_thumb_small : null
                };
            });

            $scope.$watch("selectedOption", function(newValue) {
                $scope.selectedOptionObj = $scope.options.filter(function(option) {
                    return option[$scope.uniqueKey] == newValue;
                });
            });

            $scope.selectOption = function(option) {
                $scope.selectedOption = option[$scope.uniqueKey];
                $scope.dropdownIsVisible = false;
            }

            $scope.toggleDropdown = function() {
                $scope.dropdownIsVisible = !$scope.dropdownIsVisible;
            }

            $scope.dropdownIsVisible = false;
        },
        templateUrl: '/src/js/angular/directives/selectList/selectList.html'
    }
});

