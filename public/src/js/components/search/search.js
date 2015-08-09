
define(['jquery', 'knockout', 'moment', 'text!components/search/search.html'], function($, ko, moment, htmlString) {

    /*
     * Passable list of params:
     *
     */
    var SearchViewModel = function(params) {
        var self = this;

        self.init = (function() {
        })();
    };

    return { viewModel: SearchViewModel, template: htmlString };
});