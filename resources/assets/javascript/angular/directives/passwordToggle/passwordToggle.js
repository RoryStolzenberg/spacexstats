//http://codepen.io/jakob-e/pen/eNBQaP
(function() {
    var app = angular.module('app');

    app.directive('passwordToggle', ["$compile", function($compile) {
        return {
            restrict: 'A',
            scope:{},
            link: function(scope, elem, attrs){
                scope.tgl = function() {
                    elem.attr('type',(elem.attr('type')==='text'?'password':'text'));
                };
                var lnk = angular.element('<i class="fa fa-eye" data-ng-click="tgl()"></i>');
                $compile(lnk)(scope);
                elem.wrap('<div class="password-toggle"/>').after(lnk);
            }
        }
    }]);
})();
