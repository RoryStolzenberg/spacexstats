(function() {
    var liveApp = angular.module('app', []);

    liveApp.controller('liveController', ["$scope", "liveService", function($scope, liveService) {
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
                liveService.create($scope.startingParameters).then(function() {
                    $scope.isActive = true;
                    $scope.settings.isGettingStarted = null;
                });
            },
            turnOffSpaceXStatsLive: function() {
                liveService.destroy().then(function() {
                    $scope.isActive = false;
                });
            }
        };

        $scope.startingParameters = {
            isForLaunch: true,
            threadName: '/r/SpaceX ' + $scope.data.upcomingMission.name + ' Official Launch Discussion & Updates Thread',
            toggleForLaunch: function() {
                if (this.isForLaunch) {
                    this.threadName = '/r/SpaceX ' + $scope.data.upcomingMission.name + ' Official Launch Discussion & Updates Thread';
                } else {
                    this.threadName = null;
                }

            },
            countdownTo: null,
            streamingSources: {
                nasa: false,
                spacex: false
            },
            description: null,
            extraSections: {

            }
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
            },
            update: function() {

            }
        }
        //var socket = io();


        $scope.sendMessage = function() {

        };
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
})();