Dropzone.options.uploadedFilesDropzone = {
    autoProcessQueue: false,
    maxFilesize: 1024, //MB
    addRemoveLinks: true,
    uploadMultiple: true,
    parallelUploads: 5,
    maxFiles: 5,
    init: function() {
        var uploadedFilesDropzone = this;

        $('#upload').on('click', function() {
            uploadedFilesDropzone.processQueue();
        });
    },
    successmultiple: function(files, message) {
        var uploadedFilesDropzone = this;
        var wereAnyFilesErrored = false;
        $.each(files, function(index, file) {
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
            $.each(files, function(index, file) {
                file.status = 'queued';
            });
        } else {
            $.each(message.objects, function(index, object) {
                UploadViewModel.uploadedFiles.push(object);
            });

            // switch the upload section to the form view
            UploadViewModel.uploadSection("form");

            // initialize all rich select dropdowns
            $('.rich-select').richSelect();

            // initialize all tagging inputs
            $('.tagger').suggest();
        }
    }
};

var UploadViewModel = function() {
	var self = this;

    /* Upload */

	// Switch between "upload", "post", & "write"
	self.changeVisibleSection = function(newVisibleSection) {
		self.visibleSection(newVisibleSection);
	};
	self.visibleSection = ko.observable("upload");

	// Switch between upload dropzone & form
	self.uploadSection = ko.observable("dropzone");

	// Files ready to be submitted to the queue.
	self.uploadedFiles = ko.observableArray([]);

	// Declare which template to use when a file is uploaded
	self.templateObjectType = function(uploadedFile) {
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

	self.changeVisibleTemplate = function(data, event) {
		var context = ko.contextFor(event.target);
		self.visibleTemplate(ko.unwrap(context.$index));
	};

	self.visibleTemplate = ko.observable('0');

	self.formButtonText = ko.computed(function() {
		return 'Submit';
	});

    /* Post */
    self.postType = ko.observable();

    self.retrieveTweet = function(data, event) {
        // Check that the entered URL contains 'twitter' before sending a request (perform more thorough validation serverside)
        var valueOfTwitterUrlField = event.currentTarget.value;

        if (valueOfTwitterUrlField.indexOf('twitter.com') !== -1) {

            var explodedVals = valueOfTwitterUrlField.split('/');
            var id = explodedVals[explodedVals.length - 1];

            $.ajax('/missioncontrol/create/retrievetweet/' + id, {
                dataType: 'json',
                type: 'GET',
                success: function(response) {
                    console.log(response);
                }
            });
        }
        // Allow default action
        return true;
    };

    // Submission of data to mission control
	self.submitToMissionControl = function(formData, contentTypeHeader) {
		console.log(formData);
		$.ajax('/missioncontrol/create/submit', {
				dataType: 'json',
				type: 'POST',
				headers: contentTypeHeader,
				data: { files: formData },
				success: function(response) {
					console.log(response);
				}			
		});
	};

	self.submitFiles = function(item, event) {
		var fileForms = $(event.currentTarget).siblings('.files-details').find('form').map(function() {
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

		var contentTypeHeader = { 'Submission-Type': 'files' };
		self.submitToMissionControl(fileForms, contentTypeHeader);
	};

	self.submitPost = function(item, event) {
        var postForm = $(event.currentTarget).parent();

        if (self.postType() == 'tweet') {
            var formData = {
                url: postForm.find('[name="tweet-url"]').val(),
                author: postForm.find('[name="tweet-author"]').val(),
                tweet: postForm.find('[name="tweet"]').val()
            };

            var contentTypeHeader = { 'Submission-Type': 'tweet' };
        }

        self.submitToMissionControl(formData, contentTypeHeader);
	};

	self.submitWriting = function(item, event) {

	};
};