define(['knockout', 'jquery'], function(ko, $) {
    var bindings = function () {
        ko.bindingHandlers.foreachNameAttr = {
            update: function (element, valueAccessor) {
                ko.bindingHandlers.attr.update(element, function () {
                    var index = ko.unwrap(valueAccessor());

                    var attribute = element.getAttribute('name');

                    if (attribute.indexOf('[') != -1) {
                        if (attribute.split('[').length == 2) {
                            var attribute = attribute.substr(0, attribute.indexOf('[')) + '[' + index + ']' + attribute.substr(attribute.indexOf('['));
                        } else if (attribute.split('[').length == 3) {
                            var attributeArray = attribute.split(new RegExp('\[[0-9]+\]'));
                            var attribute = attributeArray[0] + '[' + index + ']' + attributeArray[1];
                        }
                    } else {
                        var attribute = attribute + '[' + index + ']';
                    }

                    return {name: attribute}
                });
            }
        };

        ko.bindingHandlers.slideVisible = {
            update: function (element, valueAccessor, allBindings) {
                var valueUnwrapped = ko.unwrap(valueAccessor());

                // Grab some more data from another binding property
                var duration = allBindings.get('slideDuration') || 400; // 400ms is default duration unless otherwise specified

                // Now manipulate the DOM element
                (valueUnwrapped == true) ? $(element).slideDown(duration) : $(element).slideUp(duration);
            }
        };
    };

    return bindings;
});
