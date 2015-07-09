define(['jquery', 'knockout', 'ko.mapping'], function($, ko, koMapping) {
    var EditUserViewModel = function (username) {

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
            /*$.ajax('/users/' + self.username + '/edit',
                {
                    dataType: 'json',
                    type: 'POST',
                    data: self.profile,
                    success: function (response) {
                        console.log(response);
                    }
                }
            );*/
            console.log(self.profile);
        };

        self.updateEmailNotifications = function() {

        }
    };

    return EditUserViewModel;
});

