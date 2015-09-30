(function() {
    var app = angular.module('app', []);

    app.controller('pastMissionController', ["$scope", function($scope) {
        $scope.mission = laravel.mission;
        (function() {
            if (typeof laravel.telemetry !== 'undefined') {

                $scope.altitudeVsTime = {
                    data: laravel.telemetry.map(function(telemetry) {
                        if (telemetry.altitude != null) {
                            return { timestamp: telemetry.timestamp, altitude: telemetry.altitude };
                        }
                    }),
                    settings: {
                        padding: 50,
                        extrapolate: true,
                        xAxisKey: 'timestamp',
                        xAxisTitle: 'Time (T+s)',
                        yAxisKey: 'altitude',
                        yAxisTitle: 'Altitude (km)',
                        chartTitle: 'Altitude vs. Time'
                    }
                }
            }
        })();
    }]);
})();