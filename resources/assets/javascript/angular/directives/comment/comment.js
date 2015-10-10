angular.module('directives.comment', ["RecursionHelper"]).directive('comment', ["RecursionHelper", function(RecursionHelper) {
    return {
        restrict: 'E',
        replace: true,
        scope: {
            comment: '='
        },
        compile: function(element) {
            // Use the compile function from the RecursionHelper,
            // And return the linking function(s) which it returns
            return RecursionHelper.compile(element, function($scope, element, attrs, ctrl) {

                $scope.toggleReplyState = function() {
                    if (typeof $scope.reply !== 'undefined') {
                        $scope.reply = !$scope.reply;
                    } else {
                        $scope.reply = true;
                    }

                }
            });
        },
        templateUrl: '/js/templates/comment.html'
    }
}]);