define(['knockout', 'moment', 'jquery', 'text!components/tweet/tweet.html'], function(ko, moment, $, htmlString) {
    function TweetViewModel(params) {

        var self = this;

        function Image(image) {
            var self = this;
            koMapping.fromJS(image, {
                include: ['title', 'summary', 'subtype', 'tags', 'originated_at', 'mission_id', 'author', 'attribution', 'anonymous']
            }, this);

            self.title = ko.observable(null);
            self.summary = ko.observable(null);
            self.subtype = ko.observable(null);
            self.mission_id = ko.observable(null);
            self.author = ko.observable(null);
            self.attribution = ko.observable(null);
            self.anonymous = ko.observable(false);
            self.tags = ko.observableArray([]);
            self.originated_at = ko.observable(null);
        }

        self.tweet = params.tweet;
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
                        self.tweet.tweet_text(response.text);
                        self.tweet.tweet_user_profile_image_url(response.user.profile_image_url.replace("_normal", ""));
                        self.tweet.tweet_user_screen_name(response.user.screen_name);
                        self.tweet.tweet_user_name(response.user.name);
                        self.tweet.tweet_created_at(moment(response.created_at).format());

                        response.entities.media.forEach(function(image) {
                           self.tweet.images.push(new Image());
                        });
                    }
                });
            }
            // Allow default action
            return true;
        });
    }

    return { viewModel: TweetViewModel, template: htmlString };
});