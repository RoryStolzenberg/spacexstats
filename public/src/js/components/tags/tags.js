define(['knockout', 'jquery', 'text!components/tags/tags.html'], function(ko, $, htmlString) {
    function TagViewModel(params) {
        ko.bindingHandlers.resize = {
            update: function(element, valueAccessor, allBindings, viewModel, bindingContext) {
                // Register dependencies
                self.tags();

                if (ko.unwrap(valueAccessor()) === true) {
                    var elementWidth = $(element).parent().width() - $(element).siblings().outerWidth() - 1; // Why minus one? Who knows.
                    $(element).css({ 'width': elementWidth });
                }
            }
        };

        var self = this;

        self.availableTags = ['elon-musk', 'falcon-9', 'reusability', 'raptor', 'merlin', 'crs', 'commercial-resupply-services', 'gwynne-shotwell', 'dragon'];

        self.tags = ko.observableArray();
        self.tagInput = ko.observable();
        self.tagsToBeSubmitted = ko.computed(function() {
            return self.tags().join(' ');
        });

        self.suggestions = ko.observableArray();
        self.suggestionVisibility = ko.observable(false);
        self.toggleSuggestionVisibility = function(data, event) {
            self.suggestionVisibility(!self.suggestionVisibility());
            return true;
        };

        self.testFunction = function() {
            console.log('woohoo');
        }

        self.removeTag = function(data) {
            self.tags.remove(data);
        };

        self.createTag = function(tag) {
            if (self.tags().indexOf(tag) == -1 && tag.length > 0) {
                // trim and convert the text to lowercase
                tagText = $.trim(tag.toLowerCase());
                self.tags.push(tagText);
                self.tagInput("");
            }
            return true;
        };

        self.suggestionMousedown = function(tag) {
            self.createTag(tag);
            self.updateSuggestionList();
        };

        self.tagInputKeyPress = function(data, event) {
            if (event.key == ' ' || event.key == 'Enter') {
                event.preventDefault();

                // Remove any rulebreaking chars
                var tag = self.tagInput();
                tag = tag.replace(/["']/g, "");
                // Remove whitespace if present
                tag = tag.trim();

                self.createTag(tag);

            } else if (event.key == 'Backspace' && self.tagInput() == "") {
                event.preventDefault();

                // grab the last tag to be inserted (if any) and put it back in the input
                self.tagInput(self.tags.pop());
            }
            return true;
        };

        self.updateSuggestionList = function() {
            var allResults = [];
            var search = new RegExp(self.tagInput(), "i");
            allResults = $.grep(self.availableTags, function(tag) {
                // If the possible tag is not present in the currentTags array, allow it as an option
                // otherwise, just return false. No need to show duplicate tags.
                if (self.tags().indexOf(tag) == -1) {
                    return search.test(tag);
                } else {
                    return false;
                }

            }).slice(0,6);

            // Clear any current elements
            self.suggestions.removeAll();

            $.each(allResults, function(index, suggestion) {
                self.suggestions.push(suggestion);
            });
        };

        self.init = (function() {
            var tagArray = params.tags.split(" ");
            for (i = 0; i < tagArray.length; i++) {
                self.tags.push(tagArray[i]);
            }
        })();
    }

    return { viewModel: TagViewModel, template: htmlString };
});