define(['knockout', 'dropzone', 'text!components/upload/upload.html'], function(ko, Dropzone, htmlString) {
    function UploadViewModel(params) {
        Dropzone.options.uploadedFilesDropzone = {
            autoProcessQueue: false,
            maxFilesize: 1024, //MB
            addRemoveLinks: true,
            uploadMultiple: true,
            parallelUploads: 5,
            maxFiles: 5,
            init: function () {
                var uploadedFilesDropzone = this;

                $('#upload').on('click', function () {
                    uploadedFilesDropzone.processQueue();
                });
            },
            successmultiple: function (files, message) {
                var uploadedFilesDropzone = this;
                var wereAnyFilesErrored = false;
                $.each(files, function (index, file) {
                    if (!message.errors) {
                        file.previewElement.classList.add('dz-success');
                    } else {
                        wereAnyFilesErrored = true;
                        var node, _i, _len, _ref, _results;
                        if (file.previewElement) {
                            file.previewElement.classList.add("dz-error");
                            if (typeof message !== "String" && message.error) {
                                message = message.error;
                            }
                            _ref = file.previewElement.querySelectorAll("[data-dz-errormessage]");
                            _results = [];
                            for (_i = 0, _len = _ref.length; _i < _len; _i++) {
                                node = _ref[_i];
                                _results.push(node.textContent = message);
                            }
                        }
                    }
                });

                if (wereAnyFilesErrored === true) {
                    $.each(files, function (index, file) {
                        file.status = 'queued';
                    });
                } else {
                    $.each(message.objects, function (index, object) {
                        //UploadViewModel.uploadedFiles.push(object);
                    });
                }
            }
        };

        var myDropzone = new Dropzone("#uploadedFilesDropzone", { url: "/missioncontrol/create/upload"});
    }

    return { viewModel: UploadViewModel, template: htmlString };
});