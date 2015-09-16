angular.module('directives.comment', ["RecursionHelper"]).directive('comment', ["RecursionHelper", function(RecursionHelper) {
    return {
        restrict: 'E',
        replace: true,
        scope: {
            comment: '='
        },
        link: function($scope, element, attrs, ctrl) {
        },
        compile: function(element) {
            // Use the compile function from the RecursionHelper,
            // And return the linking function(s) which it returns
            return RecursionHelper.compile(element);
        },
        templateUrl: '/js/templates/comment.html'
    }
}]);