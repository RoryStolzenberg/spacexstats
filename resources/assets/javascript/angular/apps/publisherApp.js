(function() {
	var publisherApp = angular.module('app', []);

	publisherApp.controller('publishersController', ["$scope", "publisherSevice", function($scope, publisherSevice) {
        $scope.publishers = laravel.publishers;
        $scope.isCreatingPublisher = false;

        $scope.editPublisher = function(publisher) {
            publisherService.edit(publisher).then(function(response) {
                // Push & flashMessage
            });
        };

        $scope.createPublisher = function(publisher) {
            publisherService.create(publisher).then(function(response) {
                // Push & flashMessage
            });
        };

        $scope.deletePublisher = function(publisher) {
            publisherService.delete(publisher).then(function(response) {
                // Delete & flashMessage
            });
        }
	}]);

    publisherApp.service('publisherService', ["$http", function($http) {
        this.create = function(publisher) {
            return $http.post('/missioncontrol/publishers/create', publisher);
        };

        this.edit = function(publisher) {
            return $http.patch('/missioncontrol/publishers/' + publisher.publisher_id, publisher);
        };

        this.delete = function(publisher) {
            return $http.delete('/missioncontrol/publishers/' + publisher.publisher_id);
        };
    }]);
})();