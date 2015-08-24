angular.module('directives.upload', []).directive('upload', function() {
    return {
        restrict: 'E',
        scope: {
            files: '=',
            action: '@',
            callback: '&',
            multiUpload: '@'
        },
        link: function($scope, element, attrs) {
            console.log('creating dropzone');

            var dropzone = element.dropzone({
                url: $scope.action,
                autoProcessQueue: false,
                maxFilesize: 1024, // MB
                addRemoveLinks: true,
                uploadMultiple: $scope.multiUpload,
                parallelUploads: 5,
                maxFiles: 5,
                successmultiple: function(files, message) {

                }
            });

            $scope.uploadFiles = function() {
                dropzone.processQueue();
            }
        },
        templateUrl: '/js/templates/upload.html'
    }
});