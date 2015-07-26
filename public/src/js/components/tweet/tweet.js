define(['knockout', 'jquery', 'text!components/tweet/tweet.html'], function(ko, $, htmlString) {
    function TweetViewModel(params) {

        function Tweet(tweet) {
            this.tweet_id = ko.observable(tweet.id);
            this.tweet_text = ko.observable(tweet.text);
            this.tweet_user_name = ko.observable(tweet.user.name);
            this.tweet_user_screen_name = ko.observable(tweet.user.screen_name);
            this.tweet_created_at = ko.observable(tweet.created_at);
            this.tweet_parent_id = ko.observable();
            this.images = ko.observableArray(tweet.media.entities);
        }

        var self = this;

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
                        self.tweet(new Tweet(response));
                    }
                });
            }
            // Allow default action
            return true;
        });

        self.tweet = ko.observable();
    }
    return { viewModel: TweetViewModel, template: htmlString };
});