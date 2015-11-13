(function() {
    var app = angular.module('app');

    app.directive('chart', ["$window", function($window) {
        return {
            replace: true,
            restrict: 'E',
            scope: {
                chartData: '=data',
                settings: "="
            },
            link: function($scope, elem, attrs) {

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
                if (settings.extrapolate === true) {
                    var originDatapoint = {};
                    originDatapoint[settings.xAxisKey] = 0;
                    originDatapoint[settings.yAxisKey] = 0;

                    $scope.chartData.unshift(originDatapoint);
                }

                // draw
                var drawLineChart = (function() {

                    // Setup scales
                    var xScale = d3.scale.linear()
                        .domain([0, $scope.chartData[$scope.chartData.length-1][settings.xAxisKey]])
                        .range([settings.padding, width - settings.padding]);

                    var yScale = d3.scale.linear()
                        .domain([d3.max($scope.chartData, function(d) {
                            return d[settings.yAxisKey];
                        }), 0])
                        .range([settings.padding, height - settings.padding]);

                    // Generators
                    var xAxisGenerator = d3.svg.axis().scale(xScale).orient('bottom').ticks(5).tickFormat(function(d) {
                        return typeof settings.xAxisFormatter !== 'undefined' ? settings.xAxisFormatter(d) : d;
                    });
                    var yAxisGenerator = d3.svg.axis().scale(yScale).orient("left").ticks(5).tickFormat(function(d) {
                        return typeof settings.yAxisFormatter !== 'undefined' ? settings.yAxisFormatter(d) : d;
                    });

                    // Line function
                    var lineFunction = d3.svg.line()
                        .x(function(d) {
                            return xScale(d[settings.xAxisKey]);
                        })
                        .y(function(d) {
                            return yScale(d[settings.yAxisKey]);
                        })
                        .interpolate("basis");

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
                            d: lineFunction($scope.chartData),
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
                        .text(settings.xAxisTitle);

                    svg.append("text")
                        .attr("class", "axis y-axis")
                        .attr("text-anchor", "middle")
                        .attr("transform", "rotate(-90)")
                        .attr("x", - (height / 2))
                        .attr("y", settings.padding / 2)
                        .text(settings.yAxisTitle);
                })();
            },
            templateUrl: '/js/templates/chart.html'
        }
    }]);
})();