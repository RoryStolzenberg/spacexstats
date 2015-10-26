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
        $scope.activeSection = 'missionControl';
        $scope.pageTitle = "Mission Control";

        $scope.search = function() {
            missionControlService.search($scope.currentSearch).then(function() {
                $scope.pageTitle = "Search Results for \"" + $scope.currentSearch.searchTerm + "\"";
            });
            $scope.activeSection = 'searchResults';
        };

        $scope.reset = function() {
            $scope.pageTitle = "Mission Control";
            $scope.currentSearch = "";
            $scope.activeSection = 'missionControl';
        };

        (function() {
            missionControlService.fetch();
        })();
    }]);

    missionControlApp.service("missionControlService", ["$http", function($http) {
        this.search = function(currentSearch) {
            return $http.post('/missioncontrol/search', { search: currentSearch });
        }

        this.fetch = function() {
            return $http.get('/missioncontrol/fetch');
        }
    }]);
})();
(function() {
    var app = angular.module('app', []);

    app.controller("futureMissionController", ['$http', '$scope', 'flashMessage', function($http, $scope, flashMessage) {

        $scope.missionSlug = laravel.mission.slug;
        $scope.launchDateTime = laravel.mission.launchDateTime;
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
        $scope.currentTimezoneFormatted;

        $scope.setTimezone = function(timezoneToSet) {
            if (timezoneToSet === 'local') {
                $scope.currentTimezone = null;
                $scope.currentTimezoneFormatted = "Local ("+ $scope.localTimezone +")";
            } else if (timezoneToSet === 'ET') {
                $scope.currentTimezone = moment().tz("America/New_York").format('z');
                $scope.currentTimezoneFormatted = 'ET';
            } else if (timezoneToSet === 'PT') {
                $scope.currentTimezone = moment().tz("America/Los_Angeles").format('z');
                $scope.currentTimezoneFormatted = 'PT';
            } else {
                $scope.currentTimezoneFormatted = $scope.currentTimezone = 'UTC';
            }
        };
    }]);
})();
(function() {
    var uploadApp = angular.module('app', []);

    uploadApp.controller("uploadAppController", ["$scope", function($scope) {
        $scope.activeSection = "upload";

        $scope.data = {
            missions: laravel.missions,
            tags: laravel.tags,
            subtypes: {
                images: [
                    {value: 1, display: 'Mission Patch' },
                    {value: 2, display: 'Photo' },
                    {value: 4, display: 'Chart' },
                    {value: 5, display: 'Screenshot' },
                    {value: 10, display: 'Infographic' },
                    {value: 11, display: 'News Summary' },
                    {value: 16, display: 'Hazard Map' },
                    {value: 17, display: 'License' },
                ],
                video: [
                    {value: 6, display: 'Launch Video' },
                    {value: 7, display: 'Press Conference' }
                ],
                documents: [
                    {value: 6, display: 'Press Kit' },
                    {value: 7, display: 'Cargo Manifest' },
                    {value: 15, display: 'Weather Forecast' },
                    {value: 17, display: 'License' }
                ]
            },
            publishers: laravel.publishers
        };

        $scope.changeSection = function(section) {
            $scope.activeSection = section;
        }
    }]);

    uploadApp.controller("uploadController", ["$scope", "objectFromFile", "uploadService", function($scope, objectFromFile, uploadService) {
        $scope.activeUploadSection = "dropzone";

        $scope.currentVisibleFile = null;
        $scope.isVisibleFile = function(file) {
            return $scope.currentVisibleFile === file;
        };
        $scope.setVisibleFile = function(file) {
            $scope.currentVisibleFile = file;
        };

        $scope.uploadCallback = function() {

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
            $scope.$apply();
        };

        $scope.fileSubmitButtonFunction = function() {
            uploadService.postToMissionControl($scope.files, 'files');
        }
    }]);

    uploadApp.controller("postController", ["$scope", "uploadService", function($scope, uploadService ) {

        $scope.NSFcomment = {};
        $scope.redditcomment = {};
        $scope.pressrelease = {};
        $scope.article = {};
        $scope.tweet = {};

        $scope.postSubmitButtonFunction = function() {
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

        $scope.writeSubmitButtonFunction = function() {
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
                case 1: return new Image(file, index);
                case 2: return new GIF(file, index);
                case 3: return new Audio(file, index);
                case 4: return new Video(file, index);
                case 5: return new Document(file, index);
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

	publisherApp.controller(["$scope", "$http", function($scope, $http) {

		// Init
		(function() {
			if (typeof laravel.publisher !== 'undefined') {
				$scope.publisher = laravel.publisher;
			}
		})();
	}]);
})();
(function() {
    var reviewApp = angular.module('app', []);

    reviewApp.controller("reviewController", ["$scope", "$http", "ObjectToReview", function($scope, $http, ObjectToReview) {

        $scope.visibilities = ['Default', 'Public', 'Hidden'];

        $scope.objectsToReview = [];

        $scope.action = function(object, queuedStatus) {

            object.status = queuedStatus;

            $http.post('/missioncontrol/review/update/' + object.object_id, {
                visibility: object.visibility, status: object.status
            }).then(function() {
                $scope.objectsToReview.splice($scope.objectsToReview.indexOf(object), 1);

            }, function(response) {
                alert('An error occured');
            });
        };

        (function() {
            $http.get('/missioncontrol/review/get').then(function(response) {
                response.data.forEach(function(objectToReview) {
                    $scope.objectsToReview.push(new ObjectToReview(objectToReview));
                });
                console.log($scope.objectsToReview);
            });
        })();

    }]);

    reviewApp.factory("ObjectToReview", function() {
        return function (object) {
            var self = object;

            self.visibility = "Default";

            self.linkToObject = '/missioncontrol/object/' + self.object_id;

            self.linkToUser = 'users/' + self.user.username;

            self.textType = function() {
                switch(self.type) {
                    case 1:
                        return 'Image';
                    case 2:
                        return 'GIF';
                    case 3:
                        return 'Audio';
                    case 4:
                        return 'Video';
                    case 5:
                        return 'Document';
                }
            };

            self.textSubtype = function() {
                switch(self.subtype) {
                    case 1:
                        return 'MissionPatch';
                    case 2:
                        return 'Photo';
                    case 3:
                        return 'Telemetry';
                    case 4:
                        return 'Chart';
                    case 5:
                        return 'Screenshot';
                    case 6:
                        return 'LaunchVideo';
                    case 7:
                        return 'PressConference';
                    case 8:
                        return 'PressKit';
                    case 9:
                        return 'CargoManifest';
                    default:
                        return null;
                }
            };

            self.createdAtRelative = moment.utc(self.created_at).fromNow();

            return self;
        }
    });
})();
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
        $scope.commentsAreLoaded = false;

        $scope.addTopLevelComment = function(form) {
            commentService.addTopLevel($scope.object, $scope.newComment).then(function(response) {
                $scope.comments.push(new Comment(response.data));
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
                $scope.comments = response.data.map(function(comment) {
                    return new Comment(comment);
                    var x = 2;
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
            }

            this.delete = function(object, comment) {
                return $http.delete('/missioncontrol/objects/' + object.object_id + '/comments/' + comment.comment_id);
            }

            this.edit = function(object, comment) {
                return $http.patch('/missioncontrol/objects/' + object.object_id + '/comments/' + comment.comment_id, { comment: {
                    comment: comment.editText
                }});
            }
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
                commentService.edit(laravel.object, self).then(function() {
                    self.comment = self.editText;
                    self.editText = null;
                    self.isEditing = false;
                });
            }

            self.delete = function(scope) {
                commentService.delete(laravel.object, self).then(function() {
                    self.comment = null;
                    self.isDeleting = false;

                    // If the comment has no children, remove it entirely. Otherwise, just show [deleted], similar to Reddit
                    if (self.children.length === 0) {
                        scope.$parent.remove();
                    } else {
                        self.isHidden = true;
                    }
                });
            }

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
        }

        $scope.selected = {
            astronaut: null
        };

        $scope.createMission = function() {
            missionService.create($scope.mission);
        }

        $scope.updateMission = function() {
            missionService.update($scope.mission);
        }

    }]);

    app.factory("Mission", ["PartFlight", "Payload", "SpacecraftFlight", "PrelaunchEvent", "Telemetry", function(PartFlight, Payload, SpacecraftFlight, PrelaunchEvent, Telemetry) {
        return function (mission) {
            if (mission == null) {
                var self = this;

                self.payloads = [];
                self.part_flights = [];
                self.spacecraft_flight = null;
                self.prelaunch_events = [];
                self.telemetries = [];

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
                self.telemetries.push(new Telemetry());
            };

            self.removeTelemetry = function(telemetry) {
                self.telemetries.splice(self.telemetries.indexOf(telemetry), 1);
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
                    window.location = '/missions/' + response.data.slug;
                });
            };

            this.update = function (mission) {
                $http.patch('/missions/' + mission.slug + '/edit', {
                    mission: mission,
                    _token: CSRF_TOKEN
                }).then(function (response) {
                    window.location = '/missions/' + response.data.slug;
                });
            };
        }
    ]);
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

    app.controller('pastMissionController', ["$scope", function($scope) {
        $scope.mission = laravel.mission;
        (function() {
            if (typeof laravel.telemetry !== 'undefined') {

                $scope.altitudeVsTime = {
                    data: laravel.telemetry.map(function(telemetry) {
                        if (telemetry.altitude != null) {
                            return { timestamp: telemetry.timestamp, altitude: telemetry.altitude };
                        }
                    }),
                    settings: {
                        extrapolate: true,
                        xAxisKey: 'timestamp',
                        xAxisTitle: 'Time (T+s)',
                        yAxisKey: 'altitude',
                        yAxisTitle: 'Altitude (km)',
                        chartTitle: 'Altitude vs. Time',
                        yAxisFormatter: function(d) {
                            return d / 1000;
                        }
                    }
                }

                $scope.altitudeVsDownrange = {
                    data: laravel.telemetry.map(function(telemetry) {
                        if (telemetry.downrange != null && telemetry.altitude != null) {
                            return { downrange: telemetry.downrange, altitude: telemetry.altitude };
                        }
                    }),
                    settings: {
                        extrapolate: true,
                        xAxisKey: 'downrange',
                        xAxisTitle: 'Downrange Distance (km)',
                        yAxisKey: 'altitude',
                        yAxisTitle: 'Altitude (km)',
                        chartTitle: 'Altitude vs. Downrange Distance',
                        yAxisFormatter: function(d) {
                            return d / 1000;
                        },
                        xAxisFormatter: function(d) {
                            return d / 1000;
                        }
                    }
                }

                $scope.velocityVsTime = {
                    data: laravel.telemetry.map(function(telemetry) {
                        if (telemetry.velocity != null) {
                            return { timestamp: telemetry.timestamp, velocity: telemetry.velocity };
                        }
                    }),
                    settings: {
                        extrapolate: true,
                        xAxisKey: 'timestamp',
                        xAxisTitle: 'Time (T+s)',
                        yAxisKey: 'velocity',
                        yAxisTitle: 'Velocity (m/s)',
                        chartTitle: 'Velocity vs. Time'
                    }
                }

                $scope.downrangeVsTime = {
                    data: laravel.telemetry.map(function(telemetry) {
                        if (telemetry.downrange != null) {
                            return { timestamp: telemetry.timestamp, downrange: telemetry.downrange };
                        }
                    }),
                    settings: {
                        extrapolate: true,
                        xAxisKey: 'timestamp',
                        xAxisTitle: 'Time (T+s)',
                        yAxisKey: 'downrange',
                        yAxisTitle: 'Downrange Distance (km)',
                        chartTitle: 'Downrange Distance vs. Time',
                        yAxisFormatter: function(d) {
                            return d / 1000;
                        }
                    }
                }
            }
        })();
    }]);
})();
(function() {
    var editObjectApp = angular.module('app', []);

    editObjectApp.controller("editObjectController", ["$scope", function($scope) {

    }]);
})();
(function() {
    var app = angular.module('app', ['duScroll', 'ngAnimate']);

    app.controller("homeController", ['$scope', '$document', 'Statistic', function($scope, $document, Statistic) {
        $scope.statistics = [];
        $scope.activeStatistic = false;

        $scope.goToClickedStatistic = function(statisticType) {
            history.replaceState('', document.title, '#' + statisticType);
            $scope.activeStatistic = statisticType;
        };

        $scope.goToFirstStatistic = function() {
            var stat = $scope.statistics[0];

            history.replaceState('', document.title, '#' + stat.camelCaseType);
            $scope.activeStatistic = stat.camelCaseType;

            $document.scrollToElement(angular.element(document.getElementById(stat.camelCaseType)), 0, 1000);
        };

        $scope.goToNeighborStatistic = function(index) {
            if (index >= 0 && index < $scope.statistics.length) {
                var stat = $scope.statistics[index];

                history.replaceState('', document.title, '#' + stat.camelCaseType);
                $scope.activeStatistic = stat.camelCaseType;
                $document.scrollToElement(angular.element(document.getElementById(stat.camelCaseType)), 0, 1000);

                return stat.camelCaseType;
            } else {
                $scope.goHome();
            }
        };

        $scope.goHome = function() {
            history.replaceState('', document.title, window.location.pathname);
            $scope.activeStatistic = false;
            $document.scrollToElement(angular.element(document.getElementById('home')), 0, 1000);
        };

        /*$window.on('scroll',
            $.debounce(100, function() {
                $('div[data-stat]').fracs('max', 'visible', function(best) {
                    $scope.activeStatistic($(best).data('stat'));
                });
            })
        );*/

        (function() {
            laravel.statistics.forEach(function(statistic) {
                $scope.statistics.push(new Statistic(statistic));
            });

            if (window.location.hash) {
                $scope.activeStatistic = window.location.hash.substring(1);
            }
        })();
    }]);

    app.factory('Statistic', function() {
        return function(statistic) {

            var self = {};

            self.isToggling = false;

            self.changeSubstatistic = function(newSubstatistic) {
                self.activeSubstatistic = newSubstatistic;
            };

            statistic.forEach(function(substatistic) {

                if (!self.substatistics) {

                    self.substatistics = [];
                    self.activeSubstatistic = substatistic;
                    self.type = substatistic.type;
                    self.camelCaseType = self.type.replace(" ", "");
                }

                self.substatistics.push(substatistic);
            });

            return self;
        }
    });
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
    var userApp = angular.module('app', []);

    userApp.controller("editUserController", ['$http', '$scope', 'editUserService', function($http, $scope, editUserService) {

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
            $http.patch('/users/' + $scope.username + '/edit/profile', $scope.profile)
                .then(function(response) {
                    flashMessage.addOK(response.data);
                });
        }

        $scope.emailNotifications = {
            launchTimeChange: laravel.notifications.launchTimeChange,
            newMission: laravel.notifications.newMission,
            tMinus24HoursEmail: laravel.notifications.tMinus24HoursEmail,
            tMinus3HoursEmail: laravel.notifications.tMinus3HoursEmail,
            tMinus1HourEmail: laravel.notifications.tMinus1HourEmail,
            newsSummaries: laravel.notifications.newsSummaries
        }

        $scope.updateEmailNotifications = function() {
            editUserService.updateEmails($scope.username, $scope.emailNotifications).then(function() {
                // Reset form?
            });
        }

        $scope.SMSNotification = {
            mobile: laravel.user.mobile
        };

        if (laravel.notifications.tMinus24HoursSMS === true) {
            $scope.SMSNotification.status = "tMinus24HoursSMS";
        } else if (laravel.notifications.tMinus3HoursSMS === true) {
            $scope.SMSNotification.status = "tMinus3HoursSMS";
        } else if (laravel.notifications.tMinus1HourSMS === true) {
            $scope.SMSNotification.status = "tMinus1HourSMS";
        } else {
            $scope.SMSNotification.status = "false";
        }

        $scope.updateSMSNotifications = function() {
            editUserService.updateSMS($scope.username, $scope.SMSNotification).then(function() {
                // Reset the form or something
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
    var liveApp = angular.module('app', []);

    liveApp.controller('liveController', ["$scope", "liveService", "Section", "Resource", "Message", function($scope, liveService, Section, Resource, Message) {
        $scope.auth = laravel.auth;
        $scope.isActive = laravel.isActive;
        $scope.messages = laravel.messages;

        $scope.data = {
            upcomingMission: laravel.mission
        };

        $scope.settings = {
            isGettingStarted: laravel.isActive == true ? null : false,
            getStartedHeroText: 'You are the launch controller.',
            getStarted: function() {
                this.isGettingStarted = true;
                this.getStartedHeroText = 'Awesome. We just need a bit of info first.'
            },
            turnOnSpaceXStatsLive: function() {
                liveService.create($scope.liveParameters).then(function() {
                    $scope.isActive = true;
                    $scope.settings.isGettingStarted = null;
                });
            },
            turnOffSpaceXStatsLive: function() {
                liveService.destroy().then(function() {
                    $scope.isActive = false;
                });
            },
            addSection: function() {
                $scope.liveParameters.sections.push(new Section({}));
            },
            removeSection: function(section) {

            },
            addResource: function() {
                $scope.liveParameters.resources.push(new Resource({}));
            },
            removeResource: function(resource) {

            },
            updateSettings: function() {
                liveService.updateSettings($scope.liveParameters);
            }
        };

        $scope.liveParameters = {
            isForLaunch: true,
            title: '/r/SpaceX ' + $scope.data.upcomingMission.name + ' Official Launch Discussion & Updates Thread',
            toggleForLaunch: function() {
                if (this.isForLaunch) {
                    this.title = '/r/SpaceX ' + $scope.data.upcomingMission.name + ' Official Launch Discussion & Updates Thread';
                } else {
                    this.title = null;
                }

            },
            countdownTo: null,
            streamingSources: {
                nasa: false,
                spacex: false
            },
            description: null,
            sections: [],
            resources: []
        };

        $scope.send = {
            new: {
                message: null
            },
            /*
             * Send a launch update (message) via POST off to the server to be broadcast
             */
            message: function() {
                liveService.sendMessage({
                    id: $scope.messages.length + 1,
                    datetime: moment(),
                    message: $scope.send.new.message,
                    messageType: $scope.send.new.messageType
                });

                $scope.update.message = "";
            }
        }

        //var socket = io();
    }]);

    liveApp.service('liveService', ["$http", function($http) {

        this.sendMessage = function(message) {
            return $http.post('/live/send/message', message);
        }

        this.updateSettings = function(settings) {
            return $http.post('/live/send/updateSettings', settings);
        }

        this.create = function(createThreadParameters) {
            return $http.post('/live/send/create', createThreadParameters);
        }

        this.destroy = function() {
            return $http.post('/live/send/destroy');
        }

    }]);

    liveApp.factory('Message', function() {
        return function() {
        }
    });

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
    var signUpApp = angular.module('app', []);

    signUpApp.controller("signUpController", ["$scope", "signUpService", "flashMessage", function($scope, signUpService, flashMessage) {
        $scope.hasSignedUp = false;
        $scope.isSigningUp = false;
        $scope.signUpButtonText = "Sign Up";

        $scope.togglePassword = function() {
            console.log('test');
        }

        $scope.signUp = function() {
            $scope.isSigningUp = true;
            $scope.signUpButtonText = "Signing Up";

            signUpService.go($scope.user).then(function(response) {
                $scope.hasSignedUp = true;
                $scope.isSigningUp = false;
            }, function() {
                // Otherwise show error
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
    var formApp = angular.module('app', []);

    formApp.controller("formController", ["$scope", function($scope) {
    }]);
})();

// Courtesy http://stackoverflow.com/questions/14430655/recursion-in-angular-directives
// https://github.com/marklagendijk/angular-recursion
angular.module('RecursionHelper', [])
    .factory('RecursionHelper', ['$compile', function($compile) {
        return {
            /**
             * Manually compiles the element, fixing the recursion loop.
             * @param element
             * @param [link] A post-link function, or an object with function(s) registered via pre and post properties.
             * @returns An object containing the linking functions.
             */
            compile: function(element, link){
                // Normalize the link parameter
                if(angular.isFunction(link)){
                    link = { post: link };
                }

                // Break the recursion loop by removing the contents
                var contents = element.contents().remove();
                var compiledContents;
                return {
                    pre: (link && link.pre) ? link.pre : null,
                    /**
                     * Compiles and re-adds the contents
                     */
                    post: function(scope, element){
                        // Compile the contents
                        if(!compiledContents){
                            compiledContents = $compile(contents);
                        }
                        // Re-add the compiled contents to the element
                        compiledContents(scope, function(clone){
                            element.append(clone);
                        });

                        // Call the post-linking function, if any
                        if(link && link.post){
                            link.post.apply(null, arguments);
                        }
                    }
                };
            }
        };
    }
]);
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

                    if (launchUnixSeconds >= currentUnixSeconds) {
                        $scope.secondsAwayFromLaunch = launchUnixSeconds - currentUnixSeconds;

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
                    } else {
                    }

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
    var app = angular.module('app', []);

    app.directive("selectList", function() {
        return {
            restrict: 'E',
            scope: {
                options: '=',
                selectedOption: '=ngModel',
                uniqueKey: '@',
                titleKey: '@',
                imageKey: '@?',
                descriptionKey: '@?',
                searchable: '@',
                placeholder: '@'
            },
            link: function($scope, element, attributes) {

                $scope.optionsObj = $scope.options.map(function(option) {
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

                $scope.$watch("selectedOption", function(newValue) {
                    if (newValue !== null) {
                        $scope.selectedOptionObj = $scope.optionsObj
                            .filter(function(option) {
                                return option['id'] == newValue;
                            }).shift();
                    } else {
                        $scope.selectedOptionObj = null;
                    }
                });

                $scope.selectOption = function(option) {
                    $scope.selectedOption = option['id'];
                    $scope.dropdownIsVisible = false;
                };

                $scope.selectDefault = function() {
                    $scope.selectedOption = null;
                    $scope.dropdownIsVisible = false;
                };

                $scope.toggleDropdown = function() {
                    $scope.dropdownIsVisible = !$scope.dropdownIsVisible;
                };

                $scope.$watch("dropdownIsVisible", function(newValue) {
                    if (!newValue) {
                        $scope.search = "";
                    }
                });

                $scope.isSelected = function(option) {
                    return option.id == $scope.selectedOption;
                };

                $scope.dropdownIsVisible = false;
            },
            templateUrl: '/js/templates/selectList.html'
        }
    });
})();

(function() {
    var app = angular.module('app');

    app.directive('missionCard', function() {
        return {
            restrict: 'E',
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
                    }
                });

                // upload the files
                $scope.uploadFiles = function() {
                    dropzone.processQueue();
                }
            }
        }
    }]);
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

                (function() {
                    if (typeof $scope.currentTags === 'undefined') {
                        $scope.currentTags = [];
                    }
                })();

                ctrl.$options = {
                    allowInvalid: true
                };

                $scope.suggestions = [];
                $scope.inputWidth = {};

                $scope.createTag = function(createdTag) {
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
                            var newTag = new Tag({ id: null, name: $.trim(createdTag.toLowerCase()), description: null });
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

                        // Remove any rulebreaking chars
                        var tag = $scope.tagInput;
                        tag = tag.replace(/["']/g, "");
                        // Remove whitespace if present
                        tag = tag.trim();

                        $scope.createTag(tag);

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
            return self;
        }
    });
})();


(function() {
    var app = angular.module('app');

    app.directive('datetime', function() {
        return {
            require: 'ngModel',
            restrict: 'E',
            replace: true,
            scope: {
                type: '@',
                datetimevalue: '=ngModel',
                startYear: '@',
                nullableToggle: '@?',
                isNull: '=',
                disabled: '=?ngDisabled'
            },
            link: function($scope, element, attrs, ctrl) {

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
                ctrl.$parsers.push(function(viewvalue) {

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

                ctrl.$render = function() {
                    $scope.year = ctrl.$viewValue.year;
                    $scope.month = ctrl.$viewValue.month;
                    $scope.date = ctrl.$viewValue.date

                    if ($scope.type == 'datetime') {
                        $scope.hour = ctrl.$viewValue.hour;
                        $scope.minute = ctrl.$viewValue.minute;
                        $scope.second = ctrl.$viewValue.second;
                    }
                };

                //convert data from model format to view format
                ctrl.$formatters.push(function(data) {

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

                $scope.$watch('datetimevalue', function(value) {
                    if (typeof value === null) {
                        $scope.isNull = true;
                    }
                });

                $scope.$watch('year + month + date + hour + minute + second + isNull', function() {
                    ctrl.$setViewValue({ year: $scope.year, month: $scope.month,date: $scope.date,hour: $scope.hour,minute: $scope.minute,second: $scope.second });
                });
            },
            templateUrl: '/js/templates/datetime.html'
        }
    });
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

                $scope.$watch("deltaV", function(objects) {
                    if (typeof objects !== 'undefined') {
                        $scope.newValue = 0;

                        if (Array.isArray(objects)) {
                            objects.forEach(function(object) {
                                $scope.newValue += $scope.calculate(object);
                            });
                        } else {
                            $scope.newValue = $scope.calculate(objects);
                        }

                        $scope.calculatedValue = $scope.newValue;
                    }
                }, true);

                $scope.calculate = function(object) {
                    var internalValue = 0;
                    Object.getOwnPropertyNames(object).forEach(function(key) {
                        if (key == 'mission_id') {
                            if (typeof key !== 'undefined') {
                                internalValue
                            }
                        }
                    });
                    return internalValue;
                };

                $scope.calculatedValue = 0;
            },
            templateUrl: '/js/templates/deltaV.html'
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

    app.directive('redditComment', ["$http", function($http) {
        return {
            replace: true,
            restrict: 'E',
            scope: {
                redditComment: '=ngModel'
            },
            link: function($scope, element, attributes) {

                $scope.$watch('redditComment.external_url', function() {
                    $scope.retrieveRedditComment();
                });

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

	app.directive('search', ['constraintsReader', "$http", function(constraintsReader, $http) {
		return {
			restrict: 'E',
            transclude: true,
			link: function($scope, element, attributes) {

				$scope.stagingConstraints = {
					mission: null,
					type: null,
					before: null,
					after: null,
					year: null,
					uploadedBy: null,
					favorited: null,
					noted: null,
					downloaded: null
				}

				$scope.data = {
					missions: laravel.missions,
					types: null,
                    tags: laravel.tags
				}

                $scope.onSearchKeyPress = function(event) {
                    $scope.currentSearch = constraintsReader.fromSearch($scope.rawSearchTerm)
                }
			},
			templateUrl: '/js/templates/search.html'
		}
	}]);

    app.service('constraintsReader', ['kebabToCamelCase', function(kebabToCamelCase) {
		this.fromSearch = function(rawSearchTerm) {

			var currentSearch = {
				searchTerm: null,
				tags: {
					tags: []
				},
				constraints: {
					mission: null,
					type: null,
					before: null,
					after: null,
					year: null,
					uploadedBy: null,
					favorited: null,
					noted: null,
					downloaded: null
				}
			};

			// parse out tags https://regex101.com/r/uL9jN5/1
			//currentSearch.tags.tags = /\[([^)]+?)\]/gi.exec(rawSearchTerm);
            var re = /\[([^)]+?)\]/gi;
            while (match = re.exec(rawSearchTerm)) {
                currentSearch.tags.tags.push(match[1]);
            }
            rawSearchTerm = rawSearchTerm.replace(re, "");

			// constraints https://regex101.com/r/iT2zH5/2
			var re = /([a-z-]+):(?:([a-zA-Z0-9_-]+)|"([a-zA-Z0-9_ -]+)")/gi;
			var constraint;
			var rawConstraintsArray = [];
			var touchedConstraintsArray = [];

			// Pull out all the raw constraints 
			do {
			    constraint = re.exec(rawSearchTerm);
			    if (constraint) {
			        rawConstraintsArray.push(typeof constraint[2] !== 'undefined' ? constraint[2] : constraint[3]);
			        touchedConstraintsArray.push(kebabToCamelCase.convert(constraint[1]));
			    }
			} while (constraint);
            rawSearchTerm = rawSearchTerm.replace(re, "");

			// reset the constraints present in the current search
			for (var propertyName in currentSearch.constraints) {

				// If the constraint exists
				if (touchedConstraintsArray.indexOf(propertyName) !== -1) {
					var index = touchedConstraintsArray.indexOf(propertyName);
					currentSearch.constraints[propertyName] = rawConstraintsArray[index];
				}
			}

            // Send the search term through
            currentSearch.searchTerm = rawSearchTerm;
			return currentSearch;
		}
	}]);

    app.service('kebabToCamelCase', function() {
		// Converts a search-constraint into a searchConstraint
		this.convert = function(string) {

			for(var i = 0; i < string.length; i++) {

				if (string[i] === "-") {
					string = string.replace(string.substr(i, 1), "");
					string = string.substring(0, i) + string.charAt(i).toUpperCase() + string.substring(i+1, string.length);
				}
			}
			return string;
		};

	});
})();
(function() {
    var app = angular.module('app');

    app.directive('chart', ["$window", function($window) {
        return {
            replace: true,
            restrict: 'E',
            scope: {
                chartData: '=data',
                settings: "="
            },
            link: function($scope, elem, attrs) {

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
                if (settings.extrapolate === true) {
                    var originDatapoint = {};
                    originDatapoint[settings.xAxisKey] = 0;
                    originDatapoint[settings.yAxisKey] = 0;

                    $scope.chartData.unshift(originDatapoint);
                }

                // draw
                var drawLineChart = (function() {

                    // Setup scales
                    var xScale = d3.scale.linear()
                        .domain([0, $scope.chartData[$scope.chartData.length-1][settings.xAxisKey]])
                        .range([settings.padding, width - settings.padding]);

                    var yScale = d3.scale.linear()
                        .domain([d3.max($scope.chartData, function(d) {
                            return d[settings.yAxisKey];
                        }), 0])
                        .range([settings.padding, height - settings.padding]);

                    // Generators
                    var xAxisGenerator = d3.svg.axis().scale(xScale).orient('bottom').ticks(5).tickFormat(function(d) {
                        return typeof settings.xAxisFormatter !== 'undefined' ? settings.xAxisFormatter(d) : d;
                    });
                    var yAxisGenerator = d3.svg.axis().scale(yScale).orient("left").ticks(5).tickFormat(function(d) {
                        return typeof settings.yAxisFormatter !== 'undefined' ? settings.yAxisFormatter(d) : d;
                    });

                    // Line function
                    var lineFunction = d3.svg.line()
                        .x(function(d) {
                            return xScale(d[settings.xAxisKey]);
                        })
                        .y(function(d) {
                            return yScale(d[settings.yAxisKey]);
                        })
                        .interpolate("basis");

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
                            d: lineFunction($scope.chartData),
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
                        .text(settings.xAxisTitle);

                    svg.append("text")
                        .attr("class", "axis y-axis")
                        .attr("text-anchor", "middle")
                        .attr("transform", "rotate(-90)")
                        .attr("x", - (height / 2))
                        .attr("y", settings.padding / 2)
                        .text(settings.yAxisTitle);
                })();
            },
            templateUrl: '/js/templates/chart.html'
        }
    }]);
})();
(function() {
    var app = angular.module('app');

    app.directive('animateOnChange', [function() {
        return {
            restrict: 'A',
            link: function() {

            }
        }
    }]);
})();
//http://codepen.io/jakob-e/pen/eNBQaP
(function() {
    var app = angular.module('app');

    app.directive('passwordToggle',function($compile){
        return {
            restrict: 'A',
            scope:{},
            link: function(scope,elem,attrs){
                scope.tgl = function(){ elem.attr('type',(elem.attr('type')==='text'?'password':'text')); }
                var lnk = angular.element('<a data-ng-click="tgl()">Toggle</a>');
                $compile(lnk)(scope);
                elem.wrap('<div class="password-toggle"/>').after(lnk);
            }
        }
    });
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