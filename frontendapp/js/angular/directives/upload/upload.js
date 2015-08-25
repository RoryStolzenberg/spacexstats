angular.module('directives.upload', []).directive('upload', ['$parse', function($parse) {
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
                successmultiple: function(files, message) {

                    // Apply the returned files to the $scope.files variable on the controller
                    $scope.files = files;

                    // Run a callback function
                    if (typeof attrs.callback !== 'undefined' && attrs.callback !== "") {
                        var func = $parse(attrs.callback);
                        func($scope);
                    }
                }
            });

            // upload the files
            $scope.uploadFiles = function() {
                dropzone.processQueue();
            }
        }
    }
}]);