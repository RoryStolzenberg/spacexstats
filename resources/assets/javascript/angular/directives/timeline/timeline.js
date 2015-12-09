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

                    var tip = d3.tip().attr('class', 'tip').html(function(d) {
                        return d.event;
                    }).offset([0, -20]);

                    var g = svg.append("g")
                        .attr("transform", "translate(0," + 3 * $(elem[0]).height() / 4 + ")")
                        .selectAll("circle")
                        .data(scope.launchEvents.map(function(launchEvent) {
                            launchEvent.occurred_at.toDate();
                            return launchEvent;
                        }))
                        .enter().append("circle")
                        .attr("r", 20)
                        .attr('class', function(d) {
                            return d.event.toLowerCase().replace(/\s/g, "-");
                        })
                        .classed('event', true)
                        .attr("cx", function(d) { return xScale(d.occurred_at); })
                        .call(tip)
                        .on("mouseover", function(d) {

                            d3.selectAll('.event').transition()
                                .attr('opacity', 0);

                            d3.select(this).transition()
                                .attr('opacity', 1)
                                .attr("transform", "translate(-"+ d3.select(this).attr('cx') * (1.5-1) + ",-0) scale(1.5, 1.5)");
                            tip.show(d);
                        })
                        .on("mouseout", function(d) {

                            d3.selectAll('.event').transition()
                                .attr("transform", "translate(0,0) scale(1,1)")
                                .attr('opacity', 1);
                            tip.hide(d);
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