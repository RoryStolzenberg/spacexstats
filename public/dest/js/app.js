angular.module("editUserApp", ["directives.selectList"], ['$interpolateProvider', function($interpolateProvider) {
    $interpolateProvider.startSymbol('[[');
    $interpolateProvider.endSymbol(']]');

}]).controller("editUserController", ['$http', '$scope', function($http, $scope) {

    $scope.username = 'badddffffffdd';

    $scope.missions = laravel.missions;

    $scope.profile = {
        summary: laravel.profile.summary,
        twitter_account: laravel.profile.twitter_account,
        reddit_account: laravel.profile.reddit_account,
        favorite_quote: laravel.profile.favorite_quote,
        favorite_mission: laravel.profile.favorite_mission,
        favorite_patch: laravel.profile.favorite_patch
    };

    $scope.$watch("profile.favorite_mission", function(newValue) {
        console.log($scope.profile);
    });

    $scope.updateProfile = function() {
        $http.post('/users/' + $scope.username + '/edit/profile')
    }

}]);

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

            $scope.isSelected = function(option) {
                return option.id == $scope.selectedOption;
            }

            $scope.dropdownIsVisible = false;
        },
        templateUrl: '/src/js/angular/directives/selectList/selectList.html'
    }
});

