(function() {
    var app = angular.module('app');

    app.directive('uniqueUsername', ["$q", "$http", function($q, $http) {
        return {
            restrict: 'A',
            require: 'ngModel',
            link: function(scope, elem, attrs, ngModelCtrl) {
                ngModelCtrl.$asyncValidators.username = function(modelValue, viewValue) {
                    return $http.get('/auth/isusernametaken/' + modelValue).then(function(response) {
                        return response.data.taken ? $q.reject() : true;
                    });
                };
            }
        }
    }]);
})();
