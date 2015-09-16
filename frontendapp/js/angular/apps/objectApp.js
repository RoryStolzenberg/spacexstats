angular.module('objectApp', [], ['$interpolateProvider', function($interpolateProvider) {
    $interpolateProvider.startSymbol('[[');
    $interpolateProvider.endSymbol(']]');

}]).controller("objectController", ["$scope", "$http", function($scope, $http) {

    $scope.note = laravel.userNote !== null ? laravel.userNote.note : "";
    $scope.object = laravel.object;

    $scope.$watch("note", function(noteValue) {
        if (noteValue === "" || noteValue === null) {
            $scope.noteButtonText = "Create Note";
            $scope.noteReadText = "Create a Note!";
        } else {
            $scope.noteButtonText = "Edit Note";
            $scope.noteReadText = noteValue;
        }
    });

    $scope.noteState = "read";
    $scope.changeNoteState = function() {

        $scope.originalNote = $scope.note;

        if ($scope.noteState == "read") {
            $scope.noteState = "write";
        } else {
            $scope.noteState = "read";
        }
    };

    $scope.saveNote = function() {
        if ($scope.originalNote === "") {

            $http.post('/missioncontrol/objects/' + $scope.object.object_id + '/note', {
                note: $scope.note
            }).then(function() {
                $scope.changeNoteState();
            });

        } else {

            $http.patch('/missioncontrol/objects/' + $scope.object.object_id + '/note', {
                note: $scope.note
            }).then(function() {
                $scope.changeNoteState();
            });
        }
    };

    $scope.deleteNote = function() {
        $http.delete('/missioncontrol/objects/' + $scope.object.object_id + '/note')
            .then(function() {
                $scope.note = "";
                $scope.changeNoteState();
            });
    };

    /* FAVORITES */
    $scope.favorites = laravel.totalFavorites;

    $scope.$watch("favorites", function(newFavoritesValue) {
        if (newFavoritesValue == 1) {
            $scope.favoritesText = "1 Favorite";
        }  else {
            $scope.favoritesText = $scope.favorites + " Favorites";
        }
    });

    $scope.isFavorited = laravel.isFavorited !== null;
    $scope.toggleFavorite = function() {

        $scope.isFavorited = !$scope.isFavorited;

        if ($scope.isFavorited === true) {

            var requestType = 'POST';
            $scope.favorites++;
            $http.post('/missioncontrol/objects/' + $scope.object.object_id + '/favorite');

        } else if ($scope.isFavorited === false) {

            var requestType = 'DELETE';
            $scope.favorites--;
            $http.delete('/missioncontrol/objects/' + $scope.object.object_id + '/favorite');

        }
    };

    /* DOWNLOAD */
    $scope.incrementDownloads = function() {
        $http.get('/missioncontrol/objects/' + $scope.object.object_id + '/download');
    }
}]).controller('commentsController', ["$scope", function($scope) {

}]);

