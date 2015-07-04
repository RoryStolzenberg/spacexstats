define(['jquery', 'knockout', 'ko.mapping'], function($, ko, koMapping) {

    var ObjectViewModel = function(object_id) {
        var self = this;

        self.noteState = ko.observable('read');

        self.editNote = function() {
            self.noteState('write')
        };
        self.saveNote = function() {};

        self.toggleFavorite = function() {
            $.ajax('/missioncontrol/object/' + object_id + '/favorite', {
                type: 'POST',
                success: function(response) {

                }
            });
        };

        self.download = function() {

        };
    };

    return ObjectViewModel;
});
