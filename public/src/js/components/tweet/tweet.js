define(['knockout', 'jquery', 'text!components/tweet/tweet.html'], function(ko, $, htmlString) {
    function TweetViewModel(params) {
        var self = this;

        self.twitterYears = ko.observableArray([]);

        self.action = params.action;

        self.tweetUrl = ko.observable();
        self.tweetUrl.subscribe(function(value) {
            var valueOfTwitterUrlField = value;

            // Check that the entered URL contains 'twitter' before sending a request (perform more thorough validation serverside)
            if (valueOfTwitterUrlField.indexOf('twitter.com') !== -1) {

                var explodedVals = valueOfTwitterUrlField.split('/');
                var id = explodedVals[explodedVals.length - 1];

                $.ajax('/missioncontrol/create/retrievetweet/' + id, {
                    dataType: 'json',
                    type: 'GET',
                    success: function (response) {
                        console.log(response);
                    }
                });
            }
            // Allow default action
            return true;
        });

        // Init
        self.init = (function() {
            var currentYear = new Date().getFullYear();
            var startYear = 2006; // Twitter was founded

            while (startYear <= currentYear) {
                self.twitterYears.push(startYear++);
            }
        })();
    }
    return { viewModel: TweetViewModel, template: htmlString };
});