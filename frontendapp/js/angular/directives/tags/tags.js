angular.module("directives.tags", []).directive("tags", function() {
    return {
        restrict: 'E',
        scope: {
            tags: '=',
            selectedTags: '='
        },
        link: function($scope, element, attributes) {

        },
        templateUrl: '/js/templates/tags.html'
    }
});

