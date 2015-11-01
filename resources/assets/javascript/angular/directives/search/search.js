(function() {
	var app = angular.module('app', ['720kb.datepicker']);

	app.directive('search', ['searchService', 'conversionService', "$http", "$filter", function(searchService, conversionService, $http, $filter) {
		return {
			restrict: 'E',
            transclude: true,
			link: function($scope, element, attributes) {

                $scope.data = {
                    missions: [],
                    types: []
                };

                $scope.currentSearch = searchService;

                $scope.brokerFilters = {
                    mission:    null,
                    type:       null,
                    before:     null,
                    after:      null,
                    favorited:  null,
                    noted:      null,
                    downloaded: null
                };

                // Update the filters from the search
                $scope.onSearchKeyPress = function() {
                    conversionService.searchesToFilters($scope.brokerFilters, $scope.currentSearch, $scope.data);
                };

                $scope.onFilterUpdate = function(filterType) {
                    conversionService.filtersToSearches($scope.brokerFilters, $scope.currentSearch, filterType);
                };

                (function() {
                    $http.get('/missioncontrol/search/fetch').then(function(response) {
                        $scope.data = {
                            missions: response.data.missions,
                            types: response.data.types
                        }
                    });
                })();

                $scope.datepickerText = function() {
                    if ($scope.brokerFilters.before === null && $scope.brokerFilters.after === null) {
                        return "Any time";
                    } else if ($scope.brokerFilters.before !== null && $scope.brokerFilters.after === null) {
                        return "Before " + $filter('date')($scope.brokerFilters.before, "MMM d, yyyy");
                    } else if ($scope.brokerFilters.before === null && $scope.brokerFilters.after !== null) {
                        return "After " + $filter('date')($scope.brokerFilters.after, "MMM d, yyyy");
                    } else {
                        return "Between " + $filter('date')($scope.brokerFilters.after, "MMM d, yyyy") + " - " + $filter('date')($scope.brokerFilters.before, "MMM d, yyyy");
                    }
                };
			},
			templateUrl: '/js/templates/search.html'
		}
	}]);

    app.service('conversionService', function() {
        this.searchesToFilters = function(brokerFilters, search, data) {
            var missionResult = search.filters().mission();
            if (missionResult != null) {
                var mission = data.missions.filter(function(mission) {
                    return mission.name == missionResult;
                });

                if (mission !== null) {
                    brokerFilters.mission = mission[0];
                } else {
                    brokerFilters.mission = null;
                }
            } else {
                brokerFilters.mission = null;
            }

            brokerFilters.favorited = search.filters().favorited() != null;
            brokerFilters.noted = search.filters().noted() != null;
            brokerFilters.downloaded = search.filters().downloaded() != null;

        };

        this.filtersToSearches = function(brokerFilters, search, filterType) {
            if (filterType === 'mission') {
                if (brokerFilters.mission === null) {
                    search.rawQuery = search.rawQuery.replace(search.regex.mission, '');
                } else {
                    if (search.filters().mission() === null) {
                        if (/\s/.test(brokerFilters.mission.name)) {
                            search.rawQuery = search.rawQuery.concat('mission:"' + brokerFilters.mission.name + '"');
                        } else {
                            search.rawQuery = search.rawQuery.concat('mission:' + brokerFilters.mission.name);
                        }
                    } else {
                        if (/\s/.test(brokerFilters.mission.name)) {
                            search.rawQuery = search.rawQuery.replace(search.regex.mission, 'mission:"' + brokerFilters.mission.name + '"');
                        } else {
                            search.rawQuery = search.rawQuery.replace(search.regex.mission, 'mission:' + brokerFilters.mission.name);
                        }
                    }
                }
            }

            else if (filterType == 'type') {

            }

            else if (filterType == 'before') {

            }

            else if (filterType == 'after') {

            }

            else if (filterType === 'favorited') {
                if (search.filters().favorited() === null) {
                    search.rawQuery = search.rawQuery.concat('favorited:true');
                } else {
                    search.rawQuery = search.rawQuery.replace(search.regex.favorited, '');
                }
            }

            else if (filterType === 'noted') {
                if (search.filters().noted() === null) {
                    search.rawQuery = search.rawQuery.concat('noted:true');
                } else {
                    search.rawQuery = search.rawQuery.replace(search.regex.noted, '');
                }
            }

            else if (filterType === 'downloaded') {
                if (search.filters().downloaded() === null) {
                    search.rawQuery = search.rawQuery.concat('downloaded:true');
                } else {
                    search.rawQuery = search.rawQuery.replace(search.regex.downloaded, '');
                }
            }
        };
    });

    /**
     *  Eventually we could cache the outputs of the searchTerm and filters to make sure we don't re-regex
     *  things we don't have to?
     */
    app.service('searchService', function() {
        var self = this;

        self.rawQuery = "";

        self.searchTerm = function () {
            return self.rawQuery.replace(self.regex.tags, "").replace(self.regex.all, "");
        };

        // https://regex101.com/r/uL9jN5/1
        // https://regex101.com/r/iT2zH5/2
        self.filters = function() {
            return {
                tags: function () {
                    var match;
                    var tags = [];

                    while (match = self.regex.tags.exec(self.rawQuery)) {
                        tags.push(match[1]);
                    }
                    return tags;
                },
                mission: function () {
                    var missionResult = self.regex.mission.exec(self.rawQuery);
                    return missionResult !== null ? (!angular.isUndefined(missionResult[1]) ? missionResult[1] : missionResult[2]) : null;
                },
                type: function () {
                    var typeResult = self.regex.type.exec(self.rawQuery);
                    return typeResult !== null ? (!angular.isUndefined(typeResult[1]) ? typeResult[1] : typeResult[2]) : null;
                },
                before: function () {
                    return self.regex.before.exec(self.rawQuery)[0];
                },
                after: function () {
                    return self.regex.after.exec(self.rawQuery)[0];
                },
                year: function () {
                    var yearResult = self.regex.year.exec(self.rawQuery);
                    return yearResult !== null ? yearResult[1] : null;
                },
                user: function () {
                    var userResult = self.regex.user.exec(self.rawQuery);
                    return userResult !== null ? userResult[1] : null;
                },
                favorited: function () {
                    var favoritedResult = self.regex.favorited.exec(self.rawQuery);
                    return favoritedResult !== null ? favoritedResult[0] : null;
                },
                noted: function () {
                    var notedResult = self.regex.noted.exec(self.rawQuery);
                    return notedResult !== null ? notedResult[0] : null;
                },
                downloaded: function () {
                    var downloadedResult = self.regex.downloaded.exec(self.rawQuery);
                    return downloadedResult !== null ? downloadedResult[0] : null;
                }
            }
        };

        self.toQuery = function() {
            return {
                searchTerm: self.searchTerm(),
                filters: {
                    tags: self.filters.tags(),
                    mission: self.filters.mission(),
                    type: self.filters.type(),
                    before: self.filters.before(),
                    after: self.filters.after(),
                    year: self.filters.year(),
                    user: self.filters.user(),
                    favorited: self.filters.favorited(),
                    noted: self.filters.noted(),
                    downloaded: self.filters.downloaded()
                }
            }
        }

        self.regex = {
            tags: /\[([^)]+?)\]/gi,
            mission: /mission:(?:([a-zA-Z0-9_-]+)|"([a-zA-Z0-9_ -]+)")/i,
            type: /type:(?:([a-zA-Z0-9_-]+)|"([a-zA-Z0-9_ -]+)")/i,
            before: /before:([0-9-]+)/i,
            after:/after:([0-9-]+)/i,
            year: /year:([0-9]{4})/i,
            user: /uploaded-by:([a-zA-Z0-9_-]+)/i,
            favorited: /favorited:(true|yes|y|1)/i,
            noted: /noted:(true|yes|y|1)/i,
            downloaded: /downloaded:(true|yes|y|1)/i,
            all: /([a-z,-]+):(?:([a-zA-Z0-9_-]+)|"([a-zA-Z0-9_ -]+)")/gi
        }

        return self;
    });
})();