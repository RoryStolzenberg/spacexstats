define(['knockout', 'ko.mapping', 'jquery', 'text!components/rich-select/rich-select.html'], function(ko, koMapping, $, htmlString) {

    /*
    * Passable list of params:
    * data:             (array) contains all the data to be enumerated over in the select list. Required.
    * hasDefaultOption: (boolean) Represents whether a default 'Select...' option should be provided. Required.
    * value:            (observable) Represents the id of the current object selected
    * uniqueKey:        (string) The name of the key that represents the data containing the unique ID. Required.
    * searchable:       (boolean) Is the dropdown searchable or not? Required.
     */
    function RichSelectViewModel(params) {
        var self = this;

        self.selectedOption = ko.observable();
        self.selectOption = function(option) {
            self.selectedOption(option);
            if (option.id() != 0) {
                params.value(option.id());
            } else {
                params.value(undefined);
            }
            self.searchValue("");
            self.dropdownVisible(false);
        };

        self.options = ko.observableArray();
        self.searchable = params.searchable;
        self.searchValue = ko.observable("");

        self.filteredOptions = ko.computed(function() {
            return self.options().filter(function(option) {
                if (params.searchable === true) {
                    if (self.searchValue() === "") {
                        return true;
                    } else {

                        var lowerCaseName = option.name().toLowerCase();
                        var lowerCaseSearch = self.searchValue().toLowerCase();

                        return (lowerCaseName.indexOf(lowerCaseSearch) > -1);
                    }
                } else {
                    return true;
                }
            });
        });

        function Option(richSelectOption) {
            var option = this;

            option.id = ko.observable(richSelectOption.id);
            option.name = ko.observable(richSelectOption.name);
            option.summary = ko.observable(richSelectOption.summary);

            option.image = ko.computed(function() {
                if (richSelectOption.featured_image != null) {
                    return richSelectOption.featured_image.filename;
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
            // remap data with standardized values
            var data = ko.unwrap(params.data).map(function(item) {
                return {
                    id: item[params.uniqueKey],
                    name: item.name,
                    summary: item.summary,
                    featured_image: item.featured_image
                }
            });

            // apply a default option if one is required
            if (params.hasDefaultOption === true) {
                var defaultOption = { id: 0, name: 'Select...', summary: ''};
                data.unshift(defaultOption);
            }

            // map values to knockout
            koMapping.fromJS(data, {
                create: function(options) {
                    return new Option(options.data);
                }
            }, self.options);

            console.log(params.value());

            // set default value
            if (params.value() != null) {
                self.selectedOption($.grep(self.options(), function(e) {
                    return e.id() == ko.unwrap(params.value);
                })[0]);
            } else {
                self.selectedOption($.grep(self.options(), function(e) {
                    return e.id() == 0;
                })[0]);
            }
        })();
    }

    return {viewModel: RichSelectViewModel, template: htmlString};
});