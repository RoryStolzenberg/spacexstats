angular.module("missionApp", ["directives.datetime", "directives.selectList"], ['$interpolateProvider', function($interpolateProvider) {
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
        astronauts: laravel.astronauts,

        launchVideos: laravel.launchVideos ? laravel.launchVideos : null,
        missionPatches: laravel.missionPatches ? laravel.missionPatches : null,
        pressKits: laravel.pressKits ? laravel.pressKits : null,
        cargoManifests: laravel.cargoManifests ? laravel.cargoManifests : null,
        pressConferences: laravel.pressConferences ? laravel.pressConferences : null,
        featuredImages: laravel.featuredImages ? laravel.featuredImages: null,

        firstStageEngines: ['Merlin 1A', 'Merlin 1B', 'Merlin 1C', 'Merlin 1D'],
        upperStageEngines: ['Kestrel', 'Merlin 1C-Vac', 'Merlin 1D-Vac'],
        upperStageStatuses: ['Did not reach orbit', 'Decayed', 'Deorbited', 'Earth Orbit', 'Solar Orbit'],
        spacecraftTypes: ['Dragon 1', 'Dragon 2'],
        returnMethods: ['Splashdown', 'Landing', 'Did Not Return'],
        eventTypes: ['Wet Dress Rehearsal', 'Static Fire'],
        launchIlluminations: ['Day', 'Night', 'Twilight'],
        statuses: ['Upcoming', 'Complete', 'In Progress'],
        outcomes: ['Failure', 'Success']
    };

    $scope.filters = {
        parts: {
            type: ''
        }
    }

    $scope.selected = {
        astronaut: null
    };

    $scope.createMission = function() {
        missionService.create($scope.mission);
    }

    $scope.editMission = function() {
        missionService.edit($scope.mission);
    }

}]).factory("Mission", ["PartFlight", "Payload", "SpacecraftFlight", function(PartFlight, Payload, SpacecraftFlight) {
    return function (mission) {
        if (mission == null) {
            var self = this;

            self.payloads = [];
            self.part_flights = [];
            self.spacecraft_flight = null;
            self.prelaunch_events = [];

        } else {
            var self = mission;
        }

        self.addPartFlight = function(part) {
            self.part_flights.push(new PartFlight(part));
        };

        self.removePartFlight = function(part) {
            self.part_flights.splice(self.part_flights.indexOf(part), 1);
        }

        self.addPayload = function() {
            self.payloads.push(new Payload());
        };

        self.removePayload = function(payload) {
            self.payloads.splice(self.payloads.indexOf(payload), 1);
        };

        self.addSpacecraftFlight = function(spacecraft) {
            self.spacecraft_flight = new SpacecraftFlight(spacecraft);
        };

        self.removeSpacecraftFlight = function() {
            self.spacecraft_flight = null;
        };

        self.addPrelaunchEvent = function() {
            self.prelaunch_events.push(new PrelaunchEvent());
        };

        self.removePrelaunchEvent = function(prelaunchEvent) {
            self.prelaunch_events.splice(self.prelaunch_events.indexOf(prelaunchEvent), 1);
        }

        return self;
    }

}]).factory("Payload", function() {
    return function() {
        var self = {

        };
        return self;
    }

}).factory("PartFlight", ["Part", function(Part) {
    return function(type, part) {
        var self = this;

        self.part = new Part(type, part);

        return self;
    }

}]).factory("Part", function() {
    return function(type, part) {

        if (typeof part === 'undefined') {
            var self = this
            self.type = type;
        } else {
            var self = part;
        }

        return self;
    }

}).factory("SpacecraftFlight", ["Spacecraft", "AstronautFlight", function(Spacecraft, AstronautFlight) {
    return function(spacecraft) {
        var self = this;

        self.spacecraft = new Spacecraft(spacecraft);

        self.astronaut_flights = [];

        self.addAstronautFlight = function(astronaut) {
            self.astronaut_flights.push(new AstronautFlight(astronaut));
        };

        self.removeAstronautFlight = function(astronautFlight) {
            self.astronaut_flights.splice(self.astronaut_flights.indexOf(astronautFlight), 1);
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
    return function (astronaut) {
        if (astronaut == null) {
            var self = this;
        } else {
            var self = astronaut;
        }
        return self;
    }
}).factory("PrelaunchEvent", function() {
    return function (prelaunchEvent) {

        var self = prelaunchEvent;

        return self;
    }

}).service("missionService", ["$http", "CSRF_TOKEN",
    function($http, CSRF_TOKEN) {
    this.create = function(mission) {
        $http.post('/missions/create', {
            mission: mission,
            _token: CSRF_TOKEN
        }).then(function(response) {
            window.location = '/missions/' + response.data.mission.slug;
        });
    };

    this.edit = function(mission) {
        $http.patch('/missions/' + mission.slug + '/edit', {
            mission: mission,
            _token: CSRF_TOKEN
        }).then(function(response) {
            window.location = '/missions/' + response.data.mission.slug;
        });
    }
}]);



