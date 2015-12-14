(function() {
    var locationsApp = angular.module('app', []);

    locationsApp.controller("locationsController", ["$scope", "locationsService", "$compile", function($scope, locationsService, $compile) {

        $scope.filters = {
            noLongerUsed: true,
            launchSites: true,
            landingSites: true,
            ASDSs: true
        };

        $scope.locationPageTitle = function() {
            if (angular.isUndefined($scope.selectedLocation)) {
                return 'Locations';
            } else {
                return $scope.selectedLocation.name;
            }
        };

        $scope.isShowingMap = true;
        $scope.circleRadius = 20;

        $scope.makeLarger = function(d, i, self) {
            d3.select(self).transition()
                .duration(300)
                .attr('transform', "scale(1.5,1.5)");
        };

        $scope.makeSmaller = function(d, i, self) {
            d3.select(self).transition()
                .duration(300)
                .attr('transform', "scale(1,1)");
        };

        $scope.selectLocation = function(d) {
            $scope.selectedLocation = d;
            history.replaceState('', document.title, '#' + d.name.toLowerCase().replace(/\s/g, "-"));
            $scope.$apply();
        };

        (function() {
            locationsService.getLocationData().then(function(response) {
                $scope.locations = response.data;

                // If a hash already exists, preset it:
                if (window.location.hash) {
                    $scope.selectedLocation = $scope.locations.filter(function(location) {
                        return location.name.toLowerCase().replace(/\s/g, "-") == window.location.hash.substring(1);
                    })[0];
                }

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
                            return {x: 1009, y: 525 };
                        case 3:
                            return {x: 274, y: 380 };
                        case 4:
                            return {x: 1008, y: 485 };
                        case 5:
                            return {x: 684, y: 601 };
                        case 6:
                            return {x: 1100, y: 550 };
                        case 7:
                            return {x: 1009, y: 565 };
                        case 8:
                            return {x: 274, y: 340 };
                        case 9:
                            return {x: 1100, y: 500 };
                        case 10:
                            return {x: 1000, y: 550 };
                    }
                    return { x: 0, y: 0 };
                };

                // Grab the selection of elements and data
                var enterSelection = svg.selectAll("circle").data($scope.locations, function(d) { return d.name; }).enter();

                // Apply a grouping with an overall translation
                var grouping = enterSelection.append("g")
                    .attr('class', function(d) { return 'location ' + d.name; })
                    .attr('transform', function(d) {
                        return 'translate(' + placeOnMap(d.location_id).x + ',' + placeOnMap(d.location_id).y + ')';
                    });

                grouping.insert('circle')
                    .attr('fill', function(d) { return colorScale(d.type); })
                    .attr('r', $scope.circleRadius)
                    .on('mouseover', function(d, i) {
                        $scope.makeLarger(d, i, this);
                    })
                    .on('mouseout', function(d, i) {
                        $scope.makeSmaller(d, i, this);
                    })
                    .on('click', function(d, i) {
                        $scope.selectLocation(d, i, this);
                    })
                    .call(function(){
                        $compile(this[0].parentNode)($scope);
                    });

            });
        })();
    }]);

    locationsApp.service("locationsService", ["$http", function($http) {
        this.getLocationData = function() {
            return $http.get('/locations/getLocationData');
        }
    }]);
})();
