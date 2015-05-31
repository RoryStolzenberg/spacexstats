ko.bindingHandlers.foreachNameAttr = {
    update: function (element, valueAccessor) {
        ko.bindingHandlers.attr.update(element, function () {
            var index = ko.unwrap(valueAccessor());

            var attribute = element.getAttribute('name');

            if (attribute.indexOf('[') != -1) {
                if (attribute.split('[').length == 2) {
                    var attribute = attribute.substr(0,attribute.indexOf('[')) + '[' + index + ']' + attribute.substr(attribute.indexOf('['));
                } else if (attribute.split('[').length == 3) {
                    var attributeArray = attribute.split(new RegExp('\[[0-9]+\]'));
                    var attribute = attributeArray[0] + '[' + index + ']' + attributeArray[1];
                }
            } else {
                var attribute = attribute + '[' + index + ']';
            }

            return { name: attribute }
        });
    }
};

var CreateMissionViewModel = function() {
    var self = this;

    // Spacecraft
    function spacecraftViewModel(type, spacecraftName, flightName, spacecraftReturn, returnMethod, upmass, downmass, issBerth, issUnberth)  {
        this.type = (typeof type !== undefined) ? type : '' ;
        this.spacecraftName = (typeof spacecraftName !== undefined) ? spacecraftName : '' ;
        this.flightName = (typeof flightName !== undefined) ? flightName : '' ;
        this.spacecraftReturn = (typeof spacecraftReturn !== undefined) ? spacecraftReturn : '' ;
        this.returnMethod = (typeof returnMethod !== undefined) ? returnMethod : '' ;
        this.upmass = (typeof upmass !== undefined) ? upmass : '' ;
        this.downmass = (typeof downmass !== undefined) ? downmass : '' ;
        this.issBerth = (typeof issBerth !== undefined) ? issBerth : '' ;
        this.issUnberth = (typeof issUnberth !== undefined) ? issUnberth : '' ;
    }

    self.spacecraft = ko.observableArray([]);

    self.addSpacecraft = function() {
        if (self.spacecraft.length == 0) {
            self.spacecraft.push(new spacecraftViewModel());
        }
    };

    self.removeSpacecraft = function(spacecraft) {
        self.spacecraft.remove(spacecraft);
    };

    // Payloads
    function payloadViewModel(name, operator, mass, link) {
        this.name = (typeof name !== undefined) ? name : '' ;
        this.operator = (typeof operator !== undefined) ? operator : '' ;
        this.mass = (typeof mass !== undefined) ? mass : '' ;
        this.link = (typeof link !== undefined) ? link : '' ;
    }

    self.payloads = ko.observableArray([]);

    self.addPayload = function() {
        self.payloads.push(new payloadViewModel());
    };

    self.removePayload = function(payload) {
        self.payloads.remove(payload);
    };
}