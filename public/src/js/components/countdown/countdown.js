define(['jquery', 'knockout', 'moment', 'text!components/countdown/countdown.html'], function($, ko, moment, htmlString) {
    // Original jQuery countdown timer written by /u/EchoLogic, improved and optimized by /u/booOfBorg.
    // Rewritten as a Knockout Component for SpaceX Stats 4
    var CountdownViewModel = function(params) {
        var self = this;

        self.isLaunchExact = ko.computed(function() {
            return (ko.unwrap(params.specificity) == 7 || ko.unwrap(params.specificity) == 6);
        });
        self.secondsAwayFromLaunch = ko.observable();

        self.init = (function() {
            if (self.isLaunchExact()) {
                self.launchUnixSeconds = ko.observable(moment(ko.unwrap(params.countdownTo)).unix());

                self.days = ko.observable();
                self.hours = ko.observable();
                self.minutes = ko.observable();
                self.seconds = ko.observable();

                self.daysText = ko.observable();
                self.hoursText = ko.observable();
                self.minutesText = ko.observable();
                self.secondsText = ko.observable();

                self.countdownProcessor = function() {
                    var launchUnixSeconds = self.launchUnixSeconds();
                    var currentUnixSeconds = Math.floor($.now() / 1000);

                    // Stop the countdown, count up!
                    if (launchUnixSeconds <= currentUnixSeconds) {
                        clearInterval(self.countdownTimer);

                    } else {
                        self.secondsAwayFromLaunch(launchUnixSeconds - currentUnixSeconds);
                        var secondsBetween = self.secondsAwayFromLaunch();
                        // Calculate the number of days, hours, minutes, seconds
                        self.days(Math.floor(secondsBetween / (60 * 60 * 24)));
                        secondsBetween -= self.days() * 60 * 60 * 24;

                        self.hours(Math.floor(secondsBetween / (60 * 60)));
                        secondsBetween -= self.hours() * 60 * 60;

                        self.minutes(Math.floor(secondsBetween / 60));
                        secondsBetween -= self.minutes() * 60;

                        self.seconds(secondsBetween);

                        self.daysText(self.days() == 1 ? 'Day' : 'Days');
                        self.hoursText(self.hours() == 1 ? 'Hour' : 'Hours');
                        self.minutesText(self.minutes() == 1 ? 'Minute' : 'Minutes');
                        self.secondsText(self.seconds() == 1 ? 'Second' : 'Seconds');
                    }
                };

                setInterval(self.countdownProcessor, 1000);
            } else {

            }
        })();
    };

    return { viewModel: CountdownViewModel, template: htmlString };
});