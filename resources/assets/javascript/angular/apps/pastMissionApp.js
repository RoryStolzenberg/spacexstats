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
                        extrapolate: true,
                        xAxisKey: 'timestamp',
                        xAxisTitle: 'Time (T+s)',
                        yAxisKey: 'altitude',
                        yAxisTitle: 'Altitude (km)',
                        chartTitle: 'Altitude vs. Time',
                        yAxisFormatter: function(d) {
                            return d / 1000;
                        }
                    }
                };

                $scope.altitudeVsDownrange = {
                    data: laravel.telemetry.map(function(telemetry) {
                        if (telemetry.downrange != null && telemetry.altitude != null) {
                            return { downrange: telemetry.downrange, altitude: telemetry.altitude };
                        }
                    }),
                    settings: {
                        extrapolate: true,
                        xAxisKey: 'downrange',
                        xAxisTitle: 'Downrange Distance (km)',
                        yAxisKey: 'altitude',
                        yAxisTitle: 'Altitude (km)',
                        chartTitle: 'Altitude vs. Downrange Distance',
                        yAxisFormatter: function(d) {
                            return d / 1000;
                        },
                        xAxisFormatter: function(d) {
                            return d / 1000;
                        }
                    }
                }

                $scope.velocityVsTime = {
                    data: laravel.telemetry.map(function(telemetry) {
                        if (telemetry.velocity != null) {
                            return { timestamp: telemetry.timestamp, velocity: telemetry.velocity };
                        }
                    }),
                    settings: {
                        extrapolate: true,
                        xAxisKey: 'timestamp',
                        xAxisTitle: 'Time (T+s)',
                        yAxisKey: 'velocity',
                        yAxisTitle: 'Velocity (m/s)',
                        chartTitle: 'Velocity vs. Time'
                    }
                };

                $scope.downrangeVsTime = {
                    data: laravel.telemetry.map(function(telemetry) {
                        if (telemetry.downrange != null) {
                            return { timestamp: telemetry.timestamp, downrange: telemetry.downrange };
                        }
                    }),
                    settings: {
                        extrapolate: true,
                        xAxisKey: 'timestamp',
                        xAxisTitle: 'Time (T+s)',
                        yAxisKey: 'downrange',
                        yAxisTitle: 'Downrange Distance (km)',
                        chartTitle: 'Downrange Distance vs. Time',
                        yAxisFormatter: function(d) {
                            return d / 1000;
                        }
                    }
                }
            }
        })();
    }]);
})();