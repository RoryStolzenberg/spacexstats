(function() {
	var app = angular.module('app');

	app.directive('search', ['filtersReader', "$http", function(filtersReader, $http) {
		return {
			restrict: 'E',
            transclude: true,
			link: function($scope, element, attributes) {

                $scope.currentSearch = {

                };

				$scope.stagingFilters = {
                    tags: [],
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
                    $scope.currentSearch = filtersReader.fromSearch($scope.currentSearch, $scope.rawSearchTerm);
                }

                $scope.$watch('stagingConstraints', function(stagingFilters) {
                    $scope.currentSearch = filtersReader.fromFilters($scope.currentSearch, $scope.stagingFilters);
                }, true);
			},
			templateUrl: '/js/templates/search.html'
		}
	}]);

    app.service('filtersReader', ['kebabToCamelCase', function(kebabToCamelCase) {
		this.fromSearch = function(currentSearch, rawSearchTerm) {

			// parse out tags https://regex101.com/r/uL9jN5/1
            var match;
            while (match = .exec(rawSearchTerm)) {
                currentSearch.filters.tags.push(match[1]);
            }
            rawSearchTerm = rawSearchTerm;

			// other filters https://regex101.com/r/iT2zH5/2
			var filter;
			var rawFiltersArray = [];
			var touchedFiltersArray = [];

			// Pull out all the raw filters
			do {
                filter = .exec(rawSearchTerm);
			    if (filter) {
			        rawFiltersArray.push(typeof filter[2] !== 'undefined' ? filter[2] : filter[3]);
			        touchedFiltersArray.push(kebabToCamelCase.convert(filter[1]));
			    }
			} while (filter);
            rawSearchTerm = rawSearchTerm.replace(re, "");

			// reset the filters present in the current search
			for (var propertyName in currentSearch.filters) {

				// If the constraint exists
				if (touchedFiltersArray.indexOf(propertyName) !== -1) {
					var index = touchedFiltersArray.indexOf(propertyName);
					currentSearch.filters[propertyName] = rawFiltersArray[index];
				}
			}

            // Now update the values on the filter options
            for (var)


            // Send the search term through
            currentSearch.searchTerm = rawSearchTerm;
			return currentSearch;
		}

        this.fromFilters = function(currentSearch, stagingFilters) {
            stagingFilters.forEach(function(stagingFilter) {

            });
        }
	}]);

    app.service('kebabToCamelCase', function() {
		// Converts a search-filter into a searchFilter
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

    /**
     *  Eventually we could cache the outputs of the searchTerm and filters to make sure we don't re-regex
     *  things we don't have to?
     */
    app.factory('Search', function() {
        return function() {

            this.rawQuery = null;

            this.searchTerm = function() {
                return this.rawQuery.replace(this.regex.tags, "").(this.regex.other, "");
            };

            this.filters = {
                tags: null,
                mission: null,
                type: null,
                before: null,
                after: null,
                year: null,
                uploadedBy: null,
                favorited: null,
                noted: null,
                downloaded: null
            };

            this.toQuery = function() {
                return {
                    searchTerm: this.searchTerm(),
                    filters: {
                        tags: this.filters.tags(),
                        mission: this.filters.mission(),
                        type: this.filters.tags(),
                        before: this.filters.tags(),
                        after: this.filters.tags(),
                        year: this.filters.tags(),
                        uploadedBy: this.filters.tags(),
                        favorited: this.filters.tags(),
                        noted: this.filters.tags(),
                        downloaded: this.filters.tags()
                    }
                }
            };

            this.regex = {
                tags: /\[([^)]+?)\]/gi,
                other: /([a-z-]+):(?:([a-zA-Z0-9_-]+)|"([a-zA-Z0-9_ -]+)")/gi
            };
        };
    });
})();