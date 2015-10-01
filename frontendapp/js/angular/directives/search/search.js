(function() {
	var app = angular.module('app');

	app.directive('search', ['constraintsReader', "$http", function(constraintsReader, $http) {
		return {
			restrict: 'E',
			scope: {
			},
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

                console.log(laravel.missions);
                console.log($scope.data.missions);

				$scope.onSearchKeyPress = function(event) {
					$scope.currentSearch = constraintsReader.fromSearch($scope.rawSearchTerm)
				}

                $scope.search = function() {
                    var encodedQuery = encodeURIComponent(currentSearch.searchTerm);
                    $http.get('/missioncontrol/search?q=' + encodedQuery)
                }
			},
			templateUrl: '/js/templates/search.html'
		}
	}]);

    app.service('constraintsReader', ['Constraint', 'kebabToCamelCase', function(Constaint, kebabToCamelCase) {
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
			var rawConstraint;
			var rawConstraintsArray = [];
			var touchedConstraintsArray = [];

			// Pull out all the raw constraints 
			do {
			    rawConstraint = re.exec(rawSearchTerm);
			    if (rawConstraint) {
			        rawConstraintsArray.push(new Constraint(rawConstraint));
			        touchedConstraintsArray.push(kebabToCamelCase.convert(rawConstraint[1]));
			    }
			} while (rawConstraint);

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

		this.fromConstraints = function() {

		}

	}]);

    app.factory('Constraint', ['kebabToCamelCase', function(kebabToCamelCase) {
		// Holds a Constraint object which consists of a property and a value
		return function(constraint) {

			var self = this;

			self.property = kebabToCamelCase.convert(constraint[1]);
			self.value = typeof constraint[2] !== 'undefined' ? constraint[2] : constraint[3];

			return self;
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