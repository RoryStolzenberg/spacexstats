(function() {
	var publisherApp = angular.module('app', []);

	publisherApp.controller('publishersController', ["$scope", "publisherService", "flashMessage", function($scope, publisherService, flashMessage) {
        $scope.publishers = laravel.publishers;
        $scope.isCreatingPublisher = $scope.isEditingPublisher = false;

        $scope.editPublisher = function(publisher) {
            $scope.isEditingPublisher = true;
            publisherService.edit(publisher).then(function(response) {
                publisher = response.data;
                $scope.isEditingPublisher = false;
                flashMessage.addOK("Publisher " + publisher.name + " edited");
            });
        };

        $scope.createPublisher = function(publisher, form) {
            $scope.isCreatingPublisher = true;
            publisherService.create(publisher).then(function(response) {
                $scope.publishers.unshift(response.data);
                $scope.isCreatingPublisher = false;

                flashMessage.addOK("Publisher " + publisher.name + " created");
                $scope.newPublisher = null;
                form.$setUntouched();

            }, function(response) {
                $scope.isCreatingPublisher = false;
                flashMessage.addError("That publisher already exists");
            });
        };

        $scope.deletePublisher = function(publisher) {
            $scope.isDeletingPublisher = true;
            publisherService.delete(publisher).then(function(response) {
                $scope.isDeletingPublisher = false;
                flashMessage.addOK("Publisher " + publisher.name + " deleted");
            });
        }
	}]);

    publisherApp.service('publisherService', ["$http", function($http) {
        this.create = function(publisher) {
            return $http.post('/missioncontrol/publishers/create', {publisher: publisher});
        };

        this.edit = function(publisher) {
            return $http.patch('/missioncontrol/publishers/' + publisher.publisher_id, {publisher: publisher});
        };

        this.delete = function(publisher) {
            return $http.delete('/missioncontrol/publishers/' + publisher.publisher_id);
        };
    }]);
})();