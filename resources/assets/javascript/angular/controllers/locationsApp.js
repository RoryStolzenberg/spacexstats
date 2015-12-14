(function() {
    var locationsApp = angular.module('app', []);

    locationsApp.controller("locationsController", ["$scope", "locationsService", function($scope, locationsService) {
        // If a hash already exists, preset it:
        if (window.location.hash) {
            $scope.activeLocation = window.location.hash.substring(1);
        }

        self.circleRadius = 12;

        self.makeLarger = function(data, event) {

            // Create an array to hold the locations to be intersected
            var intersectingLocations = [];

            var obj1 = d3.select(event.target.parentNode).node().getBoundingClientRect();

            d3.selectAll('g.location').each(function() {
                var obj2 = this.getBoundingClientRect();

                if (!(obj2.left > obj1.right || obj2.right < obj1.left || obj2.top > obj1.bottom || obj2.bottom < obj1.top)) {

                    intersectingLocations.push({
                        object: this,
                        coords: d3.transform(d3.select(this).attr('transform')).translate
                    });

                }
            });

            if (intersectingLocations.length > 1) {
                var xSum = 0;
                var ySum = 0;

                // Get centroid of location points
                for (i = 0; i < intersectingLocations.length; i++) {
                    xSum += intersectingLocations[i].coords[0];
                    ySum += intersectingLocations[i].coords[1];
                }

                var xAvg = Math.round(xSum / intersectingLocations.length);
                var yAvg = Math.round(ySum / intersectingLocations.length);

                // Place pins around invisible circle, refer to
                // http://stackoverflow.com/questions/839899/how-do-i-calculate-a-point-on-a-circle-s-circumference
                for (i = 0; i < intersectingLocations.length; i++) {
                    var xPosOfPin = xAvg + (self.circleRadius * Math.log(intersectingLocations.length) + self.circleRadius) * Math.cos((((2 * Math.PI) / intersectingLocations.length) * i) + Math.PI/2);
                    var yPosOfPin = yAvg + (self.circleRadius * Math.log(intersectingLocations.length) + self.circleRadius) * Math.sin((((2 * Math.PI) / intersectingLocations.length) * i) + Math.PI/2);

                    d3.select(intersectingLocations[i].object)
                        .classed('offset', true)
                        .attr('stroke-width', function() {
                            return self.circleRadius * Math.log(intersectingLocations.length) + self.circleRadius * 5;
                        })
                        .attr('stroke', 'transparent')
                        .transition()
                        .delay(300)
                        .attr('transform', function() {
                            return 'translate(' + xPosOfPin + ',' + yPosOfPin + ')';
                        });
                }

            } else {
                d3.select(event.target).transition()
                    .duration(300)
                    .attr('transform', "scale(1.5,1.5)");
            }
            /*
             if (intersectingLocations.length == 1) {

             } else {


             console.log(xAvg + ", " + yAvg);
             }*/
        };

        self.makeSmaller = function(data, event) {
            d3.select(event.target).transition()
                .duration(300)
                .attr('transform', "scale(1,1)");
        };

        (function() {
            locationsService.getLocationData().then(function(response) {
                $scope.locations = response.data.lcations;

                var svg = d3.select('svg');

                var xScale = d3.scale.linear().domain([0, 1400])
                    .range([0,parseInt(svg.style('width'))]);

                var yScale = d3.scale.linear().domain([0, 700])
                    .range([0,parseInt(svg.style('height'))]);

                var colorScale = d3.scale.ordinal().domain(['Launch Site', 'Landing Site', 'ASDS', 'Facility'])
                    .range(['#CCAC55', '#40C085', '#4050C0', '#21272B']);

                var iconScale;

                var placeOnMap = function(idOfDataPoint) {
                    switch (idOfDataPoint) {
                        case 1:
                            return {x: 201, y: 550 };
                        case 2:
                            return {x: 1009, y: 523 };
                        case 3:
                            return {x: 275, y: 356 };
                        case 4:
                            return {x: 1008, y: 522 };
                        case 5:
                            return {x: 684, y: 601 };
                        case 6:
                            return {x: 1100, y: 550 };
                        case 7:
                            return {x: 1009, y: 524 };
                        case 8:
                            return {x: 274, y: 356 };
                        case 9:
                            return {x: 1100, y: 500 };
                        case 10:
                            return {x: 1000, y: 550 };
                    }
                    return { x: 0, y: 0 };
                };

                // Grab the selection of elements and data
                var enterSelection = svg.selectAll("circle").data(self.locations(), function(d) { return d.name(); }).enter();

                // Apply a grouping with an overall translation
                var grouping = enterSelection.append("g")
                    .attr('class', function(d) { return 'location ' + d.name(); })
                    .attr('transform', function(d) {
                        return 'translate(' + placeOnMap(d.location_id()).x + ',' + placeOnMap(d.location_id()).y + ')';
                    });

                // Insert
                ////grouping.insert('rect')
                //        .attr('transform', 'translate(0,-8)')
                //        .attr('height', 16)
                //        .attr('width', 100)
                //        .attr('fill', 'red');

                grouping.insert('circle')
                    .attr('fill', function(d) { return colorScale(d.type()); })
                    .attr('r', self.circleRadius)
                    .attr('data-bind', 'event: { mouseover: makeLarger.bind($data), mouseout: makeSmaller.bind($data) }');
            });
        })();
    }]);

    locationsApp.service("locationsService", ["$http", function($http) {
        this.getLocationData = function() {
            return $http.get('/locations/getLocationData');
        }
    }]);
})();
