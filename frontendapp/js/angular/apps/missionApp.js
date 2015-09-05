angular.module("missionApp", ["directives.datetime"], ['$interpolateProvider', function($interpolateProvider) {
    $interpolateProvider.startSymbol('[[');
    $interpolateProvider.endSymbol(']]');

}]).controller("missionController", ['$scope', 'Mission', 'missionService', function($scope, Mission, missionService) {
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
        astronauts: laravel.astronauts,
        spacecraftTypes: laravel.spacecraftTypes,
        returnMethods: laravel.returnMethods
    };

    $scope.selected = {
        astronaut: null
    };


    $scope.submitMission = function() {
        console.log($scope.mission);
        missionService.create($scope.mission);
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

        self.removeSpacecraftFlight = function() {
            self.spacecraftFlight = null;
        };

        return self;
    }

}]).factory("Payload", function() {
    return function() {
        var self = {

        };
        return self;
    }

}).factory("PartFlight", ["Part", function(Part) {
    return function(part) {
        if (part == null) {
            var self = this;

            self.part = new Part();

        } else {
            var self = new Part(part);
        }
        return self;
    }

}]).factory("Part", function() {
    return function(part) {
        if (part == null) {
            var self = this;
        } else {
            var self = part;
        }

        return self;
    }

}).factory("SpacecraftFlight", ["Spacecraft", "AstronautFlight", function(Spacecraft, AstronautFlight) {
    return function(spacecraft) {
        var self = this;

        self.spacecraft = new Spacecraft(spacecraft);

        self.astronautFlights = [];

        self.addAstronautFlight = function(astronaut) {
            self.astronautFlights.push(new AstronautFlight(astronaut));
        };

        self.removeAstronautFlight = function(astronautFlight) {
            self.astronautFlights.splice(self.astronautFlights.indexOf(astronautFlight), 1);
        };

        return self;
    }

}]).factory("Spacecraft", function() {
    return function(spacecraft) {
        if (spacecraft == null) {
            var self = this;
        } else {
            var self = spacecraft;
        }
        return self;
    }

}).factory("AstronautFlight", ["Astronaut", function(Astronaut) {
    return function(astronaut) {
        var self = this;

        self.astronaut = new Astronaut(astronaut);

        return self;
    }

}]).factory("Astronaut", function() {
    return function(astronaut) {
        if (astronaut == null) {
            var self = this;
        } else {
            var self = astronaut;
        }
        return self;
    }

}).service("missionService", ["$http", "CSRF_TOKEN",
    function($http, CSRF_TOKEN) {
    this.create = function(mission) {
        $http.post('/missions/create', {
            mission: mission,
            _token: CSRF_TOKEN
        }).then(function(response) {

        });
    };

    this.edit = function(mission) {
        $http.patch('/missions/' + mission.slug + '/edit', {

        }).then(function(response) {

        });
    }
}]);



