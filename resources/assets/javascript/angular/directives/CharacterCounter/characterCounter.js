(function() {
    var app = angular.module('app');

    app.directive('characterCounter', ["$compile", function($compile) {
        return {
            restrict: 'A',
            require: 'ngModel',
            link: function($scope, element, attributes, ngModelCtrl) {
                var counter = angular.element('<p class="character-counter" ng-class="{ red: isInvalid }">{{ characterCounterStatement }}</p>');
                $compile(counter)($scope);
                element.after(counter);

                ngModelCtrl.$parsers.push(function(viewValue) {
                    $scope.isInvalid = ngModelCtrl.$invalid;
                    if (attributes.ngMinlength > ngModelCtrl.$viewValue.length) {
                        $scope.characterCounterStatement = attributes.ngMinlength - ngModelCtrl.$viewValue.length + ' to go';
                    } else if (attributes.ngMinlength <= ngModelCtrl.$viewValue.length) {
                        $scope.characterCounterStatement = ngModelCtrl.$viewValue.length + ' characters';
                    }
                    return viewValue;
                });
            }
        }
    }]);
})();