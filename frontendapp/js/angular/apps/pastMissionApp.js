(function() {
    var app = angular.module('app', []);

    app.controller('pastMissionController', ["$scope", function($scope) {
        $scope.mission = laravel.mission;
        (function() {
            if (typeof laravel.telemetry !== 'undefined') {
                $scope.altitudeVsTime = laravel.telemetry.map(function(telemetry) {
                     if (telemetry.altitude != null) {
                         return { timestamp: telemetry.timestamp, altitude: telemetry.altitude };
                     }
                });
            }
        })();
    }]);
})();