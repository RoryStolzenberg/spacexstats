(function() {
	var app = angular.module('app');

	app.directive('search', ['searchService', 'conversionService', "$http", function(searchService, conversionService, $http) {
		return {
			restrict: 'E',
            transclude: true,
			link: function($scope, element, attributes) {
                $scope.currentSearch = searchService;

                $scope.brokerFilters = {
                    mission:    null,
                    type:       null,
                    before:     null,
                    after:      null,
                    year:       null,
                    uploadedBy: null,
                    favorited:  null,
                    noted:      null,
                    downloaded: null,
                }

                // Update the filters from the search
                $scope.onSearchKeyPress = function(event) {
                    conversionService.searchesToFilters($scope.currentSearch.toQuery.filters, $scope.brokerFilters);
                }

                // Update the search from the filters
                $scope.$watch('brokerFilters', function() {
                    conversionService.filtersToSearches($scope.currentSearch.toQuery.filters, $scope.brokerFilters);
                }, true);
			},
			templateUrl: '/js/templates/search.html'
		}
	}]);

    app.service('conversionService', ['searchData', function(searchData) {
        this.searchesToFilters = function(searchFilters, brokerFilters) {
            var filters = Object.keys(searchFilters);

            filters.forEach(function(filter) {

            });
        }

        this.filtersToSearches = function(searchFilters, brokerFilters) {
            var filters = Object.keys(searchFilters);
        }
    }]);

    /**
     *  Eventually we could cache the outputs of the searchTerm and filters to make sure we don't re-regex
     *  things we don't have to?
     */
    app.service('searchService', ["$scope", function($scope) {
        return function() {

            this.rawQuery = null;

            this.searchTerm = function() {
                return this.rawQuery.replace(this.regex.tags, "").(this.regex.other, "");
            };

            this.filters = {
                tags: function() {
                    var match;
                    var tags = [];

                    while (match = this.regex.tags.exec(this.rawQuery)) {
                        tags.push(match[1]);
                    }

                    return tags;
                },
                mission: function() {
                    return this.regex.other.mission.exec(this.rawQuery)[0];
                },
                type: function() {
                    return this.regex.other.type.exec(this.rawQuery)[0];
                },
                before: function() {
                    return this.regex.other.before.exec(this.rawQuery)[0];
                },
                after: function() {
                    return this.regex.other.after.exec(this.rawQuery)[0];
                },
                year: function() {
                    return this.regex.other.year.exec(this.rawQuery)[0];
                },
                uploadedBy: function() {
                    return this.regex.other.uploadedBy.exec(this.rawQuery)[0];
                },
                favorited: function() {
                    return this.regex.other.favorited.exec(this.rawQuery)[0];
                },
                noted: function() {
                    return this.regex.other.noted.exec(this.rawQuery)[0];
                },
                downloaded: function() {
                    return this.regex.other.downloaded.exec(this.rawQuery)[0];
                }
            };

            this.toQuery = function() {
                return {
                    searchTerm: this.searchTerm(),
                    filters: {
                        tags:       this.filters.tags(),
                        mission:    this.filters.mission(),
                        type:       this.filters.type(),
                        before:     this.filters.before(),
                        after:      this.filters.after(),
                        year:       this.filters.year(),
                        uploadedBy: this.filters.uploadedBy(),
                        favorited:  this.filters.favorited(),
                        noted:      this.filters.noted(),
                        downloaded: this.filters.downloaded()
                    }
                }
            };

            this.regex = {
                tags: /\[([^)]+?)\]/gi, // https://regex101.com/r/uL9jN5/1
                // https://regex101.com/r/iT2zH5/2
                mission: /mission:(?:([a-zA-Z0-9_-]+)|"([a-zA-Z0-9_ -]+)")/i,
                type: /type:(?:([a-zA-Z0-9_-]+)|"([a-zA-Z0-9_ -]+)")/i,
                before: /before:([0-9-]+)/i,
                after: /after:([0-9-]+)/i,
                year: /year:([0-9]{4})/i,
                uploadedBy: /uploaded-by:([a-zA-Z0-9_-]+)/i,
                favorited: /favorited:(true|false|yes|no|y|n|1|0)/i,
                noted: /noted:(true|false|yes|no|y|n|1|0)/i,
                downloaded: /downloaded:(true|false|yes|no|y|n|1|0)/i,
            };
        };
    }]);

    app.value('searchData', {
        missions: laravel.missions,
        types: laravel.types
    });
})();