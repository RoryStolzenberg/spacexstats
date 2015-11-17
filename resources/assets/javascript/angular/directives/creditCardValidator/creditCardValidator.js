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
            link: function($scope, element, attributes, ngModelCtrl) {
                if ($scope.componentToValidate == 'cvc') {
                    ctrl.$validators.cvc = function(modelValue, viewValue) {
                        return modelValue.length === 3 && /[0-9]{3}/.test(modelValue);
                    };
                }

                else if ($scope.componentToValidate == 'expiry') {
                }

                else if ($scope.componentToValidate == 'number') {

                }

                /*$scope.$watch('model', function() {
                    ctrl.$validate();
                });*/
            }
        }
    }]);
})();