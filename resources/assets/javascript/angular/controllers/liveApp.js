(function() {
    var liveApp = angular.module('app', []);

    liveApp.config(["$sceDelegateProvider", function($sceDelegateProvider) {
        $sceDelegateProvider.resourceUrlWhitelist([
            'self',
            'https://www.youtube.com/**']);
    }]);

    liveApp.controller('liveController', ["$scope", "liveService", "Section", "Resource", "Update", "$timeout", "flashMessage", function($scope, liveService, Section, Resource, Update, $timeout, flashMessage) {
        var socket = io(document.location.origin + ':3000');

        $scope.auth = laravel.auth;
        $scope.isActive = laravel.isActive;

        $scope.data = {
            upcomingMission: laravel.mission
        };

        $scope.streamSize = {
            smaller: 1,
            normal: 2,
            larger: 3
        };

        $scope.streamOption = {
            noVideo: 1,
            spacex: 2,
            spacexClean: 3,
            nasa: 4,
            spacexAndSpacexClean: 5,
            spacexAndNasa: 6,
            spacexCleanAndNasa: 7
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
            isTurningOff: false,
            turnOnSpaceXStatsLive: function() {
                $scope.settings.isCreating = true;
                liveService.create($scope.liveParameters).then(function() {
                    $scope.settings.isCreating = false;
                    $scope.isActive = true;
                    $scope.settings.isGettingStarted = false;
                });
            },
            turnOffSpaceXStatsLive: function() {
                $scope.settings.isTurningOff = true;
                liveService.destroy().then(function() {
                    $scope.isActive = $scope.auth = false;
                });
            },
            toggleForLaunch: function() {
                if ($scope.liveParameters.isForLaunch) {
                    $scope.liveParameters.reddit.title = '/r/SpaceX ' + $scope.data.upcomingMission.name + ' Official Launch Discussion & Updates Thread';
                    $scope.liveParameters.title = $scope.data.upcomingMission.name;
                    $scope.liveParameters.countdown.to = $scope.data.upcomingMission.launch_date_time;
                    $scope.liveParameters.countdown.isPaused = false;
                } else {
                    $scope.liveParameters.title = $scope.liveParameters.reddit.title = null;
                }
            },
            isEditingDetails: false,
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
            isUpdating: false,
            updateDetails: function() {
                $scope.settings.isUpdating = true;
                liveService.updateDetails($scope.liveParameters).then(function(response) {
                    $scope.settings.isEditingDetails = $scope.settings.isUpdating = false;
                });
            },
            isPausingCountdown: false,
            pauseCountdown: function() {
                $scope.settings.isPausingCountdown = true;
                liveService.pauseCountdown().then(function() {
                    $scope.settings.isPausingCountdown = false;
                });
            },
            isResumingCountdown: false,
            resumeCountdown: function() {
                $scope.settings.isResumingCountdown = true;
                liveService.resumeCountdown($scope.liveParameters.countdown.newLaunchTime).then(function() {
                    $scope.settings.isResumingCountdown = false
                    ;
                });
            }
        };

        // Set the default parameters here
        $scope.liveParameters = {
            isForLaunch: true,
            title: laravel.title ? laravel.title : $scope.data.upcomingMission.name,
            reddit: {
                title: laravel.reddit.title ? laravel.reddit.title : '/r/SpaceX ' + $scope.data.upcomingMission.name + ' Official Launch Discussion & Updates Thread',
                thing: laravel.reddit.thing ? laravel.reddit.thing : null
            },
            countdown: {
                to: laravel.countdown.to ? laravel.countdown.to : $scope.data.upcomingMission.launch_date_time,
                isPaused: laravel.countdown.isPaused,
                newLaunchTime: null
            },
            streams: {
                spacex: {
                    isAvailable: laravel.streams.spacex ? laravel.streams.spacex.isAvailable : false,
                    youtubeVideoId: laravel.streams.spacex ? laravel.streams.spacex.youtubeVideoId : null,
                    isActive: laravel.streams.spacex ? laravel.streams.spacex.isActive : false
                },
                spacexClean: {
                    isAvailable: laravel.streams.spacexClean ? laravel.streams.spacexClean.isAvailable : false,
                    youtubeVideoId: laravel.streams.spacexClean ? laravel.streams.spacexClean.youtubeVideoId : null,
                    isActive: laravel.streams.spacexClean ? laravel.streams.spacexClean.isActive : false
                },
                nasa: {
                    isAvailable: laravel.streams.nasa ? laravel.streams.nasa.isAvailable : false,
                    youtubeVideoId: 'HDh4uK9PvJU',
                    isActive: true
                }
            },
            description: {
                raw: laravel.description.raw,
                markdown: laravel.description.markdown
            },
            sections: laravel.sections ? laravel.sections : [],
            resources: laravel.resources ? laravel.resources : [],
            status: {
                text: laravel.status.text ? laravel.status.text.replace(/([A-Z])/g, ' $1').replace(/^./, function(str){ return str.toUpperCase(); }).trim() : 'Upcoming',
                class: function() {
                    if ($scope.liveParameters.status.text) {
                        return $scope.liveParameters.status.text.toLowerCase().replace(/\s+/g, "-");
                    }
                }
            }
        };

        $scope.user = {
            streamOption: $scope.streamOption.spacex,
            streamSize: $scope.streamSize.normal,
            sanitizedStreamOption: function() {

                $scope.user.streamOption = parseInt($scope.user.streamOption);

                switch ($scope.user.streamOption) {
                    case $scope.streamOption.noVideo:               return 'No Video';
                    case $scope.streamOption.spacex:                return 'SpaceX';
                    case $scope.streamOption.spacexClean:           return 'SpaceX (Clean)';
                    case $scope.streamOption.nasa:                  return 'NASA';
                    case $scope.streamOption.spacexAndNasa:         return 'SpaceX & NASA';
                    case $scope.streamOption.spacexCleanAndNasa:    return 'SpaceX (Clean) & NASA';
                    case $scope.streamOption.spacexAndSpacexClean:  return 'SpaceX & SpaceX (Clean)';
                }
            },
            isConfiguringStreams: false,
            isWatching: {
                singleStream: function() {
                    return [$scope.streamOption.spacex, $scope.streamOption.spacexClean, $scope.streamOption.nasa]
                            .indexOf($scope.user.streamOption) !== -1;
                },
                doubleStream: function() {
                    return [$scope.streamOption.spacexAndNasa, $scope.streamOption.spacexCleanAndNasa, $scope.streamOption.spacexAndSpacexClean]
                            .indexOf($scope.user.streamOption) !== -1;
                }
            }
        };

        /*
         *
         */
        $scope.isLivestreamVisible = function() {
            if ($scope.user.streamOption == $scope.streamOption.spacex) {
                return $scope.liveParameters.streams.spacex.isActive;
            }

            if ($scope.user.streamOption == $scope.streamOption.spacexClean) {
                return $scope.liveParameters.streams.spacexClean.isActive;
            }

            if ($scope.user.streamOption == $scope.streamOption.nasa) {
                return $scope.liveParameters.streams.nasa.isActive;
            }

            if ($scope.user.streamOption == $scope.streamOption.spacexAndNasa) {
                return $scope.liveParameters.streams.nasa.isActive || $scope.liveParameters.streams.spacex.isActive;
            }

            if ($scope.user.streamOption == $scope.streamOption.spacexCleanAndNasa) {
                return $scope.liveParameters.streams.nasa.isActive || $scope.liveParameters.streams.spacexClean.isActive;
            }

            if ($scope.user.streamOption == $scope.streamOption.spacexAndSpacexClean) {
                return $scope.liveParameters.streams.spacex.isActive || $scope.liveParameters.streams.spacexClean.isActive;
            }
        };

        /*
         * Checks if any livestream is visible. We don't need to check for the existence of the spacexClean stream.
         */
        $scope.isAnyStreamAvailable = function() {
            return $scope.liveParameters.streams.spacex.isActive === true ||$scope.liveParameters.streams.nasa.isActive === true;
        };

        $scope.send = {
            new: {
                message: null,
                messageType: null
            },

            /*
             * Send a launch update (message) via POST off to the server to be broadcast to everyone else
             */
            message: function(form) {
                // Send the message
                liveService.sendMessage({
                    message: $scope.send.new.message,
                    messageType: null
                }).then(function() {
                    flashMessage.addOK('Update submitted');
                });

                // Reset the form
                $scope.send.new.message = "";
                form.$setUntouched();
            }
        };

        $scope.buttons = {
            cannedResponses: {
                holdAbort: laravel.cannedResponses ? laravel.cannedResponses.holdAbort : null,
                terminalCount: laravel.cannedResponses ? laravel.cannedResponses.terminalCount : null,
                inProgress: laravel.cannedResponses ? laravel.cannedResponses.inProgress : null,
                maxQ: laravel.cannedResponses ? laravel.cannedResponses.maxQ : null,
                MECO: laravel.cannedResponses ? laravel.cannedResponses.MECO : null,
                stageSep: laravel.cannedResponses ? laravel.cannedResponses.stageSep : null,
                mVacIgnition: laravel.cannedResponses ? laravel.cannedResponses.mVacIgnition : null,
                SECO: laravel.cannedResponses ? laravel.cannedResponses.SECO : null,
                missionSuccess: laravel.cannedResponses ? laravel.cannedResponses.missionSuccess : null,
                missionFailure: laravel.cannedResponses ? laravel.cannedResponses.missionFailure : null
            },
            isUnlocked: {},
            click: function(messageType, form) {
                // If the button has been clicked in the last 5 seconds, we should send the message
                if ($scope.buttons.isUnlocked[messageType]) {

                    liveService.sendMessage({
                        message: $scope.send.new.message,
                        messageType: messageType
                    }).then(function() {
                        flashMessage.addOK('Canned update submitted');
                    });

                    // Reset the form
                    $scope.send.new.message = "";
                    form.$setUntouched();

                // The button hasn't been clicked recently, make it active instead
                } else {
                    $scope.buttons.isUnlocked[messageType] = true;
                    $scope.send.new.message = $scope.buttons.cannedResponses[messageType];

                    $timeout(function() {
                        $scope.send.new.message = "";
                        $scope.buttons.isUnlocked[messageType] = false;
                    }, 1500);
                }
            },
            isUpdatingCannedResponses: false,
            updateCannedResponses: function() {
                $scope.buttons.isUpdatingCannedResponses = true;
                liveService.updateCannedResponses($scope.buttons.cannedResponses).then(function(response) {
                    $scope.buttons.isUpdatingCannedResponses = false;
                });
            }
        };

        // Callback executed by countdown directive
        $scope.setTimeBetweenNowAndLaunch = function(relativeSecondsBetween) {
            $scope.timeBetweenNowAndLaunch = relativeSecondsBetween;
        };

        // Websocket listeners
        socket.on('live-updates:SpaceXStats\\Events\\Live\\LiveStartedEvent', function(data) {
            console.log(data);
            $scope.isActive = true;
            $scope.liveParameters.description = data.data.description;
            $scope.liveParameters.sections = data.data.sections;
            $scope.liveParameters.resources = data.data.resources;
            $scope.liveParameters.title = data.data.title;
            $scope.liveParameters.reddit = data.data.reddit;
            $scope.liveParameters.streams = data.data.streams;
            $scope.liveParameters.countdown = data.data.countdown;
            $scope.liveParameters.status.text = data.data.status;
            if ($scope.auth) {
                $scope.buttons.cannedResponses = data.data.cannedResponses;
            }
            $scope.$apply();
        });

        socket.on('live-updates:SpaceXStats\\Events\\Live\\LiveCountdownEvent', function(data) {
            console.log(data);
            // Countdown is being resumed
            if (data.newLaunchTime != null) {
                $scope.liveParameters.countdown = {
                    isPaused: false,
                    to: data.newLaunchTime,
                    newLaunchDate: data.newLaunchTime
                };

            // Countdown is being paused
            } else {
                $scope.liveParameters.countdown.isPaused = true;
            }
            $scope.$apply();
        });

        socket.on('live-updates:SpaceXStats\\Events\\Live\\LiveUpdateCreatedEvent', function(data) {
            $scope.updates.push(new Update(data.liveUpdate));
            if (["upcoming", "holdAbort", "terminalCount", "inProgress", "missionSuccess", "missionFailure"].indexOf(data.liveUpdate.updateType) !== -1) {
                // Take the camelCased update type and transform it to Human Readable Case
                $scope.liveParameters.status.text = data.liveUpdate.updateType.replace(/([A-Z])/g, ' $1').replace(/^./, function(str){ return str.toUpperCase(); });
            }
            $scope.$apply();
        });

        socket.on('live-updates:SpaceXStats\\Events\\Live\\LiveUpdateUpdatedEvent', function(data) {
            var indexOfUpdate = $scope.updates.indexOf($scope.updates.filter(function(update) {
                return update.id == data.liveUpdate.id;
            }).shift());

            $scope.updates[indexOfUpdate] = new Update(data.liveUpdate);
            $scope.$apply();
        });

        socket.on('live-updates:SpaceXStats\\Events\\Live\\LiveEndedEvent', function() {
            $scope.isActive = false;
            $scope.$apply();
        });

        socket.on('live-updates:SpaceXStats\\Events\\Live\\LiveDetailsUpdatedEvent', function(data) {
            console.log(data);
        });

        socket.on('live-updates:SpaceXStats\\Events\\WebcastStartedEvent', function(data) {
            console.log(data);
            for (var stream in data.videos) {
                if (data.videos.hasOwnProperty(stream)) {
                    $scope.liveParameters.streams[stream].isActive = true;
                    $scope.liveParameters.streams[stream].isAvailable = true;
                    $scope.liveParameters.streams[stream].youtubeVideoId = data.videos[stream];
                }
            }

            $scope.$apply();
        });

        socket.on('live-updates:SpaceXStats\\Events\\WebcastEndedEvent', function(data) {
             console.log(data);
        });
    }]);

    liveApp.service('liveService', ["$http", function($http) {

        this.sendMessage = function(message) {
            return $http.post('/live/send/message', message);
        };

        this.editMessage = function(message) {
            return $http.patch('/live/send/message', message);
        };

        this.pauseCountdown = function() {
            return $http.patch('live/send/countdown/pause');
        };

        this.resumeCountdown = function(data) {
            return $http.patch('live/send/countdown/resume', { newLaunchDate: data});
        };

        this.updateDetails = function(details) {
            return $http.patch('/live/send/details', details);
        };

        this.updateCannedResponses = function(cannedResponses) {
            return $http.patch('/live/send/cannedresponses', { cannedResponses: cannedResponses });
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