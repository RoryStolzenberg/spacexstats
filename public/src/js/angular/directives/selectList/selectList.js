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
                    image: option.featuredImage ? option.featuredImage.media_thumb_small : null
                };
            });

            $scope.$watch("selectedOption", function(newValue) {
                $scope.selectedOptionObj = $scope.optionsObj
                    .filter(function(option) {
                    return option['id'] == newValue;
                }).shift();
            });

            $scope.selectOption = function(option) {
                $scope.selectedOption = option['id'];
                $scope.dropdownIsVisible = false;
            }

            $scope.toggleDropdown = function() {
                $scope.dropdownIsVisible = !$scope.dropdownIsVisible;
            }

            $scope.$watch("dropdownIsVisible", function(newValue) {
                if (!newValue) {
                    $scope.search = "";
                }
            });

            $scope.isSelected = function(option) {
                return option.id == $scope.selectedOption;
            }

            $scope.dropdownIsVisible = false;
        },
        templateUrl: '/src/js/angular/directives/selectList/selectList.html'
    }
});

