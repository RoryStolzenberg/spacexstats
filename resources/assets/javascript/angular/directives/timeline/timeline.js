(function() {
    var app = angular.module('app', []);

    app.directive('timeline', ["missionDataService", function(missionDataService) {
        return {
            restrict: 'E',
            scope: {
            },
            link: function(scope, element, attributes) {
                missionDataService.launchEvents($scope.$parent.mission.slug).then(function(response) {

                    scope.launchEvents = response.data.map(function(launchEvent) {
                        launchEvent.occurred_at = moment.utc(launchEvent.occurred_at).toDate();
                    });

                    // Add 10% to the minimum and maximum dates
                    var timespan =  $scope.launchEvents[0].occurred_at.diff($scope.launchEvents[$scope.launchEvents.length].occurred_at, 'seconds');
                    var dates = {
                        min: $scope.launchEvents[0].occurred_at.substract(timespan / 10, 'seconds'),
                        max: [$scope.launchEvents.length].occurred_at.add(timespan / 10, 'seconds')
                    };

                    var data = response.data;

                    var elem = $('#timeline-graph');

                    var svg = d3.select(elem[0]).data($scope.launchEvents);

                    var xScale = d3.time.scale.utc()
                        .domain([dates.min, dates.max])
                        .range([0, elem.width()]);

                    var xAxisGenerator = d3.svg.axis().scale(xScale).orient('bottom').ticks(d3.time.month, 1).tickFormat(null);

                    svg.append("svg:g")
                        .attr("class", "x axis")
                        .attr("transform", "translate(0," + elem.height() / 2 + ")")
                        .call(xAxisGenerator);

                    svg.append("g")
                        .attr("transform", "translate(0," + elem.height() / 2 + ")")
                        .selectAll("circle")
                        .data($scope.launchEvents.map(function(launchEvent) {
                            return launchEvent.occurred_at;
                        }))
                        .enter().append("circle")
                        .attr("r", 20)
                        .attr("fill", "blue")
                        .attr("cx", function(d) { return xScale(d); });
                });
            },
            template: '<svg></svg>'
        };
    }]);
})();