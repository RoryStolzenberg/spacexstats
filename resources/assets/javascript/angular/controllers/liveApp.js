(function() {
    var liveApp = angular.module('app', []);

    liveApp.controller('liveController', ["$scope", "liveService", "Section", "Resource", "Update", function($scope, liveService, Section, Resource, Update) {
        var socket = io(document.location.origin + ':3000');

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
            updateDetails: function() {
                liveService.updateDetails($scope.liveParameters).then(function(response) {
                    $scope.settings.isEditingDetails = false;
                });
            },
            isPausingCountdown: false,
            pauseCountdown: function() {
                $scope.settings.isPausingCountdown = true;
                liveService.pauseCountdown();
            },
            isResumingCountdown: false,
            resumeCountdown: function() {
                $scope.settings.isResumingCountdown = true;
                liveService.resumeCountdown($scope.liveParameters.countdown.newLaunchTime);
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
                to: laravel.countdown.to,
                isPaused: laravel.countdown.isPaused,
                newLaunchTime: null
            },
            userSelectedStream: 'spacex',
            userStreamSize: 'smaller',
            streams: {
                spacex: {
                    isAvailable: laravel.streams.spacex ? laravel.streams.spacex.isAvailable : null,
                    youtubeVideoId: laravel.streams.spacex ? laravel.streams.spacex.youtubeVideoId : null,
                    isActive: laravel.streams.spacex ? laravel.streams.spacex.isActive : null
                },
                nasa: {
                    isAvailable: false,
                    isActive: false
                }
            },
            description: {
                raw: laravel.description.raw,
                markdown: laravel.description.markdown
            },
            sections: laravel.sections ? laravel.sections : [],
            resources: laravel.resources ? laravel.resources : [],
            status: {
                text: laravel.status.text,
                class: function() {
                    return $scope.liveParameters.status.text.toLowerCase().replace(/\s/g, "-");
                }
            }
        };

        $scope.isLivestreamVisible = function() {
            return $scope.liveParameters.userSelectedStream != null
                && $scope.liveParameters.streams[$scope.liveParameters.userSelectedStream].isAvailable
                && $scope.liveParameters.streams[$scope.liveParameters.userSelectedStream].isActive;
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
                terminalCount: laravel.cannedResponses ? laravel.cannedResponses.terminalCount : null,
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
                var timeDiff = moment.utc().diff(moment.utc($scope.liveParameters.countdown.to), 'second');
                switch (messageType) {
                    case 'holdAbort':
                        return -(60 * 60) < timeDiff < 30;
                    case 'terminalCount':
                        return -(60 * 15) < timeDiff < -(60 * 8);
                    case 'liftoff':
                        return -30 < timeDiff < 30;
                    case 'maxQ':
                        return 15 < timeDiff < 90;
                    case 'meco':
                        return 120 < timeDiff < 210;
                    case 'stageSep':
                        return 120 < timeDiff < 210;
                    case 'mVacIgnition':
                        return 120 < timeDiff < 210;
                    case 'seco':
                        return (60 * 8) < timeDiff < (60 * 12);
                    case 'missionSuccess':
                        return (60 * 8) < timeDiff;
                    case 'missionFailure':
                        return -30 < timeDiff;
                }
            },
            updateCannedResponses: function() {

            }
        };

        // Websocket listeners
        socket.on('live-updates:SpaceXStats\\Events\\Live\\LiveStartedEvent', function(data) {
            $scope.isActive = true;
            $scope.liveParameters.description = data.data.description;
            $scope.liveParameters.sections = data.data.sections;
            $scope.liveParameters.resources = data.data.resources;
            $scope.liveParameters.title = data.data.title;
            $scope.liveParameters.reddit = data.data.reddit;
            $scope.liveParameters.streams = data.data.streams;
            $scope.liveParameters.countdown = data.data.countdown;
            $scope.$apply();
        });

        socket.on('live-updates:SpaceXStats\\Events\\Live\\LiveCountdownEvent', function(data) {
            console.log(data);
            // Countdown is being resumed
            if (data.newLaunchTime != null) {
                $scope.liveParameters.countdown = {
                    isPaused: false,
                    to: data.newLaunchTime,
                    newLaunchDate: null
                };

            // Countdown is being paused
            } else {
                $scope.liveParameters.countdown.isPaused = true;
            }
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

        socket.on('live-updates:SpaceXStats\\Events\\Live\\LiveDetailsUpdatedEvent', function(data) {

        });

        socket.on('live-updates:SpaceXStats\\Events\\WebcastEvent', function(data) {
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
            return $http.post('/live/send/details', details);
        };

        this.updateCannedResponses = function(cannedResponses) {
            return $http.patch('/live/send/cannedresponses', cannedResponses);
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