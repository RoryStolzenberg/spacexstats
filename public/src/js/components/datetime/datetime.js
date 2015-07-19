
define(['jquery', 'knockout', 'moment', 'text!components/datetime/datetime.html'], function($, ko, moment, htmlString) {

    /*
    * Passable list of params:
    * value:        (observable string) Represents the date/datetime string in ISO8601 format, or undefined. Required.
    * type:         (string) "date" | "datetime" Represents whether time selectable options should be displayed. Required.
    * startYear:    (integer) Represents the year to produce year options from. Optional (defaults to 1950).
    * nullable      (boolean) Represents whether the date can be nulled. Optional.
    * isNull        (boolean) Represents whether the date is currently nulled. Optional, requires nullable.
    *
     */
    var DateTimeViewModel = function(params) {
        var self = this;

        self.type = ko.observable(params.type);

        self.days = [];
        self.months = [
            { value: '00', display: '-'},
            { value: '01', display: 'January'},
            { value: '02', display: 'February'},
            { value: '03', display: 'March'},
            { value: '04', display: 'April'},
            { value: '05', display: 'May'},
            { value: '06', display: 'June'},
            { value: '07', display: 'July'},
            { value: '08', display: 'August'},
            { value: '09', display: 'September'},
            { value: '10', display: 'October'},
            { value: '11', display: 'November'},
            { value: '12', display: 'December'}
        ];
        self.years = [];

        self.nullable = ko.observable((typeof params.nullable !== 'undefined') && (params.nullable === true));
        self.isNull = ko.observable((typeof params.isNull !== 'undefined') && (typeof params.nullable !== 'undefined') && (params.nullable === true));
        self.isNull.subscribe(function(newValue) {
            if (newValue == true) {
                params.value(null);
            }
        });

        // Current second computed
        self.currentSecond = ko.computed({ read: function() {
            return (params.value() === null) ? '00' : params.value().substr(17,2);

        }, write: function(newValue) {
            params.value(params.value() === null ? new Date().getFullYear() + '00-00 00:00:' + ("0" + newValue).slice(-2) : params.value().substr(0, 17) + ("0" + newValue).slice(-2));
            console.log(params.value());

        }, deferEvaluation: true});

        // Current minute computed
        self.currentMinute = ko.computed({ read: function() {
            return (params.value() === null) ? '00' : params.value().substr(14,2);

        }, write: function(newValue) {
            params.value(params.value() === null ? new Date().getFullYear() + '00-00 00:' + ("0" + newValue).slice(-2) + ':00' : params.value().substr(0, 14) + ("0" + newValue).slice(-2) + params.value().substr(16));
            console.log(params.value());

        }, deferEvaluation: true});

        // Current hour computed
        self.currentHour = ko.computed({ read: function() {
            return (params.value() === null) ? '00' : params.value().substr(11,2);

        }, write: function(newValue) {
            params.value(params.value() === null ? new Date().getFullYear() + '00-00 ' + ("0" + newValue).slice(-2) + ':00:00' : params.value().substr(0, 11) + ("0" + newValue).slice(-2) + params.value().substr(13));
            console.log(params.value());

        }, deferEvaluation: true});

        // Current day computed
        self.currentDay = ko.computed({ read: function() {
            return (params.value() === null) ? '00' : params.value().substr(8,2);

        }, write: function(newValue) {
            if (self.type() == 'date') {
                params.value(params.value() === null ? new Date().getFullYear() + '00-' + newValue : params.value().substr(0, 8) + newValue);
            } else {
                params.value(params.value() === null ? new Date().getFullYear() + '00-' + newValue + ' 00:00:00' : params.value().substr(0, 8) + newValue + params.value().substr(10));
            }
            console.log(params.value());


        }, deferEvaluation: true});

        // Current month computed
        self.currentMonth = ko.computed({ read: function() {
            return (params.value() === null) ? '00' : params.value().substr(5,2);

        }, write: function(newValue) {
            if (self.type() == 'date') {
                params.value(params.value() === null ? new Date().getFullYear() + '-' + newValue + '-00' : params.value().substr(0, 5) + newValue + params.value().substr(7));
            } else {
                params.value(params.value() === null ? new Date().getFullYear() + '-' + newValue + '-00 00:00:00' : params.value().substr(0, 5) + newValue + params.value().substr(7));
            }
            console.log(params.value());

        }, deferEvaluation: true});

        // Current year computed
        self.currentYear = ko.computed({ read: function() {
            return (params.value() === null) ? new Date().getFullYear() : params.value().substr(0,4);

        }, write: function(newValue) {
            if (self.type() == 'date') {
                params.value(params.value() === null ? newValue + '-00-00' : newValue + params.value().substr(4));
            } else {
                params.value(params.value() === null ? newValue + '-00-00 00:00:00' : newValue + params.value().substr(4));

            }

            console.log(params.value());

        }, deferEvaluation: true});

        self.init = (function() {
            if (typeof ko.unwrap(params.value) === 'undefined') {
                params.value(params.type == 'date' ? new Date().getFullYear() + '-00-00' : new Date().getFullYear() + '-00-00 00:00:00');
            }

            // Days
            self.days.push({ value: '00', display: '-'});
            for (i = 1; i <= 31; i++) {
                self.days.push({ value: ('0' + i).slice(-2), display: i });
            }

            // Years
            var currentYear = new Date().getFullYear();
            if (typeof params.startYear !== 'undefined') {
                var startYear = params.startYear;
            } else {
                var startYear = 1950;
            }

            while (currentYear >= startYear) {
                self.years.push({ value: currentYear, display: currentYear });
                currentYear--;
            }
        })();
    };

    return { viewModel: DateTimeViewModel, template: htmlString };
});