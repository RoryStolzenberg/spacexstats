(function() {
    var app = angular.module('app');

    app.directive('animateOnChange', ["$timeout", function($timeout) {
        return {
            restrict: 'A',
            link: function(scope, element, attr) {
                scope.$watch(attr.animateOnChange, function(newValue, oldValue) {
                    if (newValue != oldValue) {
                        element.addClass('changing');
                        $timeout(function() {
                            element.removeClass('changing');
                        }, 1000);
                    }
                });
            }
        };
    }]);
})();