var questionViewModel = function() {
	var self = this;

	self.allQuestions = ko.observableArray();

	self.searchTerm = ko.observable();
	self.searchTerm.subscribe(function() {
		self.getQuestions(self.searchTerm());
	});

	self.currentQuestions = ko.observableArray();
	self.lockedQuestion = ko.observable("");

	self.questionComparer = function(a,b) {
		return b.occurrences - a.occurrences;
	}

	self.retrieveLockedQuestion = function(optionalSlug) {
		if (optionalSlug) {
			window.location.hash = optionalSlug;
		}
		if (window.location.hash) {
			questionSlug = window.location.hash.substring(1);
			var retrievedQuestion = $.grep(self.allQuestions(), function(question) {
				return question.slug == questionSlug;
			});
			self.currentQuestions.push(retrievedQuestion[0]);
			self.lockedQuestion(retrievedQuestion[0]);
		}
		return false;
	};

	self.getQuestions = function(searchTerm) {
		self.currentQuestions.removeAll();
		window.location.hash = "";
		// Split on a string to get keywords
		var searchWords = searchTerm.split(" ");
		// If the overall search term isn't blank
		if (searchTerm !== "") {
			var allResults = [];
			var results;
			// Foreach searchwords as searchword, look for matches in all questions
			$.each(searchWords, function(index, searchWord) {
				if (searchWord !== "") {
					var search = new RegExp(searchWord, "i");				
					results = $.grep(self.allQuestions(), function(question) {
						return search.test(question.title);
					});
					// Create an array containing all results, including duplicates
					allResults = allResults.concat(results);				
				}
			});
			// For all of the results, remove duplicates and assign a score
			$.each(allResults, function(index, result) {
				var resultIndexValue = self.currentQuestions().indexOf(result);
				if (resultIndexValue !== -1) {
					self.currentQuestions()[resultIndexValue].occurrences++;
				} else {
					result.occurrences = 1;
					self.currentQuestions.push(result);
				}
			});
			self.currentQuestions.sort(self.questionComparer);
		}
	};

	self.lockQuestion = function(questionToBeLocked) {
		self.lockedQuestion(questionToBeLocked);
		window.location.hash = questionToBeLocked.slug;
	}

	self.clearLockedQuestion = function() {
		self.lockedQuestion("");
	}

	// Grab all questions from the DB
    self.init = (function() {
        $.ajax('/faq/getquestions', {
            dataType : 'json',
            type: 'POST',
            success : function(questions) {
                $.each(questions, function(index, question) {
                    self.allQuestions.push(question);
                });
                self.retrieveLockedQuestion();
            }
        });
    })();
};