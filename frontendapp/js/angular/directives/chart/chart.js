(function() {
    var app = angular.module('app');

    app.directive('chart', ["$window", function($window) {
        return {
            replace: true,
            restrict: 'E',
            scope: {
                chartData: '=',
                axisKey: '@',
                yAxisKey: '@'
            },
            link: function($scope, elem, attrs) {
                var d3 = $window.d3;

                console.log(attrs.axisKey);
                var svg = d3.select(elem[0]);

                // draw
                var drawLineChart = (function() {
                    var xScale = d3.scale.linear()
                        .domain([$scope.chartData[0][$scope.axisKey], $scope.chartData[$scope.chartData.length-1][$scope.axisKey]])
                        .range([0, elem.width()]);

                    var yScale = d3.scale.linear()
                        .domain([d3.max($scope.chartData, function(d) {
                            return d[$scope.yAxisKey];
                        }), 0])
                        .range([0, elem.height()])

                    var xAxisGenerator = d3.svg.axis().scale(xScale).orient('bottom').ticks($scope.chartData.length - 1);
                    var yAxisGenerator = d3.svg.axis().scale(yScale).orient("left").ticks(5);

                    var lineFunction = d3.svg.line()
                        .x(function(d) {
                            return xScale(d[$scope.axisKey]);
                        })
                        .y(function(d) {
                            return yScale(d[$scope.yAxisKey]);
                        })
                        .interpolate("basis");

                    svg.append("svg:g")
                        .attr("class", "x axis")
                        .attr("transform", "translate(0," + (elem.height() - 50) + ")")
                        .call(xAxisGenerator);

                    svg.append("svg:g")
                        .attr("class", "y axis")
                        .attr("transform", "translate(50,0)")
                        .call(yAxisGenerator);

                    svg.append("svg:path")
                        .attr({
                            d: lineFunction($scope.chartData),
                            "stroke": "blue",
                            "stroke-width": 2,
                            "fill": "none",
                            "class": "path"
                        });
                })();
            },
            templateUrl: '/js/templates/chart.html'
        }
    }]);
})();