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
                        min: moment(scope.launchEvents[0].occurred_at).subtract(timespan / 10, 'seconds').toDate(),
                        max: moment(scope.launchEvents[scope.launchEvents.length-1].occurred_at).add(timespan / 10, 'seconds').toDate()
                    };

                    var elem = $(element).find('svg');

                    var svg = d3.select(elem[0]).data(scope.launchEvents);

                    var xScale = d3.time.scale.utc()
                        .domain([dates.min, dates.max])
                        .range([0, $(elem[0]).width()]);

                    // Determine ticks to use
                    if (timespan > timespans.ONE_YEAR) {
                        var preferredTick = {
                            frequency: d3.time.month,
                            format: d3.time.format("%b %Y")
                        };
                    } else if (timespan > timespans.SIX_MONTHS) {
                        var preferredTick = {
                            frequency: d3.time.month,
                            format: d3.time.format("%b %Y")
                        };
                    } else if (timespan > timespans.ONE_MONTH) {
                        var preferredTick = {
                            frequency: d3.time.week,
                            format: d3.time.format("%e %b")
                        };
                    } else {
                        var preferredTick = {
                            frequency: d3.time.day,
                            format: d3.time.format("%e %b")
                        };
                    }

                    var xAxisGenerator = d3.svg.axis().scale(xScale).orient('bottom')
                        .ticks(preferredTick.frequency, 1)
                        .tickFormat(preferredTick.format)
                        .tickPadding(25);

                    var axis = svg.append("svg:g")
                        .attr("class", "x axis")
                        .attr("transform", "translate(0," + 3 * $(elem[0]).height() / 4 + ")")
                        .call(xAxisGenerator);

                    var g = svg.append("g")
                        .attr("transform", "translate(0," + 3 * $(elem[0]).height() / 4 + ")")
                        .selectAll("circle")
                        .data(scope.launchEvents.map(function(launchEvent) {
                            launchEvent.occurred_at.toDate();
                            return launchEvent;
                        }))
                        .enter().append("circle")
                            .enter().append("path")
                            .attr("d", "M165.494,533.333c-35.545-73.962-16.616-116.343,10.703-156.272c29.917-43.728,37.627-87.013,37.627-87.013   s23.518,30.573,14.11,78.39c41.548-46.25,49.389-119.938,43.115-148.159c93.914,65.63,134.051,207.737,79.96,313.054   c287.695-162.776,71.562-406.339,33.934-433.775c12.543,27.435,14.922,73.88-10.416,96.42C331.635,33.333,225.583,0,225.583,0c12.543,83.877-45.466,175.596-101.404,244.13c-1.965-33.446-4.053-56.525-21.641-88.531   C98.59,216.357,52.157,265.884,39.583,326.76C22.551,409.2,52.341,469.562,165.494,533.333z")
                            .attr("transform", "scale(0.05, 0.05")
                            .exit()
                        .attr("r", 20)
                        .classed('event', true)
                        .attr("cx", function(d) { return xScale(d.occurred_at); })
                        .on("mouseover", function() {

                            d3.selectAll('.event').transition()
                                .attr('opacity', 0);

                            d3.select(this).transition()
                                .attr('opacity', 1)
                                .attr("transform", "translate(-"+ d3.select(this).attr('cx') * (1.5-1) + ",-0) scale(1.5, 1.5)");
                        })
                        .on("mouseout", function() {
                            d3.selectAll('.event').transition()
                                .attr("transform", "translate(0,0) scale(1,1)")
                                .attr('opacity', 1);
                        });

                    // replace tick lines with circles
                    var ticks = axis.selectAll(".tick");
                    ticks.each(function() { d3.select(this).append("circle").attr("r", 3); });
                    ticks.selectAll("line").remove();
                });
            },
            templateUrl: '/js/templates/timeline.html'
        };
    }]);
})();