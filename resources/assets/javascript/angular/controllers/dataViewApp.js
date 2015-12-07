(function() {
    var dataViewApp = angular.module('app', []);

    dataViewApp.controller('dataViewController', ['DataView', 'dataViewService', '$scope', '$http', function(DataView, dataViewService, $scope, $http) {
        $scope.newDataView = new DataView();
        $scope.dataViews = [];

        $scope.create = function(dataViewToCreate) {
            dataViewService.create(dataViewToCreate).then(function(response) {
                $scope.newDataView = new DataView();
            });
        };

        $scope.edit = function(dataViewToEdit) {
            dataViewService.edit(dataViewToEdit).then(function(response) {

            });
        };

        (function() {
            $scope.data = {
                bannerImages: laravel.bannerImages
            };

            laravel.dataViews.forEach(function(dataView) {
                $scope.dataViews.push(new DataView(dataView));
            });
        })();
    }]);

    dataViewApp.service('dataViewService', ["$http", function($http) {
        this.testQuery = function(query) {
            var encodedQuery = encodeURIComponent(query);
            return $http.get('/missioncontrol/dataviews/testquery?q=' + encodedQuery);
        };

        this.create = function(data) {
            return $http.post('/missioncontrol/dataviews/create',{ dataView: data });
        };

        this.edit = function(data) {
            return $http.post('/missioncontrol/dataviews/' + data.dataview_id + '/edit', { dataView: data });
        };
    }]);

    dataViewApp.factory('DataView', ['dataViewService', function(dataViewService) {
        return function(dataView) {

            if (typeof dataView === 'undefined') {
                var self = this
            } else {
                var self = dataView;
            }

            if (typeof dataView === 'undefined') {
                self.column_titles = [];
            }

            self.addTitle = function(newTitle) {
                if (typeof newTitle !== 'undefined' && newTitle != "") {
                    self.column_titles.push(newTitle);
                    self.newTitle = undefined;
                }
            };

            self.deleteTitle = function() {

            };

            self.testQuery = function() {
                dataViewService.testQuery(self.query).then(function(response) {
                    self.testQueryOutput = response.data;
                });
            }
        }
    }]);

})();