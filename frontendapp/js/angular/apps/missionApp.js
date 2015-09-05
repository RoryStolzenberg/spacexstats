angular.module("missionApp", ["directives.datetime"], ['$interpolateProvider', function($interpolateProvider) {
    $interpolateProvider.startSymbol('[[');
    $interpolateProvider.endSymbol(']]');

}]).controller("missionController", ['$scope', 'Mission', function($scope, Mission) {
    // Set the current mission being edited/created
    $scope.mission = new Mission(typeof laravel.mission !== "undefined" ? laravel.mission : null);

    // Scope the possible form data info
    $scope.data = {
        parts: laravel.parts,
        spacecraft: laravel.spacecraft,
        destinations: laravel.destinations,
        missionTypes: laravel.missionTypes,
        launchSites: laravel.launchSites,
        landingSites: laravel.landingSites,
        vehicles: laravel.vehicles,
        firststageEngines: laravel.firststageEngines,
        upperstageEngines: laravel.upperstageEngines,
        astronauts: laravel.astronauts
    };

    $scope.submitMission = function() {
        console.log($scope.mission);
    }


}]).factory("Mission", ["PartFlight", "Payload", "SpacecraftFlight", function(PartFlight, Payload, SpacecraftFlight) {
    return function (mission) {
        if (mission == null) {
            var self = this;

            self.payloads = [];
            self.partFlights = [];
            self.spacecraftFlight = null;

        } else {
            var self = mission;
        }

        self.addPartFlight = function(part) {
            self.partFlights.push(new PartFlight(part));
        };

        self.addPayload = function() {
            self.payloads.push(new Payload());
        };

        self.removePayload = function(payload) {
            self.payloads.splice(self.payloads.indexOf(payload), 1);
        };

        self.addSpacecraftFlight = function(spacecraft) {
            self.spacecraftFlight = new SpacecraftFlight(spacecraft);
        };

        return self;
    }

}]).factory("Payload", function() {
    return function (payload) {
        if (payload == null) {
            var self = this;
        } else {
            var self = payload;
        }
        return self;
    }

}).factory("PartFlight", function() {
    return function(part) {
        if (partFlight == null) {
            var self = this;

            self.part = null;

        } else {
            var self = partFlight;
        }
        return self;
    }

}).factory("Part", function() {
    return function() {

    }

}).factory("SpacecraftFlight", function() {
    return function(spacecraftFlight) {
        if (spacecraftFlight == null) {
            var self = this;

            self.spacecraft = null;

        } else {
            var self = spacecraftFlight;
        }
        return self;
    }
}).factory("Spacecraft", function() {
    return function() {

    }
});



