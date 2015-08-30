angular.module('reviewApp', [], ['$interpolateProvider', function($interpolateProvider) {
    $interpolateProvider.startSymbol('[[');
    $interpolateProvider.endSymbol(']]');

}]).controller("reviewController", ["$scope", "$http", "ObjectToReview", function($scope, $http, ObjectToReview) {

    $scope.visibilities = ['Default', 'Public', 'Hidden'];

    $scope.objectsToReview = [];

    $scope.action = function(object, newStatus) {

        object.status = newStatus;

        $http.post('/missioncontrol/review/update/' + object.object_id, {
                visibility: object.visibility, status: object.status
        }).then(function() {
            $scope.objectsToRemove.splice($scope.objectsToRemove.indexOf(object), 1);

        }, function(response) {
            alert('An error occured');
        });
    };

    (function() {
        $http.get('/missioncontrol/review/get').then(function(response) {
            response.data.forEach(function(objectToReview) {
                 $scope.objectsToReview.push(new ObjectToReview(objectToReview));
            });
            console.log($scope.objectsToReview);
        });
    })();

}]).factory("ObjectToReview", function() {
    return function (object) {
        var self = object;

        self.visibility = "Default";

        self.linkToObject = '/missioncontrol/object/' + self.object_id;

        self.linkToUser = 'users/' + self.user.username;

        self.textType = function() {
            switch(self.type) {
                case 1:
                    return 'Image';
                case 2:
                    return 'GIF';
                case 3:
                    return 'Audio';
                case 4:
                    return 'Video';
                case 5:
                    return 'Document';
            }
        };

        self.textSubtype = function() {
            switch(self.subtype) {
                case 1:
                    return 'MissionPatch';
                case 2:
                    return 'Photo';
                case 3:
                    return 'Telemetry';
                case 4:
                    return 'Chart';
                case 5:
                    return 'Screenshot';
                case 6:
                    return 'LaunchVideo';
                case 7:
                    return 'PressConference';
                case 8:
                    return 'PressKit';
                case 9:
                    return 'CargoManifest';
                default:
                    return null;
            }
        };

        self.createdAtRelative = moment.utc(self.created_at).fromNow();

        return self;
    }

});

