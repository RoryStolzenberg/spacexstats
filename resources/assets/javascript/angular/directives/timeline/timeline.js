(function() {
    var app = angular.module('app', []);

    app.directive('timeline', ["missionDataService", function(missionDataService) {
        return {
            restrict: 'E',
            scope: {
                mission: '='
            },
            link: function(scope, element, attributes) {
                missionDataService.launchEvents(scope.mission.slug).then(function(response) {

                    scope.launchEvents = response.data.map(function(launchEvent) {
                        launchEvent.occurred_at = moment.utc(launchEvent.occurred_at);
                        return launchEvent;
                    });

                    if (scope.mission.status == 'Complete') {
                        scope.launchEvents.push({
                            'event': 'Launch',
                            'occurred_at': moment.utc(scope.mission.launch_date_time)
                        });
                    }

                    // Add 10% to the minimum and maximum dates
                    var timespan = Math.abs(scope.launchEvents[0].occurred_at.diff(scope.launchEvents[scope.launchEvents.length-1].occurred_at, 'seconds'));
                    var dates = {
                        min: scope.launchEvents[0].occurred_at.subtract(timespan / 10, 'seconds').toDate(),
                        max: scope.launchEvents[scope.launchEvents.length-1].occurred_at.add(timespan / 10, 'seconds').toDate()
                    };

                    var elem = $(element).find('svg');

                    var svg = d3.select(elem[0]).data(scope.launchEvents);

                    var xScale = d3.time.scale.utc()
                        .domain([dates.min, dates.max])
                        .range([0, $(elem[0]).width()]);

                    var xAxisGenerator = d3.svg.axis().scale(xScale).orient('bottom').ticks(d3.time.month, 1).tickFormat(null);

                    svg.append("svg:g")
                        .attr("class", "x axis")
                        .attr("transform", "translate(0," + $(elem[0]).height() / 2 + ")")
                        .call(xAxisGenerator);

                    svg.append("g")
                        .attr("transform", "translate(0," + $(elem[0]).height() / 2 + ")")
                        .selectAll("circle")
                        .data(scope.launchEvents.map(function(launchEvent) {
                            return launchEvent.occurred_at.toDate();
                        }))
                        .enter().append("circle")
                        .attr("r", 20)
                        .attr("fill", "blue")
                        .attr("cx", function(d) { return xScale(d); });
                });
            },
            template: '<svg width="100%" height="200px"></svg>'
        };
    }]);
})();