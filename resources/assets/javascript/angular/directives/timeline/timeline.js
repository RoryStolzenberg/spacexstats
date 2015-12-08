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

                    var timespans = {
                        ONE_YEAR: 365 * 86400,
                        SIX_MONTHS: 6 * 30 * 86400,
                        ONE_MONTH: 30 * 86400
                    };

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
                        min: scope.launchEvents[0].occurred_at,
                        max: scope.launchEvents[scope.launchEvents.length-1].occurred_at
                    };
                    dates.min.subtract(timespan / 10, 'seconds').toDate();
                    dates.min.add(timespan / 10, 'seconds').toDate();

                    var elem = $(element).find('svg');

                    var svg = d3.select(elem[0]).data(scope.launchEvents);

                    var xScale = d3.time.scale.utc()
                        .domain([dates.min, dates.max])
                        .range([0, $(elem[0]).width()]);

                    // Determine ticks to use
                    if (timespan > timespans.ONE_YEAR) {
                        var preferredTickFormat = d3.time.month;
                    } else if (timespan > timespans.SIX_MONTHS) {
                        var preferredTickFormat = d3.time.month;
                    } else if (timespan > timespans.ONE_MONTH) {
                        var preferredTickFormat = d3.time.week;
                    } else {
                        var preferredTickFormat = d3.time.day;
                    }

                    var xAxisGenerator = d3.svg.axis().scale(xScale).orient('bottom').ticks(preferredTickFormat, 1).tickFormat(null);

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
                        .attr("fill", "#4f708f")
                        .attr("cx", function(d) { return xScale(d); });
                });
            },
            template: '<svg width="100%" height="200px"></svg>'
        };
    }]);
})();