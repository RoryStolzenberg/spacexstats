define(['jquery', 'knockout', 'ko.mapping'], function($, ko, koMapping) {
    var EditUserViewModel = function (username) {

        console.log(laravel.emailSubscriptions);

        var getOriginalValue = ko.bindingHandlers.value.init;
        ko.bindingHandlers.value.init = function(element, valueAccessor, allBindings) {
            if (allBindings.has('getOriginalValue')) {
                valueAccessor()(element.value);
            }
            getOriginalValue.apply(this, arguments);
        };

        ko.components.register('rich-select', { require: 'components/rich-select/rich-select'});

        var self = this;
        self.username = username;

        self.profile = {
            summary: ko.observable(),
            twitter_account: ko.observable(),
            reddit_account: ko.observable(),
            favorite_mission: ko.observable(),
            favorite_mission_patch: ko.observable(),
            favorite_quote: ko.observable()
        };

        self.updateProfile = function () {
            var mappedProfile = koMapping.toJS(self.profile);
            $.ajax('/users/' + self.username + '/edit',
                {
                    dataType: 'json',
                    type: 'POST',
                    data: JSON.stringify(mappedProfile, function(key, value) {
                        if (value === "" || typeof value === 'undefined') {
                            return null;
                        }
                        return value;
                    }),
                    contentType: "application/json",
                    success: function (response) {
                        console.log(response);
                    }
                }
            );
        };

        self.emailNotifications = {
            launch_time_change: ko.observable(),
            new_mission: ko.observable(),
            launch_in_24_hours: ko.observable(),
            launch_in_3_hours: ko.observable(),
            launch_in_1_hour: ko.observable(),
            news_summaries: ko.observable()
        };

        self.updateEmailNotifications = function() {
            console.log(koMapping.toJS(self.emailNotifications));
        }
    };

    return EditUserViewModel;
});

