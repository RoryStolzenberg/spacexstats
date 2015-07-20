define(['jquery', 'knockout', 'ko.mapping'], function($, ko, koMapping) {
    var MissionViewModel = function () {

        var getOriginalValue = ko.bindingHandlers.value.init;
        ko.bindingHandlers.value.init = function(element, valueAccessor, allBindings) {
            if (allBindings.has('getOriginalValue')) {
                valueAccessor()(element.value);
            }
            getOriginalValue.apply(this, arguments);
        };

        ko.components.register('datetime', { require: 'components/datetime/datetime'});

        var self = this;

        self.submit = function() {

            var final = { data: koMapping.toJS(self.mission), _token: self.csrfToken() };

            $.ajax('/missions/create', {
                method: 'POST',
                data: JSON.stringify(final, function(key, value) {
                    if (value === "" || typeof value === 'undefined') {
                        return null;
                    }
                    return value;
                }),
                contentType: "application/json",
                success: function(response) {
                    console.log(response);
                }
            });
        };

        // Data lists
        self.dataLists = {
            destinations: ko.observableArray(),
            missionTypes: ko.observableArray(),
            launchSites: ko.observableArray(),
            landingSites: ko.observableArray(),
            vehicles: ko.observableArray(),
            spacecraft: ko.observableArray(),
            firststageEngines: ko.observableArray(),
            upperstageEngines: ko.observableArray(),
            parts: ko.observableArray(),
            astronauts: ko.observableArray()
        };

        self.mission = ko.observable(new Mission({
            partFlights: [],
            spacecraftFlight: [],
            payloads: ko.observable([])
        }));

        self.csrfToken = ko.observable();

        function Mission(mission) {
            koMapping.fromJS(mission, {
                include: ['mission_id', 'mission_type_id', 'launch_date_time', 'name', 'contractor',
                        'vehicle_id', 'destination_id', 'launch_site_id',
                        'summary', 'article', 'status', 'outcome', 'fairings_recovered', 'launch_video',
                        'mission_patch', 'press_kit', 'cargo_manifest', 'prelaunch_press_conference',
                        'postlaunch_press_conference', 'reddit_discussion', 'featured_image', 'payloads'],
                'partFlights': {
                    create: function(options) {
                        return new PartFlight(options.data);
                    }
                },
                'spacecraftFlight': {
                    create: function(options) {
                        return new SpacecraftFlight(options.data);
                    }
                },
                'payloads': {
                    create: function(options) {
                        return new Payload(options.data);
                    }
                }
            }, this);

            this.mission_id                     = ko.observable(mission.mission_id);
            this.mission_type_id                = ko.observable(mission.mission_type_id);
            this.launch_date_time               = ko.observable(mission.launch_date_time);
            this.name                           = ko.observable(mission.name);
            this.contractor                     = ko.observable(mission.contractor);
            this.vehicle_id                     = ko.observable(mission.vehicle_id);
            this.destination_id                 = ko.observable(mission.destination_id);
            this.launch_site_id                 = ko.observable(mission.launch_site_id);
            this.summary                        = ko.observable(mission.summary);
            this.article                        = ko.observable(mission.article);
            this.status                         = ko.observable(mission.status);
            this.outcome                        = ko.observable(mission.outcome);
            this.fairings_recovered             = ko.observable(mission.fairings_recovered);
            this.launch_video                   = ko.observable(mission.launch_video);
            this.mission_patch                  = ko.observable(mission.mission_patch);
            this.press_kit                      = ko.observable(mission.press_kit);
            this.cargo_manifest                 = ko.observable(mission.cargo_manifest);
            this.prelaunch_press_conference     = ko.observable(mission.prelaunch_press_conference);
            this.postlaunch_press_conference    = ko.observable(mission.postlaunch_press_conference);
            this.reddit_discussion              = ko.observable(mission.reddit_discussion);
            this.featured_image                 = ko.observable(mission.featured_image);
        };

        function SpacecraftFlight(spacecraftFlight) {
            koMapping.fromJS(spacecraftFlight, {
                include: ['spacecraft_flight_id','flight_name','end_of_mission','return_method','upmass','downmass','iss_berth','iss_unberth'],
                'spacecraft': {
                    create: function(options) {
                        return new Spacecraft(options.data);
                    }
                },
                'astronautFlights': {
                    create: function(options) {
                        return new AstronautFlight(options.data);
                    }
                }
            }, this);

            this.spacecraft_flight_id   = ko.observable(spacecraftFlight.spacecraft_flight_id);
            this.flight_name            = ko.observable(spacecraftFlight.flight_name);
            this.end_of_mission         = ko.observable(spacecraftFlight.end_of_mission);
            this.return_method          = ko.observable(spacecraftFlight.return_method);
            this.upmass                 = ko.observable(spacecraftFlight.upmass);
            this.downmass               = ko.observable(spacecraftFlight.downmass);
            this.iss_berth              = ko.observable(spacecraftFlight.iss_berth);
            this.iss_unberth            = ko.observable(spacecraftFlight.iss_unberth);

            this.flight_name.subscribe(function() {
                console.log('ysdnjjjjfg');
            });
        }

        function Spacecraft(spacecraft) {
            koMapping.fromJS(spacecraft, {
                include: ['spacecraft_id', 'type', 'name']
            }, this);

            this.spacecraft_id  = ko.observable(spacecraft.spacecraft_id);
            this.type           = ko.observable(spacecraft.type);
            this.name           = ko.observable(spacecraft.name);
        }

        function AstronautFlight(astronautFlight) {
            koMapping.fromJS(astronautFlight, {
                include: ['astronaut_flight_id'],
                'astronaut': {
                    create: function(options) {
                        return new Astronaut(options.data);
                    }
                }
            }, this);

            this.astronaut_flight_id    = ko.observable(astronautFlight.astronaut_flight_id);
        }

        function Astronaut(astronaut) {
            koMapping.fromJS(astronaut, {
                include: ['astronaut_id', 'first_name', 'last_name', 'nationality', 'date_of_birth', 'contracted_by']
            }, this);

            this.astronaut_id   = ko.observable(astronaut.astronaut_id);
            this.first_name     = ko.observable(astronaut.first_name);
            this.last_name      = ko.observable(astronaut.last_name);
            this.nationality    = ko.observable(astronaut.nationality);
            this.date_of_birth  = ko.observable(astronaut.date_of_birth);
            this.contracted_by  = ko.observable(astronaut.contracted_by);

            this.full_name = ko.computed(function() {
                return this.first_name() + " " + this.last_name();
            }, this);
        }

        function Payload(payload) {
            koMapping.fromJS(payload, {
                include: ['payload_id', 'name', 'operator', 'mass', 'primary', 'link']
            }, this);

            this.payload_id = ko.observable(payload.payload_id);
            this.name       = ko.observable(payload.name);
            this.operator   = ko.observable(payload.operator);
            this.mass       = ko.observable(payload.mass);
            this.primary    = ko.observable(payload.primary);
            this.link       = ko.observable(payload.link);
        }

        function PartFlight(partFlight) {
            koMapping.fromJS(partFlight, {
                include: ['part_flight_id', 'firststage_landing_legs', 'firststage_grid_fins',
                    'firststage_engine', 'landing_site_id', 'firststage_engine_failures',
                    'firststage_meco', 'firststage_landing_coords_lat', 'firststage_landing_coords_lng',
                    'baseplate_color', 'upperstage_engine', 'upperstage_seco', 'upperstage_status',
                    'upperstage_decay_date', 'upperstage_norad_id', 'upperstage_intl_designator',
                    'landed', 'note'],
                'part': {
                    create: function(options) {
                        return new Part(options.data);
                    }
                }
            }, this);

            this.part_flight_id                 = ko.observable(partFlight.part_flight_id);
            this.firststage_landing_legs        = ko.observable(partFlight.firststage_landing_legs);
            this.firststage_grid_fins           = ko.observable(partFlight.firststage_grid_fins);
            this.firststage_engine              = ko.observable(partFlight.firststage_engine);
            this.landing_site_id                = ko.observable(partFlight.landing_site_id);
            this.firststage_engine_failures     = ko.observable(partFlight.firststage_engine_failures);
            this.firststage_meco                = ko.observable(partFlight.firststage_meco);
            this.firststage_landing_coords_lat  = ko.observable(partFlight.firststage_landing_coords_lat);
            this.firststage_landing_coords_lng  = ko.observable(partFlight.firststage_landing_coords_lng);
            this.baseplate_color                = ko.observable(partFlight.baseplate_color);
            this.upperstage_engine              = ko.observable(partFlight.upperstage_engine);
            this.upperstage_seco                = ko.observable(partFlight.upperstage_seco);
            this.upperstage_status              = ko.observable(partFlight.upperstage_status);
            this.upperstage_decay_date          = ko.observable(partFlight.upperstage_decay_date);
            this.upperstage_norad_id            = ko.observable(partFlight.upperstage_norad_id);
            this.upperstage_intl_designator     = ko.observable(partFlight.upperstage_intl_designator);
            this.landed                         = ko.observable(partFlight.landed);
            this.note                           = ko.observable(partFlight.note);

            this.heading = ko.computed(function() {
                return this.part.type() + " (" + this.part.name() + ")";
            }, this);
        }

        function Part(part) {
            koMapping.fromJS(part, {
                include: ['part_id', 'name', 'type']
            }, this);

            this.part_id    = ko.observable(part.part_id);
            this.name       = ko.observable(part.name);
            this.type       = ko.observable(part.type);
        }

        // PARTS STUFF
        self.partActions = {
            selectedPart: ko.observable(),
            partsFilter: ko.observable(),
            addPart: function() {
                if (typeof self.partActions.selectedPart() === 'undefined') {
                    var partFlight = {
                        part: {
                            type: self.partActions.partsFilter(),
                            name: ""
                        }
                    };
                    self.mission().partFlights.push(new PartFlight(partFlight));
                } else {
                    var partFlight = {
                        part: koMapping.toJS(self.partActions.selectedPart)
                    };
                    self.mission().partFlights.push(new PartFlight(partFlight));
                }
            },
            removePart: function(partFlight) {
                self.mission().partFlights.remove(partFlight);
            },
            filteredParts: ko.computed({ read: function() {
                return self.dataLists.parts().filter(function(part) {
                    return part.type() == self.partActions.partsFilter();
                });
            }, deferEvaluation: true }),
            filterByBoosters: function() {
                self.partActions.partsFilter('Booster');
            },
            filterByFirstStages: function() {
                self.partActions.partsFilter('First Stage');
            },
            filterByUpperStages: function() {
                self.partActions.partsFilter('Upper Stage');
            }
        };

        self.payloadActions = {
            addPayload: function() {
                self.mission().payloads.push(new Payload({}));
            },
            removePayload: function(payload) {
                self.mission().payloads.remove(payload);
            }
        };

        self.spacecraftActions = {
            selectedSpacecraft: ko.observable(),
            addSpacecraft: function() {
                if (self.mission().spacecraftFlight().length == 0) {
                    var spacecraftFlight = {
                        spacecraft: {

                        },
                        astronautFlights: []
                    };
                    self.mission().spacecraftFlight.push(new SpacecraftFlight(spacecraftFlight));
                }
            },
            removeSpacecraft: function(spacecraftFlight) {
                self.mission().spacecraftFlight.remove(spacecraftFlight);
            }
        };

        self.astronautActions = {
            selectedAstronaut: ko.observable(),
            filteredAstronauts: ko.computed(function() {

            }),
            addAstronaut: function() {
                console.log(self.mission().spacecraftFlight()[0]);
                if (typeof self.astronautActions.selectedAstronaut() !== 'undefined') {
                    var astronautFlight = {
                        astronaut: koMapping.toJS(self.astronautActions.selectedAstronaut)
                    };

                    self.mission().spacecraftFlight()[0].astronautFlights.push(new AstronautFlight(astronautFlight));
                } else {
                    var astronautFlight = {
                        astronaut: {}
                    };
                    self.mission().spacecraftFlight()[0].astronautFlights.push(new AstronautFlight(astronautFlight));
                }
            },
            removeAstronaut: function(astronautFlight) {
                self.mission().spacecraftFlight()[0].astronautFlights.remove(astronautFlight);
            }
        };


        self.init = (function() {
            $.ajax('/missions/create', {
                method: 'GET',
                dataType: 'json',
                success: function(lists) {
                    // Map the data lists
                    koMapping.fromJS(lists, {}, self.dataLists);
                }
            });
        })();
    };

    return MissionViewModel;
});
