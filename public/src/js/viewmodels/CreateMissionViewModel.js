define(['jquery', 'knockout', 'ko.mapping'], function($, ko, koMapping) {
    var CreateMissionViewModel = function () {
        var self = this;

        // Data lists
        self.dataLists = {};

        var data = {
            'mission_id': '1',
            'name': '5',
            'payloads': [
                {
                    'name': 'heres a payload'
                },
                {
                    'name': 'moar struts'
                }
            ],
            'spacecraftFlight': [
                {
                    'title': 'CRS-7',
                    'astronautFlights': [
                        {
                            'astronaut': {
                                'person': 'Gustavo'
                            }
                        }
                    ]
                }
            ]
        };

        self.mission = koMapping.fromJS(data, {
            include: [],
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
        });

        function SpacecraftFlight(spacecraftFlight) {
            koMapping.fromJS(spacecraftFlight, {
                'astronautFlights': {
                    create: function(options) {
                        return new AstronautFlight(options.data);
                    }
                }
            }, this);
        }

        function AstronautFlight(astronautFlight) {
            koMapping.fromJS(astronautFlight, {
                'astronaut': {
                    create: function(options) {
                        return new Astronaut(options.data);
                    }
                }
            }, this);
        }

        function Astronaut(astronaut) {
            koMapping.fromJS(astronaut, {
                include: ['some_bullshit']
            }, this);

            this.some_bullshit = ko.computed(function() {
                return '77';
            });
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

            this.excessiveTitle = ko.computed(function() {
                return this.name() + " yeah bitch";
            }, this);
        }

        console.log(koMapping.toJS(self.mission));

        self.mission.payloads.push(new Payload({ name: 'yolo'}));

        console.log(koMapping.toJS(self.mission));


        // PARTS STUFF
        /*self.partSelection = {
            selectedPart: ko.observable(),
            selectedPartType: ko.observable(),
            partsFilter: ko.observable(),
            addThisPart: function() {
                if (typeof self.partSelection.selectedPart() === 'undefined') {
                    self.mission().parts.push(new Part({}));
                } else {
                    self.mission().parts.push(koMapping.fromJS(self.partSelection.selectedPart, {
                        create: function(options) {
                            console.log('yolo');
                            return new Part(options.data);
                        }
                    }));
                }
            },
            filteredParts: ko.computed({ read: function() {
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
        };*/


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

    return CreateMissionViewModel;
});
