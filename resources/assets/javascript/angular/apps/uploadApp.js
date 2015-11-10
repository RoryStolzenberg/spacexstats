(function() {
    var uploadApp = angular.module('app', []);

    uploadApp.controller("uploadAppController", ["$scope", function($scope) {
        $scope.activeSection = "upload";

        $scope.data = {
            missions: laravel.missions,
            tags: laravel.tags,
            subtypes: {
                images: [
                    {value: 1, display: 'Mission Patch' },
                    {value: 2, display: 'Photo' },
                    {value: 4, display: 'Chart' },
                    {value: 5, display: 'Screenshot' },
                    {value: 10, display: 'Infographic' },
                    {value: 11, display: 'News Summary' },
                    {value: 16, display: 'Hazard Map' },
                    {value: 17, display: 'License' },
                ],
                video: [
                    {value: 6, display: 'Launch Video' },
                    {value: 7, display: 'Press Conference' }
                ],
                documents: [
                    {value: 6, display: 'Press Kit' },
                    {value: 7, display: 'Cargo Manifest' },
                    {value: 15, display: 'Weather Forecast' },
                    {value: 17, display: 'License' }
                ]
            },
            publishers: laravel.publishers
        };

        $scope.changeSection = function(section) {
            $scope.activeSection = section;
        }
    }]);

    uploadApp.controller("uploadController", ["$scope", "objectFromFile", "uploadService", function($scope, objectFromFile, uploadService) {
        $scope.activeUploadSection = "dropzone";
        $scope.isSubmitting = false;
        $scope.isUploading = false;

        $scope.currentVisibleFile = null;
        $scope.isVisibleFile = function(file) {
            return $scope.currentVisibleFile === file;
        };
        $scope.setVisibleFile = function(file) {
            $scope.currentVisibleFile = file;
        };

        $scope.uploadCallback = function() {
            $scope.isUplading = false;

            // Once files have been successfully upload, convert to Objects
            $scope.files.forEach(function(file, index) {
                file = objectFromFile.create(file, index);

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
            $scope.isSubmitting = true;
            uploadService.postToMissionControl($scope.files, 'files');
        }
    }]);

    uploadApp.controller("postController", ["$scope", "uploadService", function($scope, uploadService) {

        $scope.NSFcomment = {};
        $scope.redditcomment = {};
        $scope.pressrelease = {};
        $scope.article = {};
        $scope.tweet = {};

        $scope.isSubmitting = false;

        $scope.postSubmitButtonFunction = function() {
            $scope.isSubmitting = true;
            switch ($scope.postType) {
                case 'NSFcomment': uploadService.postToMissionControl($scope.NSFcomment, 'NSFcomment'); break;
                case 'redditcomment': uploadService.postToMissionControl($scope.redditcomment, 'redditcomment'); break;
                case 'pressrelease' : uploadService.postToMissionControl($scope.pressrelease, 'pressrelease'); break;
                case 'article': uploadService.postToMissionControl($scope.article, 'article'); break;
                case 'tweet': uploadService.postToMissionControl($scope.tweet, 'tweet'); break;
            }
        }
    }]);

    uploadApp.controller("writeController", ["$scope", "uploadService", function($scope, uploadService) {

        $scope.text = {
            title: null,
            content: null,
            mission_id: null,
            anonymous: null,
            tags: []
        };

        $scope.isSubmitting = false;

        $scope.writeSubmitButtonFunction = function() {
            $scope.isSubmitting = true;
            uploadService.postToMissionControl($scope.text, 'text');
        }
    }]);

    uploadApp.service('uploadService', ['$http', 'CSRF_TOKEN', function($http, CSRF_TOKEN) {
        this.postToMissionControl = function(dataToUpload, submissionHeader) {
            var req = {
                method: 'POST',
                url: '/missioncontrol/create/submit',
                headers: {
                    'Submission-Type': submissionHeader
                },
                data: {
                    data: dataToUpload,
                    _token: CSRF_TOKEN
                }
            };

            $http(req).then(function() {
                window.location = '/missioncontrol';
            });
        }
    }]);

    uploadApp.factory("Image", function() {
        return function (image, index) {
            var self = image;

            self.index = index;

            self.title = null;
            self.summary = null;
            self.subtype = null;
            self.mission_id = null;
            self.author = null;
            self.attribution = null;
            self.anonymous = null;
            self.tags = [];

            self.datetimeExtractedFromEXIF = self.originated_at !== null ? true : false;

            return self;
        }
    });

    uploadApp.factory("GIF", function() {
        return function(gif, index) {
            var self = gif;

            self.index = index;

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
    });

    uploadApp.factory("Audio", function() {
        return function(audio, index) {
            var self = audio;

            self.index = index;

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
    });

    uploadApp.factory("Video", function() {
        return function(video, index) {
            var self = video;

            self.index = index;

            self.title = null;
            self.summary = null;
            self.external_url = null;
            self.subtype = null;
            self.mission_id = null;
            self.author = null;
            self.attribution = null;
            self.anonymous = null;
            self.tags = [];
            self.originated_at = null;

            return self;
        }
    });

    uploadApp.factory("Document", function() {
        return function(document, index) {
            var self = document;

            self.index = index;

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
    });

    uploadApp.service("objectFromFile", ["Image", "GIF", "Audio", "Video", "Document", function(Image, GIF, Audio, Video, Document) {
        this.create = function(file, index) {
            switch(file.type) {
                case 'Image': return new Image(file, index);
                case 'GIF': return new GIF(file, index);
                case 'Audio': return new Audio(file, index);
                case 'Video': return new Video(file, index);
                case 'Document': return new Document(file, index);
                default: return null;
            }
        }
    }]);
})();