define(['jquery', 'knockout', 'ko.mapping'], function($, ko, koMapping) {
    var EditUserViewModel = function (username) {

        ko.components.register('rich-select', { require: 'components/rich-select/rich-select'});

        var self = this;
        self.username = username;

        self.profile = {
            summary: ko.observable(laravel.profile.summary),
            twitter_account: ko.observable(laravel.profile.twitter_account),
            reddit_account: ko.observable(laravel.profile.reddit_account),
            favorite_mission: ko.observable(laravel.profile.favorite_mission),
            favorite_mission_patch: ko.observable(laravel.profile.favorite_mission_patch),
        };

        self.missions = ko.observable(laravel.missions);

        self.updateProfile = function () {
            $.ajax('/users/' + self.username + '/edit/profile',
                {
                    dataType: 'json',
                    type: 'POST',
                    data: JSON.stringify(koMapping.toJS(self.profile), function(key, value) {
                        if (value === "" || typeof value === 'undefined') {
                            return null;
                        }
                        return value;
                    }),
                    contentType: "application/json",
                    success: function (response) {
                        console.log(response);
                    }
                }
            );
        };

        self.emailNotifications = {
            launchTimeChange: ko.observable(laravel.emailNotifications.launchTimeChange),
            newMission: ko.observable(laravel.emailNotifications.newMission),
            tMinus24HoursEmail: ko.observable(laravel.emailNotifications.tMins24HoursEmail),
            tMinus3HoursEmail: ko.observable(laravel.emailNotifications.tMins3HoursEmail),
            tMinus1HourEmail: ko.observable(laravel.emailNotifications.tMins1HourEmail),
            newsSummaries: ko.observable(laravel.emailNotifications.newsSummaries)
        };

        self.updateEmailNotifications = function() {
            console.log(koMapping.toJS(self.emailNotifications));
        };

        self.SMSNotification = {
            mobile: ko.observable(),
            status: ko.observable('tMinus1HourSMS')
        };

        self.updateSMSNotifications = function() {
            $.ajax('/users/' + self.username + '/edit/smsnotifications',
                {
                    dataType: 'json',
                    type: 'POST',
                    data: JSON.stringify(koMapping.toJS(self.SMSNotification), function(key, value) {
                        if (value === "" || typeof value === 'undefined') {
                            return null;
                        }
                        return value;
                    }),
                    contentType: "application/json",
                    success: function (response) {
                        console.log(response);
                    }
                }
            );
        }
    };

    return EditUserViewModel;
});

