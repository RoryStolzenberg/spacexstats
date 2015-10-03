(function() {
	var app = angular.module('app');

	app.directive('search', ['constraintsReader', "$http", function(constraintsReader, $http) {
		return {
			restrict: 'E',
            transclude: true,
			link: function($scope, element, attributes) {

				$scope.stagingConstraints = {
					mission: null,
					type: null,
					before: null,
					after: null,
					year: null,
					uploadedBy: null,
					favorited: null,
					noted: null,
					downloaded: null
				}

				$scope.data = {
					missions: laravel.missions,
					types: null,
                    tags: laravel.tags
				}

                $scope.onSearchKeyPress = function(event) {
                    $scope.currentSearch = constraintsReader.fromSearch($scope.rawSearchTerm)
                }
			},
			templateUrl: '/js/templates/search.html'
		}
	}]);

    app.service('constraintsReader', ['kebabToCamelCase', function(kebabToCamelCase) {
		this.fromSearch = function(rawSearchTerm) {

			var currentSearch = {
				searchTerm: null,
				tags: {
					tags: []
				},
				constraints: {
					mission: null,
					type: null,
					before: null,
					after: null,
					year: null,
					uploadedBy: null,
					favorited: null,
					noted: null,
					downloaded: null
				}
			};

			// parse out tags https://regex101.com/r/uL9jN5/1
			//currentSearch.tags.tags = /\[([^)]+?)\]/gi.exec(rawSearchTerm);
            var re = /\[([^)]+?)\]/gi;
            while (match = re.exec(rawSearchTerm)) {
                currentSearch.tags.tags.push(match[1]);
            }
            rawSearchTerm = rawSearchTerm.replace(re, "");

			// constraints https://regex101.com/r/iT2zH5/2
			var re = /([a-z-]+):(?:([a-zA-Z0-9_-]+)|"([a-zA-Z0-9_ -]+)")/gi;
			var constraint;
			var rawConstraintsArray = [];
			var touchedConstraintsArray = [];

			// Pull out all the raw constraints 
			do {
			    constraint = re.exec(rawSearchTerm);
			    if (constraint) {
			        rawConstraintsArray.push(typeof constraint[2] !== 'undefined' ? constraint[2] : constraint[3]);
			        touchedConstraintsArray.push(kebabToCamelCase.convert(constraint[1]));
			    }
			} while (constraint);
            rawSearchTerm = rawSearchTerm.replace(re, "");

			// reset the constraints present in the current search
			for (var propertyName in currentSearch.constraints) {

				// If the constraint exists
				if (touchedConstraintsArray.indexOf(propertyName) !== -1) {
					var index = touchedConstraintsArray.indexOf(propertyName);
					currentSearch.constraints[propertyName] = rawConstraintsArray[index];
				}
			}

            // Send the search term through
            currentSearch.searchTerm = rawSearchTerm;
			return currentSearch;
		}
	}]);

    app.service('kebabToCamelCase', function() {
		// Converts a search-constraint into a searchConstraint
		this.convert = function(string) {

			for(var i = 0; i < string.length; i++) {

				if (string[i] === "-") {
					string = string.replace(string.substr(i, 1), "");
					string = string.substring(0, i) + string.charAt(i).toUpperCase() + string.substring(i+1, string.length);
				}
			}
			return string;
		};

	});
})();