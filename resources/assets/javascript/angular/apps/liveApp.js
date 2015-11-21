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