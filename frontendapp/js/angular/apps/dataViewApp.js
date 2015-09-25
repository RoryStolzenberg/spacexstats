(function() {
    var dataViewApp = angular.module('app', []);

    dataViewApp.controller('dataViewController', ['$scope', '$http', function($scope, $http) {
        $scope.newDataview = {};

        (function() {

            $scope.data = {
                bannerImages: laravel.bannerImages
            };

            $scope.dataViews = laravel.dataViews;
        })();
    }]);

    dataViewApp.service('dataViewService', ["$http", function($http) {
        this.testQuery = function(query) {
            $http.get('/missioncontrol/dataviews/testquery')
        }

        this.create = function(data) {

        }

        this.edit = function(data) {

        }
    }]);

})();