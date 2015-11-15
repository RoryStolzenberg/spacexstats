(function() {
    var liveApp = angular.module('app', []);

    liveApp.controller('liveController', ["$scope", "liveService", "Section", "Resource", "Update", function($scope, liveService, Section, Resource, Update) {
        var socket = io('http://spacexstats.app:3000');

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
                    $scope.isActive = false;
                });
            },
            addSection: function() {
                $scope.liveParameters.sections.push(new Section({}));
            },
            removeSection: function(section) {
                $scope.liveParameters.sections.splice($scope.liveParameters.sections.indexOf(section), 1);
            },
            addResource: function() {
                $scope.liveParameters.resources.push(new Resource({}));
            },
            removeResource: function(resource) {
                $scope.liveParameters.resources.splice($scope.liveParameters.resources.indexOf(resource), 1);
            },
            updateSettings: function() {
                liveService.updateSettings($scope.liveParameters);
            }
        };

        $scope.liveParameters = {
            isForLaunch: true,
            title: $scope.data.upcomingMission.name,
            redditTitle: '/r/SpaceX ' + $scope.data.upcomingMission.name + ' Official Launch Discussion & Updates Thread',
            pageTitle: function() {
                if (!$scope.settings.isActive) {
                    return 'SpaceXStats Live';
                } else {
                    return 'countdown here';
                }
            },
            toggleForLaunch: function() {
                if (this.isForLaunch) {
                    this.title = '/r/SpaceX ' + $scope.data.upcomingMission.name + ' Official Launch Discussion & Updates Thread';
                } else {
                    this.title = null;
                }

            },
            countdownTo: $scope.data.upcomingMission.launch_date_time,
            streamingSources: {
                nasa: false,
                spacex: false
            },
            selectedStreamingSource: 'none',
            description: null,
            sections: [],
            resources: []
        };

        $scope.send = {
            new: {
                message: null,
                messageType: 'update'
            },
            /*
             * Send a launch update (message) via POST off to the server to be broadcast
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
            click: function(messageType) {

            },
            isDisabled: function(messageType) {
                return true;
            },
            isVisible: function(messageType) {
                return true;
            }
        };

        // Websocket listeners
        socket.on('live-updates:SpaceXStats\\Events\\LiveStartedEvent', function(data) {
            $scope.isActive = true;
            console.log(data);
            $scope.$apply();
        });

        socket.on('live-updates:SpaceXStats\\Events\\LiveUpdateCreatedEvent', function(data) {
            $scope.updates.push(new Update(data.liveUpdate));
            $scope.$apply();
        });

        socket.on('live-updates:SpaceXStats\\Events\\LiveUpdateUpdatedEvent', function(data) {
            var indexOfUpdate = $scope.updates.indexOf($scope.updates.filter(function(update) {
                return update.id == data.liveUpdate.id;
            }).shift());

            $scope.updates[indexOfUpdate] = new Update(data.liveUpdate);
            $scope.$apply();
        });

        // Initialize from page load
        (function() {
            $scope.auth = laravel.auth;
            $scope.isActive = laravel.isActive;
            $scope.updates = laravel.updates.map(function(update) {
                return new Update(update);
            });
            $scope.liveParameters.resources = laravel.resources;
            $scope.liveParameters.description = laravel.description;
            $scope.liveParameters.sections = laravel.sections;
        })();
    }]);

    liveApp.service('liveService', ["$http", function($http) {

        this.sendMessage = function(message) {
            return $http.post('/live/send/message', message);
        };

        this.editMessage = function(message) {
            return $http.patch('/live/send/message', message);
        };

        this.updateSettings = function(settings) {
            return $http.post('/live/send/updateSettings', settings);
        };

        this.create = function(createThreadParameters) {
            return $http.post('/live/send/create', createThreadParameters);
        };

        this.destroy = function() {
            return $http.post('/live/send/destroy');
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