(function() {
    var dataViewApp = angular.module('app', []);

    dataViewApp.controller('dataViewController', ['DataView', 'dataViewService', '$scope', '$http', function(DataView, dataViewService, $scope, $http) {
        $scope.newDataView = new DataView();

        $scope.create = function(dataViewToCreate) {
            dataViewService.create(dataViewToCreate).then(function(response) {

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
            return $http.get('/missioncontrol/dataviews/testquery?q=' + query);
        };

        this.create = function(data) {

        };

        this.edit = function(data) {

        };
    }]);

    dataViewApp.factory('DataView', ['dataViewService', function(dataViewService) {
        return function(dataView) {

            var self = this;

            if (typeof dataView === 'undefined') {
                self.titles = [];
            }

            self.addTitle = function(newTitle) {
                if (typeof newTitle !== 'undefined' && newTitle != "") {
                    self.titles.push(newTitle);
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