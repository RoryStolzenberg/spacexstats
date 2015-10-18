(function() {
    var objectApp = angular.module('app', ['ui.tree']);

    objectApp.controller("objectController", ["$scope", "$http", function($scope, $http) {

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

    }]);

    objectApp.controller('commentsController', ["$scope", "commentService", "Comment", function($scope, commentService, Comment) {
        $scope.object = laravel.object;

        $scope.addTopLevelComment = function(form) {
            commentService.addTopLevel($scope.object, $scope.newComment).then(function(response) {
                $scope.comments.push(response.data);
                $scope.newComment = null;
                form.$setPristine();
            });
        };

        $scope.addReplyComment = function() {
            commentService.addReply($scope.object);
        };

        $scope.deleteComment = function() {

        };

        $scope.editComment = function() {

        };

        (function() {
            commentService.get($scope.object).then(function(response) {
                $scope.comments = response.data;
            });
        })();

    }]);

    objectApp.service("noteService", ["$http", function($http) {

    }]);

    objectApp.service("favoriteService", ["$http", function($http) {

    }]);

    objectApp.service("commentService", ["$http",
        function($http) {

            this.get = function (object) {
                return $http.get('/missioncontrol/objects/' + object.object_id + '/comments');
            };

            this.addTopLevel = function(object, comment) {
                return $http.post('/missioncontrol/objects/' + object.object_id + '/comments/create', { comment: {
                    comment: comment,
                    parent: null
                }});
            };

            this.addReply = function(object, comment) {

            }

            this.delete = function(object, comment) {
                return $http.delete('/missioncontrol/objects/' + object.object_id + '/comments/' + comment.comment_id);
            }

            this.edit = function(object, comment) {
                return $http.patch('/missioncontrol/objects/' + object.object_id + '/comments/' + comment.comment_id);
            }
        }
    ]);

    objectApp.factory("Comment", function() {
        return function(comment) {
            var self = comment;

            self.toggleReplyState = function() {
                if (typeof $scope.reply !== 'undefined') {
                    $scope.reply = !$scope.reply;
                } else {
                    $scope.reply = true;
                }
            };

            self.edit = function() {

            }

            self.delete = function() {

            }

            return self;
        }
    });
})();