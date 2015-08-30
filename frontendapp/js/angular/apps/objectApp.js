angular.module('objectApp', [], ['$interpolateProvider', function($interpolateProvider) {
    $interpolateProvider.startSymbol('[[');
    $interpolateProvider.endSymbol(']]');

}]).controller("objectController", ["$scope", "$http", function($scope, $http) {

    $scope.note = laravel.note;
    $scope.object = laravel.object;

    $scope.$watch("note", function(noteValue) {
        if (noteValue == "") {
            $scope.noteButtonText = "Create Note";
            $scope.noteReadText = "Create a Note!";
        } else {
            $scope.noteButtonText = "Edit Note";
            $scope.noteReadText = noteValue;
        }
    });

    $scope.noteState = "read";
    $scope.changeNoteState = function() {
        $scope.originalNote = "";

        if ($scope.noteState == "read") {
            $scope.noteState = "write";
        } else {
            $scope.noteState = "read";
        }
    };

    $scope.saveNote = function() {

    };

    $scope.deleteNote = function() {
        $http.delete('/missioncontrol/objects/' + object.object_id + '/note')
            .then(function() {
                $scope.note = "";
                $scope.changeNoteState();
            });
    };

    /* FAVORITES */
    $scope.favorites = laravel.totalFavorites;
    $scope.favoritesText;

    $scope.isFavorited = laravel.isFavorited !== null;
    $scope.toggleFavorite = function() {

        $scope.isFavorited = !$scope.isFavorited;

        if ($scope.isFavorited === false) {

            var requestType = 'POST';
            $scope.favorites++;
            $http.post('/missioncontrol/objects/' + object_id + '/favorite');

        } else if ($scope.isFavorited === true) {

            var requestType = 'DELETE';
            $scope.favorites--;
            $http.delete('/missioncontrol/objects/' + object_id + '/favorite');

        }
    };

    /* DOWNLOAD */
    $scope.makeDownloadRequest = function() {
        $http.get('/missioncontrol')
    }
}]);

