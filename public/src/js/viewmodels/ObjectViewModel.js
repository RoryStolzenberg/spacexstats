define(['jquery', 'knockout', 'ko.mapping'], function($, ko, koMapping) {

    var ObjectViewModel = function(object_id) {

        var getOriginalValue = ko.bindingHandlers.value.init;
        ko.bindingHandlers.value.init = function(element, valueAccessor, allBindings) {
            if (allBindings.has('getOriginalValue')) {
                valueAccessor()(element.value);
            }
            getOriginalValue.apply(this, arguments);
        };

        var self = this;

        self.note = ko.observable();

        self.noteButtonText = ko.computed({ read: function() {
            if (self.note() == null) {
                return 'Create Note';
            } else {
                return 'Edit Note';
            }
        }, deferEvaluation: true });

        self.noteReadText = ko.computed({ read: function() {
            if (self.note() == null) {
                return 'Create a Note!';
            }  else {
                return self.note();
            }
        }, deferEvaluation: true });

        self.noteState = ko.observable('read');

        self.changeNoteState = function() {
            if (self.noteState() == 'read') {
                self.originalNote = self.note();
                self.noteState('write');
            } else {
                self.noteState('read');
            }

        };

        self.saveNote = function() {
            console.log(self.originalNote);
            if (typeof self.originalNote == 'undefined') {
                var requestType = 'POST';
            } else {
                var requestType = 'PATCH';
            }

            $.ajax('/missioncontrol/objects/' + object_id + '/note', {
                type: requestType,
                data: { note: self.note() },
                success: function(response) {
                    console.log(response);

                    self.changeNoteState();
                }
            });
        };

        self.deleteNote = function() {
            $.ajax('/missioncontrol/objects/' + object_id + '/note', {
                type: 'DELETE',
                success: function(response) {
                    console.log(response);
                }
            });
        }

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
