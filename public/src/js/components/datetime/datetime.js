
define(['jquery', 'knockout', 'moment', 'text!components/datetime/datetime.html'], function($, ko, moment, htmlString) {
    var DateTimeViewModel = function(params) {
        var self = this;

        self.days = [];
        self.months = [
            { value: 0, name: '-'},
            { value: 1, name: 'January'},
            { value: 2, name: 'February'},
            { value: 3, name: 'March'},
            { value: 4, name: 'April'},
            { value: 5, name: 'May'},
            { value: 6, name: 'June'},
            { value: 7, name: 'July'},
            { value: 8, name: 'August'},
            { value: 9, name: 'September'},
            { value: 10, name: 'October'},
            { value: 11, name: 'November'},
            { value: 12, name: 'December'}
        ];
        self.years = [];

        self.currentDay = ko.computed(function() {

        });

        self.currentMonth = ko.computed(function() {

        });

        self.currentYear = ko.computed(function() {

        });

        self.init = (function() {
            // Days
            for (i = 0; i < 31; i++) {
                if (i == 0) {
                    self.days.push('-');
                }
                self.days.push(i);
            }

            var currentYear = new Date().getFullYear();
            if (typeof params.startYear !== 'undefined') {
                var startYear = params.startYear;
            } else {
                var startYear = 1950;
            }

            while (startYear <= currentYear) {
                self.years.push(startYear++);
            }
        })();
    };

    return { viewModel: DateTimeViewModel, template: htmlString };
});