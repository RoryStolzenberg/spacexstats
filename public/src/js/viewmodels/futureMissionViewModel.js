define(['jquery', 'knockout', 'moment'], function($, ko, moment) {

    var FutureMissionViewModel = function() {

        ko.components.register('countdown', {require: 'components/countdown/countdown'});

        var self = this;

        self.missionSlug = ko.observable(laravel.slug);
        self.launchDateTime = ko.observable(laravel.launchDateTime);

        self.launchSpecificity = ko.observable(laravel.launchSpecificity);
        self.isLaunchExact = ko.computed(function() {
           return (self.launchSpecificity() == 7 || self.launchSpecificity() == 6);
        });

        self.launchUnixSeconds = ko.computed(function() {
            if (self.isLaunchExact()) {
                return (moment(self.launchDateTime()).unix());
            }
            return null;
        });

        self.lastRequest = ko.observable(moment().unix());
        self.secondsSinceLastRequest = ko.observable();

        self.secondsToLaunch = ko.observable();

        /*
        Make requests to the server for launchdatetime and webcast updates at the following frequencies:
        >24hrs to launch    =   1hr / request
        1hr-24hrs           =   15min / request
        20min-1hr           =   5 min / request
        <20min              =   30sec / request
         */
        self.requestFrequencyManager = function() {
            self.secondsSinceLastRequest(Math.floor($.now() / 1000) - self.lastRequest());
            self.secondsToLaunch(self.launchUnixSeconds() - Math.floor($.now() / 1000));

            console.log('secondsSinceLastRequest: ' + self.secondsSinceLastRequest() + ' secondsToLaunch: ' + self.secondsToLaunch());

            var aRequestNeedsToBeMade = (self.secondsToLaunch() >= 86400 && self.secondsSinceLastRequest() >= 3600) ||
                (self.secondsToLaunch() >= 3600 && self.secondsToLaunch() < 86400 && self.secondsSinceLastRequest() >= 900) ||
                (self.secondsToLaunch() >= 1200 && self.secondsToLaunch() < 3600 && self.secondsSinceLastRequest() >= 300) ||
                (self.secondsToLaunch() < 1200 && self.secondsSinceLastRequest() >= 30);

            if (aRequestNeedsToBeMade === true) {
                // Make both requests then update the time since last request
                self.requestLaunchDateTime();
                self.requestWebcastStatus();
                self.lastRequest(moment().unix());
            }
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
                if (self.secondsToLaunch() < (60 * 60 * 24) && self.webcast.isLive() == 'true') {
                    return 'webcast-live';
                } else if (self.secondsToLaunch() < (60 * 60 * 24) && self.webcast.isLive() == 'false') {
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