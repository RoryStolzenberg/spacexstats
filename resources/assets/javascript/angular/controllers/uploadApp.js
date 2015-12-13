    (function() {
    var uploadApp = angular.module('app', []);

    uploadApp.controller("uploadAppController", ["$scope", function($scope) {
        $scope.activeSection = "upload";
        $scope.showRecentAdditions = true;

        $scope.data = {
            missions: laravel.missions,
            tags: laravel.tags,
            subtypes: {
                images: [
                    'Mission Patch',
                    'Photo',
                    'Chart',
                    'Concept Art',
                    'Screenshot',
                    'Infographic',
                    'News Summary',
                    'Hazard Map'
                ],
                videos: [
                    'Launch Video',
                    'Press Conference'
                ],
                documents: [
                    'Press Kit',
                    'Cargo Manifest',
                    'Weather Forecast',
                    'License'
                ]
            },
            publishers: laravel.publishers,
            recentUploads: laravel.recentUploads
        };

        $scope.changeSection = function(section) {
            $scope.activeSection = section;
            $scope.showRecentAdditions = section == 'upload';
        };

        $scope.$on('hideSubmissionMethods', function() {
            $scope.areSubmissionMethodsHidden = true;
        });

    }]);

    uploadApp.controller("uploadController", ["$rootScope", "$scope", "objectFromFile", "uploadService", function($rootScope, $scope, objectFromFile, uploadService) {
        $scope.activeUploadSection = "dropzone";
        $scope.isSubmitting = false;
        $scope.isUploading = false;
        $scope.queuedFiles = 0;

        $scope.currentVisibleFile = null;
        $scope.isVisibleFile = function(file) {
            return $scope.currentVisibleFile === file;
        };
        $scope.setVisibleFile = function(file) {
            $scope.currentVisibleFile = file;
        };

        $scope.uploadCallback = function() {
            $scope.isUploading = false;

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
            $rootScope.$broadcast('hideSubmissionMethods');
            $scope.showRecentAdditions = false;
            $scope.$apply();
        };

        $scope.optionalCollection = null;

        $scope.fileSubmitButtonText = function(form) {
            if (form.$invalid) {
                return 'We need more info';
            } else if ($scope.isSubmitting) {
                return 'Submitting...';
            } else {
                return 'Submit';
            }
        };

        $scope.fileSubmitButtonFunction = function() {
            $scope.isSubmitting = true;
            uploadService.postToMissionControl($scope.files, 'files', $scope.optionalCollection);
        }
    }]);

    uploadApp.controller("postController", ["$scope", "uploadService", function($scope, uploadService) {

        $scope.NSFcomment = {};
        $scope.redditcomment = {};
        $scope.pressrelease = {};
        $scope.article = {};
        $scope.tweet = {};

        $scope.isSubmitting = false;

        $scope.detectPublisher = function() {

        };

        $scope.postSubmitButtonText = function(form) {
            if (form.$invalid) {
                return 'We need more info';
            } else if ($scope.isSubmitting) {
                return 'Submitting...';
            } else {
                return 'Submit';
            }
        };

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
            summary: null,
            mission_id: null,
            anonymous: null,
            tags: []
        };

        $scope.isSubmitting = false;

        $scope.writeSubmitButtonText = function(form) {
            if (form.$invalid) {
                return 'We need more info';
            } else if ($scope.isSubmitting) {
                return 'Submitting...';
            } else {
                return 'Submit';
            }
        };

        $scope.writeSubmitButtonFunction = function() {
            $scope.isSubmitting = true;
            uploadService.postToMissionControl($scope.text, 'text');
        }
    }]);

    uploadApp.service('uploadService', ['$http', 'CSRF_TOKEN', 'flashMessage', function($http, CSRF_TOKEN, flashMessage) {
        this.postToMissionControl = function(dataToUpload, resourceType, collection) {
            var submissionData = {
                data: dataToUpload,
                collection: collection,
                type: resourceType,
                _token: CSRF_TOKEN
            };

            if (resourceType == 'files') {
                submitFiles(submissionData).then(redirect, error);
            } else if (["article", "pressrelease", "tweet", "redditcomment", "NSFcomment"].indexOf(resourceType) !== -1) {
                submitPost(submissionData).then(redirect, error);
            } else if (resourceType == "text") {
                submitWriting(submissionData).then(redirect, error);
            }
        };

        var submitFiles = function(submissionData) {
            return $http.put('/missioncontrol/create/submit/files', submissionData);
        };

        var submitPost = function(submissionData) {
            return $http.put('/missioncontrol/create/submit/post', submissionData);
        };

        var submitWriting = function(submissionData) {
            return $http.put('/missioncontrol/create/submit/writing', submissionData);
        };

        var redirect = function(response) {
            window.location = '/missioncontrol';
        };

        var error = function(response) {
            flashMessage.addError(response.data.errors);
        };
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

            self.datetimeExtractedFromEXIF = angular.isDefined(self.originated_at) ? true : false;

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