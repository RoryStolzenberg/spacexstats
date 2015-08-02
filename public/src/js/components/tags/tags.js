define(['knockout', 'jquery', 'ko.mapping', 'text!components/tags/tags.html'], function(ko, $, koMapping, htmlString) {
    function TagViewModel(params) {

        ko.bindingHandlers.resize = {
            update: function(element, valueAccessor) {
                ko.unwrap(valueAccessor());
                var elementWidth = $(element).parent().innerWidth() - $(element).siblings().outerWidth() - 1; // Why minus one? Who knows.
                $(element).css({ 'width' : elementWidth});
            }
        };

        var self = this;

        $(window).on('resize', function() {
            self.setDimensions();
        });

        self.setDimensions = function(data, event) {
            var cur = $(event.delegateTarget);
            var elementWidth = cur.children('.wrapper').innerWidth() - cur.find('.tag-input').siblings().outerWidth() - 1; // Why minus one? Who knows.
            cur.find('.tag-input').css({ 'width' : elementWidth});
        }

        function Tag(tag) {
            var self = this;
            self.tag_id = ko.observable(tag.tag_id);
            self.name = ko.observable(tag.name);
            self.description = ko.observable(tag.description);
        }

        self.availableTags = ko.observableArray();

        self.tags = ko.computed(function() {
            return params.tags();
        });
        self.tagInput = ko.observable();

        self.suggestions = ko.observableArray();
        self.suggestionVisibility = ko.observable(false);
        self.toggleSuggestionVisibility = function(data, event) {
            self.suggestionVisibility(!self.suggestionVisibility());
            return true;
        };

        self.inputHasFocus = ko.observable();

        self.removeTag = function(data) {
            params.tags.remove(data);
            self.inputHasFocus(true);
        };

        self.createTag = function(tagText) {
            var tagIsPresentInCurrentTags = params.tags().filter(function(tag) {
                return tag.name() == tagText;
            });

            if (tagText.length > 0 && tagIsPresentInCurrentTags.length === 0) {

                // check if tag is present in the available tags array
                var tagIsPresentInAvailableTags = self.availableTags().filter(function(tag) {
                    return tag.name() == tagText;
                });

                if (tagIsPresentInAvailableTags.length === 1) {
                    // grab tag
                    var newTag = tagIsPresentInAvailableTags[0];
                } else {
                    // trim and convert the text to lowercase, then create!
                    var newTag = new Tag({ id: null, name: $.trim(tagText.toLowerCase()), description: null });
                }

                params.tags.push(newTag);

                // reset the input field
                self.tagInput("");
            }
            return true;
        };

        self.suggestionMousedown = function(tag) {
            self.createTag(tag.name());
            self.updateSuggestionList();
        };

        self.tagInputKeyPress = function(data, event) {
            // Currently using jQuery.event.which to detect keypresses, keyCode is deprecated, use KeyboardEvent.key eventually:
            // https://developer.mozilla.org/en-US/docs/Web/API/KeyboardEvent/key

            // event.key == ' ' || event.key == 'Enter'
            if (event.which == 32 || event.which == 13) {
                event.preventDefault();

                // Remove any rulebreaking chars
                var tag = self.tagInput();
                tag = tag.replace(/["']/g, "");
                // Remove whitespace if present
                tag = tag.trim();

                self.createTag(tag);

            // event.key == 'Backspace'
            } else if (event.which == 8 && self.tagInput() == "") {
                event.preventDefault();

                // grab the last tag to be inserted (if any) and put it back in the input
                if (params.tags().length > 0) {
                    self.tagInput(params.tags.pop().name());
                }
            }
            return true;
        };

        self.updateSuggestionList = function() {
            var allResults = [];
            var search = new RegExp(self.tagInput(), "i");

            allResults = self.availableTags().filter(function(availableTag) {
                if (params.tags().filter(function(currentTag) {
                    return availableTag.name() == currentTag.name();
                }).length == 0) {
                    return search.test(availableTag.name());
                }
                return false;
            }).slice(0,6);

            self.suggestions(allResults);
        };

        // Fetch the available tags to use
        self.init = (function() {
            koMapping.fromJS(laravel.tags, {
                create: function(options) {
                    return new Tag(options.data);
                }
            }, self.availableTags);
        })();
    }

    return { viewModel: TagViewModel, template: htmlString };
});