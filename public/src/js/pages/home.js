require(['jquery', 'knockout', 'viewmodels/HomePageViewModel'], function($, ko, HomePageViewModel) {

    ko.components.register('countdown', { require: 'components/countdown/countdown' });

    $(document).ready(function() {
        ko.applyBindings(new HomePageViewModel());
    });
});