(function() {
    var liveApp = angular.module('app', []);

    liveApp.controller('liveController', ["$scope", "liveService", function($scope, liveService) {
        $scope.auth = laravel.auth;
        $scope.isActive = laravel.isActive;
        $scope.messages = laravel.messages;
        //var socket = io();

        /*
         * Send a launch update (message) via POST off to the server to be broadcast
         */
        $scope.sendMessage = function() {
            liveService.sendMessage({
                id: $scope.messages.length + 1,
                datetime: moment(),
                message: $scope.update.message,
                messageType: $scope.update.messageType
            });

            $scope.update.message = "";
        };

        $scope.turnOnSpaceXStatsLive = function() {
            liveService.create().then(function() {
                $scope.isActive = true;
            });
        }

        $scope.destroy = function() {
            liveService.destroy().then(function() {
                $scope.isActive = false;
            });
        }


    }]);

    liveApp.service('liveService', ["$http", function($http) {

        this.sendMessage = function(message) {
            return $http.post('/live/send/message', message);
        }

        this.updateSettings = function(settings) {
            return $http.post('/live/send/updateSettings', settings);
        }

        this.create = function() {
            return $http.post('/live/send/create');
        }

        this.destroy = function() {
            return $http.post('/live/send/destroy');
        }

    }]);
})();