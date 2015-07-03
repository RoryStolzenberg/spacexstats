define(['knockout', 'ko.mapping'], function(ko, koMapping) {
    var ReviewViewModel = function() {
        var self = this;

        var fileMappingOptions = {
            create: function(options) {
                return new ObjectToReview(options.data);
            }
        };

        function ObjectToReview(obj) {
            var self = this;
            koMapping.fromJS(obj, {}, this);
        }

        self.objectsToReview = ko.observableArray();

        self.action = function(object_id, action) {
            $.ajax('/missioncontrol/review/update/' + object_id, {
                dataType: 'json',
                type: 'POST',
                data: { action: action},
                success: function(response) {
                    if (response == true) {

                    } else if (response == false) {

                    }
                },
                error: function(response) {

                }
            });
        };

        self.init = (function() {
            $.ajax('/missioncontrol/review/get', {
                dataType: 'json',
                type: 'GET',
                success: function(objectsToReview) {
                    koMapping.fromJS(objectsToReview, fileMappingOptions, self.objectsToReview);
                }
            });
        })();
    };

    return ReviewViewModel;
});