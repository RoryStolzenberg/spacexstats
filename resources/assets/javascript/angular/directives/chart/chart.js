(function() {
    var app = angular.module('app');

    app.directive('chart', ["$window", function($window) {
        return {
            replace: true,
            restrict: 'E',
            scope: {
                data: '=data',
                settings: "="
            },
            link: function($scope, elem, attrs) {

                $scope.$watch('data', function(newValue) {
                    render(newValue);
                }, true);

                function render(chartData) {
                    if (!angular.isDefined(chartData) || chartData.length == 0) {
                        return;
                    }

                    // Make a deep copy of the object as we may be doing manipulation
                    // which would cause the watcher to fire
                    var data = jQuery.extend(true, [], chartData);

                    var d3 = $window.d3;
                    var svg = d3.select(elem[0]);
                    var width = elem.width();
                    var height = elem.height();

                    var settings = $scope.settings;

                    // check padding and set default
                    if (typeof settings.padding === 'undefined') {
                        settings.padding = 50;
                    }

                    // extrapolate data
                    if (settings.extrapolation === true) {
                        var originDatapoint = {};
                        originDatapoint[settings.xAxis.key] = 0;
                        originDatapoint[settings.yAxis.key] = 0;

                        //data.unshift(originDatapoint);
                    }

                    // draw
                    var drawLineChart = function() {
                        // Setup scales
                        if (settings.xAxis.type == 'linear') {
                            var xScale = d3.scale.linear()
                                .domain([0, data[data.length-1][settings.xAxis.key]])
                                .range([settings.padding, width - settings.padding]);

                        } else if (settings.xAxis.type == 'timescale') {
                            var xScale = d3.time.scale.utc()
                                .domain([data[0][settings.xAxis.key], data[data.length-1][settings.xAxis.key]])
                                .range([settings.padding, width - settings.padding]);
                        }

                        if (settings.yAxis.type == 'linear') {
                            var yScale = d3.scale.linear()
                                .domain([d3.max(data, function(d) {
                                    return d[settings.yAxis.key];
                                }), d3.min(data, function(d) {
                                    return d[settings.yAxis.key];
                                })])
                                .range([settings.padding, height - settings.padding]);

                        } else if (settings.yAxis.type == 'timescale') {
                            var yScale = d3.time.scale.utc()
                                .domain([d3.max(data, function(d) {
                                    return d[settings.yAxis.key];
                                }), 0])
                                .range([settings.padding, height - settings.padding]);
                        }

                        // Generators
                        var xAxisGenerator = d3.svg.axis().scale(xScale).orient('bottom').ticks(5).tickFormat(function(d) {
                            return typeof settings.xAxis.formatter !== 'undefined' ? settings.xAxis.formatter(d) : d;
                        });
                        var yAxisGenerator = d3.svg.axis().scale(yScale).orient("left").ticks(5).tickFormat(function(d) {
                            return typeof settings.yAxis.formatter !== 'undefined' ? settings.yAxis.formatter(d) : d;
                        });

                        // Line function
                        var lineFunction = d3.svg.line()
                            .x(function(d) {
                                return xScale(d[settings.xAxis.key]);
                            })
                            .y(function(d) {
                                return yScale(d[settings.yAxis.key]);
                            })
                            .interpolate(settings.interpolation);

                        // Element manipulation
                        svg.append("svg:g")
                            .attr("class", "x axis")
                            .attr("transform", "translate(0," + (height - settings.padding) + ")")
                            .call(xAxisGenerator);

                        svg.append("svg:g")
                            .attr("class", "y axis")
                            .attr("transform", "translate(" + settings.padding + ",0)")
                            .attr("stroke-width", 2)
                            .call(yAxisGenerator);

                        svg.append("svg:path")
                            .attr({
                                d: lineFunction(data),
                                "stroke-width": 2,
                                "fill": "none",
                                "class": "path"
                            });

                        svg.append("text")
                            .attr("class", "chart-title")
                            .attr("text-anchor", "middle")
                            .attr("x", width / 2)
                            .attr("y", settings.padding / 2)
                            .text(settings.chartTitle);

                        svg.append("text")
                            .attr("class", "axis x-axis")
                            .attr("text-anchor", "middle")
                            .attr("x", width / 2)
                            .attr("y", height - (settings.padding / 2))
                            .text(settings.xAxis.title);

                        svg.append("text")
                            .attr("class", "axis y-axis")
                            .attr("text-anchor", "middle")
                            .attr("transform", "rotate(-90)")
                            .attr("x", - (height / 2))
                            .attr("y", settings.padding / 2)
                            .text(settings.yAxis.title);
                    };

                    drawLineChart();
                }

            },
            templateUrl: '/js/templates/chart.html'
        }
    }]);
})();