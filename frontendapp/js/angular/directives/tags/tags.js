angular.module("directives.tags", []).directive("tags", ["Tag", function(Tag) {
    return {
        restrict: 'E',
        scope: {
            availableTags: '=',
            selectedTags: '='
        },
        link: function($scope, element, attributes) {

            $scope.suggestions = [];

            $scope.createTag = function(createdTag) {
                console.log(createdTag);
                var tagIsPresentInCurrentTags = $scope.selectedTags.filter(function(tag) {
                    return tag.name == createdTag;
                });

                if (createdTag.length > 0 && tagIsPresentInCurrentTags.length === 0) {

                    // check if tag is present in the available tags array
                    var tagIsPresentInAvailableTags = $scope.availableTags.filter(function(tag) {
                        return tag.name == createdTag;
                    });

                    if (tagIsPresentInAvailableTags.length === 1) {
                        // grab tag
                        var newTag = tagIsPresentInAvailableTags[0];
                    } else {
                        // trim and convert the text to lowercase, then create!
                        var newTag = new Tag({ id: null, name: $.trim(createdTag.toLowerCase()), description: null });
                    }

                    $scope.selectedTags.push(newTag);

                    // reset the input field
                    $scope.tagInput = "";
                }
                return true;
            };


            $scope.removeTag = function(removedTag) {
                $scope.selectedTags.splice($scope.selectedTags.indexOf(removedTag), 1);
                // give focus to form
            };

            $scope.tagInputKeyPress = function(event) {
                // Currently using jQuery.event.which to detect keypresses, keyCode is deprecated, use KeyboardEvent.key eventually:
                // https://developer.mozilla.org/en-US/docs/Web/API/KeyboardEvent/key

                // event.key == ' ' || event.key == 'Enter'
                if (event.which == 32 || event.which == 13) {
                    event.preventDefault();

                    // Remove any rulebreaking chars
                    var tag = $scope.tagInput;
                    tag = tag.replace(/["']/g, "");
                    // Remove whitespace if present
                    tag = tag.trim();

                    $scope.createTag(tag);

                // event.key == 'Backspace'
                } else if (event.which == 8 && $scope.tagInput == "") {
                    event.preventDefault();

                    // grab the last tag to be inserted (if any) and put it back in the input
                    if ($scope.selectedTags.length > 0) {
                        $scope.tagInput = $scope.selectedTags.pop().name;
                    }
                }
                return true;
            };

            $scope.areSuggestionsVisible = false;
            $scope.toggleSuggestionVisibility = function() {
                $scope.areSuggestionsVisible = !$scope.areSuggestionsVisible;
            };

            $scope.updateSuggestionList = function() {
                var search = new RegExp($scope.tagInput, "i");

                $scope.suggestions = $scope.availableTags.filter(function(availableTag) {
                    if ($scope.selectedTags.filter(function(currentTag) {
                            return availableTag.name == currentTag.name;
                        }).length == 0) {
                        return search.test(availableTag.name);
                    }
                    return false;
                }).slice(0,6);
            };

            $scope.$watch("selectedTags", function() {
                $scope.inputLength = {
                    width: $(element).find('input.tag-input').parent().innerWidth() - $(element).find('input.tag-input').siblings().outerWidth(true) - 1 + "px"
                };
                console.log($scope.inputLength);
            }, true);
        },
        templateUrl: '/js/templates/tags.html'
    }
}]).factory("Tag", function() {
    return function(tag) {
        var self = tag;
        return self;
    }
});

