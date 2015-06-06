define(['knockout', 'text!components/countdown/countdown.html'], function(ko, htmlString) {
    function CountdownViewModel(params) {
        var self = this;

        self.launchDateTime = ko.observable(params.launchDateTime);
        self.isLaunchExact = ko.observable(params.launchSpecificity == 7 ||params.launchSpecificity == 6);

        self.init = (function() {
            if (self.isLaunchExact()) {
                self.launchUnixSeconds = ko.observable(Date.parse(params.launchDateTime) / 1000);

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
                        self.zeroTimer();

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

                        // Update the frequency at which the AJAX request to check the launch time is called
                        self.setFrequency();
                    }
                };

                self.countdownTimer = setInterval(self.countdownProcessor, 1000);
            }
        })();
    }

    return { viewModel: CountdownViewModel, template: htmlString };
});