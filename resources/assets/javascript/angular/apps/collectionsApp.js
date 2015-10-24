(function() {
    var collectionsApp = angular.module('app', []);

    collectionsApp.controller("createCollectionController", ["$scope", "collectionService", function($scope, collectionService) {
        $scope.createCollection = function() {
            collectionService.create($scope.newCollection);
        }
    }]);

    collectionsApp.service("collectionService", ["$http", function($http) {
        this.create = function(collection) {
            $http.post('/missioncontrol/collections/create', collection).then(function(response) {
                window.location.href = '/missioncontrol/collections/' + response.data.collection.collection_id;
            });
        };

        this.delete = function(collection) {
            $http.delete('/missioncontrol/collections/' + collection.collection_id).then(function(response) {
                window.location.href = '/missioncontrol/collections';
            });
        };

        this.edit = function(collection) {
            return $http.patch('/missioncontrol/collections/' + collection.collection_id);
        }
    }]);
})();
