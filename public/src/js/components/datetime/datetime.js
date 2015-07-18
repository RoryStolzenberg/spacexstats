
define(['jquery', 'knockout', 'moment', 'text!components/datetime/datetime.html'], function($, ko, moment, htmlString) {

    /*
    * Passable list of params:
    * value:        (observable string) Represents the date/datetime string in ISO8601 format, or undefined. Required.
    * type:         (string) "date" | "datetime" Represents whether time selectable options should be displayed. Required.
    * startYear:    (integer) Represents the year to produce year options from. Optional (defaults to 1950).
    * nullable      (boolean) Represents whether the date can be nulled. Optional.
    *
    *
     */
    var DateTimeViewModel = function(params) {
        var self = this;

        self.isValueNull = ko.observable(ko.unwrap(params.value) === null);

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
        self.isNull = ko.observable(false
        );
        self.isNull.subscribe(function(newValue) {
            if (newValue == true) {
                params.value(null);
            }
            console.log(ko.unwrap(params.value));
        });

        self.currentDay = ko.computed({ read: function() {
            if (ko.unwrap(params.value) === null) {
                return '00';
            } else {
                return ko.unwrap(params.value).substr(8,2);
            }

        }, write: function(newValue) {
            if (ko.unwrap(params.value) === null) {
                params.value(new Date().getFullYear() + '00-' + newValue);
            } else {
                params.value(params.value().substr(0, 8) + newValue);
            }
            console.log(params.value());

        }, deferEvaluation: true});

        self.currentMonth = ko.computed({ read: function() {
            if (ko.unwrap(params.value) === null) {
                return '00';
            }
            return ko.unwrap(params.value).substr(5,2);

        }, write: function(newValue) {
            if (ko.unwrap(params.value) === null) {
                params.value(new Date().getFullYear() + '-' + newValue + '-00');
            } else {
                params.value(params.value().substr(0, 5) + newValue + params.value().substr(7, 3));
            }
            console.log(params.value());

        }, deferEvaluation: true});

        self.currentYear = ko.computed({ read: function() {
            if (ko.unwrap(params.value) === null) {
                return new Date().getFullYear();
            }
            return ko.unwrap(params.value).substr(0,4);

        }, write: function(newValue) {
            if (ko.unwrap(params.value) === null) {
                params.value(newValue + '-00-00');
            } else {
                params.value(newValue + params.value().substr(4, 6));
            }
            console.log(params.value());

        }, deferEvaluation: true});

        self.init = (function() {
            if (typeof ko.unwrap(params.value) === 'undefined') {
                params.value(new Date().getFullYear() + '-00-00');
            }

            // Days
            self.days.push({ value: '00', display: '-'});
            for (i = 1; i <= 31; i++) {
                self.days.push({ value: ('0' + i).slice(-2), display: i });
            }

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