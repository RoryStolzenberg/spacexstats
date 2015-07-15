define(['jquery', 'knockout', 'ko.mapping'], function($, ko, koMapping) {
    var CreateMissionViewModel = function () {
        var self = this;

        // Data lists
        self.dataLists = {
            missionTypes: ko.observableArray([]),
            destinations: ko.observableArray([]),
            launchSites: ko.observableArray([]),
            vehicles: ko.observableArray([]),
            spacecraft: ko.observableArray([]),
            spacecraftReturnMethods: ko.observableArray([]),
            firstStageEngines: ko.observableArray([]),
            upperStageEngines: ko.observableArray([]),
            parts: ko.observableArray([])
        };

        self.mission = ko.observable(new Mission());

        self.createMission = function(data) {
            console.log(koMapping.toJS(self.mission));
        };

        function Mission(mission) {
            koMapping.fromJS(mission, {
                include: ['mission_id', 'name', 'mission_type_id', 'contractor', 'launch_date_time',
                    'destination_id', 'launch_site_id', 'summary', 'payloads', 'parts', 'spacecraft'],
                'payloads': {
                   create: function(options) {
                       console.log(options);
                   }
                }
            }, this);
            var m = this;

            this.mission_id = ko.observable();
            this.name = ko.observable();
            this.mission_type_id = ko.observable();
            this.contractor = ko.observable();
            this.launch_date_time = ko.observable();
            this.destination_id = ko.observable();
            this.launch_site_id = ko.observable();
            this.summary = ko.observable();

            /* PAYLOADS */
            this.payloads = ko.observableArray([]);

            /* PARTS */
            this.parts = ko.observableArray([]);

            /* SPACECRAFT */
            this.spacecraft = ko.observable();
        }

        self.addPayload = function (data) {
            self.mission().payloads.push(new Payload(data));
        };

        self.removePayload = function (data) {
            self.mission().payloads.remove(data);
        };

        self.addPart = function (data) {
            self.mission.parts.push(new Part(data));
        };

        self.removePart = function (data) {
            self.mission.parts.remove(data);
        };

        self.addSpacecraft = function () {
            if (self.spacecraft.length == 0) {
                self.spacecraft.push(new Spacecraft());
            }
        };

        self.removeSpacecraft = function (spacecraft) {
            self.spacecraft.remove(spacecraft);
        };

        // Astronaut
        function Astronaut(astronaut) {
            var a = this;
            this.astronaut_id = ko.observable();
            this.first_name = ko.observable();
            this.last_name = ko.observable();
            this.full_name = ko.computed(function() {
                return a.first_name() + " " + a.last_name();
            });
            this.nationality = ko.observable();
            this.date_of_birth = ko.observable();
            this.contracted_by = ko.observable();
        }



        function Spacecraft() {
            var s = this;
            this.spacecraft_id = ko.observable();
            this.type = ko.observable();
            this.spacecraft_name = ko.observable();
        }

        function Payload(payload) {
            koMapping.fromJS(payload, {}, this);
            var p = this;

            this.payload_id = ko.observable();
            this.name = ko.observable();
            this.operator = ko.observable();
            this.mass = ko.observable();
            this.primary = ko.observable();
            this.link = ko.observable();
        }

        function Part(part) {
            koMapping.fromJS(part, {
                include: ['part_id', 'name', 'type', 'part_flights']
            }, this);
            var p = this;

            this.part_id = ko.observable();
            this.name = ko.observable();
            this.type = ko.observable();

            this.part_flights = ko.observableArray([]);
        }

        function PartFlight(partFlight) {
            koMapping.fromJS(partFlight, {
                include: ['part_id', 'name', 'type', 'part_flights']
            }, this);
            var pf = this;

            this.part_flight_id = ko.observable();
            this.firststage_landing_legs = ko.observable();
            this.firststage_grid_fins = ko.observable();
            this.firststage_engine = ko.observable();
            this.landing_site_id = ko.observable();
            this.firststage_engine_failures = ko.observable();
            this.firststage_meco = ko.observable();
            this.firststage_landing_coords_lat = ko.observable();
            this.firststage_landing_coords_long = ko.observable();
            this.baseplate_color = ko.observable();
            this.upperstage_engine = ko.observable();
            this.upperstage_seco = ko.observable();
            this.upperstage_status = ko.observable();
            this.upperstage_decay_date = ko.observable();
            this.upperstage_norad_id = ko.observable();
            this.upperstage_intl_designator = ko.observable();
            this.landed = ko.observable();
            this.note = ko.observable();
            this.part_id = ko.observable();
        }

        // PARTS STUFF
        self.partSelection = {
            selectedPart: ko.observable(),
            selectedPartType: ko.observable(),
            partsFilter: ko.observable(),
            addThisPart: function() {
                console.log(self.partSelection.selectedPart());
            },
            filteredParts: ko.computed({ read: function() {
                console.log(self.dataLists.parts());
                return self.dataLists.parts().filter(function(part) {
                    return part.type() == self.partSelection.partsFilter();
                });
            }, deferEvaluation: true }),
            addBooster: function() {
                self.partSelection.partsFilter('Booster');
            },
            addFirstStage: function() {
                self.partSelection.partsFilter('First Stage');
            },
            addUpperStage: function() {
                self.partSelection.partsFilter('Upper Stage');
            }
        };


        self.init = (function() {
            $.ajax('/missions/create', {
                method: 'GET',
                dataType: 'json',
                success: function(lists) {
                    // Map the data lists
                    koMapping.fromJS(lists, {}, self.dataLists);
                    console.log(self.dataLists);
                }
            });
        })();
    };

    return CreateMissionViewModel;
});
