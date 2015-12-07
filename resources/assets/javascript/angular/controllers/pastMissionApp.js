(function() {
    var app = angular.module('app', []);

    app.controller('pastMissionController', ["$scope", "missionDataService", "telemetryPlotCreator", "ephemerisPlotCreator", function($scope, missionDataService, telemetryPlotCreator, ephemerisPlotCreator) {
        $scope.mission = laravel.mission;

        (function() {
            missionDataService.telemetry($scope.mission.slug).then(function(response) {
                $scope.telemetryPlots = {
                    altitudeVsTime:         telemetryPlotCreator.altitudeVsTime(response.data),
                    altitudeVsDownrange:    telemetryPlotCreator.altitudeVsDownrange(response.data),
                    velocityVsTime:         telemetryPlotCreator.velocityVsTime(response.data),
                    downrangeVsTime:        telemetryPlotCreator.downrangeVsTime(response.data)
                }
            });
            missionDataService.orbitalElements($scope.mission.slug).then(function(response) {
                $scope.orbitalPlots = {
                    apogeeVsTime:           ephemerisPlotCreator.apogeeVsTime(response.data),
                    perigeeVsTime:          ephemerisPlotCreator.perigeeVsTime(response.data),
                    inclinationVsTime:      ephemerisPlotCreator.inclinationVsTime(response.data)
                }
            });
        })();
    }]);

    app.service('telemetryPlotCreator', [function() {
        this.altitudeVsTime = function(telemetryCollection) {
            return {
                data: telemetryCollection.filter(function(telemetry) {
                    return telemetry.altitude != null;
                }).map(function(telemetry) {
                    return { timestamp: telemetry.timestamp, altitude: telemetry.altitude };
                }),
                settings: {
                    extrapolation: true,
                    interpolation: 'cardinal',
                    xAxis: {
                        type: 'linear',
                        key: 'timestamp',
                        title: 'Time (T+s)'
                    },
                    yAxis: {
                        type: 'linear',
                        key: 'altitude',
                        title: 'Altitude (km)',
                        formatter: function(d) {
                            return d / 1000;
                        }
                    },
                    chartTitle: 'Altitude vs. Time'
                }
            }
        };

        this.altitudeVsDownrange = function(telemetryCollection) {
            return {
                data: telemetryCollection.filter(function(telemetry) {
                    return (telemetry.downrange != null && telemetry.altitude != null);
                }).map(function(telemetry) {
                    return { downrange: telemetry.downrange, altitude: telemetry.altitude };
                }),
                settings: {
                    extrapolation: true,
                    interpolation: 'cardinal',
                    xAxis: {
                        type: 'linear',
                        key: 'downrange',
                        title: 'Downrange Distance (km)',
                        formatter: function(d) {
                            return d / 1000;
                        }
                    },
                    yAxis: {
                        type: 'linear',
                        key: 'altitude',
                        title: 'Altitude (km)',
                        formatter: function(d) {
                            return d / 1000;
                        }
                    },
                    chartTitle: 'Altitude vs. Downrange Distance'
                }
            }
        };

        this.velocityVsTime = function(telemetryCollection) {
            return {
                data: telemetryCollection.filter(function(telemetry) {
                    return telemetry.velocity != null;
                }).map(function(telemetry) {
                    return { timestamp: telemetry.timestamp, velocity: telemetry.velocity };
                }),
                settings: {
                    extrapolation: true,
                    interpolation: 'cardinal',
                    xAxis: {
                        type: 'linear',
                        key: 'timestamp',
                        title: 'Time (T+s)'
                    },
                    yAxis: {
                        type: 'linear',
                        key: 'velocity',
                        title: 'Velocity (m/s)'
                    },
                    chartTitle: 'Velocity vs. Time'
                }
            }
        };

        this.downrangeVsTime = function(telemetryCollection) {
            return {
                data: telemetryCollection.filter(function(telemetry) {
                    return telemetry.downrange != null;
                }).map(function(telemetry) {
                    return { timestamp: telemetry.timestamp, downrange: telemetry.downrange };
                }),
                settings: {
                    extrapolation: true,
                    interpolation: 'cardinal',
                    xAxis: {
                        type: 'linear',
                        key: 'timestamp',
                        title: 'Time (T+s)'
                    },
                    yAxis: {
                        type: 'linear',
                        key: 'downrange',
                        title: 'Downrange Distance (km)',
                        formatter: function(d) {
                            return d / 1000;
                        }
                    },
                    chartTitle: 'Downrange Distance vs. Time'
                }
            }
        };
    }]);

    app.service('ephemerisPlotCreator', [function() {
        this.apogeeVsTime = function(orbitalElements) {
            return {
                data: orbitalElements.map(function(orbitalElement) {
                        return {
                            timestamp: orbitalElement.epoch,
                            apogee: orbitalElement.apogee
                        };
                }),
                settings: {
                    extrapolation: false,
                    interpolation: 'linear',
                    xAxis: {
                        type: 'timescale',
                        key: 'timestamp',
                        title: 'Epoch Date',
                        ticks: 10,
                        formatter: function(d) {
                            return moment(d).format('MMM D, YYYY');
                        }
                    },
                    yAxis: {
                        type: 'linear',
                        key: 'apogee',
                        title: 'Apogee (km)',
                        formatter: function(d) {
                            return Math.round(d * 10) / 10; // Round to 1dp
                        }
                    },
                    chartTitle: 'Apogee (km) vs. Time'
                }
            }
        };

        this.perigeeVsTime = function(orbitalElements) {
            return {
                data: orbitalElements.map(function(orbitalElement) {
                    return {
                        timestamp: orbitalElement.epoch,
                        perigee: orbitalElement.perigee
                    };
                }),
                settings: {
                    extrapolation: false,
                    interpolation: 'linear',
                    xAxis: {
                        type: 'timescale',
                        key: 'timestamp',
                        title: 'Epoch Date',
                        ticks: 10,
                        formatter: function(d) {
                            return moment(d).format('MMM D, YYYY');
                        }
                    },
                    yAxis: {
                        type: 'linear',
                        key: 'perigee',
                        title: 'Perigee (km)',
                        formatter: function(d) {
                            return Math.round(d * 10) / 10; // Round to 1dp
                        }
                    },
                    chartTitle: 'Perigee (km) vs. Time'
                }
            }
        };

        this.inclinationVsTime = function(orbitalElements) {
            return {
                data: orbitalElements.map(function(orbitalElement) {
                    return {
                        timestamp: orbitalElement.epoch,
                        inclination: orbitalElement.perigee
                    };
                }),
                settings: {
                    extrapolation: false,
                    interpolation: 'linear',
                    xAxis: {
                        type: 'timescale',
                        key: 'timestamp',
                        title: 'Epoch Date',
                        ticks: 10,
                        formatter: function(d) {
                            return moment(d).format('MMM D, YYYY');
                        }
                    },
                    yAxis: {
                        type: 'linear',
                        key: 'inclination',
                        title: 'Inclination (km)',
                        formatter: function(d) {
                            return Math.round(d * 10) / 10 + '°'; // Round to 1dp
                        }
                    },
                    chartTitle: 'Inclination (°) vs. Time'
                }
            }
        };
    }]);
})();