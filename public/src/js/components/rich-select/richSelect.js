define(['knockout', 'jquery', 'text!components/rich-select/richSelect.html'], function(ko, $, htmlString) {
    function RichSelectViewModel(params) {
        var self = this;

        function RichSelectOption(richSelectOption) {
            this.id = ko.observable(richSelectOption.id);
            this.name = ko.observable(richSelectOption.name);
            this.summary = ko.observable(richSelectOption.summary);
            this.image = ko.observable(richSelectOption.image);
            this.selected = ko.observable();
        }

        self.richSelectOptions = ko.observableArray();

        self.init = (function() {
            for(i = 0; i < params.options.length; i++) {
                self.richSelectOptions.push(new RichSelectOption(params.options[i]));
            }
        })();

    }

    return {viewModel: RichSelectViewModel, template: htmlString};
});