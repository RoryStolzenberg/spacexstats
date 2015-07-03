define(['jquery', 'moment', 'knockout', 'ko.mapping'], function($, moment, ko, koMapping) {
    var ReviewViewModel = function() {
        var self = this;

        var fileMappingOptions = {
            create: function(options) {
                return new ObjectToReview(options.data);
            }
        };

        self.visibilities = ['Default', 'Public', 'Hidden'];

        function ObjectToReview(obj) {
            var otr = this;
            koMapping.fromJS(obj, {}, this);

            otr.visibility = ko.observable("Default");
            otr.status = ko.observable(obj.status);

            otr.linkToObject = ko.computed(function() {
               return '/missioncontrol/object/' + otr.object_id();
            });

            otr.linkToUser = ko.computed(function() {
                return '/users/' + otr.user.username();
            });

            otr.textType = ko.computed(function() {
                switch(otr.type()) {
                    case 1:
                        return 'Image';
                    case 2:
                        return 'GIF';
                    case 3:
                        return 'Audio';
                    case 4:
                        return 'Video';
                    case 5:
                        return 'Document';
                }
            });

            otr.textSubtype = ko.computed(function() {
               switch(otr.subtype()) {
                   case 1:
                       return 'MissionPatch';
                   case 2:
                       return 'Photo';
                   case 3:
                       return 'Telemetry';
                   case 4:
                       return 'Chart';
                   case 5:
                       return 'Screenshot';
                   case 6:
                       return 'LaunchVideo';
                   case 7:
                       return 'PressConference';
                   case 8:
                       return 'PressKit';
                   case 9:
                       return 'CargoManifest';
               }
            });

            otr.createdAtRelative = ko.computed(function() {
                return moment.utc(otr.created_at()).fromNow();
            });

            otr.setAction = function(actionToTake) {
                otr.status(actionToTake);

                console.log(otr.status());

                $.ajax('/missioncontrol/review/update/' + otr.object_id(), {
                    dataType: 'json',
                    type: 'POST',
                    data: { visibility: otr.visibility(), status: otr.status() },
                    success: function(response) {
                        self.objectsToReview.remove(otr);
                    },
                    error: function(response) {
                        alert('Could not be removed');
                    }
                });
            }
        }

        self.objectsToReview = ko.observableArray();

        self.init = (function() {
            $.ajax('/missioncontrol/review/get', {
                dataType: 'json',
                type: 'GET',
                success: function(objectsToReview) {
                    koMapping.fromJS(objectsToReview, fileMappingOptions, self.objectsToReview);

                    console.log(self.objectsToReview());
                }
            });
        })();
    };

    return ReviewViewModel;
});