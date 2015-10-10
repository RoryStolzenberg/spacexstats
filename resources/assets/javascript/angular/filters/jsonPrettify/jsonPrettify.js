(function() {
    var app = angular.module('app');

    app.filter('jsonPrettify', function() {
       return function(input) {
           if (typeof input !== 'undefined') {
               return JSON.stringify(input, null, 2);
           }
           return null;
       }
    });
})();