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