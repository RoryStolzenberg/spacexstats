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
            $http.patch('/users/' + $scope.username + '/edit', $scope.profile)
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
            $scope.SMSNotification.status = "TMinus24HoursSMS";
        } else if (laravel.notifications.tMinus3HoursSMS === true) {
            $scope.SMSNotification.status = "TMinus3HoursSMS";
        } else if (laravel.notifications.tMinus1HourSMS === true) {
            $scope.SMSNotification.status = "TMinus1HourSMS";
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