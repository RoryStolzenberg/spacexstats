var ReviewViewModel = function() {
    var self = this;

    self.objects = ko.observableArray();

    self.init = function() {
        $.ajax('/missioncontrol/review/get', {
           dataType: 'json',
            type: 'GET',
            success: function(objectsToReview) {
                $.each(objectsToReview, function(index, objectToReview) {
                    self.objects.push(objectToReview);
                });
            }
        });
    };

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

    self.init();
};