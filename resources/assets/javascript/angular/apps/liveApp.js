(function() {
    var liveApp = angular.module('app', []);

    liveApp.controller('liveController', ["$scope", "liveService", "Section", "Resource", "Message", function($scope, liveService, Section, Resource, Message) {
        var socket = io('http://spacexstats.app:3000');

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
                message: null,
                messageType: 'update'
            },
            /*
             * Send a launch update (message) via POST off to the server to be broadcast
             */
            message: function() {
                liveService.sendMessage({
                    message: $scope.send.new.message,
                    messageType: $scope.send.new.messageType
                });

                $scope.send.new.message = "";
            }
        };

        socket.on('foo', function(data) {
            console.log(data);
        });

        socket.on('live-updates:SpaceXStats\\Events\\LiveUpdateCreatedEvent', function(data) {
            console.log(data);
        });
    }]);

    liveApp.service('liveService', ["$http", function($http) {

        this.sendMessage = function(message) {
            return $http.post('/live/send/message', message);
        };

        this.editMessage = function(message) {
            return $http.patch('/live/send/')
        }

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