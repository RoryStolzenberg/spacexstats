(function($) {
	$.fn.suggest = function(options) {
		return this.each(function() {
			// Provide an accessor to the bound element
			var self = $(this);

			var containerElement,
				wrapperElement,
				submissionElement, // this
				tagsElement,
				inputElement,
				suggestionElement;

			var currentTags = new Array();

			var availableTags = ['elon-musk', 'falcon-9', 'reusability', 'raptor', 'merlin', 'crs', 'commercial-resupply-services', 'gwynne-shotwell', 'dragon'];

			$.fn.suggest.defaults = {
				maxSuggestions: 6
			}

			var opts = $.extend({}, $.fn.suggest.defaults, options);

			// Create a new tag when asked
			var createNewTag = function(tag) {
				if (currentTags.indexOf(tag) == -1) {
					// trim and convert the text to lowercase
					tagText = $.trim(tag.toLowerCase());

					tagsElement.append('<div>'+ tagText +'<span class="remove"></span></div>');
					currentTags.push(tagText);
					inputElement.val("");

					// Add it to the hidden submission element if it isn't already present
					self.attr('value', function(index, value) {
						if (value.indexOf(tag) == -1) {
							if (currentTags.length == 1) {
								return tag;
							} else {
								return value + " " + tag;
							}
						} else {
							return value;
						}
					});
					//console.log(currentTags);
					containerElement.trigger('tag:added');
				}
			}

			var removeTagFromTagArray = function(tag) {
				if (currentTags.indexOf(tag) > -1) {
					currentTags.splice(currentTags.indexOf(tag), 1);
					tagsElement.children().filter(function() {
						return $(this).text() === tag;
					}).remove();

					var oldTagsInSubmissionElement = submissionElement.attr('value').split(" ");
					var newTagsInSubmissionElement = "";
					$.each(oldTagsInSubmissionElement, function(index, tagInElement) {
						if (tagInElement != tag) {
							newTagsInSubmissionElement += tagInElement;
							if (index != (oldTagsInSubmissionElement.length - 1)) {
								newTagsInSubmissionElement += " ";
							}
						}
					});
					submissionElement.attr('value', newTagsInSubmissionElement);
					//console.log(currentTags);
					containerElement.trigger('tag:removed');
				}
			}

			var updateSuggestionList = function(currentInput) {
				var results = getTags(currentInput);
				// Clear any current elements
				suggestionElement.empty();
				$.each(results, function(index, result) {
					suggestionElement.append('<div class="suggestion" value="'+ result +'">'+ result +'</div>');
				});
			}

			var getTags = function(searchTerm) {
				var allResults = [];
				var search = new RegExp(searchTerm, "i");
				allResults = $.grep(availableTags, function(tag) {
					// If the possible tag is not present in the currentTags array, allow it as an option
					// otherwise, just return false. No need to show duplicate tags.
					if (currentTags.indexOf(tag) == -1) {
						return search.test(tag);
					} else {
						return false;
					}

				});
				return allResults.slice(0, opts.maxSuggestions);
			}

			function actions() {
				// Event handler for text being typed
				inputElement.on('keypress', function(e) {
					// If the key pressed is a space or the enter key.
					if (e.key == ' ' || e.key == 'Enter') {
						e.preventDefault();

						// Remove any rulebreaking chars
						var tag = inputElement.val();
						tag = tag.replace(/["']/g, "");
						// Remove whitespace if present
						tag = tag.trim();

						// Check if tag already exists and the length of the tag is greater than 0
						if (currentTags.indexOf(tag) == -1 && tag.length > 0) {
							createNewTag(tag);
						} else {
							// error, tag exists!
						}
					// if the backspace key was pressed while the input was empty
					} else if (e.key == 'Backspace' && inputElement.val() == "") {
						e.preventDefault();

						// grab the last tag to be inserted (if any) and put it back in the input
						lastTagToBeAdded = currentTags[currentTags.length-1];
						inputElement.val(lastTagToBeAdded);
						removeTagFromTagArray(lastTagToBeAdded);
					}
				});

				inputElement.on('keyup', function(e) {
					updateSuggestionList(inputElement.val());
				});

				containerElement.on('click', '.remove', function(e) {
					removeTagFromTagArray($(e.target).parent().text());
				});

				// When the input element is focused, show the tag suggestions
				containerElement.on('focusin', inputElement, function(e) {
					updateSuggestionList(inputElement.val());
					suggestionElement.show();
				});

				// When focus is lost to the input element, hide the tag suggestions
				containerElement.on('focusout', inputElement, function(e) {
					suggestionElement.hide();
				});

				containerElement.on('mousedown', '.suggestion', function(e) {
					createNewTag($(this).attr('value'));
					setTimeout(function(){
					   inputElement.focus();
					});
				});

				containerElement.on('tag:added tag:removed', function() {
					var inputElementWidth = wrapperElement.width() - tagsElement.outerWidth() - 1; // Why minus one? Who knows.
					inputElement.css({'width': inputElementWidth});
				});

				$(window).on('resize', function() {
					console.log('yep');
					var inputElementWidth = wrapperElement.width() - tagsElement.outerWidth() - 1; // Why minus one? Who knows.
					inputElement.css({'width': inputElementWidth});
				});
			}

			// init
			(function() {

				// Define the hidden submission element where tags are appended to as the element where this
				// jQuery plugin function was attached to.
				submissionElement = self;
				submissionElement.css({
					'display':'none'
				});

				// Create the container element for the entire tagging system
				self.wrap('<div class="tagger-container"></div>');
				containerElement = self.parent();

				// Create the wrapper to hold the visible tags + dynamic input
				containerElement.append('<div class="wrapper"></div>');
				wrapperElement = containerElement.children('.wrapper');
				wrapperElement.css({
					'font-size':'0'
				});

				// Create the visible input inside the wrapper
				wrapperElement.append('<input type="text" class="tag-input" />');
				inputElement = wrapperElement.children('input');
				inputElement.css({
					'display': 'inline-block'
				});

				// Create the visible listing of tags inside the wrapper
				wrapperElement.prepend('<div class="tags"></div>');
				tagsElement = wrapperElement.children('.tags');
				tagsElement.css({
					'display':'inline-block',
					'font-size':'12px'
				});

				// Create the element which holds the suggestions for the inputs
				containerElement.append('<div class="suggestions"></div>');
				suggestionElement = containerElement.children('.suggestions');
				suggestionElement.hide();

				actions();

				// Once all the elements are setup, check to see if there's any default values in the input that we need to include
				if (self.val().length > 0) {
					var defaultTags = self.val().split(" ");
					$.each(defaultTags, function(index, defaultTag) {
						createNewTag(defaultTag);
					});
				}
			}());

		});
	}
}(jQuery));