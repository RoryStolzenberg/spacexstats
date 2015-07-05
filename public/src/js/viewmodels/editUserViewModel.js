define(['jquery', 'knockout', 'ko.mapping'], function($, ko, koMapping) {
    var EditUserViewModel = function (username) {

        ko.components.register('rich-select', { require: 'components/rich-select/rich-select'});

        var self = this;
        self.username = username;

        self.favorite_mission_id = ko.observable();
        self.patch_mission_id = ko.observable();

        self.updateProfile = function (formData) {
            $.ajax('/users/' + self.username + '/edit',
                {
                    dataType: 'json',
                    type: 'POST',
                    data: formData,
                    success: function (response) {
                        console.log(response);
                    }
                }
            );
        }
    };

    return EditUserViewModel;
});

