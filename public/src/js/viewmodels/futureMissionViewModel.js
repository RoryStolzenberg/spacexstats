// Original jQuery countdown timer written by /u/EchoLogic, improved and optimized by /u/booOfBorg. 
// Rewritten as a Knockout ViewModel for SpaceX Stats 4 to make AJAX requests & provide automatic pubsub
var FutureMissionViewModel = function(missionSlug, launchDateTime) {
	var self = this;

	self.missionSlug = ko.observable(missionSlug);
	self.launchDateTime = ko.observable(launchDateTime);
	self.launchUnixSeconds = ko.observable(Date.parse(launchDateTime) / 1000);
	self.secondsAwayFromLaunch = ko.observable();
	self.requestIntervalFrequency = ko.observable();

	self.webcast = {
		isLive: ko.observable(),
		viewers: ko.observable(),
		status: ko.pureComputed(function() {
			
			if (self.secondsAwayFromLaunch() < (60 * 60 * 24) && self.webcast.isLive() == 'true') {
				return 'webcast-live';
			} else if (self.secondsAwayFromLaunch() < (60 * 60 * 24) && self.webcast.isLive() == 'false') {
				return 'webcast-updates';	
			} else {
				return 'webcast-inactive';
			}
		}),
		publicStatus: ko.pureComputed(function() {
			if (self.webcast.status() === 'webcast-live') {
				return 'Live Webcast'
			} else if (self.webcast.status() === 'webcast-updates') {
				return 'Launch Updates'
			}
		}),
		publicViewers: ko.pureComputed(function() {
			return ' (' + self.webcast.viewers() + ' viewers)';
		})
	};

	self.days = ko.observable();
	self.hours = ko.observable();
	self.minutes = ko.observable();
	self.seconds = ko.observable();

	self.daysText = ko.observable();
	self.hoursText = ko.observable();
	self.minutesText = ko.observable();
	self.secondsText = ko.observable();

	self.requestWebcastStatus = function() {
		$.ajax('/webcast/getstatus', 
		{
			dataType: 'json',
			type: 'POST',
			success: function(data) {
				self.webcast.isLive(data.isLive);
				self.webcast.viewers(data.viewers);
			}
		});
	}

	self.requestLaunchDateTime = function() {
		$.ajax('/missions/' + self.missionSlug() + '/requestlaunchdatetime',
		{
			dataType: 'json',
			type: 'POST',
			success: function(data) {
				// If there has been a change in the launch datetime, update & broadcast an event
				if (self.launchDateTime() !== data.launchDateTime) {
					self.launchDateTime(data.launchDateTime);
					self.launchUnixSeconds(Date.parse(data.launchDateTime) / 1000); 
					// Also remember to update the frequency of requests
					self.setFrequency();
				}
			}
		});	
	}

	self.setFrequency = function() {
		var secondsBetween = self.launchUnixSeconds() - Math.floor($.now() / 1000);

		if (secondsBetween < 1200 && self.requestIntervalFrequency() !== 'hypersonic') {
			self.requestIntervalFrequency('hypersonic');
			self.setTimers(1000 * 30);			

		} else if (secondsBetween < 3600 && secondsBetween >= 1200 && self.requestIntervalFrequency() !== 'supersonic') {
			self.requestIntervalFrequency('supersonic');
			self.setTimers(1000 * 60);

		} else if (secondsBetween < (3600 * 24) && secondsBetween >= 3600 && self.requestIntervalFrequency() !== 'transonic') {
			self.requestIntervalFrequency('transonic');
			self.setTimers(1000 * 60 * 10);
			
		} else if (secondsBetween >= (3600 * 24) && self.requestIntervalFrequency() !== 'subsonic') {
			self.requestIntervalFrequency('subsonic');
			self.setTimers(1000 * 60 * 60);
		}		
	};

	self.setTimers = function(frequency) {
		clearInterval(requestDateTimeTimer);
		clearInterval(requestWebcastStatusTimer);
		requestDateTimeTimer = setInterval(self.requestLaunchDateTime, frequency);
		requestWebcastStatusTimer = setInterval(self.requestWebcastStatus, frequency);
	};

	self.countdownProcessor = function() {
		var launchUnixSeconds = self.launchUnixSeconds();
		var currentUnixSeconds = Math.floor($.now() / 1000);

		// Stop the countdown, the rocket has launched. Display 0-0-0-0
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

	self.zeroTimer = function() {
		self.days(0);
		self.hours(0);
		self.minutes(0);
		self.seconds(0);
		self.daysText('Days');
		self.hoursText('Hours');
		self.minutesText('Minutes');
		self.secondsText('Seconds');
	};

	var requestDateTimeTimer;
	var requestWebcastStatusTimer;
	self.setFrequency();	
	self.countdownProcessor();
	self.requestWebcastStatus();
	var countdownTimer = setInterval(self.countdownProcessor, 1000);
}