(function() {
	var publisherApp = angular.module('app', []);

	publisherApp.controller(["$scope", "$http", function($scope, $http) {

		// Init
		(function() {
			if (typeof laravel.publisher !== 'undefined') {
				$scope.publisher = laravel.publisher;
			}
		})();
	}]);
})();