(function() {
    var app = angular.module('app');

    app.directive('chart', ["$window", function($window) {
        return {
            replace: true,
            restrict: 'E',
            scope: {
                data: '=data',
                settings: "=",
                type: '@'
            },
            link: function($scope, elem, attrs) {

                $scope.$watch('data', function(newValue) {
                    render(newValue);
                }, true);

                $scope.$on('chart:rerender', function() {
                    elem.empty();
                    render($scope.data);
                });

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

                    // Settings for rendering the chart
                    var settings = $scope.settings;

                    // Core information used to render the chart
                    var core = {};

                    // create a reasonable set of defaults for some things
                    if (typeof settings.xAxis.ticks === 'undefined') {
                        settings.xAxis.ticks = 5;
                    }
                    if (typeof settings.yAxis.ticks === 'undefined') {
                        settings.yAxis.ticks = 5;
                    }

                    // check padding and set default
                    if (typeof settings.padding === 'undefined') {
                        settings.padding = 50;
                    }

                    // draw
                    if ($scope.type == 'bar') {
                        drawBarChart();
                    } else {
                        drawLineChart();
                    }

                    function drawChart() {
                        // Element manipulation
                        var xAxisLine = svg.append("svg:g")
                            .attr("class", "x axis")
                            .attr("transform", "translate(0," + (height - settings.padding) + ")")
                            .call(core.xAxisGenerator);

                        var yAxisLine = svg.append("svg:g")
                            .attr("class", "y axis")
                            .attr("transform", "translate(" + settings.padding + ",0)")
                            .attr("stroke-width", 2)
                            .call(core.yAxisGenerator);

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
                            .attr("y", height)
                            .text(settings.xAxis.title);

                        svg.append("text")
                            .attr("class", "axis y-axis")
                            .attr("text-anchor", "middle")
                            .attr("transform", "rotate(-90)")
                            .attr("x", - (height / 2))
                            .attr("y", settings.padding / 2)
                            .text(settings.yAxis.title);
                    }

                    function computeChart() {
                        // Setup xZeroing
                        var startPoint = settings.xAxis.zeroing ? 0 : data[0][settings.xAxis.key];

                        // Setup xScales
                        if (settings.xAxis.type == 'linear') {
                            core.xScale = d3.scale.linear()
                                .domain([startPoint, data[data.length-1][settings.xAxis.key]])
                                .range([settings.padding, width - settings.padding]);

                        } else if (settings.xAxis.type == 'timescale') {
                            core.xScale = d3.time.scale.utc()
                                .domain([startPoint, data[data.length-1][settings.xAxis.key]])
                                .range([settings.padding, width - settings.padding]);

                        } else if (settings.xAxis.type == 'ordinal') {

                            core.xScale = d3.scale.ordinal()
                                .domain(data.map(function(dataBit) { return dataBit[settings.xAxis.key]; }))
                                .rangeRoundBands([settings.padding, width - settings.padding], 0.5);
                        }

                        // setup yZeroing
                        var startPoint = settings.yAxis.zeroing ? 0 : data[0][settings.yAxis.key];

                        // setup yScales
                        if (settings.yAxis.type == 'linear') {
                            core.yScale = d3.scale.linear()
                                .domain([d3.max(data, function(d) {
                                    if (typeof d[settings.yAxis.key] === 'string') {
                                        return parseFloat(d[settings.yAxis.key]);
                                    }
                                    return d[settings.yAxis.key];
                                }), startPoint])
                                .range([settings.padding, height - settings.padding]);

                        } else if (settings.yAxis.type == 'timescale') {
                            core.yScale = d3.time.scale.utc()
                                .domain([d3.max(data, function(d) {
                                    return d[settings.yAxis.key];
                                }), startPoint])
                                .range([settings.padding, height - settings.padding]);
                        }

                        // Generators
                        core.xAxisGenerator = d3.svg.axis().scale(core.xScale).orient('bottom').ticks(settings.xAxis.ticks).tickFormat(function(d) {
                            return typeof settings.xAxis.formatter !== 'undefined' ? settings.xAxis.formatter(d) : d;
                        });

                        core.yAxisGenerator = d3.svg.axis().scale(core.yScale).orient("left").ticks(settings.yAxis.ticks).tickFormat(function(d) {
                            return typeof settings.yAxis.formatter !== 'undefined' ? settings.yAxis.formatter(d) : d;
                        });
                    };

                    function drawBarChart() {

                        computeChart();

                        svg.selectAll("bar")
                            .data(data)
                            .enter().append("rect")
                            .style("fill", "steelblue")
                            .attr("x", function(d) {
                                return core.xScale(d[settings.xAxis.key]);
                            })
                            .attr("width", core.xScale.rangeBand())
                            .attr("y", function(d) {
                                return core.yScale(d[settings.yAxis.key]);
                            })
                            .attr("height", function(d) {
                                return height - core.yScale(d[settings.yAxis.key]) - settings.padding;
                            });

                        drawChart();
                    };

                    function drawLineChart() {

                        computeChart();

                        // Line function
                        var lineFunction = d3.svg.line()
                            .x(function(d) {
                                return core.xScale(d[settings.xAxis.key]);
                            })
                            .y(function(d) {
                                return core.yScale(d[settings.yAxis.key]);
                            })
                            .interpolate(settings.interpolation);

                        svg.append("svg:path")
                            .attr({
                                d: lineFunction(data),
                                "stroke-width": 2,
                                "fill": "none",
                                "class": "path"
                            });

                        drawChart();
                    };
                }

            },
            templateUrl: '/js/templates/chart.html'
        }
    }]);
})();