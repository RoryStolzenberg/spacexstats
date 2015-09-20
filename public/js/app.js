angular.module("missionsListApp", ["directives.missionCard"]).controller("missionsListController", ['$scope', function($scope) {
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
    }
}]);
angular.module("missionControlApp", ["directives.tags"]).controller("missionControlController", ["$scope", function($scope) {
    $scope.tags = [];
    $scope.selectedTags = [];
}]);
/**
 * Workaround to make defining and retrieving angular modules easier and more intuitive.
 */
(function (angular) {
    var origMethod = angular.module;

    var alreadyRegistered = {};

    /**
     * Register/fetch a module.
     *
     * @param name {string} module name.
     * @param reqs {array} list of modules this module depends upon.
     * @param configFn {function} config function to run when module loads (only applied for the first call to create this module).
     * @returns {*} the created/existing module.
     */
    angular.module = function (name, reqs, configFn) {
        reqs = reqs || [];
        var module = null;

        if (alreadyRegistered[name]) {
            module = origMethod(name);
            module.requires.push.apply(module.requires, reqs);
        } else {
            module = origMethod(name, reqs, configFn);
            alreadyRegistered[name] = module;
        }

        return module;
    };
})(angular);
(function() {
    var app = angular.module('app', []);

    app.controller("futureMissionController", ['$http', '$scope', 'flashMessage', function($http, $scope, flashMessage) {

        $scope.missionSlug = laravel.slug;
        $scope.launchDateTime = laravel.launchDateTime;
        $scope.launchSpecificity = laravel.launchSpecificity;

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

                        flashMessage.add({ type: 'success', contents: 'Launch time updated!' });
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
        }),

            $scope.$watch('webcast.viewers', function(newValue) {
                $scope.webcast.publicViewers = ' (' + newValue + ' viewers)';
            })

    }]);
})();
(function() {
    var app = angular.module('app', []);

    app.controller("uploadAppController", ["$scope", function($scope) {
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
            }
        };

        $scope.changeSection = function(section) {
            $scope.activeSection = section;
        }
    }]);

    app.controller("uploadController", ["$rootScope", "$scope", "objectFromFile", function($rootScope, $scope, objectFromFile) {
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
            console.log($scope.files);
            $rootScope.postToMissionControl($scope.files, 'files');
        }
    }]);

    app.controller("postController", ["$rootScope", "$scope", "$http", function($rootScope, $scope, $http) {

        $scope.NSFcomment = {};
        $scope.redditcomment = {};
        $scope.pressrelease = {};

        $scope.postSubmitButtonFunction = function() {
            switch ($scope.postType) {
                case 'NSFcomment' :     $rootScope.postToMissionControl($scope.NSFcomment, 'NSFcomment'); break;
                case 'redditcomment' :  $rootScope.postToMissionControl($scope.redditcomment, 'redditcomment'); break;
                case 'pressrelease' :  $rootScope.postToMissionControl($scope.pressrelease, 'pressrelease'); break;
            }
        }
    }]);

    app.controller("writeController", ["$rootScope", "$scope", function($rootScope, $scope) {

        $scope.text = {
            title: null,
            content: null,
            mission_id: null,
            anonymous: null,
            tags: []
        };

        $scope.writeSubmitButtonFunction = function() {
            console.log($scope.text);
            $rootScope.postToMissionControl($scope.text, 'text');
        }
    }]);

    app.run(['$rootScope', '$http', function($rootScope, $http) {
        $rootScope.postToMissionControl = function(dataToUpload, submissionHeader) {
            var req = {
                method: 'POST',
                url: '/missioncontrol/create/submit',
                headers: {
                    'Submission-Type': submissionHeader
                },
                data: {
                    data: dataToUpload
                }
            };

            $http(req).then(function() {
                window.location = '/missioncontrol';
            });
        }
    }]);

    app.factory("Image", function() {
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

    app.factory("GIF", function() {
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

    app.factory("Audio", function() {
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

    app.factory("Video", function() {
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

    app.factory("Document", function() {
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

    app.service("objectFromFile", ["Image", "GIF", "Audio", "Video", "Document", function(Image, GIF, Audio, Video, Document) {
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
angular.module('questionsApp', []).controller("questionsController", ["$scope", function($scope) {
    $scope
}]);

angular.module('reviewApp', []).controller("reviewController", ["$scope", "$http", "ObjectToReview", function($scope, $http, ObjectToReview) {

    $scope.visibilities = ['Default', 'Public', 'Hidden'];

    $scope.objectsToReview = [];

    $scope.action = function(object, newStatus) {

        object.status = newStatus;

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

}]).factory("ObjectToReview", function() {
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


angular.module('objectApp', ['directives.comment']).controller("objectController", ["$scope", "$http", function($scope, $http) {

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

}]).controller('commentsController', ["$scope", "commentService", function($scope, commentService) {
    $scope.object = laravel.object;

    (function() {
        commentService.getComments($scope.object).then(function(response) {
            $scope.comments = response.data;
        });
    })();

}]).service("commentService", ["$http",
    function($http) {

        this.getComments = function (object) {
            return $http.get('/missioncontrol/objects/' + object.object_id + '/comments');
        };

        this.addComment = function(comment) {

        };

        this.deleteComment = function(comment) {

        }

        this.editComment = function(comment) {

        }
    }
]);


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
    var app = angular.module('app', []);

    app.controller("editUserController", ['$http', '$scope', 'flashMessage', function($http, $scope, flashMessage) {

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
            $http.post('/users/' + $scope.username + '/edit/profile', $scope.profile)
                .then(function(response) {
                    flashMessage.add(response.data);
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
            console.log(laravel);
            console.log($scope.emailNotifications);

            $http.post('/users/' + $scope.username + '/edit/emailnotifications',
                { 'emailNotifications': $scope.emailNotifications }
            )
                .then(function(response) {
                    flashMessage.add(response.data);
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
            $http.post('/users/' + $scope.username + '/edit/smsnotifications',
                { 'SMSNotification': $scope.SMSNotification }
            )
                .then(function(response) {
                    flashMessage.add(response.data);
                });
        }

    }]);

})();
(function() {
    var app = angular.module('app', []);

    app.controller("homePageController", ['$scope', 'Statistic', function($scope, Statistic) {
        $scope.statistics = [];

        $scope.activeStatistic = false;

        laravel.statistics.forEach(function(statistic) {
            $scope.statistics.push(new Statistic(statistic));
        });

        $scope.goToClickedStatistic = function(statisticType) {
            $scope.activeStatistic = statisticType;
        }

        $scope.goToPreviousStatistic = function() {

        }

        $scope.goToNextStatistic = function() {

        }

        $scope.$watch("activeStatistic", function(newValue, oldValue) {

        });
    }]);

    app.factory('Statistic', ['Substatistic', function(Substatistic) {
        return function(statistic) {

            var self = {};

            statistic.forEach(function(substatistic) {

                var substatisticObject = new Substatistic(substatistic);

                if (!self.substatistics) {

                    self.substatistics = [];
                    self.activeSubstatistic = substatisticObject;
                    self.type = substatisticObject.type;
                }

                self.substatistics.push(substatisticObject);
            });

            self.changeSubstatistic = function(newSubstatistic) {
                self.activeSubstatistic = newSubstatistic;
            };

            return self;
        }
    }]);

    app.factory('Substatistic', function() {
        return function(substatistic) {

            var self = substatistic;
            return self;
        }
    });
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
        this.add = function(data) {

            $('<p style="display:none;" class="flash-message ' + data.type + '">' + data.contents + '</p>').appendTo('#flash-message-container').slideDown(300);

            setTimeout(function() {
                $('.flash-message').slideUp(300, function() {
                    $(this).remove();
                });
            }, 3000);
        };
    });
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

angular.module('directives.upload', []).directive('upload', ['$parse', function($parse) {
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
// Original jQuery countdown timer written by /u/EchoLogic, improved and optimized by /u/booOfBorg.
// Rewritten as an Angular directive for SpaceXStats 4
angular.module('directives.countdown', []).directive('countdown', ['$interval', function($interval) {
    return {
        restrict: 'E',
        scope: {
            specificity: '=',
            countdownTo: '=',
            callback: '&'
        },
        link: function($scope) {

            $scope.isLaunchExact = ($scope.specificity == 6 || $scope.specificity == 7);

            $scope.$watch('specificity', function(newValue) {
                $scope.isLaunchExact = (newValue == 6 || newValue == 7);
            });

            (function() {
                if ($scope.isLaunchExact) {

                    $scope.launchUnixSeconds = moment($scope.countdownTo).unix();


                    $scope.countdownProcessor = function() {

                        var launchUnixSeconds = $scope.launchUnixSeconds;
                        var currentUnixSeconds = Math.floor($.now() / 1000);

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

                            // Stop the countdown, count up!
                        } else {
                        }

                        if ($scope.callback && typeof $scope.callback === 'function') {
                            $scope.callback();
                        }
                    };

                    $interval($scope.countdownProcessor, 1000);
                } else {
                    $scope.countdownText = $scope.countdownTo;
                }
            })();

        },
        templateUrl: '/js/templates/countdown.html'
    }
}]);

angular.module('directives.missionCard', []).directive('missionCard', function() {
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

angular.module("directives.tags", []).directive("tags", ["Tag", "$timeout", function(Tag, $timeout) {
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
}]).factory("Tag", function() {
    return function(tag) {
        var self = tag;
        return self;
    }
});
angular.module('directives.datetime', []).directive('datetime', function() {
    return {
        require: 'ngModel',
        restrict: 'E',
        replace: true,
        scope: {
            type: '@',
            datetimevalue: '=ngModel',
            startYear: '@',
            nullableToggle: '@',
            isNull: '='
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


angular.module('directives.tweet', []).directive('tweet', function() {
    return {
        restrict: 'E',
        scope: {
            state: '@',
            tweet: '='
        },
        link: function($scope, element, attributes, ngModelCtrl) {

        },
        templateUrl: '/js/templates/tweet.html'
    }
});



(function() {
    var app = angular.module('app');

    app.directive('deltaV', function() {
        return {
            restrict: 'A',
            scope: {
                deltaV: '='
            },
            link: function($scope, element, attributes) {

                $scope.$watch("deltaV", function(files) {
                    if (typeof files !== 'undefined') {
                        files.forEach(function(file) {
                            console.log(Object.prototype.toString.call(file));
                        });
                    }
                });

                $scope.calculatedValue = 0;
            },
            template: '<span>{{ calculatedValue }} m/s of dV</span>'
        }
    });
})();
angular.module('directives.comment', ["RecursionHelper"]).directive('comment', ["RecursionHelper", function(RecursionHelper) {
    return {
        restrict: 'E',
        replace: true,
        scope: {
            comment: '='
        },
        compile: function(element) {
            // Use the compile function from the RecursionHelper,
            // And return the linking function(s) which it returns
            return RecursionHelper.compile(element, function($scope, element, attrs, ctrl) {

                $scope.toggleReplyState = function() {
                    if (typeof $scope.reply !== 'undefined') {
                        $scope.reply = !$scope.reply;
                    } else {
                        $scope.reply = true;
                    }

                }
            });
        },
        templateUrl: '/js/templates/comment.html'
    }
}]);
angular.module('directives.redditComment', []).directive('redditComment', function() {
    return {
        restrict: 'E',
        scope: {
            redditComment: '=ngModel'
        },
        link: function($scope, element, attributes) {

            $scope.retrieveRedditComment = function() {
                $http.get('/missioncontrol/create/retrieveredditcomment?url=' + encodeURIComponent($scope.redditcomment.external_url));
            }

        },
        templateUrl: '/js/templates/redditComment.html'
    }
});


