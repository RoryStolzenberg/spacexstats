(function() {
    var app = angular.module('app', []);

    app.service('missionDataService', ["$http", function($http) {
        this.telemetry = function(slug) {
            return $http.get('/missions/'+ slug + '/telemetry');
        };

        this.orbitalElements = function(slug) {
            return $http.get('/missions/' + slug + '/orbitalelements').then(function(response) {
                // premap the dates of the timestamps because otherwise we'll do it too many times
                if (response.data === Array) {
                    return response.data.map(function(orbitalElement) {
                        orbitalElement.epoch = moment(orbitalElement.epoch).toDate();
                        return orbitalElement;
                    });
                }
            });
        };

        this.launchEvents = function(slug) {
            return $http.get('/missions/' + slug + '/launchevents');
        }
    }]);
})();
