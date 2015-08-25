angular.module('directives.upload', []).directive('upload', function() {
    return {
        restrict: 'A',
        link: function($scope, element, attrs) {

            console.log(attrs);

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
                    console.log(files);
                    console.log(message);
                }
            });

            $scope.uploadFiles = function() {
                dropzone.processQueue();
            }
        }
    }
});