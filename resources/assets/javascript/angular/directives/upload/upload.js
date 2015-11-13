(function() {
    var app = angular.module('app');

    app.directive('upload', ['$parse', function($parse) {
        return {
            restrict: 'A',
            link: function($scope, element, attrs) {

                // Initialize the dropzone
                var dropzone = new Dropzone(element[0], {
                    url: attrs.action,
                    autoProcessQueue: false,
                    dictDefaultMessage: "Upload files here!",
                    maxFilesize: 1024, // MB
                    addRemoveLinks: true,
                    uploadMultiple: attrs.multiUpload,
                    parallelUploads: 5,
                    maxFiles: 5,
                    successmultiple: function(dropzoneStatus, files) {

                        $scope.files = files.objects;

                        // Run a callback function with the files passed through as a parameter
                        if (typeof attrs.callback !== 'undefined' && attrs.callback !== "") {
                            var func = $parse(attrs.callback);
                            func($scope, { files: files });
                        }
                    },
                    error: function() {
                        $scope.isUploading = false;
                    }
                });

                dropzone.on("addedfile", function(file) {
                    ++$scope.queuedFiles;
                    $scope.$apply();
                });

                dropzone.on("removedfile", function(file) {
                    --$scope.queuedFiles;
                    $scope.$apply();
                });

                // upload the files
                $scope.uploadFiles = function() {
                    $scope.isUploading = true;
                    dropzone.processQueue();
                }
            }
        }
    }]);
})();