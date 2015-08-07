
define(['jquery', 'knockout', 'moment', 'text!components/search/search.html'], function($, ko, moment, htmlString) {

    /*
     * Passable list of params:
     * value:        (observable string) Represents the date/datetime string in ISO8601 format, or undefined. Required.
     * type:         (string) "date" | "datetime" Represents whether time selectable options should be displayed. Required.
     * startYear:    (integer) Represents the year to produce year options from. Optional (defaults to 1950).
     * nullable      (boolean) Represents whether the date can be nulled. Optional.
     * isNull        (boolean) Represents whether the date is currently nulled. Optional, requires nullable.
     *
     */
    var SearchViewModel = function(params) {
        var self = this;

        self.init = (function() {
        })();
    };

    return { viewModel: SearchViewModel, template: htmlString };
});