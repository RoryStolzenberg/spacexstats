(function() {
    var missionsListApp = angular.module('app', []);

    missionsListApp.controller("missionsListController", ['$scope', function($scope) {
        $scope.missions = laravel.missions;

        // Cheap way to get the next launch (only use on future mission page)
        $scope.nextLaunch = function() {
            return $scope.missions[0];
        };

        // Cheap way to get the previous launch (only use on past mission page)
        $scope.lastLaunch = function() {
            return $scope.missions[$scope.missions.length - 1];
        };

        $scope.currentYear = function() {
            return moment().year();
        };

        $scope.missionsInYear = function(year, completeness) {
            return $scope.missions.filter(function(mission) {
                return moment(mission.launchDateTime).year() == year && mission.status == completeness;
            }).length;
        };
    }]);
})();
(function() {
    var missionControlApp = angular.module("app", []);

    missionControlApp.controller("missionControlController", ["$scope", "missionControlService", function($scope, missionControlService) {
        $scope.hasSearchResults = false;
        $scope.isCurrentlySearching = false;
        $scope.pageTitle = "Mission Control";

        $scope.$on('startedSearching', function() {
            $scope.hasSearchResults = false;
            $scope.isCurrentlySearching = true;
            $scope.pageTitle = "Searching...";
        });

        $scope.$on('finishedSearching', function(event, arg) {
            $scope.hasSearchResults = true;
            $scope.isCurrentlySearching = false;
            $scope.pageTitle = '"' + arg + '" results';
        });

        $scope.$on('exitSearchMode', function(event, arg) {
            $scope.hasSearchResults = $scope.isCurrentlySearching = false;
            $scope.pageTitle = "Mission Control";
        });

        $scope.missioncontrol = {
            objects: {
                visibleSection: 'latest',
                show: function(sectionToShow) {
                    $scope.missioncontrol.objects.visibleSection = sectionToShow;
                }
            },
            leaderboards: {
                visibleSection: 'week',
                show: function(sectionToShow) {
                    $scope.missioncontrol.leaderboards.visibleSection = sectionToShow;
                }
            }
        }
    }]);

    missionControlApp.controller("searchController", ["$scope", "$rootScope", "missionControlService", function($scope, $rootScope, missionControlService) {

        $scope.search = function() {

            // Get query and broadcast
            var currentQuery = $scope.currentSearch.toQuery();
            $rootScope.$broadcast('startedSearching');

            // Make request
            missionControlService.search(currentQuery).then(function(response) {
                $rootScope.$broadcast('finishedSearching', currentQuery.searchTerm);
                $scope.searchResults = response.data;
            });
        };
    }]);

    missionControlApp.service("missionControlService", ["$http", function($http) {
        this.search = function(currentQuery) {
            return $http.post('/missioncontrol/search', { search: currentQuery });
        };
    }]);
})();
(function() {
    var app = angular.module('app', []);

    app.controller("futureMissionController", ['$http', '$scope', '$filter', 'flashMessage', function($http, $scope, $filter, flashMessage) {

        $scope.missionSlug = laravel.mission.slug;
        $scope.launchDateTime = moment(laravel.mission.launch_date_time).toDate();
        $scope.launchSpecificity = laravel.mission.launch_specificity;

        $scope.$watch("launchSpecificity", function(newValue) {
            $scope.isLaunchExact =  (newValue == 6 || newValue == 7);
        });

        $scope.$watchCollection('[isLaunchExact, launchDateTime]', function(newValues) {
            if (newValues[0] === true) {
                $scope.launchUnixSeconds =  (moment(newValues[1]).unix());
            }
            $scope.launchUnixSeconds =  null;
        });

        $scope.lastRequest = moment().unix();
        $scope.secondsSinceLastRequest = 0;

        $scope.secondsToLaunch;

        $scope.requestFrequencyManager = function() {
            $scope.secondsSinceLastRequest = Math.floor($.now() / 1000) - $scope.lastRequest;
            $scope.secondsToLaunch = $scope.launchUnixSeconds - Math.floor($.now() / 1000);

            /*
             Make requests to the server for launchdatetime and webcast updates at the following frequencies:
             >24hrs to launch    =   1hr / request
             1hr-24hrs           =   15min / request
             20min-1hr           =   5 min / request
             <20min              =   30sec / request
             */
            var aRequestNeedsToBeMade = ($scope.secondsToLaunch >= 86400 && $scope.secondsSinceLastRequest >= 3600) ||
                ($scope.secondsToLaunch >= 3600 && $scope.secondsToLaunch < 86400 && $scope.secondsSinceLastRequest >= 900) ||
                ($scope.secondsToLaunch >= 1200 && $scope.secondsToLaunch < 3600 && $scope.secondsSinceLastRequest >= 300) ||
                ($scope.secondsToLaunch < 1200 && $scope.secondsSinceLastRequest >= 30);

            if (aRequestNeedsToBeMade === true) {
                // Make both requests then update the time since last request
                $scope.requestLaunchDateTime();
                $scope.requestWebcastStatus();
                $scope.lastRequest = moment().unix();
            }
        }

        $scope.requestLaunchDateTime = function() {
            $http.get('/missions/' + $scope.missionSlug + '/requestlaunchdatetime')
                .then(function(response) {
                    // If there has been a change in the launch datetime, update
                    if ($scope.launchDateTime !== response.data.launchDateTime) {
                        $scope.launchDateTime = response.data.launchDateTime;
                        $scope.launchSpecificity = response.data.launchSpecificity;

                        flashMessage.addOK('Launch time updated!');
                    }
                });
        }

        $scope.requestWebcastStatus = function() {
            $http.get('/webcast/getstatus')
                .then(function(response) {
                    $scope.webcast.isLive = response.data.isLive;
                    $scope.webcast.viewers = response.data.viewers;
                });
        }

        $scope.webcast = {
            isLive: laravel.webcast.isLive,
            viewers: laravel.webcast.viewers
        }

        $scope.$watchCollection('[webcast.isLive, secondsToLaunch]', function(newValues) {
            if (newValues[1] < (60 * 60 * 24) && newValues[0] == 'true') {
                $scope.webcast.status = 'webcast-live';
            } else if (newValues[1] < (60 * 60 * 24) && newValues[0] == 'false') {
                $scope.webcast.status = 'webcast-updates';
            } else {
                $scope.webcast.status = 'webcast-inactive';
            }
        });

        $scope.$watch('webcast.status', function(newValue) {
            if (newValue === 'webcast-live') {
                $scope.webcast.publicStatus = 'Live Webcast'
            } else if (newValue === 'webcast-updates') {
                $scope.webcast.publicStatus = 'Launch Updates'
            }
        });

        $scope.$watch('webcast.viewers', function(newValue) {
            $scope.webcast.publicViewers = ' (' + newValue + ' viewers)';
        });

        /*
        *   Timezone stuff.
         */
        // Get the IANA Timezone identifier and format it into a 3 letter timezone.
        $scope.localTimezone = moment().tz(jstz.determine().name()).format('z');
        $scope.currentFormat = 'h:mm:ssa MMMM d, yyyy';
        $scope.currentTimezone;
        $scope.currentTimezoneFormatted = "Local ("+ $scope.localTimezone +")";

        $scope.setTimezone = function(timezoneToSet) {
            if (timezoneToSet === 'local') {
                $scope.currentTimezone = null;
                $scope.currentTimezoneFormatted = "Local ("+ $scope.localTimezone +")";
            } else if (timezoneToSet === 'ET') {
                $scope.currentTimezone = moment().tz("America/New_York").format('z');
                $scope.currentTimezoneFormatted = 'Eastern';
            } else if (timezoneToSet === 'PT') {
                $scope.currentTimezone = moment().tz("America/Los_Angeles").format('z');
                $scope.currentTimezoneFormatted = 'Pacific';
            } else {
                $scope.currentTimezoneFormatted = $scope.currentTimezone = 'UTC';
            }
        };

        $scope.displayDateTime = function() {
            if ($scope.isLaunchExact) {
                return $filter('date')($scope.launchDateTime, $scope.currentFormat, $scope.currentTimezone);
            } else {
                return $scope.launchDateTime;
            }

        };
    }]);
})();
    (function() {
    var uploadApp = angular.module('app', []);

    uploadApp.controller("uploadAppController", ["$scope", function($scope) {
        $scope.activeSection = "upload";
        $scope.showRecentAdditions = true;

        $scope.data = {
            missions: laravel.missions,
            tags: laravel.tags,
            subtypes: {
                images: [
                    'Mission Patch',
                    'Photo',
                    'Chart',
                    'Concept Art',
                    'Screenshot',
                    'Infographic',
                    'News Summary',
                    'Hazard Map'
                ],
                video: [
                    'Launch Video',
                    'Press Conference'
                ],
                documents: [
                    'Press Kit',
                    'Cargo Manifest',
                    'Weather Forecast',
                    'License'
                ]
            },
            publishers: laravel.publishers,
            recentUploads: laravel.recentUploads
        };

        $scope.changeSection = function(section) {
            $scope.activeSection = section;
            $scope.showRecentAdditions = section == 'upload';
        };

        $scope.$on('hideSubmissionMethods', function() {
            $scope.areSubmissionMethodsHidden = true;
        });

    }]);

    uploadApp.controller("uploadController", ["$rootScope", "$scope", "objectFromFile", "uploadService", function($rootScope, $scope, objectFromFile, uploadService) {
        $scope.activeUploadSection = "dropzone";
        $scope.isSubmitting = false;
        $scope.isUploading = false;
        $scope.queuedFiles = 0;

        $scope.currentVisibleFile = null;
        $scope.isVisibleFile = function(file) {
            return $scope.currentVisibleFile === file;
        };
        $scope.setVisibleFile = function(file) {
            $scope.currentVisibleFile = file;
        };

        $scope.uploadCallback = function() {
            $scope.isUploading = false;

            // Once files have been successfully upload, convert to Objects
            $scope.files.forEach(function(file, index) {
                file = objectFromFile.create(file, index);

                // Set the initial visible file
                if (index === 0) {
                    $scope.currentVisibleFile = file;
                }
            });

            // Change the upload section
            $scope.activeUploadSection = "data";
            $rootScope.$broadcast('hideSubmissionMethods');
            $scope.showRecentAdditions = false;
            $scope.$apply();
        };

        $scope.fileSubmitButtonFunction = function() {
            $scope.isSubmitting = true;
            uploadService.postToMissionControl($scope.files, 'files');
        }
    }]);

    uploadApp.controller("postController", ["$scope", "uploadService", function($scope, uploadService) {

        $scope.NSFcomment = {};
        $scope.redditcomment = {};
        $scope.pressrelease = {};
        $scope.article = {};
        $scope.tweet = {};

        $scope.isSubmitting = false;

        $scope.postSubmitButtonFunction = function() {
            $scope.isSubmitting = true;
            switch ($scope.postType) {
                case 'NSFcomment': uploadService.postToMissionControl($scope.NSFcomment, 'NSFcomment'); break;
                case 'redditcomment': uploadService.postToMissionControl($scope.redditcomment, 'redditcomment'); break;
                case 'pressrelease' : uploadService.postToMissionControl($scope.pressrelease, 'pressrelease'); break;
                case 'article': uploadService.postToMissionControl($scope.article, 'article'); break;
                case 'tweet': uploadService.postToMissionControl($scope.tweet, 'tweet'); break;
            }
        }
    }]);

    uploadApp.controller("writeController", ["$scope", "uploadService", function($scope, uploadService) {

        $scope.text = {
            title: null,
            content: null,
            mission_id: null,
            anonymous: null,
            tags: []
        };

        $scope.isSubmitting = false;

        $scope.writeSubmitButtonFunction = function() {
            $scope.isSubmitting = true;
            uploadService.postToMissionControl($scope.text, 'text');
        }
    }]);

    uploadApp.service('uploadService', ['$http', 'CSRF_TOKEN', function($http, CSRF_TOKEN) {
        this.postToMissionControl = function(dataToUpload, submissionHeader) {
            var req = {
                method: 'POST',
                url: '/missioncontrol/create/submit',
                headers: {
                    'Submission-Type': submissionHeader
                },
                data: {
                    data: dataToUpload,
                    _token: CSRF_TOKEN
                }
            };

            $http(req).then(function() {
                window.location = '/missioncontrol';
            });
        }
    }]);

    uploadApp.factory("Image", function() {
        return function (image, index) {
            var self = image;

            self.index = index;

            self.title = null;
            self.summary = null;
            self.subtype = null;
            self.mission_id = null;
            self.author = null;
            self.attribution = null;
            self.anonymous = null;
            self.tags = [];

            self.datetimeExtractedFromEXIF = self.originated_at !== null ? true : false;

            return self;
        }
    });

    uploadApp.factory("GIF", function() {
        return function(gif, index) {
            var self = gif;

            self.index = index;

            self.title = null;
            self.summary = null;
            self.subtype = null;
            self.mission_id = null;
            self.author = null;
            self.attribution = null;
            self.anonymous = null;
            self.tags = [];
            self.originated_at = null;

            return self;
        }
    });

    uploadApp.factory("Audio", function() {
        return function(audio, index) {
            var self = audio;

            self.index = index;

            self.title = null;
            self.summary = null;
            self.subtype = null;
            self.mission_id = null;
            self.author = null;
            self.attribution = null;
            self.anonymous = null;
            self.tags = [];
            self.originated_at = null;

            return self;
        }
    });

    uploadApp.factory("Video", function() {
        return function(video, index) {
            var self = video;

            self.index = index;

            self.title = null;
            self.summary = null;
            self.external_url = null;
            self.subtype = null;
            self.mission_id = null;
            self.author = null;
            self.attribution = null;
            self.anonymous = null;
            self.tags = [];
            self.originated_at = null;

            return self;
        }
    });

    uploadApp.factory("Document", function() {
        return function(document, index) {
            var self = document;

            self.index = index;

            self.title = null;
            self.summary = null;
            self.subtype = null;
            self.mission_id = null;
            self.author = null;
            self.attribution = null;
            self.anonymous = null;
            self.tags = [];
            self.originated_at = null;

            return self;
        }
    });

    uploadApp.service("objectFromFile", ["Image", "GIF", "Audio", "Video", "Document", function(Image, GIF, Audio, Video, Document) {
        this.create = function(file, index) {
            switch(file.type) {
                case 'Image': return new Image(file, index);
                case 'GIF': return new GIF(file, index);
                case 'Audio': return new Audio(file, index);
                case 'Video': return new Video(file, index);
                case 'Document': return new Document(file, index);
                default: return null;
            }
        }
    }]);
})();
(function() {
    var questionsApp = angular.module('app', []);

    questionsApp.controller("questionsController", ["$scope", "questionService", function($scope, questionService) {

        $scope.pinnedQuestion = null;

        $scope.clearPinnedQuestion = function() {

        };

        $scope.pinQuestion = function(question) {

        };

        (function() {
            questionService.get().then(function(questions) {
                $scope.questions = questions;
            });
        })();
    }]);

    questionsApp.service("questionService", ["$http", "Question", function($http, Question) {
        this.get = function() {
            return $http.get('/faq/get').then(function(response) {
                return response.data.map(function(question) {
                    return new Question(question);
                });
            });
        };
    }]);

    questionsApp.factory("Question", function() {
        return function(question) {
            var self = question;

            self.slug = question.question.toLowerCase()
                .replace(/[^\w ]+/g,'')
                .replace(/ +/g,'-');

            return self;
        };
    });

})();
(function() {
	var publisherApp = angular.module('app', []);

	publisherApp.controller('publishersController', ["$scope", "publisherService", function($scope, publisherService) {
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
(function() {
    var reviewApp = angular.module('app', []);

    reviewApp.controller("reviewController", ["$scope", 'reviewService', function($scope, reviewService) {
        $scope.isLoading = true;
        $scope.objectsToReview = [];

        $scope.visibilities = ['Default', 'Public', 'Hidden'];

        $scope.action = function(object, status) {

            object.status = status;

            if (status == 'Published') {
                object.isBeingPublished = true;
            } else if (status == 'Deleted') {
                object.isBeingDeleted = true;
            }

            reviewService.review(object).then(function() {
                $scope.objectsToReview.splice($scope.objectsToReview.indexOf(object), 1);

            }, function(response) {
                alert('An error occurred');
                console.log(response);
            })
        };

        $scope.reviewPageSubheading = function() {
            if ($scope.isLoading) {
                return 'Loading Queued Objects...';
            } else {
                if (angular.isDefined($scope.objectsToReview))
                    return '<span>' + $scope.objectsToReview.length + '</span> objects to review';
            }
        };

        (function() {
            reviewService.fetch().then(function(response) {
                console.log(response);
                $scope.objectsToReview = response;
                $scope.isLoading = false;
            });
        })();
    }]);

    reviewApp.service('reviewService', ["$http", "ObjectToReview", function($http, ObjectToReview) {
        this.fetch = function() {
            return $http.get('/missioncontrol/review/get').then(function(response) {

                return response.data.map(function(objectToReview) {
                    return new ObjectToReview(objectToReview);
                });
            });
        };

        this.review = function(object) {
            return $http.post('/missioncontrol/review/update/' + object.object_id, {
                visibility: object.visibility, status: object.status
            });
        };
    }]);

    reviewApp.factory("ObjectToReview", function() {
        return function (object) {
            var self = object;

            self.visibility = "Default";

            self.linkToObject = '/missioncontrol/object/' + self.object_id;
            self.linkToUser = 'users/' + self.user.username;

            self.createdAtRelative = moment.utc(self.created_at).fromNow();

            self.size = self.size / 1000 + ' KB';

            self.isBeingPublished = false;
            self.isBeingDeleted = false;

            return self;
        }
    });
})();
(function() {
    var objectApp = angular.module('app', ['ui.tree', 'ngSanitize']);

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

    objectApp.controller('commentsController', ["$scope", "commentService", "Comment", function($scope, commentService, Comment) {
        $scope.object = laravel.object;
        $scope.commentsAreLoaded = false;

        $scope.addTopLevelComment = function(form) {
            commentService.addTopLevel($scope.object, $scope.newComment).then(function(response) {
                $scope.comments.push(new Comment(response.data));
                $scope.newComment = null;
                form.$setUntouched();
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

            self.toggleReplyState = function() {
                if (self.isReplying === false) {
                    self.isReplying = true;
                    self.isEditing = self.isDeleting = false;
                } else {
                    self.isReplying = false;
                }
            };

            self.toggleEditState = function() {
                if (self.isEditing === false) {
                    self.isEditing = true;
                    self.isReplying = self.isDeleting = false;
                } else {
                    self.isEditing = false;
                }
            };

            self.toggleDeleteState = function() {
                if (self.isDeleting === false) {
                    self.isDeleting = true;
                    self.isReplying = self.isEditing = false;
                } else {
                    self.isDeleting = false;
                }
            };

            self.editText = self.comment;

            self.reply = function() {
                commentService.addReply(laravel.object, self.replyText, self).then(function(response) {
                    self.replyText = null;
                    self.isReplying = false;

                    self.children.push(new Comment(response.data));
                });
            };

            self.edit = function() {
                commentService.edit(laravel.object, self).then(function(response) {
                    self.comment_md = response.data.comment_md;
                    self.comment = self.editText;
                    self.editText = null;
                    self.isEditing = false;
                });
            };

            self.delete = function(scope) {
                commentService.delete(laravel.object, self).then(function() {
                    self.comment = self.comment_md = null;
                    self.isDeleting = false;

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
(function() {
    var app = angular.module('app', []);

    app.controller("missionController", ['$scope', 'Mission', 'missionService', function($scope, Mission, missionService) {
        // Set the current mission being edited/created
        $scope.mission = new Mission(typeof laravel.mission !== "undefined" ? laravel.mission : null);

        // Scope the possible form data info
        $scope.data = {
            parts: laravel.parts,
            spacecraft: laravel.spacecraft,
            destinations: laravel.destinations,
            missionTypes: laravel.missionTypes,
            launchSites: laravel.launchSites,
            landingSites: laravel.landingSites,
            vehicles: laravel.vehicles,
            astronauts: laravel.astronauts,

            launchVideos: laravel.launchVideos ? laravel.launchVideos : null,
            missionPatches: laravel.missionPatches ? laravel.missionPatches : null,
            pressKits: laravel.pressKits ? laravel.pressKits : null,
            cargoManifests: laravel.cargoManifests ? laravel.cargoManifests : null,
            pressConferences: laravel.pressConferences ? laravel.pressConferences : null,
            featuredImages: laravel.featuredImages ? laravel.featuredImages: null,

            firstStageEngines: ['Merlin 1A', 'Merlin 1B', 'Merlin 1C', 'Merlin 1D'],
            upperStageEngines: ['Kestrel', 'Merlin 1C-Vac', 'Merlin 1D-Vac'],
            upperStageStatuses: ['Did not reach orbit', 'Decayed', 'Deorbited', 'Earth Orbit', 'Solar Orbit'],
            spacecraftTypes: ['Dragon 1', 'Dragon 2'],
            returnMethods: ['Splashdown', 'Landing', 'Did Not Return'],
            eventTypes: ['Wet Dress Rehearsal', 'Static Fire'],
            launchIlluminations: ['Day', 'Night', 'Twilight'],
            statuses: ['Upcoming', 'Complete', 'In Progress'],
            outcomes: ['Failure', 'Success']
        };

        $scope.filters = {
            parts: {
                type: ''
            }
        };

        $scope.selected = {
            astronaut: null
        };

        $scope.createMission = function() {
            missionService.create($scope.mission);
        };

        $scope.updateMission = function() {
            missionService.update($scope.mission);
        };

    }]);

    app.factory("Mission", ["PartFlight", "Payload", "SpacecraftFlight", "PrelaunchEvent", "Telemetry", function(PartFlight, Payload, SpacecraftFlight, PrelaunchEvent, Telemetry) {
        return function (mission) {
            if (mission == null) {
                var self = this;

                self.payloads = [];
                self.part_flights = [];
                self.spacecraft_flight = null;
                self.prelaunch_events = [];
                self.telemetry = [];

            } else {
                var self = mission;
            }

            self.addPartFlight = function(part) {
                self.part_flights.push(new PartFlight(part));
            };

            self.removePartFlight = function(part) {
                self.part_flights.splice(self.part_flights.indexOf(part), 1);
            }

            self.addPayload = function() {
                self.payloads.push(new Payload());
            };

            self.removePayload = function(payload) {
                self.payloads.splice(self.payloads.indexOf(payload), 1);
            };

            self.addSpacecraftFlight = function(spacecraft) {
                self.spacecraft_flight = new SpacecraftFlight(spacecraft);
            };

            self.removeSpacecraftFlight = function() {
                self.spacecraft_flight = null;
            };

            self.addPrelaunchEvent = function() {
                self.prelaunch_events.push(new PrelaunchEvent());
            };

            self.removePrelaunchEvent = function(prelaunchEvent) {
                self.prelaunch_events.splice(self.prelaunch_events.indexOf(prelaunchEvent), 1);
            };

            self.addTelemetry = function() {
                self.telemetry.push(new Telemetry());
            };

            self.removeTelemetry = function(telemetry) {
                self.telemetry.splice(self.telemetry.indexOf(telemetry), 1);
            };

            return self;
        }
    }]);

    app.factory("Payload", function() {
        return function() {
            var self = {

            };
            return self;
        }
    });

    app.factory("PartFlight", ["Part", function(Part) {
        return function(type, part) {
            var self = this;

            self.part = new Part(type, part);

            return self;
        }
    }]);

    app.factory("Part", function() {
        return function(type, part) {

            if (typeof part === 'undefined') {
                var self = this
                self.type = type;
            } else {
                var self = part;
            }

            return self;
        }
    });

    app.factory("SpacecraftFlight", ["Spacecraft", "AstronautFlight", function(Spacecraft, AstronautFlight) {
        return function(spacecraft) {
            var self = this;

            self.spacecraft = new Spacecraft(spacecraft);

            self.astronaut_flights = [];

            self.addAstronautFlight = function(astronaut) {
                self.astronaut_flights.push(new AstronautFlight(astronaut));
            };

            self.removeAstronautFlight = function(astronautFlight) {
                self.astronaut_flights.splice(self.astronaut_flights.indexOf(astronautFlight), 1);
            };

            return self;
        }
    }]);

    app.factory("Spacecraft", function() {
        return function(spacecraft) {
            if (spacecraft == null) {
                var self = this;
            } else {
                var self = spacecraft;
            }
            return self;
        }
    });

    app.factory("AstronautFlight", ["Astronaut", function(Astronaut) {
        return function(astronaut) {
            var self = this;

            self.astronaut = new Astronaut(astronaut);

            return self;
        }
    }]);

    app.factory("Astronaut", function() {
        return function (astronaut) {
            if (astronaut == null) {
                var self = this;
            } else {
                var self = astronaut;
            }
            return self;
        }
    });

    app.factory("PrelaunchEvent", function() {
        return function (prelaunchEvent) {

            var self = prelaunchEvent;

            return self;
        }
    });

    app.factory("Telemetry", function() {
        return function (telemetry) {

            var self = telemetry;

            return self;
        }
    });

    app.service("missionService", ["$http", "CSRF_TOKEN",
        function($http, CSRF_TOKEN) {
            this.create = function (mission) {
                $http.post('/missions/create', {
                    mission: mission,
                    _token: CSRF_TOKEN
                }).then(function (response) {
                    window.location = '/missions/' + response.data;
                });
            };

            this.update = function (mission) {
                $http.patch('/missions/' + mission.slug + '/edit', {
                    mission: mission,
                    _token: CSRF_TOKEN
                }).then(function (response) {
                    window.location = '/missions/' + response.data;
                });
            };
        }
    ]);
})();
(function() {
    var aboutMissionControlApp = angular.module('app', ['credit-cards']);

    aboutMissionControlApp.controller("subscriptionController", ["$scope", "subscriptionService", function($scope, subscriptionService) {
        $scope.subscriptionButtonText = "Pay $9";
        $scope.subscriptionState = {
            isLooking: true,
            isEnteringDetails: false,
            isSubscribing: false,
            hasSubscribed: false,
            failed: false
        };

        $scope.subscription = {
            showSubscribeForm: function() {
                $scope.subscriptionState.isLooking = false;
                $scope.subscriptionState.isEnteringDetails = true;
            },
            subscribe: function($event) {
                $scope.subscriptionState.isEnteringDetails =  $scope.subscriptionState.failed = false;
                $scope.subscriptionState.isSubscribing = true;
                $scope.subscriptionButtonText = "You're awesome";

                var form = $('form[name="subscribeForm"]');
                Stripe.card.createToken(form, $scope.subscription.stripeResponseHandler);
            },
            stripeResponseHandler: function(stripeStatus, stripeResponse) {

                if (stripeResponse.error) {
                    $scope.subscriptionState.isSubscribing = false;
                    $scope.subscriptionState.isEnteringDetails = $scope.subscriptionState.failed = true;
                } else {
                    // Fetch the token from Stripe's response.
                    var token = stripeResponse.id;

                    // Subscribe
                    subscriptionService.subscribe(token).then(function() {
                        // Success!
                        $scope.subscriptionState.isSubscribing = false;
                        $scope.subscriptionState.hasSubscribed = true;
                    });
                }

                $scope.$apply();
            }
        };
    }]);

    aboutMissionControlApp.controller('aboutController', ["$scope", function($scope) {

    }]);

    aboutMissionControlApp.service("subscriptionService", ["$http", function($http) {
        this.subscribe = function(token) {
            return $http.post('/missioncontrol/payments/subscribe', { creditCardToken: token });
        };
    }]);

    aboutMissionControlApp.service("aboutMissionControlService", ["$http", function($http) {
    }]);
})();

(function() {
    var dataViewApp = angular.module('app', []);

    dataViewApp.controller('dataViewController', ['DataView', 'dataViewService', '$scope', '$http', function(DataView, dataViewService, $scope, $http) {
        $scope.newDataView = new DataView();
        $scope.dataViews = [];

        $scope.create = function(dataViewToCreate) {
            dataViewService.create(dataViewToCreate).then(function(response) {
                $scope.newDataView = new DataView();
            });
        };

        $scope.edit = function(dataViewToEdit) {
            dataViewService.edit(dataViewToEdit).then(function(response) {

            });
        };

        (function() {
            $scope.data = {
                bannerImages: laravel.bannerImages
            };

            laravel.dataViews.forEach(function(dataView) {
                $scope.dataViews.push(new DataView(dataView));
            });
        })();
    }]);

    dataViewApp.service('dataViewService', ["$http", function($http) {
        this.testQuery = function(query) {
            var encodedQuery = encodeURIComponent(query);
            return $http.get('/missioncontrol/dataviews/testquery?q=' + encodedQuery);
        };

        this.create = function(data) {
            return $http.post('/missioncontrol/dataviews/create',{ dataView: data });
        };

        this.edit = function(data) {
            return $http.post('/missioncontrol/dataviews/' + data.dataview_id + '/edit', { dataView: data });
        };
    }]);

    dataViewApp.factory('DataView', ['dataViewService', function(dataViewService) {
        return function(dataView) {

            if (typeof dataView === 'undefined') {
                var self = this
            } else {
                var self = dataView;
            }

            if (typeof dataView === 'undefined') {
                self.column_titles = [];
            }

            self.addTitle = function(newTitle) {
                if (typeof newTitle !== 'undefined' && newTitle != "") {
                    self.column_titles.push(newTitle);
                    self.newTitle = undefined;
                }
            };

            self.deleteTitle = function() {

            };

            self.testQuery = function() {
                dataViewService.testQuery(self.query).then(function(response) {
                    self.testQueryOutput = response.data;
                });
            }
        }
    }]);

})();
(function() {
    var app = angular.module('app', []);

    app.controller('pastMissionController', ["$scope", "missionService", "telemetryPlotCreator", "ephemerisPlotCreator", function($scope, missionService, telemetryPlotCreator, ephemerisPlotCreator) {
        $scope.mission = laravel.mission;

        (function() {
            missionService.telemetry($scope.mission.slug).then(function(response) {
                $scope.telemetryPlots = {
                    altitudeVsTime:         telemetryPlotCreator.altitudeVsTime(response.data),
                    altitudeVsDownrange:    telemetryPlotCreator.altitudeVsDownrange(response.data),
                    velocityVsTime:         telemetryPlotCreator.velocityVsTime(response.data),
                    downrangeVsTime:        telemetryPlotCreator.downrangeVsTime(response.data)
                }
            });
            missionService.orbitalElements($scope.mission.slug).then(function(response) {
                $scope.orbitalPlots = {
                    apogeeVsTime:           ephemerisPlotCreator.apogeeVsTime(response.data),
                    perigeeVsTime:          ephemerisPlotCreator.perigeeVsTime(response.data)
                }
            });
        })();
    }]);

    app.service('telemetryPlotCreator', [function() {
        this.altitudeVsTime = function(telemetryCollection) {
            return {
                data: telemetryCollection.filter(function(telemetry) {
                    return telemetry.altitude != null;
                }).map(function(telemetry) {
                    return { timestamp: telemetry.timestamp, altitude: telemetry.altitude };
                }),
                settings: {
                    extrapolation: true,
                    interpolation: 'cardinal',
                    xAxis: {
                        type: 'linear',
                        key: 'timestamp',
                        title: 'Time (T+s)'
                    },
                    yAxis: {
                        type: 'linear',
                        key: 'altitude',
                        title: 'Altitude (km)',
                        formatter: function(d) {
                            return d / 1000;
                        }
                    },
                    chartTitle: 'Altitude vs. Time'
                }
            }
        };

        this.altitudeVsDownrange = function(telemetryCollection) {
            return {
                data: telemetryCollection.filter(function(telemetry) {
                    return (telemetry.downrange != null && telemetry.altitude != null);
                }).map(function(telemetry) {
                    return { downrange: telemetry.downrange, altitude: telemetry.altitude };
                }),
                settings: {
                    extrapolation: true,
                    interpolation: 'cardinal',
                    xAxis: {
                        type: 'linear',
                        key: 'downrange',
                        title: 'Downrange Distance (km)',
                        formatter: function(d) {
                            return d / 1000;
                        }
                    },
                    yAxis: {
                        type: 'linear',
                        key: 'altitude',
                        title: 'Altitude (km)',
                        formatter: function(d) {
                            return d / 1000;
                        }
                    },
                    chartTitle: 'Altitude vs. Downrange Distance'
                }
            }
        };

        this.velocityVsTime = function(telemetryCollection) {
            return {
                data: telemetryCollection.filter(function(telemetry) {
                    return telemetry.velocity != null;
                }).map(function(telemetry) {
                    return { timestamp: telemetry.timestamp, velocity: telemetry.velocity };
                }),
                settings: {
                    extrapolation: true,
                    interpolation: 'cardinal',
                    xAxis: {
                        type: 'linear',
                        key: 'timestamp',
                        title: 'Time (T+s)'
                    },
                    yAxis: {
                        type: 'linear',
                        key: 'velocity',
                        title: 'Velocity (m/s)'
                    },
                    chartTitle: 'Velocity vs. Time'
                }
            }
        };

        this.downrangeVsTime = function(telemetryCollection) {
            return {
                data: telemetryCollection.filter(function(telemetry) {
                    return telemetry.downrange != null;
                }).map(function(telemetry) {
                    return { timestamp: telemetry.timestamp, downrange: telemetry.downrange };
                }),
                settings: {
                    extrapolation: true,
                    interpolation: 'cardinal',
                    xAxis: {
                        type: 'linear',
                        key: 'timestamp',
                        title: 'Time (T+s)'
                    },
                    yAxis: {
                        type: 'linear',
                        key: 'downrange',
                        title: 'Downrange Distance (km)',
                        formatter: function(d) {
                            return d / 1000;
                        }
                    },
                    chartTitle: 'Downrange Distance vs. Time'
                }
            }
        };
    }]);

    app.service('ephemerisPlotCreator', [function() {
        this.apogeeVsTime = function(orbitalElements) {
            return {
                data: orbitalElements.map(function(orbitalElement) {
                        return {
                            timestamp: moment(orbitalElement.epoch).toDate(),
                            apogee: orbitalElement.apogee
                        };
                }),
                settings: {
                    extrapolation: false,
                    interpolation: 'linear',
                    xAxis: {
                        type: 'timescale',
                        key: 'timestamp',
                        title: 'Epoch Date',
                        formatter: function(d) {
                            return moment(d).format('MMM D, YYYY');
                        }
                    },
                    yAxis: {
                        type: 'linear',
                        key: 'apogee',
                        title: 'Apogee (km)',
                        formatter: function(d) {
                            return Math.round(d * 10) / 10; // Round to 1dp
                        }
                    },
                    chartTitle: 'Apogee (km) vs. Time'
                }
            }
        };

        this.perigeeVsTime = function(orbitalElements) {
            return {
                data: orbitalElements.map(function(orbitalElement) {
                    return {
                        timestamp: moment(orbitalElement.epoch).toDate(),
                        perigee: orbitalElement.perigee
                    };
                }),
                settings: {
                    extrapolation: false,
                    interpolation: 'linear',
                    xAxis: {
                        type: 'timescale',
                        key: 'timestamp',
                        title: 'Epoch Date',
                        formatter: function(d) {
                            return moment(d).format('MMM D, YYYY');
                        }
                    },
                    yAxis: {
                        type: 'linear',
                        key: 'perigee',
                        title: 'Perigee (km)',
                        formatter: function(d) {
                            return Math.round(d * 10) / 10; // Round to 1dp
                        }
                    },
                    chartTitle: 'Perigee (km) vs. Time'
                }
            }
        };
    }]);

    app.service('missionService', ["$http", function($http) {
        this.telemetry = function(name) {
            return $http.get('/missions/'+ name + '/telemetry');
        };

        this.orbitalElements = function(name) {
            return $http.get('/missions/' + name + '/orbitalelements');
        };
    }]);
})();
(function() {
    var editObjectApp = angular.module('app', []);

    editObjectApp.controller("editObjectController", ["$scope", "editObjectService", function($scope, editObjectService) {

        $scope.edit = function() {
            editObjectService.edit($scope.object, $scope.metadata);
        };

        $scope.revert = function() {
            editObjectService.revert($scope.object, $scope.selectedRevision);
        };

        (function() {
            $scope.object = laravel.object;
            $scope.revisions = laravel.revisions;
        })();
    }]);

    editObjectApp.service("editObjectService", ["$http", function($http) {
        this.edit = function(object, metadata) {
            return $http.patch('/missioncontrol/objects/' + object.object_id + '/edit', {
                metadata: metadata,
                object: object
            }).then(function(response) {
                window.location.href = '/missioncontrol/objects/' + object.object_id;
            });
        };

        this.revert = function(object, revertTo) {
            return $http.patch('/missioncontrol/objects/' + object.object_id + '/revert/' + revertTo.object_revision_id).then(function(response) {
                window.location.href = '/missioncontrol/objects/' + object.object_id;
            });
        };

        this.addToCollection = function(object, collection) {

        };
    }]);
})();
(function() {
    var app = angular.module('app', ['duScroll', 'ngAnimate']);

    app.controller("homeController", ['$scope', '$rootScope', '$document', '$window', 'Statistic', function($scope, $rootScope, $document, $window, Statistic) {
        $scope.statistics = [];
        $scope.activeStatistic = null;

        $scope.goToClickedStatistic = function(statistic) {
            $scope.scrollToAndMakeActive(statistic);
        };

        $scope.goToFirstStatistic = function() {
            $scope.scrollToAndMakeActive($scope.statistics[0]);
        };

        $scope.goToNeighborStatistic = function(index) {
            if (index >= 0 && index < $scope.statistics.length) {
                $scope.scrollToAndMakeActive($scope.statistics[index]);
                return $scope.activeStatistic.camelCaseType;

            } else {
                $scope.goHome();
            }
        };

        $scope.goHome = function() {
            $scope.scrollToAndMakeActive(null, true);
        };

        $scope.keypress = function(event) {
            // Currently using jQuery.event.which to detect keypresses, keyCode is deprecated, use KeyboardEvent.key eventually:
            // https://developer.mozilla.org/en-US/docs/Web/API/KeyboardEvent/key

            // event.key == down
            if (event.which == 40) {
                if ($scope.activeStatistic == null) {
                    $scope.goToFirstStatistic();

                } else if ($scope.activeStatistic == $scope.statistics[$scope.statistics.length - 1]) {
                    $scope.goHome();

                } else {
                    $scope.scrollToAndMakeActive($scope.statistics[$scope.statistics.indexOf($scope.activeStatistic) + 1]);
                }
            }

            // event.key == up
            else if (event.which == 38) {
                if ($scope.activeStatistic == null) {
                    $scope.scrollToAndMakeActive($scope.statistics[$scope.statistics.length - 1]);

                } else if ($scope.activeStatistic == $scope.statistics[0]) {
                    $scope.goHome();

                } else {
                    $scope.scrollToAndMakeActive($scope.statistics[$scope.statistics.indexOf($scope.activeStatistic) - 1]);
                }
            }

            // event.key == left
            else if (event.which == 37) {
                if ($scope.activeStatistic == null) {
                    return;
                }

                if ($scope.activeStatistic.activeSubstatistic == $scope.activeStatistic.substatistics[0]) {
                    $scope.activeStatistic.changeSubstatistic($scope.activeStatistic.substatistics[$scope.activeStatistic.substatistics.length - 1]);

                } else {
                    $scope.activeStatistic.changeSubstatistic($scope.activeStatistic.substatistics[$scope.activeStatistic.substatistics.indexOf($scope.activeStatistic.activeSubstatistic) - 1]);
                }
            }

            else if (event.which == 39) {
                if ($scope.activeStatistic == null) {
                    return;
                }

                if ($scope.activeStatistic.activeSubstatistic == $scope.activeStatistic.substatistics[$scope.activeStatistic.substatistics.length - 1]) {
                    $scope.activeStatistic.changeSubstatistic($scope.activeStatistic.substatistics[0]);

                } else {
                    $scope.activeStatistic.changeSubstatistic($scope.activeStatistic.substatistics[$scope.activeStatistic.substatistics.indexOf($scope.activeStatistic.activeSubstatistic) + 1]);
                }
            }

        };

        $scope.scrollToAndMakeActive = function(statistic, setToDefault) {
            if (setToDefault === true) {
                history.replaceState('', document.title, window.location.pathname);
                $scope.activeStatistic = null;
                $document.scrollToElement(angular.element(document.getElementById('home')), 0, 1000);;
            } else {
                $scope.activeStatistic = statistic;
                $document.scrollToElement(angular.element(document.getElementById(statistic.camelCaseType)), 0, 1000);
            }

            return $scope.activeStatistic;
        };

        $rootScope.$on('duScrollspy:becameActive', function($event, $element, $target) {
            if ($element.prop('id') == 'home') {
                history.replaceState('', document.title, window.location.pathname);
                $scope.activeStatistic = null;
            } else {
                $scope.activeStatistic = $scope.statistics.filter(function(statistic) {
                    return statistic.camelCaseType == $element.prop('id');
                })[0];
                history.replaceState('', document.title, '#' + $scope.activeStatistic.camelCaseType);
            }
        });

        (function() {
            laravel.statistics.forEach(function(statistic) {
                $scope.statistics.push(new Statistic(statistic));
            });

            // If a hash exists, preset it
            if (window.location.hash) {
                $scope.activeStatistic = $scope.statistics.filter(function(statistic) {
                    return statistic.camelCaseType == window.location.hash.substring(1);
                })[0];
            }
        })();
    }]);

    app.factory('Statistic', ["$timeout", function($timeout) {
        return function(statistic) {

            var self = {};

            self.show = true;

            self.changeSubstatistic = function(newSubstatistic) {
                self.show = false;

                $timeout(function () {
                    self.activeSubstatistic = newSubstatistic;
                    self.show = true;
                }, 300);
            };

            statistic.forEach(function(substatistic) {

                if (!self.substatistics) {

                    self.substatistics = [];
                    self.activeSubstatistic = substatistic;
                    self.type = substatistic.type;
                    self.camelCaseType = self.type.replace(/\W/g, "");
                }

                self.substatistics.push(substatistic);
            });

            return self;
        }
    }]);
})();
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

(function() {
    var liveApp = angular.module('app', []);

    liveApp.controller('liveController', ["$scope", "liveService", "Section", "Resource", "Update", function($scope, liveService, Section, Resource, Update) {
        var socket = io('http://spacexstats.app:3000');

        $scope.auth = laravel.auth;
        $scope.isActive = laravel.isActive;

        $scope.data = {
            upcomingMission: laravel.mission
        };

        $scope.updates = laravel.updates.map(function(update) {
            return new Update(update);
        });

        $scope.settings = {
            isGettingStarted: laravel.isActive == true ? null : false,
            getStartedHeroText: 'You are the launch controller.',
            getStarted: function() {
                this.isGettingStarted = true;
                this.getStartedHeroText = 'Awesome. We just need a bit of info first.'
            },
            isCreating: false,
            turnOnSpaceXStatsLive: function() {
                $scope.settings.isCreating = true;
                liveService.create($scope.liveParameters).then(function() {
                    $scope.settings.isCreating = false;
                    $scope.isActive = true;
                    $scope.settings.isGettingStarted = false;
                });
            },
            turnOffSpaceXStatsLive: function() {
                liveService.destroy().then(function() {
                    $scope.isActive = $scope.auth = false;
                });
            },
            toggleForLaunch: function() {
                if ($scope.liveParameters.isForLaunch) {
                    $scope.liveParameters.reddit.title = '/r/SpaceX ' + $scope.data.upcomingMission.name + ' Official Launch Discussion & Updates Thread';
                    $scope.liveParameters.title = $scope.data.upcomingMission.name;
                } else {
                    $scope.liveParameters.title = $scope.liveParameters.reddit.title = null;
                }
            },
            isEditingSettings: false,
            addSection: function() {
                if (!$scope.liveParameters.sections) {
                    $scope.liveParameters.sections = [];
                }
                $scope.liveParameters.sections.push(new Section({}));
            },
            removeSection: function(section) {
                $scope.liveParameters.sections.splice($scope.liveParameters.sections.indexOf(section), 1);
            },
            addResource: function() {
                if (!$scope.liveParameters.resources) {
                    $scope.liveParameters.resources = [];
                }
                $scope.liveParameters.resources.push(new Resource({}));
            },
            removeResource: function(resource) {
                $scope.liveParameters.resources.splice($scope.liveParameters.resources.indexOf(resource), 1);
            },
            updateSettings: function() {
                liveService.updateSettings($scope.liveParameters).then(function(response) {
                    $scope.settings.isEditingSettings = false;
                });
            }
        };

        $scope.liveParameters = {
            isForLaunch: true,
            title: laravel.title ? laravel.title : $scope.data.upcomingMission.name,
            reddit: {
                title: laravel.reddit.title ? laravel.reddit.title : '/r/SpaceX ' + $scope.data.upcomingMission.name + ' Official Launch Discussion & Updates Thread',
                thing: laravel.reddit.thing ? laravel.reddit.thing : null,
            },
            pageTitle: function() {
                if (!$scope.settings.isActive) {
                    return 'SpaceXStats Live';
                } else {
                    return 'countdown here';
                }
            },
            countdownTo: $scope.data.upcomingMission.launch_date_time,
            isCountdownPaused: false,
            streamingSources: {
                nasa: false,
                spacex: false
            },
            selectedStreamingSource: 'none',
            description: laravel.description,
            sections: laravel.sections ? laravel.sections : [],
            resources: laravel.resources ? laravel.resources : []
        };

        $scope.send = {
            new: {
                message: null,
                messageType: 'update'
            },
            /*
             * Send a launch update (message) via POST off to the server to be broadcast to everyone else
             */
            message: function(form) {

                // Send the message
                liveService.sendMessage({
                    message: $scope.send.new.message,
                    messageType: $scope.send.new.messageType
                });

                // Reset the form
                $scope.send.new.message = "";
                form.$setUntouched();
            }
        };

        $scope.buttons = {
            cannedResponses: {
                holdAbort: laravel.cannedResponses ? laravel.cannedResponses.holdAbort : null,
                tMinusTen: laravel.cannedResponses ? laravel.cannedResponses.tMinusTen : null,
                liftoff: laravel.cannedResponses ? laravel.cannedResponses.liftoff : null,
                maxQ: laravel.cannedResponses ? laravel.cannedResponses.maxQ : null,
                meco: laravel.cannedResponses ? laravel.cannedResponses.meco : null,
                stageSep: laravel.cannedResponses ? laravel.cannedResponses.stageSep : null,
                mVacIgnition: laravel.cannedResponses ? laravel.cannedResponses.mVacIgnition : null,
                seco: laravel.cannedResponses ? laravel.cannedResponses.seco : null,
                missionSuccess: laravel.cannedResponses ? laravel.cannedResponses.missionSuccess : null,
                missionFailure: laravel.cannedResponses ? laravel.cannedResponses.missionFailure : null
            },
            click: function(messageType) {

            },
            isDisabled: function(messageType) {
                return true;
            },
            isVisible: function(messageType) {
                return true;
            },
            updateCannedResponses: function() {

            }
        };

        // Websocket listeners
        socket.on('live-updates:SpaceXStats\\Events\\Live\\LiveStartedEvent', function(data) {
            $scope.isActive = true;
            $scope.liveParameters.sections = data.data.sections;
            $scope.liveParameters.resources = data.data.resources;
            $scope.liveParameters.title = data.data.title;
            $scope.$apply();
        });

        socket.on('live-updates:SpaceXStats\\Events\\Live\\LiveUpdateCreatedEvent', function(data) {
            $scope.updates.push(new Update(data.liveUpdate));
            $scope.$apply();
        });

        socket.on('live-updates:SpaceXStats\\Events\\Live\\LiveUpdateUpdatedEvent', function(data) {
            var indexOfUpdate = $scope.updates.indexOf($scope.updates.filter(function(update) {
                return update.id == data.liveUpdate.id;
            }).shift());

            $scope.updates[indexOfUpdate] = new Update(data.liveUpdate);
            $scope.$apply();
        });

        socket.on('live-updates:SpaceXStats\\Events\\Live\\LiveEndedEvent', function(data) {
            $scope.isActive = false;
            $scope.$apply();
        });
    }]);

    liveApp.service('liveService', ["$http", function($http) {

        this.sendMessage = function(message) {
            return $http.post('/live/send/message', message);
        };

        this.editMessage = function(message) {
            return $http.patch('/live/send/message', message);
        };

        this.updateSettings = function(settings) {
            return $http.post('/live/send/settings', settings);
        };

        this.updateCannedResponses = function(cannedResponses) {
            return $http.patch('/live/sent/cannedresponses', cannedResponses);
        };

        this.create = function(createThreadParameters) {
            return $http.post('/live/send/create', createThreadParameters);
        };

        this.destroy = function() {
            return $http.delete('/live/send/destroy');
        };
    }]);

    liveApp.factory('Update', ['liveService', function(liveService) {
        return function(update) {
            var self = update;

            self.isEditFormVisible = false;
            self.isEditButtonDisabled = false;

            self.edit = function() {
                self.isEditButtonDisabled = true;
                liveService.editMessage(self).then(function() {
                    self.isEditFormVisible = self.isEditButtonDisabled = false;
                });
            };

            return self;
        }
    }]);

    liveApp.factory('Resource', function() {
        return function() {
            this.title = null;
            this.url = null;
            this.courtesy = null;
        }
    });

    liveApp.factory('Section', function() {
        return function() {
            this.title = null;
            this.content = null;
        }
    });
})();
(function() {
    var userApp = angular.module('app', []);

    userApp.controller("editUserController", ['$http', '$scope', 'editUserService', 'flashMessage', function($http, $scope, editUserService, flashMessage) {
        $scope.isUpdating = {
            profile: false,
            emailNotifications: false,
            SMSNotifications: false
        };

        $scope.username = laravel.user.username;

        $scope.missions = laravel.missions;

        $scope.patches = laravel.patches;

        $scope.profile = {
            summary: laravel.user.profile.summary,
            twitter_account: laravel.user.profile.twitter_account,
            reddit_account: laravel.user.profile.reddit_account,
            favorite_quote: laravel.user.profile.favorite_quote,
            favorite_mission: laravel.user.profile.favorite_mission,
            favorite_patch: laravel.user.profile.favorite_patch
        };

        $scope.updateProfile = function() {
            $scope.isUpdating.profile = true;
            $http.patch('/users/' + $scope.username + '/edit', $scope.profile)
                .then(function(response) {
                    window.location = '/users/' + $scope.username;
                });
        };

        $scope.emailNotifications = {
            LaunchChange: laravel.notifications.LaunchChange,
            NewMission: laravel.notifications.NewMission,
            TMinus24HoursEmail: laravel.notifications.TMinus24HoursEmail,
            TMinus3HoursEmail: laravel.notifications.TMinus3HoursEmail,
            TMinus1HourEmail: laravel.notifications.TMinus1HourEmail,
            NewsSummaries: laravel.notifications.NewsSummaries
        };

        $scope.updateEmailNotifications = function() {
            $scope.isUpdating.emailNotifications = true;
            editUserService.updateEmails($scope.username, $scope.emailNotifications).then(function() {
                $scope.isUpdating.emailNotifications = false;
            });
        };

        $scope.SMSNotification = {
            mobile: laravel.user.mobile
        };

        if (laravel.notifications.TMinus24HoursSMS === true) {
            $scope.SMSNotification.status = "TMinus24HoursSMS";
        } else if (laravel.notifications.TMinus3HoursSMS === true) {
            $scope.SMSNotification.status = "TMinus3HoursSMS";
        } else if (laravel.notifications.TMinus1HourSMS === true) {
            $scope.SMSNotification.status = "TMinus1HourSMS";
        } else {
            $scope.SMSNotification.status = "false";
        }

        $scope.updateSMSNotifications = function() {
            $scope.isUpdating.SMSNotifications = true;
            editUserService.updateSMS($scope.username, $scope.SMSNotification).then(function() {
                $scope.isUpdating.SMSNotifications = false;
            });
        }

    }]);

    userApp.service('editUserService', ["$http", "flashMessage", function($http, flashMessage) {
        this.updateSMS = function(username, notification) {
            return $http.patch('/users/' + username + '/edit/smsnotifications',

                { 'SMSNotification': notification }

            ).then(function(response) {
                return flashMessage.addOK(response.data);
            }, function(response) {
                return flashMessage.addError(response.data);
            });
        };

        this.updateEmails = function(username, notification) {
            return $http.patch('/users/' + username + '/edit/emailnotifications',

                { 'emailNotifications': notification }

            ).then(function(response) {
                return flashMessage.addOK(response.data);
            }, function(response) {
                return flashMessage.addError(response.data);
            });
        };

        this.updateProfile = function() {

        };
    }]);

})();
(function() {
    var signUpApp = angular.module('app', []);

    signUpApp.controller("signUpController", ["$scope", "signUpService", "flashMessage", function($scope, signUpService, flashMessage) {
        $scope.hasSignedUp = false;
        $scope.isSigningUp = false;
        $scope.signUpButtonText = "Sign Up";

        $scope.signUp = function() {
            $scope.isSigningUp = true;
            $scope.signUpButtonText = "Signing Up...";

            signUpService.go($scope.user).then(function(response) {
                $scope.hasSignedUp = true;
                $scope.isSigningUp = false;
            }, function() {
                // Otherwise show error
                $scope.isSigningUp = false;
                $scope.signUpButtonText = "Sign Up";
                flashMessage.addError('Your account could not be created. Please contact us.');
            });
        }
    }]);

    signUpApp.service("signUpService", ["$http", function($http) {
        this.go = function(credentials) {
            return $http.post('/auth/signup', credentials);
        };
    }]);
})();
(function() {
    var app = angular.module('app', []);

    app.service('flashMessage', function() {
        this.addOK = function(message) {

            $('<p style="display:none;" class="flash-message success">' + message + '</p>').appendTo('#flash-message-container').slideDown(300);

            setTimeout(function() {
                $('.flash-message').slideUp(300, function() {
                    $(this).remove();
                });
            }, 3000);
        };

        this.addError = function(message) {
            $('<p style="display:none;" class="flash-message failure">' + message + '</p>').appendTo('#flash-message-container').slideDown(300);

            setTimeout(function() {
                $('.flash-message').slideUp(300, function() {
                    $(this).remove();
                });
            }, 3000);
        }
    });
})();


// Original jQuery countdown timer written by /u/EchoLogic, improved and optimized by /u/booOfBorg.
// Rewritten as an Angular directive for SpaceXStats 4
(function() {
    var app = angular.module('app');

    app.directive('countdown', ['$interval', function($interval) {
        return {
            restrict: 'E',
            scope: {
                specificity: '=',
                countdownTo: '=',
                isPaused: '=',
                type: '@',
                callback: '&?'
            },
            link: function($scope, elem, attrs) {

                $scope.isLaunchExact = ($scope.specificity == 6 || $scope.specificity == 7);

                $scope.$watch('specificity', function(newValue) {
                    $scope.isLaunchExact = (newValue == 6 || newValue == 7);
                });

                var countdownProcessor = function() {

                    var launchUnixSeconds = $scope.launchUnixSeconds;
                    var currentUnixSeconds = Math.floor(Date.now() / 1000);

                    // Countdown
                    if (launchUnixSeconds >= currentUnixSeconds) {
                        $scope.secondsAwayFromLaunch = launchUnixSeconds - currentUnixSeconds;
                    // Countup
                    } else {
                        $scope.secondsAwayFromLaunch = currentUnixSeconds - launchUnixSeconds;
                    }

                    var secondsBetween = $scope.secondsAwayFromLaunch;
                    // Calculate the number of days, hours, minutes, seconds
                    $scope.days = Math.floor(secondsBetween / (60 * 60 * 24));
                    secondsBetween -= $scope.days * 60 * 60 * 24;

                    $scope.hours = Math.floor(secondsBetween / (60 * 60));
                    secondsBetween -= $scope.hours * 60 * 60;

                    $scope.minutes = Math.floor(secondsBetween / 60);
                    secondsBetween -= $scope.minutes * 60;

                    $scope.seconds = secondsBetween;

                    $scope.daysText = $scope.days == 1 ? 'Day' : 'Days';
                    $scope.hoursText = $scope.hours == 1 ? 'Hour' : 'Hours';
                    $scope.minutesText = $scope.minutes == 1 ? 'Minute' : 'Minutes';
                    $scope.secondsText = $scope.seconds == 1 ? 'Second' : 'Seconds';

                    if (attrs.callback) {
                        $scope.callback();
                    }
                };

                // Countdown here
                if ($scope.isLaunchExact) {
                    $scope.launchUnixSeconds = moment($scope.countdownTo).unix();
                    $interval(countdownProcessor, 1000);
                } else {
                    $scope.countdownText = $scope.countdownTo;
                }
            },
            templateUrl: '/js/templates/countdown.html'
        }
    }]);
})();
(function() {
    var app = angular.module('app');

    app.directive('missionCard', function() {
        return {
            restrict: 'E',
            replace: true,
            scope: {
                size: '@',
                mission: '='
            },
            link: function($scope) {
            },
            templateUrl: '/js/templates/missionCard.html'
        }
    });
})();
(function() {
    var app = angular.module('app');

    app.directive('upload', ['$parse', function($parse) {
        return {
            restrict: 'A',
            link: function($scope, element, attrs) {

                // Initialize the dropzone
                var dropzone = new Dropzone(element[0], {
                    url: attrs.action,
                    autoProcessQueue: false,
                    dictDefaultMessage: "Upload files here!",
                    maxFilesize: 1024, // MB
                    addRemoveLinks: true,
                    uploadMultiple: attrs.multiUpload,
                    parallelUploads: 5,
                    maxFiles: 5,
                    successmultiple: function(dropzoneStatus, files) {

                        $scope.files = files.objects;

                        // Run a callback function with the files passed through as a parameter
                        if (typeof attrs.callback !== 'undefined' && attrs.callback !== "") {
                            var func = $parse(attrs.callback);
                            func($scope, { files: files });
                        }
                    },
                    error: function() {
                        $scope.isUploading = false;
                    }
                });

                dropzone.on("addedfile", function(file) {
                    ++$scope.queuedFiles;
                    $scope.$apply();
                });

                dropzone.on("removedfile", function(file) {
                    --$scope.queuedFiles;
                    $scope.$apply();
                });

                // upload the files
                $scope.uploadFiles = function() {
                    $scope.isUploading = true;
                    dropzone.processQueue();
                }
            }
        }
    }]);
})();
(function() {
    var app = angular.module('app');

    app.directive('datetime', function() {
        return {
            require: 'ngModel',
            restrict: 'E',
            scope: {
                type: '@',
                datetimevalue: '=ngModel',
                startYear: '@',
                nullableToggle: '@?',
                isNull: '=',
                disabled: '=?ngDisabled'
            },
            link: function($scope, element, attrs, ngModelController) {

                $scope.days = [];
                $scope.days.push({ value: 0, display: '-'});

                for (i = 1; i <= 31; i++) {
                    $scope.days.push({ value: i, display: i });
                }

                $scope.months = [
                    { value: 0, display: '-'},
                    { value: 1, display: 'January'},
                    { value: 2, display: 'February'},
                    { value: 3, display: 'March'},
                    { value: 4, display: 'April'},
                    { value: 5, display: 'May'},
                    { value: 6, display: 'June'},
                    { value: 7, display: 'July'},
                    { value: 8, display: 'August'},
                    { value: 9, display: 'September'},
                    { value: 10, display: 'October'},
                    { value: 11, display: 'November'},
                    { value: 12, display: 'December'}
                ];

                $scope.years = function() {
                    var years = [];

                    var currentYear = moment().year();

                    if (typeof $scope.startYear !== 'undefined') {
                        var startYear = $scope.startYear;
                    } else {
                        var startYear = 1950;
                    }

                    while (currentYear >= startYear) {
                        years.push(currentYear);
                        currentYear--;
                    }
                    return years;
                };

                //convert data from view format to model format
                ngModelController.$parsers.push(function(viewvalue) {

                    if ($scope.isNull == true) {
                        return null;
                    }

                    if (typeof data !== 'undefined' && moment(viewvalue).isValid()) {

                        if ($scope.type == 'datetime') {
                            var value = moment({
                                year: viewvalue.year,
                                month: viewvalue.month - 1,
                                date: viewvalue.date,
                                hour: viewvalue.hour,
                                minute: viewvalue.minute,
                                second: viewvalue.second
                            }).format('YYYY-MM-DD HH:mm:ss');

                        } else if ($scope.type == 'date') {
                            var value = moment({
                                year: viewvalue.year,
                                month: viewvalue.month - 1,
                                date: viewvalue.date
                            }).format('YYYY-MM-DD');
                        }
                    } else {

                        if ($scope.type == 'datetime') {
                            var value = viewvalue.year + "-"
                                + ("0" + viewvalue.month).slice(-2) + "-"
                                + ("0" + viewvalue.date).slice(-2) + " "
                                + ("0" + viewvalue.hour).slice(-2) + ":"
                                + ("0" + viewvalue.minute).slice(-2) + ":"
                                + ("0" + viewvalue.second).slice(-2);

                        } else {
                            var value = viewvalue.year + "-"
                                + ("0" + viewvalue.month).slice(-2) + "-"
                                + ("0" + viewvalue.date).slice(-2);
                        }
                    }
                    return value;
                });

                //convert data from model format to view format
                ngModelController.$formatters.push(function(data) {

                    // If the value is not undefined and the value is valid,
                    if (typeof data !== 'undefined' && moment(data).isValid()) {

                        var dt = moment(data);

                        if ($scope.type == 'datetime') {
                            return {
                                year: dt.year(),
                                month: dt.month() + 1,
                                date: dt.date(),
                                hour: dt.hour(),
                                minute: dt.minute(),
                                second: dt.second()
                            }
                        } else if ($scope.type == 'date') {
                            return {
                                year: dt.year(),
                                month: dt.month() + 1,
                                date: dt.date()
                            }
                        }
                    } else {

                        if ($scope.type == 'datetime') {
                            return {
                                year: moment().year(),
                                month: 0,
                                date: 0,
                                hour: 0,
                                minute: 0,
                                second: 0
                            }
                        } else if ($scope.type == 'date') {
                            return {
                                year: moment().year(),
                                month: 0,
                                date: 0
                            }
                        }
                    }
                });

                ngModelController.$render = function() {
                    $scope.year = ngModelController.$viewValue.year;
                    $scope.month = ngModelController.$viewValue.month;
                    $scope.date = ngModelController.$viewValue.date;

                    if ($scope.type == 'datetime') {
                        $scope.hour = ngModelController.$viewValue.hour;
                        $scope.minute = ngModelController.$viewValue.minute;
                        $scope.second = ngModelController.$viewValue.second;
                    }
                };

                $scope.$watch('datetimevalue', function(value) {
                    if (typeof value === null) {
                        $scope.isNull = true;
                    }
                });

                $scope.$watch('year + month + date + hour + minute + second + isNull', function() {
                    ngModelController.$setViewValue({ year: $scope.year, month: $scope.month,date: $scope.date,hour: $scope.hour,minute: $scope.minute,second: $scope.second });
                });

                $scope.toggleChecked = function() {
                    console.log('yep');
                    $scope.isNull = !$scope.isNull;
                }
            },
            templateUrl: '/js/templates/datetime.html'
        }
    });
})();
(function() {
    var app = angular.module('app');

    app.directive('tweet', ["$http", function($http) {
        return {
            restrict: 'E',
            scope: {
                action: '@',
                tweet: '='
            },
            link: function($scope, element, attributes, ngModelCtrl) {

                $scope.retrieveTweet = function() {

                    // Check that the entered URL contains 'twitter' before sending a request (perform more thorough validation serverside)
                    if (typeof $scope.tweet.external_url !== 'undefined' && $scope.tweet.external_url.indexOf('twitter.com') !== -1) {

                        var explodedVals = $scope.tweet.external_url.split('/');
                        var id = explodedVals[explodedVals.length - 1];

                        $http.get('/missioncontrol/create/retrievetweet?id=' + id).then(function(response) {
                            // Set parameters
                            $scope.tweet.tweet_text = response.data.text;
                            $scope.tweet.tweet_user_profile_image_url = response.data.user.profile_image_url.replace("_normal", "");
                            $scope.tweet.tweet_user_screen_name = response.data.user.screen_name;
                            $scope.tweet.tweet_user_name = response.data.user.name;
                            $scope.tweet.originated_at = moment(response.data.created_at, 'dddd MMM DD HH:mm:ss Z YYYY').utc().format('YYYY-MM-DD HH:mm:ss');

                        });
                    } else {
                        $scope.tweet = {};
                    }
                    // Toggle disabled state somewhere around here
                    $scope.tweetRetrievedFromUrl = $scope.tweet.external_url.indexOf('twitter.com') !== -1;
                }
            },
            templateUrl: '/js/templates/tweet.html'
        }
    }]);
})();
(function() {
    var app = angular.module('app');

    app.directive('deltaV', function() {
        return {
            restrict: 'E',
            scope: {
                deltaV: '=ngModel'
            },
            link: function($scope, element, attributes) {

                $scope.constants = {
                    SECONDS_PER_DAY: 86400,
                    DELTAV_TO_DAY_CONVERSION_RATE: 1000
                };

                $scope.$watch("deltaV", function(object) {
                    if (typeof object !== 'undefined') {
                        var calculatedValue = $scope.calculate(object);
                        $scope.setCalculatedValue(calculatedValue);
                    }
                }, true);

                $scope.calculate = function(object) {
                    console.log(object);
                    var internalValue = 0;
                    Object.getOwnPropertyNames(object).forEach(function(key) {
                        if (key == 'mission_id') {
                            if (typeof key !== 'undefined') {
                                //internalValue
                            }
                        }
                    });
                    return internalValue;
                };

                $scope.setCalculatedValue = function(calculatedValue) {
                    $scope.calculatedValue.deltaV = calculatedValue;

                    var seconds = $scope.calculatedValue.deltaV * ($scope.constants.SECONDS_PER_DAY / $scope.constants.DELTAV_TO_DAY_CONVERSION_RATE);

                    $scope.calculatedValue.time = seconds + ' seconds';
                };

                $scope.calculatedValue = {
                    deltaV: 0,
                    time: 0
                };
            },
            templateUrl: '/js/templates/deltaV.html'
        }
    });
})();
(function() {
    var app = angular.module('app', []);

    app.directive("tags", ["Tag", "$timeout", function(Tag, $timeout) {
        return {
            require: 'ngModel',
            replace: true,
            restrict: 'E',
            scope: {
                availableTags: '=',
                currentTags: '=ngModel'
            },
            link: function($scope, element, attributes, ctrl) {
                $scope.suggestions = [];
                $scope.inputWidth = {};
                $scope.currentTags = typeof $scope.currentTags !== 'undefined' ? $scope.currentTags : [];

                ctrl.$options = {
                    allowInvalid: true
                };

                $scope.createTag = function(createdTag) {
                    if ($scope.currentTags.length == 5) {
                        return;
                    }

                    var tagIsPresentInCurrentTags = $scope.currentTags.filter(function(tag) {
                        return tag.name == createdTag;
                    });

                    if (createdTag.length > 0 && tagIsPresentInCurrentTags.length === 0) {

                        // check if tag is present in the available tags array
                        var tagIsPresentInAvailableTags = $scope.availableTags.filter(function(tag) {
                            return tag.name == createdTag;
                        });

                        if (tagIsPresentInAvailableTags.length === 1) {
                            // grab tag
                            var newTag = tagIsPresentInAvailableTags[0];
                        } else {
                            // trim and convert the text to lowercase, then create!
                            var newTag = new Tag({ id: null, name: createdTag, description: null });
                        }

                        $scope.currentTags.push(newTag);

                        // reset the input field
                        $scope.tagInput = "";

                        $scope.updateSuggestionList();
                        $scope.updateInputLength();
                    }
                };

                $scope.removeTag = function(removedTag) {
                    $scope.currentTags.splice($scope.currentTags.indexOf(removedTag), 1);
                    $scope.updateSuggestionList();
                    $scope.updateInputLength();
                };

                $scope.tagInputKeydown = function(event) {
                    // Currently using jQuery.event.which to detect keypresses, keyCode is deprecated, use KeyboardEvent.key eventually:
                    // https://developer.mozilla.org/en-US/docs/Web/API/KeyboardEvent/key

                    // event.key == ' ' || event.key == 'Enter'
                    if (event.which == 32 || event.which == 13) {
                        event.preventDefault();

                        $scope.createTag($scope.tagInput);

                        // event.key == 'Backspace'
                    } else if (event.which == 8 && $scope.tagInput == "") {
                        event.preventDefault();

                        // grab the last tag to be inserted (if any) and put it back in the input
                        if ($scope.currentTags.length > 0) {
                            $scope.tagInput = $scope.currentTags.pop().name;
                        }
                    }
                };

                $scope.updateInputLength = function() {
                    $timeout(function() {
                        $scope.inputLength = $(element).find('.wrapper').innerWidth() - $(element).find('.tag-wrapper').outerWidth() - 1;
                    });
                };

                $scope.areSuggestionsVisible = false;
                $scope.toggleSuggestionVisibility = function() {
                    $scope.areSuggestionsVisible = !$scope.areSuggestionsVisible;
                };

                $scope.updateSuggestionList = function() {
                    var search = new RegExp($scope.tagInput, "i");

                    $scope.suggestions = $scope.availableTags.filter(function(availableTag) {
                        if ($scope.currentTags.filter(function(currentTag) {
                                return availableTag.name == currentTag.name;
                            }).length == 0) {
                            return search.test(availableTag.name);
                        }
                        return false;
                    }).slice(0,6);
                };

                ctrl.$validators.taglength = function(modelValue, viewValue) {
                    return viewValue.length > 0 && viewValue.length < 6;
                };

                $scope.$watch('currentTags', function() {
                    ctrl.$validate();
                }, true);

            },
            templateUrl: '/js/templates/tags.html'
        }
    }]);

    app.factory("Tag", function() {
        return function(tag) {
            var self = tag;

            // Convert the tag to lowercase and replace all spaces present.
            self.name = tag.name.replace(/["'\s]/g, "").toLowerCase();

            return self;
        }
    });
})();


(function() {
    var app = angular.module('app');

    app.directive('chart', ["$window", function($window) {
        return {
            replace: true,
            restrict: 'E',
            scope: {
                data: '=data',
                settings: "="
            },
            link: function($scope, elem, attrs) {

                $scope.$watch('data', function(newValue) {
                    render(newValue);
                });

                function render(data) {
                    var untouched = data;
                    if (!angular.isDefined(untouched) || untouched.length == 0) {
                        return;
                    }

                    var d3 = $window.d3;
                    var svg = d3.select(elem[0]);
                    var width = elem.width();
                    var height = elem.height();

                    var settings = $scope.settings;

                    // check padding and set default
                    if (typeof settings.padding === 'undefined') {
                        settings.padding = 50;
                    }

                    // extrapolate data
                    if (settings.extrapolation === true) {
                        var originDatapoint = {};
                        originDatapoint[settings.xAxis.key] = 0;
                        originDatapoint[settings.yAxis.key] = 0;

                        untouched.unshift(originDatapoint);
                    }

                    // draw
                    var drawLineChart = function() {
                        // Setup scales
                        if (settings.xAxis.type == 'linear') {
                            var xScale = d3.scale.linear()
                                .domain([0, untouched[untouched.length-1][settings.xAxis.key]])
                                .range([settings.padding, width - settings.padding]);

                        } else if (settings.xAxis.type == 'timescale') {
                            var xScale = d3.time.scale.utc()
                                .domain([untouched[0][settings.xAxis.key], untouched[untouched.length-1][settings.xAxis.key]])
                                .range([settings.padding, width - settings.padding]);
                        }

                        if (settings.yAxis.type == 'linear') {
                            var yScale = d3.scale.linear()
                                .domain([d3.max(untouched, function(d) {
                                    return d[settings.yAxis.key];
                                }), d3.min(untouched, function(d) {
                                    return d[settings.yAxis.key];
                                })])
                                .range([settings.padding, height - settings.padding]);

                        } else if (settings.yAxis.type == 'timescale') {
                            var yScale = d3.time.scale.utc()
                                .domain([d3.max(untouched, function(d) {
                                    return d[settings.yAxis.key];
                                }), 0])
                                .range([settings.padding, height - settings.padding]);
                        }

                        // Generators
                        var xAxisGenerator = d3.svg.axis().scale(xScale).orient('bottom').ticks(5).tickFormat(function(d) {
                            return typeof settings.xAxis.formatter !== 'undefined' ? settings.xAxis.formatter(d) : d;
                        });
                        var yAxisGenerator = d3.svg.axis().scale(yScale).orient("left").ticks(5).tickFormat(function(d) {
                            return typeof settings.yAxis.formatter !== 'undefined' ? settings.yAxis.formatter(d) : d;
                        });

                        // Line function
                        var lineFunction = d3.svg.line()
                            .x(function(d) {
                                return xScale(d[settings.xAxis.key]);
                            })
                            .y(function(d) {
                                return yScale(d[settings.yAxis.key]);
                            })
                            .interpolate(settings.interpolation);

                        // Element manipulation
                        svg.append("svg:g")
                            .attr("class", "x axis")
                            .attr("transform", "translate(0," + (height - settings.padding) + ")")
                            .call(xAxisGenerator);

                        svg.append("svg:g")
                            .attr("class", "y axis")
                            .attr("transform", "translate(" + settings.padding + ",0)")
                            .attr("stroke-width", 2)
                            .call(yAxisGenerator);

                        svg.append("svg:path")
                            .attr({
                                d: lineFunction(untouched),
                                "stroke-width": 2,
                                "fill": "none",
                                "class": "path"
                            });

                        svg.append("text")
                            .attr("class", "chart-title")
                            .attr("text-anchor", "middle")
                            .attr("x", width / 2)
                            .attr("y", settings.padding / 2)
                            .text(settings.chartTitle);

                        svg.append("text")
                            .attr("class", "axis x-axis")
                            .attr("text-anchor", "middle")
                            .attr("x", width / 2)
                            .attr("y", height - (settings.padding / 2))
                            .text(settings.xAxis.title);

                        svg.append("text")
                            .attr("class", "axis y-axis")
                            .attr("text-anchor", "middle")
                            .attr("transform", "rotate(-90)")
                            .attr("x", - (height / 2))
                            .attr("y", settings.padding / 2)
                            .text(settings.yAxis.title);
                    };

                    drawLineChart();
                }

            },
            templateUrl: '/js/templates/chart.html'
        }
    }]);
})();
(function() {
	var app = angular.module('app', ['720kb.datepicker']);

	app.directive('search', ['searchService', 'conversionService', "$rootScope", "$http", "$filter", function(searchService, conversionService, $rootScope, $http, $filter) {
		return {
			restrict: 'E',
            transclude: true,
			link: function($scope, element, attributes, ngModelCtrl) {

                $scope.data = {
                    missions: [],
                    types: []
                };

                $scope.currentSearch = searchService;

                $scope.brokerFilters = {
                    mission:    null,
                    type:       null,
                    before:     null,
                    after:      null,
                    favorited:  null,
                    noted:      null,
                    downloaded: null
                };

                // Update the filters from the search
                $scope.onSearchChange = function() {
                    conversionService.searchesToFilters($scope.brokerFilters, $scope.currentSearch, $scope.data);
                };

                $scope.onFilterUpdate = function(filterType) {
                    conversionService.filtersToSearches($scope.brokerFilters, $scope.currentSearch, filterType);
                };

                $scope.reset = function() {
                    $rootScope.$broadcast('exitSearchMode');
                    $scope.currentSearch.rawQuery = '';
                    $scope.onSearchChange();
                };

                (function() {
                    $http.get('/missioncontrol/search/fetch').then(function(response) {
                        $scope.data = {
                            missions: response.data.missions.map(function(mission) {
                                return {
                                    name: mission.name,
                                    image: mission.featured_image
                                }
                            }),
                            types: response.data.types.map(function(type) {
                                return {
                                    name: type,
                                    image: '/images/icons/' + type.replace(" ", "") + '.jpg'
                                }
                            })
                        }
                    });
                })();

                $scope.datepickerText = function() {
                    if ($scope.brokerFilters.before === null && $scope.brokerFilters.after === null) {
                        return "Any time";
                    } else if ($scope.brokerFilters.before !== null && $scope.brokerFilters.after === null) {
                        return "Before " + $scope.brokerFilters.before;
                    } else if ($scope.brokerFilters.before === null && $scope.brokerFilters.after !== null) {
                        return "After " + $scope.brokerFilters.after;
                    } else {
                        return "Between " + $scope.brokerFilters.after + " - " + $scope.brokerFilters.before;
                    }
                };
			},
			templateUrl: '/js/templates/search.html'
		}
	}]);

    app.service('conversionService', function() {
        this.searchesToFilters = function(brokerFilters, search, data) {
            // Search for missions in the query string
            var missionResult = search.filters().mission();
            if (missionResult != null) {
                var mission = data.missions.filter(function(mission) {
                    return mission.name.toLowerCase() == missionResult.toLowerCase();
                });

                if (mission !== null) {
                    brokerFilters.mission = mission[0];
                } else {
                    brokerFilters.mission = null;
                }
            } else {
                brokerFilters.mission = null;
            }

            // Search for types of resources in the query string
            var typeResult = search.filters().type();
            if (typeResult != null) {
                var type = data.types.filter(function(type) {
                    return type.name.toLowerCase() == typeResult.toLowerCase();
                });

                if (type !== null) {
                    brokerFilters.type = type[0];
                } else {
                    brokerFilters.type = null;
                }
            } else {
                brokerFilters.type = null;
            }

            var afterResult = search.filters().after();
            if (afterResult != null) {
                brokerFilters.after = moment(afterResult, 'YYYY-MM-DD').format('MMM D, YYYY');
            }  else {
                brokerFilters.after = null;
            }

            var beforeResult = search.filters().before();
            if (beforeResult != null) {
                brokerFilters.before = moment(beforeResult, 'YYYY-MM-DD').format('MMM D, YYYY');
            } else {
                brokerFilters.before = null;
            }

            brokerFilters.favorited = search.filters().favorited() != null;
            brokerFilters.noted = search.filters().noted() != null;
            brokerFilters.downloaded = search.filters().downloaded() != null;

        };

        this.filtersToSearches = function(brokerFilters, search, filterType) {
            if (filterType === 'mission') {
                if (brokerFilters.mission === null) {
                    search.rawQuery = search.rawQuery.replace(search.regex.mission, '');
                } else {
                    if (search.filters().mission() === null) {

                        // Test whether the name of the mission contains a space. If it does, we need to append
                        // quotes around it
                        var whatToConcatenate = /\s/.test(brokerFilters.mission.name) ?
                            'mission:"' + brokerFilters.mission.name + '"' :
                            'mission:' + brokerFilters.mission.name;

                        this.contextualConcat(search, whatToConcatenate);

                    } else {
                        search.rawQuery = /\s/.test(brokerFilters.mission.name) ?
                            search.rawQuery.replace(search.regex.mission, 'mission:"' + brokerFilters.mission.name + '"') :
                            search.rawQuery.replace(search.regex.mission, 'mission:' + brokerFilters.mission.name);
                    }
                }
            }

            else if (filterType == 'type') {
                if (brokerFilters.type === null) {
                    search.rawQuery = search.rawQuery.replace(search.regex.type, '');
                } else {
                    if (search.filters().type() === null) {

                        // Test whether the name of the type contains a space. If it does, we need to append
                        // quotes around it
                        var whatToConcatenate = /\s/.test(brokerFilters.type.name) ?
                        'type:"' + brokerFilters.type.name + '"' :
                        'type:' + brokerFilters.type.name;

                        this.contextualConcat(search, whatToConcatenate);

                    } else {
                        search.rawQuery = /\s/.test(brokerFilters.type.name) ?
                            search.rawQuery.replace(search.regex.type, 'type:"' + brokerFilters.type.name + '"') :
                            search.rawQuery.replace(search.regex.type, 'type:' + brokerFilters.type.name);
                    }
                }
            }

            else if (filterType == 'after') {
                if (brokerFilters.after === null) {
                    search.rawQuery = search.rawQuery.replace(search.regex.after, '');
                } else {

                    var dateToConcatenate = moment(brokerFilters.after, "MMM D, YYYY").format('YYYY-MM-DD');
                    if (search.filters().after() === null) {
                        this.contextualConcat(search, 'after:' + dateToConcatenate);
                    } else {
                        search.rawQuery = search.rawQuery.replace(search.regex.after, 'after:' + dateToConcatenate);
                    }
                }
            }

            else if (filterType == 'before') {
                if (brokerFilters.before === null) {
                    search.rawQuery = search.rawQuery.replace(search.regex.before, '');
                } else {

                    var dateToConcatenate = moment(brokerFilters.before, "MMM D, YYYY").format('YYYY-MM-DD');
                    if (search.filters().before() === null) {
                        this.contextualConcat(search, 'before:' + dateToConcatenate);
                    } else {
                        search.rawQuery = search.rawQuery.replace(search.regex.before, 'before:' + dateToConcatenate);
                    }
                }
            }

            else if (filterType === 'favorited') {
                if (search.filters().favorited() === null) {
                    this.contextualConcat(search, 'favorited:true');
                } else {
                    search.rawQuery = search.rawQuery.replace(search.regex.favorited, '');
                }
            }

            else if (filterType === 'noted') {
                if (search.filters().noted() === null) {
                    this.contextualConcat(search, 'noted:true');
                } else {
                    search.rawQuery = search.rawQuery.replace(search.regex.noted, '');
                }
            }

            else if (filterType === 'downloaded') {
                if (search.filters().downloaded() === null) {
                    this.contextualConcat(search, 'downloaded:true');
                } else {
                    search.rawQuery = search.rawQuery.replace(search.regex.downloaded, '');
                }
            }
        };

        this.contextualConcat = function(search, whatToConcatenate) {
            // Add a space so that we can make the search look cleaner (but only if it's not empty and the last character is not a string)
            if (search.rawQuery != "" && search.rawQuery.slice(-1) != ' ') {
                whatToConcatenate = ' ' + whatToConcatenate;
            }
            search.rawQuery = search.rawQuery.concat(whatToConcatenate);
        };

        this.contextualRemove = function(search, whatToRemove) {

        };
    });

    /**
     *  Eventually we could cache the outputs of the searchTerm and filters to make sure we don't re-regex
     *  things we don't have to?
     */
    app.service('searchService', function() {
        var self = this;

        self.rawQuery = "";

        self.searchTerm = function () {
            return self.rawQuery.replace(self.regex.tags, "").replace(self.regex.all, "").trim();
        };

        // https://regex101.com/r/uL9jN5/1
        // https://regex101.com/r/iT2zH5/2
        self.filters = function() {
            return {
                tags: function () {
                    var match;
                    var tags = [];

                    while (match = self.regex.tags.exec(self.rawQuery)) {
                        tags.push(match[1]);
                    }
                    return tags;
                },
                mission: function () {
                    var missionResult = self.regex.mission.exec(self.rawQuery);
                    return missionResult !== null ? (!angular.isUndefined(missionResult[1]) ? missionResult[1] : missionResult[2]) : null;
                },
                type: function () {
                    var typeResult = self.regex.type.exec(self.rawQuery);
                    return typeResult !== null ? (!angular.isUndefined(typeResult[1]) ? typeResult[1] : typeResult[2]) : null;
                },
                before: function () {
                    var beforeResult = self.regex.before.exec(self.rawQuery);
                    return beforeResult !== null ? beforeResult[1] : null;
                },
                after: function () {
                    var afterResult = self.regex.after.exec(self.rawQuery);
                    return afterResult !== null ? afterResult[1] : null;
                },
                year: function () {
                    var yearResult = self.regex.year.exec(self.rawQuery);
                    return yearResult !== null ? yearResult[1] : null;
                },
                user: function () {
                    var userResult = self.regex.user.exec(self.rawQuery);
                    return userResult !== null ? userResult[1] : null;
                },
                favorited: function () {
                    var favoritedResult = self.regex.favorited.exec(self.rawQuery);
                    return favoritedResult !== null ? favoritedResult[0] : null;
                },
                noted: function () {
                    var notedResult = self.regex.noted.exec(self.rawQuery);
                    return notedResult !== null ? notedResult[0] : null;
                },
                downloaded: function () {
                    var downloadedResult = self.regex.downloaded.exec(self.rawQuery);
                    return downloadedResult !== null ? downloadedResult[0] : null;
                }
            }
        };

        self.toQuery = function() {
            return {
                searchTerm: self.searchTerm(),
                filters: {
                    tags: self.filters().tags(),
                    mission: self.filters().mission(),
                    type: self.filters().type(),
                    before: self.filters().before(),
                    after: self.filters().after(),
                    year: self.filters().year(),
                    user: self.filters().user(),
                    favorited: self.filters().favorited(),
                    noted: self.filters().noted(),
                    downloaded: self.filters().downloaded()
                }
            }
        };

        self.regex = {
            tags: /\[([^)]+?)\]/gi,
            mission: /mission:(?:([^ "]+)|"(.+)")/i,
            type: /type:(?:([^ "]+)|"(.+)")/i,
            before: /before:([0-9]{4}-[0-9]{2}-[0-9]{2})/i,
            after:/after:([0-9]{4}-[0-9]{2}-[0-9]{2})/i,
            year: /year:([0-9]{4})/i,
            user: /uploaded-by:([a-zA-Z0-9_-]+)/i,
            favorited: /favorited:(true|yes|y|1)/i,
            noted: /noted:(true|yes|y|1)/i,
            downloaded: /downloaded:(true|yes|y|1)/i,
            all: /([a-z-]+):(?:([^ "]+)|"(.+)")/gi
        };

        return self;
    });
})();
//http://codepen.io/jakob-e/pen/eNBQaP
(function() {
    var app = angular.module('app');

    app.directive('passwordToggle', ["$compile", function($compile) {
        return {
            restrict: 'A',
            scope:{},
            link: function(scope, elem, attrs){
                scope.tgl = function() {
                    elem.attr('type',(elem.attr('type')==='text'?'password':'text'));
                };
                var lnk = angular.element('<i class="fa fa-eye" data-ng-click="tgl()"></i>');
                $compile(lnk)(scope);
                elem.wrap('<div class="password-toggle"/>').after(lnk);
            }
        }
    }]);
})();

(function() {
    var app = angular.module('app');

    app.directive('redditComment', ["$http", function($http) {
        return {
            replace: true,
            restrict: 'E',
            scope: {
                redditComment: '=ngModel'
            },
            link: function($scope, element, attributes) {

                $scope.retrieveRedditComment = function() {
                    if (typeof $scope.redditComment.external_url !== "undefined") {
                        $http.get('/missioncontrol/create/retrieveredditcomment?url=' + encodeURIComponent($scope.redditComment.external_url)).then(function(response) {

                            // Set properties on object
                            $scope.redditComment.summary = response.data.data.body;
                            $scope.redditComment.author = response.data.data.author;
                            $scope.redditComment.reddit_comment_id = response.data.data.name;
                            $scope.redditComment.reddit_parent_id = response.data.data.parent_id; // make sure to check if the parent is a comment or not
                            $scope.redditComment.reddit_subreddit = response.data.data.subreddit;
                            $scope.redditComment.originated_at = moment.unix(response.data.data.created_utc).format();
                        });
                    }
                }

            },
            templateUrl: '/js/templates/redditComment.html'
        }
    }]);
})();
(function() {
    var app = angular.module('app');

    app.directive('uniqueUsername', ["$q", "$http", function($q, $http) {
        return {
            restrict: 'A',
            require: 'ngModel',
            link: function(scope, elem, attrs, ngModelCtrl) {
                ngModelCtrl.$asyncValidators.username = function(modelValue, viewValue) {
                    return $http.get('/auth/isusernametaken/' + modelValue).then(function(response) {
                        return response.data.taken ? $q.reject() : true;
                    });
                };
            }
        }
    }]);
})();

(function() {
    var app = angular.module('app', []);

    app.directive("dropdown", function() {
        return {
            restrict: 'E',
            require: '^ngModel',
            scope: {
                data: '=options',
                uniqueKey: '@',
                titleKey: '@',
                imageKey: '@?',
                descriptionKey: '@?',
                searchable: '@',
                placeholder: '@',
                idOnly: '@?'
            },
            link: function($scope, element, attributes, ngModelCtrl) {

                $scope.search = {
                    name: ''
                };

                ngModelCtrl.$viewChangeListeners.push(function() {
                    $scope.$eval(attributes.ngChange);
                });

                $scope.mapData = function() {
                    if (!angular.isDefined($scope.data)) {
                        return;
                    }

                    return $scope.data.map(function(option) {
                        var props = {
                            id: option[$scope.uniqueKey],
                            name: option[$scope.titleKey],
                            image: option.featuredImage ? option.featuredImage.media_thumb_small : option.media_thumb_small
                        };

                        if (typeof $scope.descriptionKey !== 'undefined') {
                            props.description = option[$scope.descriptionKey];
                        }

                        return props;
                    });
                };

                $scope.options = $scope.mapData();

                $scope.$watch("data", function() {
                    $scope.options = $scope.mapData();
                    ngModelCtrl.$setViewValue(ngModelCtrl.$viewValue);
                });

                ngModelCtrl.$render = function() {
                    $scope.selectedOption = ngModelCtrl.$viewValue;
                };

                ngModelCtrl.$parsers.push(function(viewValue) {
                    if ($scope.idOnly === 'true') {
                        return viewValue.id;
                    } else {
                        return viewValue;
                    }
                });

                ngModelCtrl.$formatters.push(function(modelValue) {
                        if ($scope.idOnly === 'true' && angular.isDefined($scope.options)) {
                            return $scope.options.filter(function(option) {
                                return option.id = modelValue;
                            }).shift();
                        } else {
                            return modelValue;
                        }
                });

                $scope.selectOption = function(option) {
                    $scope.selectedOption = option;
                    ngModelCtrl.$setViewValue(option);
                    $scope.dropdownIsVisible = false;
                };

                $scope.toggleDropdown = function() {
                    $scope.dropdownIsVisible = !$scope.dropdownIsVisible;
                    if (!$scope.dropdownIsVisible) {
                        $scope.search.name = '';
                    }
                };

                $scope.dropdownIsVisible = false;
            },
            templateUrl: '/js/templates/dropdown.html'
        }
    });
})();

(function() {
    var app = angular.module('app');

    app.directive('characterCounter', ["$compile", function($compile) {
        return {
            restrict: 'A',
            require: 'ngModel',
            link: function($scope, element, attributes, ngModelCtrl) {
                var counter = angular.element('<p class="character-counter" ng-class="{ red: isInvalid }">{{ characterCounterStatement }}</p>');
                $compile(counter)($scope);
                element.after(counter);

                ngModelCtrl.$parsers.push(function(viewValue) {
                    $scope.isInvalid = ngModelCtrl.$invalid;
                    if (attributes.ngMinlength > ngModelCtrl.$viewValue.length) {
                        $scope.characterCounterStatement = attributes.ngMinlength - ngModelCtrl.$viewValue.length + ' to go';
                    } else if (attributes.ngMinlength <= ngModelCtrl.$viewValue.length) {
                        $scope.characterCounterStatement = ngModelCtrl.$viewValue.length + ' characters';
                    }
                    return viewValue;
                });
            }
        }
    }]);
})();
(function() {
    var app = angular.module('app');

    app.filter('jsonPrettify', function() {
       return function(input) {
           if (typeof input !== 'undefined') {
               return JSON.stringify(input, null, 2);
           }
           return null;
       }
    });
})();