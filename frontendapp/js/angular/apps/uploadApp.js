angular.module("uploadApp", ["directives.upload", "directives.selectList", "directives.tags", "directives.deltaV"], ['$interpolateProvider', function($interpolateProvider) {
    $interpolateProvider.startSymbol('[[');
    $interpolateProvider.endSymbol(']]');

}]).controller("uploadAppController", ["$scope", function($scope) {
    $scope.activeSection = "upload";

    $scope.missions = laravel.missions;
    $scope.tags = laravel.tags;

    $scope.changeSection = function(section) {
        $scope.activeSection = section;
    }

}]).controller("uploadController", ["$rootScope", "$scope", "objectFromFile", function($rootScope, $scope, objectFromFile) {
    $scope.activeUploadSection = "dropzone";
    $scope.buttonText = "Next";

    $scope.currentVisibleFile = null;
    $scope.isVisibleFile = function(file) {
        return $scope.currentVisibleFile === file;
    };
    $scope.setVisibleFile = function(file) {
        $scope.currentVisibleFile = file;
    };

    $scope.uploadCallback = function() {

        // Once files have been successfully upload, convert to Objects
        $scope.files.forEach(function(file, index) {
            file = objectFromFile.create(file);

            // Set the initial visible file
            if (index === 0) {
                $scope.currentVisibleFile = file;
            }
        });

        // Change the upload section
        $scope.activeUploadSection = "data";
        $scope.$apply();
    };

    $scope.fileSubmitButtonFunction = function() {
        console.log($scope.files);
        $rootScope.postToMissionControl($scope.files, 'files');
    }

}]).controller("postController", ["$scope", function($scope) {

}]).controller("writeController", ["$scope", function($scope) {

}]).run(['$rootScope', '$http', function($rootScope, $http) {
    $rootScope.postToMissionControl = function(dataToUpload, submissionHeader) {
        var req = {
            method: 'POST',
            url: '/missioncontrol/create/submit',
            headers: {
                'Submission-Type': submissionHeader
            },
            data: {
                data: dataToUpload
            }
        };

        $http(req).then(function() {
            window.location = '/missioncontrol';
        });
    }
}]).factory("Image", function() {
    return function (image) {
        var self = image;

        self.title = null;
        self.summary = null;
        self.subtype = null;
        self.mission_id = null;
        self.author = null;
        self.attribution = null;
        self.anonymous = null;
        self.tags = [];
        self.originated_at = null;

        return self;
    }

}).factory("GIF", function() {
    return function(gif) {
        var self = gif;

        self.title = null;
        self.summary = null;
        self.subtype = null;
        self.mission_id = null;
        self.author = null;
        self.attribution = null;
        self.anonymous = null;
        self.tags = [];
        self.originated_at = null;

        return self;
    }

}).factory("Audio", function() {
    return function(audio) {
        var self = audio;

        self.title = null;
        self.summary = null;
        self.subtype = null;
        self.mission_id = null;
        self.author = null;
        self.attribution = null;
        self.anonymous = null;
        self.tags = [];
        self.originated_at = null;

        return self;
    }

}).factory("Video", function() {
    return function(video) {
        var self = video;

        self.title = null;
        self.summary = null;
        self.subtype = null;
        self.mission_id = null;
        self.author = null;
        self.attribution = null;
        self.anonymous = null;
        self.tags = [];
        self.originated_at = null;

        return self;
    }

}).factory("Document", function() {
    return function(document) {
        var self = document;

        self.title = null;
        self.summary = null;
        self.subtype = null;
        self.mission_id = null;
        self.author = null;
        self.attribution = null;
        self.anonymous = null;
        self.tags = [];
        self.originated_at = null;

        return self;
    }
}).service("objectFromFile", ["Image", "GIF", "Audio", "Video", "Document", function(Image, GIF, Audio, Video, Document) {
    this.create = function(file) {
        switch(file.type) {
            case 1: return new Image(file);
            case 2: return new GIF(file);
            case 3: return new Audio(file);
            case 4: return new Video(file);
            case 5: return new Document(file);
            default: return null;
        }
    }
}]);
