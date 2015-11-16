(function() {
    var app = angular.module('app');

    app.directive('creditCardValidator', [function() {
        return {
            restrict: 'A',
            require: 'ngModel',
            scope: {
                componentToValidate: '@',
                model: '=ngModel'
            },
            link: function($scope, element, attributes, model) {

            }
        }
    }]);
})();