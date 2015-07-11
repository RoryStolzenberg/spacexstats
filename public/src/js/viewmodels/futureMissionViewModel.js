define(['jquery', 'knockout', 'moment'], function($, ko, moment) {

    var FutureMissionViewModel = function(missionSlug, launchDateTime, launchSpecificity) {

        ko.components.register('countdown', {require: 'components/countdown/countdown'});

        var self = this;

        self.missionSlug = ko.observable(missionSlug);
        self.launchDateTime = ko.observable(launchDateTime);


        self.launchSpecificity = ko.observable(launchSpecificity);
        self.isLaunchExact = ko.computed(function() {
           return (self.launchSpecificity() == 7 || self.launchSpecificity() == 6);
        });

        self.launchUnixSeconds = ko.computed(function() {
            if (self.isLaunchExact()) {
                return (moment(self.launchDateTime()).unix());
            }
            return null;
        });

        self.someFunc = function() {
            console.log('yeah bitch');
        };

        self.requestLaunchDateTime = function () {
            $.ajax('/missions/' + self.missionSlug() + '/requestlaunchdatetime',
                {
                    dataType: 'json',
                    type: 'POST',
                    success: function (data) {
                        // If there has been a change in the launch datetime, update & broadcast an event
                        if (self.launchDateTime() !== data.launchDateTime) {
                            self.launchDateTime(data.launchDateTime);
                            self.launchSpecificity(data.launchSpecificity);
                        }
                    }
                });
        };

        self.webcast = {
            isLive: ko.observable(),
            viewers: ko.observable(),
            status: ko.pureComputed(function () {
                if (self.secondsAwayFromLaunch() < (60 * 60 * 24) && self.webcast.isLive() == 'true') {
                    return 'webcast-live';
                } else if (self.secondsAwayFromLaunch() < (60 * 60 * 24) && self.webcast.isLive() == 'false') {
                    return 'webcast-updates';
                } else {
                    return 'webcast-inactive';
                }
            }),

            publicStatus: ko.pureComputed(function () {
                if (self.webcast.status() === 'webcast-live') {
                    return 'Live Webcast'
                } else if (self.webcast.status() === 'webcast-updates') {
                    return 'Launch Updates'
                }
            }),

            publicViewers: ko.pureComputed(function () {
                return ' (' + self.webcast.viewers() + ' viewers)';
            })
        };

        self.requestWebcastStatus = function () {
            $.ajax('/webcast/getstatus',
                {
                    dataType: 'json',
                    type: 'POST',
                    success: function (data) {
                        self.webcast.isLive(data.isLive);
                        self.webcast.viewers(data.viewers);
                    }
                });
        };
    };

    return FutureMissionViewModel;
});