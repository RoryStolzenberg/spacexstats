define(['knockout', 'ko.mapping', 'jquery', 'text!components/rich-select/rich-select.html'], function(ko, koMapping, $, htmlString) {
    function RichSelectViewModel(params) {
        var self = this;

        self.mappingOptions = {
            key: function(data) {
                return data.id;
            },
            create: function(options) {
                return new Option(options.data);
            }
        };

        self.selectedOption = ko.observable();
        self.selectOption = function(option) {
            self.selectedOption(option);
            params.value(option.id);
            self.dropdownVisible(false);
        };

        self.options = ko.observableArray();

        function Option(richSelectOption) {
            var option = this;

            option.id = ko.observable(richSelectOption.mission_id);
            option.name = ko.observable(richSelectOption.name);
            option.summary = ko.observable(richSelectOption.summary);
            //this.image = ko.observable('/media/small/' + richSelectOption.featured_image.filename);

            option.image = ko.computed(function() {
                if (richSelectOption.featured_image != null) {
                    return '/media/small/' + richSelectOption.featured_image.filename;
                }
                return null;
            });

            option.isSelected = ko.computed(function() {
                return (option == self.selectedOption());
            });
        }

        self.dropdownVisible = ko.observable(false);
        self.toggleDropdownVisibility = function() {
            self.dropdownVisible(!self.dropdownVisible());
        };

        self.init = (function() {
            $.ajax(params.fetchFrom, {
                type: 'GET',
                success: function(fetchedItems) {

                    var defaultOption = { mission_id: 0, name: 'Select...', summary: '' };
                    fetchedItems.unshift(defaultOption);

                    koMapping.fromJS(fetchedItems, self.mappingOptions, self.options);

                    if (params.default == true && !params.selected) {
                        self.selectedOption($.grep(self.options(), function(e){ return e.id() == 0; })[0]);
                    } else if (params.selected) {
                        self.selectedOption($.grep(self.options(), function(e){ return e.id() == params.selected(); })[0]);
                    }
                }
            });
        })();
    }

    return {viewModel: RichSelectViewModel, template: htmlString};
});