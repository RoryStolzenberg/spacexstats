(function() {
    var dataViewApp = angular.module('app', []);

    dataViewApp.controller('dataViewController', ['DataView', '$scope', '$http', function(DataView, $scope, $http) {
        $scope.newDataView = new DataView();

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

    dataViewApp.factory('DataView', [function() {
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

            }
        }
    }]);

})();