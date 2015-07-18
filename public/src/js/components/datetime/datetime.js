
define(['jquery', 'knockout', 'moment', 'text!components/datetime/datetime.html'], function($, ko, moment, htmlString) {

    /*
    * Passable list of params:
    * value:        (observable string) Represents the date/datetime string in ISO8601 format, or undefined. Required.
    * type:         (string) "date" | "datetime" Represents whether time selectable options should be displayed. Required.
    * startYear:    (integer) Represents the year to produce year options from. Required.
    * nullable      (boolean) Represents whether the date can be nulled. Optional.
    *
    *
     */
    var DateTimeViewModel = function(params) {
        var self = this;

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

        self.nullable = ko.observable((typeof params.nullable !== 'undefined'));
        self.isNull = ko.observable(params.isNull);
        self.isNull.subscribe(function(newValue) {
            if (newValue == true) {
                params.value(undefined);
            }
        });

        self.currentDay = ko.computed({ read: function() {
            if (typeof ko.unwrap(params.value) === 'undefined') {
                return '00';
            } else {
                return ko.unwrap(params.value).substr(8,2);
            }
        }, write: function(newValue) {

        }});

        self.currentMonth = ko.computed({ read: function() {
            if (typeof ko.unwrap(params.value) === 'undefined') {
                return '00';
            } else {
                return ko.unwrap(params.value).substr(5,2);
            }
        }, write: function(newValue) {

        }});

        self.currentYear = ko.computed({ read: function() {
            if (typeof ko.unwrap(params.value) === 'undefined') {
                return '0000';
            } else {
                return ko.unwrap(params.value).substr(0,4);
            }
        }, write: function(newValue) {
            // Check if type is date or datetime

            // Check if rest of string is undefined if setting
        }});

        self.init = (function() {
            console.log(ko.unwrap(params.value));
            // Days
            self.days.push({ value: '00', display: '-'});
            for (i = 1; i <= 31; i++) {
                self.days.push({ value: ('0' + i).slice(-2), display: i });
            }

            console.log(self.days);

            var currentYear = new Date().getFullYear();
            if (typeof params.startYear !== 'undefined') {
                var startYear = params.startYear;
            } else {
                var startYear = 1950;
            }

            self.years.push({ value: '0000', display: '-' });
            while (currentYear >= startYear) {
                self.years.push({ value: currentYear, display: currentYear });
                currentYear--;
            }


        })();
    };

    return { viewModel: DateTimeViewModel, template: htmlString };
});