(function() {
    var collectionsApp = angular.module('app', []);

    collectionsApp.controller("createCollectionController", ["$scope", "collectionService", "flashMessage", function($scope, collectionService, flashMessage) {
        $scope.is = {
            creatingCollection: false,
            editingCollection: false,
            deletingCollection: false,
            mergingCollection: false
        };

        $scope.createCollection = function() {
            $scope.is.creatingCollection = true;
            collectionService.create($scope.newCollection).then(function() {
                flashMessage.addError('Your collection could not be created.');
            });
        };

        $scope.editCollection = function() {

        };

        $scope.deleteCollection = function() {

        };

        $scope.mergeCollection = function() {

        };
    }]);

    collectionsApp.service("collectionService", ["$http", function($http) {
        this.create = function(collection) {
            $http.post('/missioncontrol/collections/create', collection).then(function(response) {
                window.location.href = '/missioncontrol/collections/' + response.data.collection_id;
            }, function(response) {
                return response;
            });
        };

        this.delete = function(collection) {
            $http.delete('/missioncontrol/collections/' + collection.collection_id).then(function(response) {
                window.location.href = '/missioncontrol/collections';
            });
        };

        this.edit = function(collection) {
            return $http.patch('/missioncontrol/collections/' + collection.collection_id, collection);
        }
    }]);
})();
