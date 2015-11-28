(function() {
    var userApp = angular.module('app', []);

    userApp.controller("editUserController", ['$http', '$scope', 'editUserService', 'flashMessage', function($http, $scope, editUserService, flashMessage) {
        $scope.isUpdating = {
            profile: false,
            emailNotifications: false,
            SMSNotifications: false
        };

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
            $scope.isUpdating.profile = true;
            $http.patch('/users/' + $scope.username + '/edit', $scope.profile)
                .then(function(response) {
                    window.location = '/users/' + $scope.username;
                });
        };

        $scope.emailNotifications = {
            LaunchChange: laravel.notifications.LaunchChange,
            NewMission: laravel.notifications.NewMission,
            TMinus24HoursEmail: laravel.notifications.TMinus24HoursEmail,
            TMinus3HoursEmail: laravel.notifications.TMinus3HoursEmail,
            TMinus1HourEmail: laravel.notifications.TMinus1HourEmail,
            NewsSummaries: laravel.notifications.NewsSummaries
        };

        $scope.updateEmailNotifications = function() {
            $scope.isUpdating.emailNotifications = true;
            editUserService.updateEmails($scope.username, $scope.emailNotifications).then(function() {
                $scope.isUpdating.emailNotifications = false;
            });
        };

        $scope.SMSNotification = {
            mobile: laravel.user.mobile
        };

        if (laravel.notifications.TMinus24HoursSMS === true) {
            $scope.SMSNotification.status = "TMinus24HoursSMS";
        } else if (laravel.notifications.TMinus3HoursSMS === true) {
            $scope.SMSNotification.status = "TMinus3HoursSMS";
        } else if (laravel.notifications.TMinus1HourSMS === true) {
            $scope.SMSNotification.status = "TMinus1HourSMS";
        } else {
            $scope.SMSNotification.status = "false";
        }

        $scope.updateSMSNotifications = function() {
            $scope.isUpdating.SMSNotifications = true;
            editUserService.updateSMS($scope.username, $scope.SMSNotification).then(function() {
                $scope.isUpdating.SMSNotifications = false;
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