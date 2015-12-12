(function() {
    var objectApp = angular.module('app', ['ui.tree', 'ngSanitize'], function($rootScopeProvider) {
        $rootScopeProvider.digestTtl(20);
    });

    objectApp.controller("objectController", ["$scope", "$http", function($scope, $http) {

        $scope.note = laravel.userNote !== null ? laravel.userNote.note : "";
        $scope.object = laravel.object;

        $scope.$watch("note", function(noteValue) {
            if (noteValue === "" || noteValue === null) {
                $scope.noteButtonText = "Create Note";
                $scope.noteReadText = '<p class="exclaim">Create a note!</p>';
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

    objectApp.controller('commentsController', ["$scope", "commentService", "Comment", "flashMessage", function($scope, commentService, Comment, flashMessage) {
        $scope.object = laravel.object;
        $scope.commentsAreLoaded = false;
        $scope.isAddingTopLevelComment = false;

        $scope.addTopLevelComment = function(form) {
            $scope.isAddingTopLevelComment = true;
            commentService.addTopLevel($scope.object, $scope.newComment).then(function(response) {
                $scope.isAddingTopLevelComment = false;
                $scope.comments.push(new Comment(response.data));
                $scope.newComment = null;
                form.$setUntouched();
                    flashMessage.addOK('Comment submitted');
            },
            function(response) {
                $scope.isAddingTopLevelComment = false;
                flashMessage.addError('Comment could not be submitted. Try again or contact us.');
            });
        };

        (function() {
            commentService.get($scope.object).then(function(response) {
                $scope.comments = response.data.map(function(comment) {
                    return new Comment(comment);
                });
                $scope.commentsAreLoaded = true;
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

            this.addReply = function(object, reply, parent) {
                return $http.post('/missioncontrol/objects/' + object.object_id + '/comments/create', { comment: {
                    comment: reply,
                    parent: parent.comment_id
                }});
            };

            this.delete = function(object, comment) {
                return $http.delete('/missioncontrol/objects/' + object.object_id + '/comments/' + comment.comment_id);
            };

            this.edit = function(object, comment) {
                return $http.patch('/missioncontrol/objects/' + object.object_id + '/comments/' + comment.comment_id, { comment: {
                    comment: comment.editText
                }});
            };
        }
    ]);

    objectApp.factory("Comment", ["commentService", function(commentService) {
        function Comment(comment) {
            var self = comment;

            if (typeof self.children === 'undefined') {
                self.children = [];
            }

            self.isReplying = false;
            self.isEditing = false;
            self.isDeleting = false;

            self.isSending = {
                reply: false,
                edit: false,
                deletion: false
            };

            self.toggleReplyState = function() {
                if (!self.isReplying) {
                    self.isReplying = true;
                    self.isEditing = self.isDeleting = false;
                } else {
                    self.isReplying = false;
                }
            };

            self.toggleEditState = function() {
                if (!self.isEditing) {
                    self.isEditing = true;
                    self.isReplying = self.isDeleting = false;
                } else {
                    self.isEditing = false;
                }
            };

            self.toggleDeleteState = function() {
                if (!self.isDeleting) {
                    self.isDeleting = true;
                    self.isReplying = self.isEditing = false;
                } else {
                    self.isDeleting = false;
                }
            };

            self.editText = self.comment;

            self.reply = function() {
                self.isSending.reply = true;
                commentService.addReply(laravel.object, self.replyText, self).then(function(response) {
                    self.replyText = null;
                    self.isReplying = self.isSending.reply = false;

                    self.children.push(new Comment(response.data));
                });
            };

            self.edit = function() {
                self.isSending.edit = true;
                commentService.edit(laravel.object, self).then(function(response) {
                    self.comment_md = response.data.comment_md;
                    self.comment = self.editText;
                    self.editText = null;
                    self.isEditing = self.isSending.edit = false;
                });
            };

            self.delete = function(scope) {
                self.isSending.deletion = true;
                commentService.delete(laravel.object, self).then(function() {
                    self.comment = self.comment_md = null;
                    self.isDeleting = self.isSending.deletion = false;

                    // If the comment has no children, remove it entirely. Otherwise, just show [deleted], similar to Reddit
                    if (self.children.length === 0) {
                        scope.$parent.remove();
                    } else {
                        self.isHidden = true;
                    }
                });
            };

            self.children = self.children.map(function(reply) {
                return new Comment(reply);
            });

            return self;
        }

        return Comment;
    }]);
})();