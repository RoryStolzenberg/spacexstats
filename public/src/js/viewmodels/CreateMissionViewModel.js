define(['jquery', 'knockout', 'ko.mapping'], function($, ko, koMapping) {
    var CreateMissionViewModel = function () {
        var self = this;

        // Data lists
        self.missionTypes = ko.observableArray([]);
        self.destinations = ko.observableArray([]);
        self.launchSites = ko.observableArray([]);
        self.vehicles = ko.observableArray([]);
        self.spacecraft = ko.observableArray([]);
        self.spacecraftReturnMethods = ko.observableArray([]);
        self.firstStageEngines = ko.observableArray([]);
        self.upperStageEngines = ko.observableArray([]);

        function Mission(mission) {
            koMapping.fromJS(mission, {

            }, this);
            var m = this;

            this.mission_id = ko.observable();
            this.name = ko.observable();
            this.mission_type = ko.observable();
            this.contractor = ko.observable();
            this.launch_date_time = ko.observable();
            this.destination_id = ko.observable();
            this.launch_site_id = ko.observable();
            this.mission_id = ko.observable();

        }

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

        /*self.spacecraft = ko.observableArray([]);

        self.addSpacecraft = function () {
            if (self.spacecraft.length == 0) {
                self.spacecraft.push(new Spacecraft());
            }
        };

        self.removeSpacecraft = function (spacecraft) {
            self.spacecraft.remove(spacecraft);
        };

        self.payloads = ko.observableArray([]);

        self.addPayload = function () {
            self.payloads.push(new Payload());
        };

        self.removePayload = function (payload) {
            self.payloads.remove(payload);
        };*/

        self.init = (function() {
            $.ajax('/missions/create', {
                method: 'GET',
                dataType: 'json',
                success: function(response) {
                    console.log(response);
                }
            });
        })();
    };

    return CreateMissionViewModel;
});
