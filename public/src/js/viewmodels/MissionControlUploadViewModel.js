define(['jquery', 'knockout', 'ko.mapping'], function($, ko, koMapping) {
    var MissionControlUploadViewModel = function () {

        ko.components.register('upload', {require: 'components/upload/upload'});
        ko.components.register('tweet', { require: 'components/tweet/tweet' });
        ko.components.register('rich-select', { require: 'components/rich-select/rich-select'});
        ko.components.register('tags', { require: 'components/tags/tags'});

        var self = this;

        var fileMappingOptions = {
            create: function(options) {
                if (options.data.type == 1) {
                    return new UploadedImage(options.data);

                } else if (options.data.type == 2) {
                    return new UploadedGif(options.data);

                } else if (options.data.type == 3) {
                    return new UploadedAudio(options.data);

                } else if (options.data.type == 4) {
                    return new UploadedVideo(options.data);

                } else if (options.data.type == 5) {
                    return new UploadedDocument(options.data);
                }
            }
        };

        function UploadedImage(image) {
            var self = this;
            koMapping.fromJS(image, {
                include: ['title', 'summary', 'subtype', 'tags', 'originated_at', 'mission_id', 'author', 'attribution', 'anonymous']
            }, this);

            self.title = ko.observable(null);
            self.summary = ko.observable(null);
            self.subtype = ko.observable(null);
            self.mission_id = ko.observable(null);
            self.author = ko.observable(null);
            self.attribution = ko.observable(null);
            self.anonymous = ko.observable(false);
            self.tags = ko.observableArray([]);
            self.originated_at = ko.computed(function() {
                return self.year() + '-' + ("0" + self.month()).slice(-2)  + '-' + ("0" + self.date()).slice(-2);
            });

            self.year = ko.observable(null);
            self.month = ko.observable(null);
            self.date = ko.observable(null);
        }

        function UploadedGif(gif) {
            var self = this;
            koMapping.fromJS(gif, {
                include: ['title', 'summary', 'tags', 'originated_at', 'mission_id', 'author', 'attribution', 'anonymous']
            }, this);

            self.title = ko.observable(null);
            self.summary = ko.observable(null);
            self.mission_id = ko.observable(null);
            self.author = ko.observable(null);
            self.attribution = ko.observable(null);
            self.anonymous = ko.observable(false);
            self.tags = ko.observableArray([]);
            self.originated_at = ko.computed(function() {
                return self.year() + '-' + ("0" + self.month()).slice(-2)  + '-' + ("0" + self.date()).slice(-2);
            });

            self.year = ko.observable(null);
            self.month = ko.observable(null);
            self.date = ko.observable(null);
        }

        function UploadedAudio(audio) {
            var self = this;
            koMapping.fromJS(audio, {
                include: ['title', 'summary', 'tags', 'originated_at', 'mission_id', 'author', 'attribution', 'anonymous']
            }, this);

            self.title = ko.observable(null);
            self.summary = ko.observable(null);
            self.mission_id = ko.observable(null);
            self.author = ko.observable(null);
            self.attribution = ko.observable(null);
            self.anonymous = ko.observable(false);
            self.tags = ko.observableArray([]);
            self.originated_at = ko.computed(function() {
                return self.year() + '-' + ("0" + self.month()).slice(-2)  + '-' + ("0" + self.date()).slice(-2);
            });

            self.year = ko.observable(null);
            self.month = ko.observable(null);
            self.date = ko.observable(null);
        }

        function UploadedVideo(video) {
            var self = this;
        }

        function UploadedDocument(document) {
            var self = this;
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
            var uploadedFileType = uploadedFile.type();
            if (uploadedFileType == 1) {
                return 'image-file-template';
            } else if (uploadedFileType == 2) {
                return 'gif-file-template';
            } else if (uploadedFileType == 3) {
                return 'audio-file-template';
            } else if (uploadedFileType == 4) {
                return 'video-file-template';
            } else if (uploadedFileType == 5) {
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
                data: { files: formData},
                success: function () {
                    window.location = '/missioncontrol';
                },
                error: function(response) {
                    console.log(response);
                }
            });
        };

        self.submitFiles = function (item, event) {
            var contentTypeHeader = {'Submission-Type': 'files'};
            self.submitToMissionControl(koMapping.toJS(self.uploadedFiles), contentTypeHeader);
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