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
            upperStageEngines: ko.observableArray([])
        };

        self.mission = ko.observable(new Mission());

        self.createMission = function(data) {
            console.log(koMapping.toJS(self.mission));
        };

        function Mission(mission) {
            koMapping.fromJS(mission, {
                include: ['mission_id'],
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
        }

        this.addPayload = function (data) {
            self.mission().payloads.push(new Payload(data));
        };

        this.removePayload = function (data) {
            self.mission().payloads.remove(data);
        };

        this.addPart = function (data) {
            self.mission.parts.push(new Part(data));
        };

        this.removePart = function (data) {
            self.mission.parts.remove(data);
        };

        // Astronaut
        function Astronaut(astronaut) {
            var a = this;
            this.astronaut_id = ko.observable(astronaut.astronaut_id);
            this.first_name = ko.observable(astronaut.first_name);
            this.last_name = ko.observable(astronaut.last_name);
            this.full_name = ko.computed(function() {
                return a.first_name() + " " + a.last_name();
            });
            this.nationality = ko.observable(astronaut.nationality);
            this.date_of_birth = ko.observable(astronaut.date_of_birth);
            this.contracted_by = ko.observable(astronaut.contracted_by);
        }



        function Part() {

        }

        self.addPart = function(data) {

        };

        self.spacecraft = ko.observableArray([]);

        function Spacecraft() {

        }

        function Payload(payload) {
            koMapping.fromJS(payload, {

            }, this);
            var p = this;

            this.payload_id = ko.observable();
            this.name = ko.observable();
            this.operator = ko.observable();
            this.mass = ko.observable();
            this.primary = ko.observable();
            this.link = ko.observable();
        }

        /*self.addSpacecraft = function () {
            if (self.spacecraft.length == 0) {
                self.spacecraft.push(new Spacecraft());
            }
        };

        self.removeSpacecraft = function (spacecraft) {
            self.spacecraft.remove(spacecraft);
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
