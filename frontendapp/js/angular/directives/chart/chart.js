(function() {
    var app = angular.module('app');

    app.directive('chart', ["$window", function($window) {
        return {
            replace: true,
            restrict: 'E',
            scope: {
                chartData: '=data',
                axisKey: '@',
                yAxisKey: '@',
                chartTitle: '@title',
                padding: "@"
            },
            link: function($scope, elem, attrs) {
                var d3 = $window.d3;
                var svg = d3.select(elem[0]);
                var padding = parseInt($scope.padding);
                var width = elem.width();
                var height = elem.height();
                // draw
                var drawLineChart = (function() {

                    // Setup scales
                    var xScale = d3.scale.linear()
                        .domain([0, $scope.chartData[$scope.chartData.length-1][$scope.axisKey]])
                        .range([padding, width - padding]);

                    var yScale = d3.scale.linear()
                        .domain([d3.max($scope.chartData, function(d) {
                            return d[$scope.yAxisKey];
                        }), 0])
                        .range([padding, height - padding]);

                    // Generators
                    var xAxisGenerator = d3.svg.axis().scale(xScale).orient('bottom').ticks(5);
                    var yAxisGenerator = d3.svg.axis().scale(yScale).orient("left").ticks(5).tickFormat(function(d) {
                        return d / 1000;
                    });

                    // Line function
                    var lineFunction = d3.svg.line()
                        .x(function(d) {
                            return xScale(d[$scope.axisKey]);
                        })
                        .y(function(d) {
                            return yScale(d[$scope.yAxisKey]);
                        })
                        .interpolate("basis");

                    // Element manipulation
                    svg.append("svg:g")
                        .attr("class", "x axis")
                        .attr("transform", "translate(0," + (height - padding) + ")")
                        .call(xAxisGenerator);

                    svg.append("svg:g")
                        .attr("class", "y axis")
                        .attr("transform", "translate(" + padding + ",0)")
                        .attr("stroke-width", 2)
                        .call(yAxisGenerator);

                    svg.append("svg:path")
                        .attr({
                            d: lineFunction($scope.chartData),
                            "stroke": "blue",
                            "stroke-width": 2,
                            "fill": "none",
                            "class": "path"
                        });

                    svg.append("text")
                        .attr("class", "chart-title")
                        .attr("text-anchor", "middle")
                        .attr("x", width / 2)
                        .attr("y", padding)
                        .text($scope.chartTitle);
                })();
            },
            templateUrl: '/js/templates/chart.html'
        }
    }]);
})();