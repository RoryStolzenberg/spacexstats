(function() {
	var app = angular.module('app', ['720kb.datepicker']);

	app.directive('search', ['searchService', 'conversionService', "$rootScope", "$http", "$filter", function(searchService, conversionService, $rootScope, $http, $filter) {
		return {
			restrict: 'E',
            transclude: true,
			link: function($scope, element, attributes, ngModelCtrl) {

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
                $scope.onSearchChange = function() {
                    conversionService.searchesToFilters($scope.brokerFilters, $scope.currentSearch, $scope.data);
                };

                $scope.onFilterUpdate = function(filterType) {
                    conversionService.filtersToSearches($scope.brokerFilters, $scope.currentSearch, filterType);
                };

                $scope.reset = function() {
                    $rootScope.$broadcast('exitSearchMode');
                    $scope.currentSearch.rawQuery = '';
                    $scope.onSearchChange();
                };

                (function() {
                    $http.get('/missioncontrol/search/fetch').then(function(response) {
                        $scope.data = {
                            missions: response.data.missions.map(function(mission) {
                                return {
                                    name: mission.name,
                                    image: mission.featured_image
                                }
                            }),
                            types: response.data.types.map(function(type) {
                                return {
                                    name: type,
                                    image: '/images/icons/' + type.replace(" ", "") + '.jpg'
                                }
                            })
                        }
                    });
                })();
			},
			templateUrl: '/js/templates/search.html'
		}
	}]);

    app.service('conversionService', function() {
        this.searchesToFilters = function(brokerFilters, search, data) {
            // Search for missions in the query string
            var missionResult = search.filters().mission();
            if (missionResult != null) {
                var mission = data.missions.filter(function(mission) {
                    return mission.name.toLowerCase() == missionResult.toLowerCase();
                });

                if (mission !== null) {
                    brokerFilters.mission = mission[0];
                } else {
                    brokerFilters.mission = null;
                }
            } else {
                brokerFilters.mission = null;
            }

            // Search for types of resources in the query string
            var typeResult = search.filters().type();
            if (typeResult != null) {
                var type = data.types.filter(function(type) {
                    return type.name.toLowerCase() == typeResult.toLowerCase();
                });

                if (type !== null) {
                    brokerFilters.type = type[0];
                } else {
                    brokerFilters.type = null;
                }
            } else {
                brokerFilters.type = null;
            }

            var afterResult = search.filters().after();
            if (afterResult != null) {
                brokerFilters.after = moment(afterResult, 'YYYY-MM-DD').format('MMM D, YYYY');
            }  else {
                brokerFilters.after = null;
            }

            var beforeResult = search.filters().before();
            if (beforeResult != null) {
                brokerFilters.before = moment(beforeResult, 'YYYY-MM-DD').format('MMM D, YYYY');
            } else {
                brokerFilters.before = null;
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

                        // Test whether the name of the mission contains a space. If it does, we need to append
                        // quotes around it
                        var whatToConcatenate = /\s/.test(brokerFilters.mission.name) ?
                            'mission:"' + brokerFilters.mission.name + '"' :
                            'mission:' + brokerFilters.mission.name;

                        this.contextualConcat(search, whatToConcatenate);

                    } else {
                        search.rawQuery = /\s/.test(brokerFilters.mission.name) ?
                            search.rawQuery.replace(search.regex.mission, 'mission:"' + brokerFilters.mission.name + '"') :
                            search.rawQuery.replace(search.regex.mission, 'mission:' + brokerFilters.mission.name);
                    }
                }
            }

            else if (filterType == 'type') {
                if (brokerFilters.type === null) {
                    search.rawQuery = search.rawQuery.replace(search.regex.type, '');
                } else {
                    if (search.filters().type() === null) {

                        // Test whether the name of the type contains a space. If it does, we need to append
                        // quotes around it
                        var whatToConcatenate = /\s/.test(brokerFilters.type.name) ?
                        'type:"' + brokerFilters.type.name + '"' :
                        'type:' + brokerFilters.type.name;

                        this.contextualConcat(search, whatToConcatenate);

                    } else {
                        search.rawQuery = /\s/.test(brokerFilters.type.name) ?
                            search.rawQuery.replace(search.regex.type, 'type:"' + brokerFilters.type.name + '"') :
                            search.rawQuery.replace(search.regex.type, 'type:' + brokerFilters.type.name);
                    }
                }
            }

            else if (filterType == 'after') {
                if (brokerFilters.after === null || brokerFilters.after === "") {
                    search.rawQuery = search.rawQuery.replace(search.regex.after, '');
                } else {
                    if (moment(brokerFilters.after, "MMM D, YYYY").isValid()) {
                        var dateToConcatenate = moment(brokerFilters.after, "MMM D, YYYY").format('YYYY-MM-DD');
                        if (search.filters().after() === null) {
                            this.contextualConcat(search, 'after:' + dateToConcatenate);
                        } else {
                            search.rawQuery = search.rawQuery.replace(search.regex.after, 'after:' + dateToConcatenate);
                        }
                    }
                }
            }

            else if (filterType == 'before') {
                if (brokerFilters.before === null || brokerFilters.before === "") {
                    search.rawQuery = search.rawQuery.replace(search.regex.before, '');
                } else {
                    if (moment(brokerFilters.before, "MMM D, YYYY").isValid()) {
                        var dateToConcatenate = moment(brokerFilters.before, "MMM D, YYYY").format('YYYY-MM-DD');
                        if (search.filters().before() === null) {
                            this.contextualConcat(search, 'before:' + dateToConcatenate);
                        } else {
                            search.rawQuery = search.rawQuery.replace(search.regex.before, 'before:' + dateToConcatenate);
                        }
                    }
                }
            }

            else if (filterType === 'favorited') {
                if (search.filters().favorited() === null) {
                    this.contextualConcat(search, 'favorited:true');
                } else {
                    search.rawQuery = search.rawQuery.replace(search.regex.favorited, '');
                }
            }

            else if (filterType === 'noted') {
                if (search.filters().noted() === null) {
                    this.contextualConcat(search, 'noted:true');
                } else {
                    search.rawQuery = search.rawQuery.replace(search.regex.noted, '');
                }
            }

            else if (filterType === 'downloaded') {
                if (search.filters().downloaded() === null) {
                    this.contextualConcat(search, 'downloaded:true');
                } else {
                    search.rawQuery = search.rawQuery.replace(search.regex.downloaded, '');
                }
            }
        };

        this.contextualConcat = function(search, whatToConcatenate) {
            // Add a space so that we can make the search look cleaner (but only if it's not empty and the last character is not a string)
            if (search.rawQuery != "" && search.rawQuery.slice(-1) != ' ') {
                whatToConcatenate = ' ' + whatToConcatenate;
            }
            search.rawQuery = search.rawQuery.concat(whatToConcatenate);
        };

        this.contextualRemove = function(search, whatToRemove) {

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
            return self.rawQuery.replace(self.regex.tags, "").replace(self.regex.all, "").trim();
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
                    var beforeResult = self.regex.before.exec(self.rawQuery);
                    return beforeResult !== null ? beforeResult[1] : null;
                },
                after: function () {
                    var afterResult = self.regex.after.exec(self.rawQuery);
                    return afterResult !== null ? afterResult[1] : null;
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
                    tags: self.filters().tags(),
                    mission: self.filters().mission(),
                    type: self.filters().type(),
                    before: self.filters().before(),
                    after: self.filters().after(),
                    year: self.filters().year(),
                    user: self.filters().user(),
                    favorited: self.filters().favorited(),
                    noted: self.filters().noted(),
                    downloaded: self.filters().downloaded()
                }
            }
        };

        self.regex = {
            tags: /\[([^)]+?)\]/gi,
            mission: /mission:(?:([^ "]+)|"(.+)")/i,
            type: /type:(?:([^ "]+)|"(.+)")/i,
            before: /before:([0-9]{4}-[0-9]{2}-[0-9]{2})/i,
            after:/after:([0-9]{4}-[0-9]{2}-[0-9]{2})/i,
            year: /year:([0-9]{4})/i,
            user: /uploaded-by:([a-zA-Z0-9_-]+)/i,
            favorited: /favorited:(true|yes|y|1)/i,
            noted: /noted:(true|yes|y|1)/i,
            downloaded: /downloaded:(true|yes|y|1)/i,
            all: /([a-z-]+):(?:([^ "]+)|"(.+)")/gi
        };

        return self;
    });
})();