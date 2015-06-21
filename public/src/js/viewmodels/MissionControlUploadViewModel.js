define(['jquery', 'knockout', 'ko.mapping'], function($, ko, koMapping) {
    var MissionControlUploadViewModel = function () {

        ko.components.register('upload', {require: 'components/upload/upload'});
        ko.components.register('tweet', { require: 'components/tweet/tweet' });
        ko.components.register('rich-select', { require: 'components/rich-select/rich-select'});

        var self = this;

        var fileMappingOptions = {
            create: function(options) {
                return new UploadedImage(options.data);
            }
        };

        function UploadedImage(image) {
            var self = this;
            self.id = ko.observable(image.object_id);
            self.type = ko.observable(image.type);
            self.subtype = ko.observable();
            self.filename = ko.observable(image.filename);
            self.originalName = ko.observable(image.original_name);
            self.thumbnail = ko.computed(function() {
                return '/media/small/' + self.filename();
            });
            /*self.deltaV = ko.computed(function() {
                $.ajax('objects/calculateDeltaV', {
                    type: 'POST',
                    data: { '': ''},
                    success: function(response) {

                    }
                });
            }).extend({ rateLimit: 5000 });*/
        }

        function UploadedGif() {

        }

        function UploadedAudio() {

        }

        function UploadedVideo() {

        }

        function UploadedDocument() {

        }

        // Switch between "upload", "post", & "write"
        self.visibleSection = ko.observable("upload");
        self.changeVisibleSection = function (newVisibleSection) {
            self.visibleSection(newVisibleSection);
        };

        // Switch between upload dropzone & form
        self.uploadSection = ko.observable("dropzone");

        // Files returned from the dropzone
        self.rawFiles = ko.observableArray([]);
        self.rawFiles.subscribe(function(newValue) {
             // map files to
             koMapping.fromJS(newValue, fileMappingOptions, self.uploadedFiles);

             if (self.rawFiles().length > 0) {
                 self.uploadSection('form');
             } else {
                 self.uploadSection('dropzone');
             }
        });

        // Uploaded files
        self.uploadedFiles = ko.observableArray();

        // Declare which template to use when a file is uploaded
        self.templateObjectType = function (uploadedFile) {
            if (uploadedFile.type == 1) {
                return 'image-file-template';
            } else if (uploadedFile.type == 2) {
                return 'gif-file-template';
            } else if (uploadedFile.type == 3) {
                return 'audio-file-template';
            } else if (uploadedFile.type == 4) {
                return 'video-file-template';
            } else if (uploadedFile.type == 5) {
                return 'document-file-template';
            }
        };

        self.changeVisibleTemplate = function (data, event) {
            var context = ko.contextFor(event.target);
            self.visibleTemplate(ko.unwrap(context.$index));
        };

        self.visibleTemplate = ko.observable(0);

        self.formButtonText = ko.computed(function () {
            return 'Submit';
        });

        /* Post */
        self.postType = ko.observable();

        // Submission of data to mission control
        self.submitToMissionControl = function (formData, contentTypeHeader) {
            console.log(formData);
            $.ajax('/missioncontrol/create/submit', {
                dataType: 'json',
                type: 'POST',
                headers: contentTypeHeader,
                data: {files: formData},
                success: function (response) {
                    console.log(response);
                }
            });
        };

        self.submitFiles = function (item, event) {
            var fileForms = $(event.currentTarget).siblings('.files-details').find('form').map(function () {
                return {
                    title: $(this).find('[name="title"]').val(),
                    summary: $(this).find('[name="summary"]').val(),
                    mission_id: $(this).find('#mission_id').data('value'),
                    author: $(this).find('[name="author"]').val(),
                    attribution: $(this).find('[name="attribution"]').val(),
                    tags: $(this).find('.tagger').prop('value'),
                    type: $(this).find('[name="type"]').val(),
                    association: $(this).find('[name="anonymous"]').val()
                };
            }).get();

            var contentTypeHeader = {'Submission-Type': 'files'};
            self.submitToMissionControl(fileForms, contentTypeHeader);
        };

        self.submitPost = function (item, event) {
            var postForm = $(event.currentTarget).parent();

            if (self.postType() == 'tweet') {
                var formData = {
                    url: postForm.find('[name="tweet-url"]').val(),
                    author: postForm.find('[name="tweet-author"]').val(),
                    tweet: postForm.find('[name="tweet"]').val()
                };

                var contentTypeHeader = {'Submission-Type': 'tweet'};
            }

            self.submitToMissionControl(formData, contentTypeHeader);
        };

        self.submitWriting = function (item, event) {
        };
    };

    return MissionControlUploadViewModel;
});