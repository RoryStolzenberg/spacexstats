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

        /* NOTES */
        self.note = ko.observable();
        self.originalNote = ko.observable("");

        self.noteButtonText = ko.computed({ read: function() {
            if (self.note() == "") {
                return 'Create Note';
            } else {
                return 'Edit Note';
            }
        }, deferEvaluation: true });

        self.noteReadText = ko.computed({ read: function() {
            if (self.note() == "") {
                return 'Create a Note!';
            }  else {
                return self.note();
            }
        }, deferEvaluation: true });

        self.noteState = ko.observable('read');

        self.changeNoteState = function() {
            self.originalNote(self.note());
            if (self.noteState() == 'read') {

                self.noteState('write');
            } else {
                self.noteState('read');
            }

        };

        self.saveNote = function() {
            if (self.originalNote() == "") {
                var requestType = 'POST';
            } else {
                var requestType = 'PATCH';
            }

            $.ajax('/missioncontrol/objects/' + object_id + '/note', {
                type: requestType,
                data: { note: self.note() },
                success: function(response) {
                    self.changeNoteState();
                }
            });
        };

        self.deleteNote = function() {
            $.ajax('/missioncontrol/objects/' + object_id + '/note', {
                type: 'DELETE',
                success: function(response) {
                    self.note("");
                    self.changeNoteState();
                }
            });
        }

        /* FAVORITES */
        self.favorites = ko.observable(laravel.totalFavorites);
        self.favoritesText = ko.computed(function() {
            if (self.favorites() == 1) {
                return '1 Favorite';
            } else {
                return self.favorites() + ' Favorites';
            }
        });
        self.isFavorited = ko.observable(laravel.isFavorited !== null);

        self.toggleFavorite = function() {
            if (self.isFavorited() === false) {
                var requestType = 'POST';
                self.favorites(self.favorites() + 1);
            } else if (self.isFavorited() === true) {
                var requestType = 'DELETE';
                self.favorites(self.favorites() - 1);
            }

            self.isFavorited(!self.isFavorited());

            $.ajax('/missioncontrol/objects/' + object_id + '/favorite', {
                type: requestType,
                success: function(response) {
                }
            });
        };

        self.download = function() {

        };
    };

    return ObjectViewModel;
});
