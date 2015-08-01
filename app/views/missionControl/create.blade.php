@extends('templates.main')

@section('title', 'Upload to Mission Control')
@section('bodyClass', 'missioncontrol-upload')

@section('scripts')
    <script data-main="/src/js/common" src="/src/js/require.js"></script>
    <script>
        require(['common'], function() {
            require(['knockout', 'viewmodels/UploadViewModel'], function(ko, UploadViewModel) {
                ko.applyBindings(new UploadViewModel());
            });
        });
    </script>

    <!-- Knockout Templates -->
	<script type="text/html" id="uploaded-files-template">
		<li class="uploaded-file" data-bind="attr: { 'data-index': $index }, click: $root.changeVisibleTemplate">
            <img data-bind="attr: { src: media_thumb_small }"/><br/>
            <span data-bind="text: original_name"></span>
        </li>
	</script>

	<script type="text/html" id="image-file-template">
		<div data-bind="attr: { 'data-index': $index }, visible: $root.visibleTemplate() == ko.unwrap($index)">
			<h2 data-bind="text: original_name"></h2>
			<form>
				<ul class="container">
					<li class="grid-4">
						<img data-bind="attr: { src: media_thumb_small, alt: media_thumb_small }" />
					</li>

					<li class="grid-4">
						<label>
                            <p>Title</p>
                            <input type="text" name="title" data-bind="value: title" />
                        </label>
					</li>

					<li class="grid-8">
                        <label>
                            <p>Summary</p>
                            <textarea name="summary" data-bind="value: summary"></textarea>
                        </label>
                    </li>

					<li class="grid-4">
						<label>
                            <p>Related to Mission</p>
                            <rich-select params="fetchFrom: '/missions/all', default: true, value: mission_id, mapping: {}"></rich-select>
                        </label>
					</li>

					<li class="grid-6">
                        <label>
                            <p>Author</p>
                            <input type="text" name="author" data-bind="value: author" />
                        </label>
                    </li>

					<li class="grid-6">
                        <label>
                            <p>Attribution/Copyright</p>
                            <textarea name="attribution" data-bind="value: attribution"></textarea>
                        </label>
                    </li>

					<li class="grid-6">
                        <label>
                            <p>Tags</p>
                            <tags params="tags: tags"></tags>
                        </label>
                    </li>

					<li class="grid-6">
                        <label>
                            <p>Type</p>
                            <select data-bind="value: subtype">
                                <option>None</option>
                                <option value="1">Mission Patch</option>
                                <option value="2">Photo</option>
                                <option value="3">Chart</option>
                                <option value="5">Screenshot</option>
                                <option value="11">Infographic</option>
                                <option value="12">News Summary</option>
                            </select>
                        </label>
                    </li>

                    <li class="grid-6">
                        <datetime params="value: originated_at, type: 'date'"></datetime>
                    </li>

					<li class="grid-12">
                        <label>
                            <p>Submit anonymously?</p>
                            <input type="checkbox" name="anonymous" data-bind="checked: anonymous" />
                        </label>
                    </li>
				</ul>
			</form>
		</div>
	</script>

	<script type="text/html" id="gif-file-template">
		<div data-bind="attr: { 'data-index': $index }, visible: $root.visibleTemplate() == ko.unwrap($index)">
            <h2 data-bind="text: original_name"></h2>
            <form>
                <ul class="container">
                    <li class="grid-4">
                        <img data-bind="attr : { src: media_thumb_small, alt: media_thumb_small }">
                    </li>

                    <li class="grid-4">
                        <label>
                            <p>Title</p>
                            <input type="text" name="title" data-bind="value: title" />
                        </label>
                    </li>

                    <li class="grid-8">
                        <label>
                            <p>Summary</p>
                            <textarea name="summary" data-bind="value: summary"></textarea>
                        </label>
                    </li>

                    <li class="grid-4">
                        <label>
                            <p>Related to Mission</p>
                            <rich-select params="fetchFrom: '/missions/all', default: true, value: mission_id, mapping: {}"></rich-select>
                        </label>
                    </li>

                    <li class="grid-6">
                        <label>
                            <p>Author</p>
                            <input type="text" name="author" data-bind="value: author" />
                        </label>
                    </li>

                    <li class="grid-6">
                        <label>
                            <p>Attribution/Copyright</p>
                            <textarea name="attribution" data-bind="value: attribution"></textarea>
                        </label>
                    </li>

                    <li class="grid-6">
                        <label>
                            <p>Tags</p>
                            <tags params="tags: tags"></tags>
                        </label>
                    </li>

                    <li class="grid-6">
                        <datetime params="value: originated_at, type: 'date'"></datetime>
                    </li>

                    <li class="grid-12">
                        <label>
                            <p>Submit anonymously?</p>
                            <input type="checkbox" name="anonymous" data-bind="checked: anonymous" />
                        </label>
                    </li>
                </ul>
            </form>
		</div>
	</script>

	<script type="text/html" id="audio-file-template">
        <div data-bind="attr: { 'data-index': $index }, visible: $root.visibleTemplate() == ko.unwrap($index)">
            <h2 data-bind="text: original_name"></h2>
            <form>
                <ul class="container">
                    <li class="grid-4">
                        <img data-bind="attr : { src: media_thumb_small, alt: media_thumb_small }">
                    </li>

                    <li class="grid-4">
                        <label>
                            <p>Title</p>
                            <input type="text" name="title" data-bind="value: title" />
                        </label>
                    </li>

                    <li class="grid-8">
                        <label>
                            <p>Summary</p>
                            <textarea name="summary" data-bind="value: summary"></textarea>
                        </label>
                    </li>

                    <li class="grid-4">
                        <label>
                            <p>Related to Mission</p>
                            <rich-select params="fetchFrom: '/missions/all', default: true, value: mission_id, mapping: {}"></rich-select>
                        </label>
                    </li>

                    <li class="grid-6">
                        <label>
                            <p>Author</p>
                            <input type="text" name="author" data-bind="value: author" />
                        </label>
                    </li>

                    <li class="grid-6">
                        <label>
                            <p>Attribution/Copyright</p>
                            <textarea name="attribution" data-bind="value: attribution"></textarea>
                        </label>
                    </li>

                    <li class="grid-6">
                        <label>
                            <p>Tags</p>
                            <tags params="tags: tags"></tags>
                        </label>
                    </li>

                    <li class="grid-6">
                        <datetime params="value: originated_at, type: 'date'"></datetime>
                    </li>

                    <li class="grid-12">
                        <label>
                            <p>Submit anonymously?</p>
                            <input type="checkbox" name="anonymous" data-bind="checked: anonymous" />
                        </label>
                    </li>
                </ul>
            </form>
        </div>
	</script>

	<script type="text/html" id="video-file-template">
        <div data-bind="attr: { 'data-index': $index }, visible: $root.visibleTemplate() == ko.unwrap($index)">
            <h2 data-bind="text: original_name"></h2>
            <form>
                <ul class="container">
                    <li class="grid-4">
                        <img data-bind="attr : { src: media_thumb_small, alt: media_thumb_small }">
                    </li>

                    <li class="grid-4">
                        <label>
                            <p>Title</p>
                            <input type="text" name="title" data-bind="value: title" />
                        </label>
                    </li>

                    <li class="grid-8">
                        <label>
                            <p>Summary</p>
                            <textarea name="summary" data-bind="value: summary"></textarea>
                        </label>
                    </li>

                    <li class="grid-4">
                        <label>
                            <p>Related to Mission</p>
                            <rich-select params="fetchFrom: '/missions/all', default: true, value: mission_id, mapping: {}"></rich-select>
                        </label>
                    </li>

                    <li class="grid-6">
                        <label>
                            <p>Author</p>
                            <input type="text" name="author" data-bind="value: author" />
                        </label>
                    </li>

                    <li class="grid-6">
                        <label>
                            <p>Attribution/Copyright</p>
                            <textarea name="attribution" data-bind="value: attribution"></textarea>
                        </label>
                    </li>

                    <li class="grid-6">
                        <label>
                            <p>Tags</p>
                            <tags params="tags: tags"></tags>
                        </label>
                    </li>

                    <li class="grid-6">
                        <label>
                            <p>Type</p>
                            <select data-bind="value: subtype">
                                <option>None</option>
                                <option value="6">Launch Video</option>
                                <option value="7">Press Conference</option>
                            </select>
                        </label>
                    </li>

                    <li class="grid-6">
                        <datetime params="value: originated_at, type: 'date'"></datetime>
                    </li>

                    <li class="grid-12">
                        <label>
                            <p>Submit anonymously?</p>
                            <input type="checkbox" name="anonymous" data-bind="checked: anonymous" />
                        </label>
                    </li>
                </ul>
            </form>
        </div>
	</script>

	<script type="text/html" id="document-file-template">
        <div data-bind="attr: { 'data-index': $index }, visible: $root.visibleTemplate() == ko.unwrap($index)">
            <h2 data-bind="text: original_name"></h2>
            <form>
                <ul class="container">
                    <li class="grid-4">
                        <img data-bind="attr : { src: media_thumb_small, alt: media_thumb_small }">
                    </li>

                    <li class="grid-4">
                        <label>
                            <p>Title</p>
                            <input type="text" name="title" data-bind="value: title" />
                        </label>
                    </li>

                    <li class="grid-8">
                        <label>
                            <p>Summary</p>
                            <textarea name="summary" data-bind="value: summary"></textarea>
                        </label>
                    </li>

                    <li class="grid-4">
                        <label>
                            <p>Related to Mission</p>
                            <rich-select params="fetchFrom: '/missions/all', default: true, value: mission_id, mapping: {}"></rich-select>
                        </label>
                    </li>

                    <li class="grid-6">
                        <label>
                            <p>Author</p>
                            <input type="text" name="author" data-bind="value: author" />
                        </label>
                    </li>

                    <li class="grid-6">
                        <label>
                            <p>Attribution/Copyright</p>
                            <textarea name="attribution" data-bind="value: attribution"></textarea>
                        </label>
                    </li>

                    <li class="grid-6">
                        <label>
                            <p>Tags</p>
                            <tags params="tags: tags"></tags>
                        </label>
                    </li>

                    <li class="grid-6">
                        <label>
                            <p>Type</p>
                            <select data-bind="value: subtype">
                                <option>None</option>
                                <option value="6">Press Kit</option>
                                <option value="7">Cargo Manifest</option>
                                <option value="15">Weather Forecast</option>
                                <option value="17">License</option>
                            </select>
                        </label>
                    </li>

                    <li class="grid-6">
                        <datetime params="value: originated_at, type: 'date'"></datetime>
                    </li>

                    <li class="grid-12">
                        <label>
                            <p>Submit anonymously?</p>
                            <input type="checkbox" name="anonymous" data-bind="checked: anonymous" />
                        </label>
                    </li>
                </ul>
            </form>
        </div>
	</script>
@stop

@section('content')
	<div class="content-wrapper">	
			<h1>Upload to Mission Control</h1>
			<main>
				<!-- List of methods to upload -->
                <nav>
                    <ul class="upload-type text-center">
                        <li data-bind="click: changeVisibleSection.bind($data, 'upload')"><i class="fa fa-upload"></i> Upload</li>
                        <li data-bind="click: changeVisibleSection.bind($data, 'post')"><i class="fa fa-paperclip"></i> Post</li>
                        <li data-bind="click: changeVisibleSection.bind($data, 'write')"><i class="fa fa-pencil"></i> Write</li>
                    </ul>
                </nav>
				<!-- Upload -->
				<section class="upload-upload" data-bind="visible: visibleSection() == 'upload'">
					<div data-bind="visible: uploadSection() == 'dropzone'">
                        <p>Do not upload files that might violate SpaceX's Communications Policy. If you are unsure </p>
					    <upload params="dropzoneId: 'uploadFilesDropzone', postLocation: '/missioncontrol/create/upload', uploadedFiles: rawFiles"></upload>
                    </div>
					<div data-bind="visible: uploadSection() == 'form'">
							<ul class="files-list" data-bind="template: { name: 'uploaded-files-template', foreach: uploadedFiles }">
							</ul>
							<div class="files-details" data-bind="template: { name: templateObjectType, foreach: uploadedFiles }">
							</div>
							<button id="files-submit" data-bind="text: formButtonText, click: submitFiles"></button>
					</div>
				</section>

				<!-- Post -->
				<section class="upload-post" data-bind="visible: visibleSection() == 'post'">
					<form>
						<fieldset class="post-type-selection">
							<label><input type="radio" name="type" value="tweet" data-bind="checked: postType" />Tweet</label>
                            <label><input type="radio" name="type" value="article" data-bind="checked: postType" />News Article</label>
                            <label><input type="radio" name="type" value="pressrelease" data-bind="checked: postType" />SpaceX press release</label>
                            <label><input type="radio" name="type" value="redditcomment" data-bind="checked: postType" />Reddit comment</label>
                            <label><input type="radio" name="type" value="nsfcomment" data-bind="checked: postType" />NSF comment</label>
						</fieldset>

						<fieldset class="post-type tweet" data-bind="visible: postType() == 'tweet'">
							<tweet params="action: 'write', tweet: tweet"></tweet>
						</fieldset>

						<fieldset class="post-type article" data-bind="visible: postType() == 'article', with: article">
                            <label>Article URL</label>
							<input type="url" name="article-url" id="article-url" data-bind="text: external_url" />

                            <label>Article Date</label>
                            <datetime params="value: originated_at, type: 'date'"></datetime>

                            <label>Article News Source</label>
							<input type="text" name="article-publisher" id="article-publisher" data-bind="text: publisher" />

                            <label>Article Author</label>
							<input type="text" name="article-author" id="article-author" data-bind="text: author" />

                            <label>Article Title</label>
                            <input type="text" name="article-title" id="article-title" data-bind="text: title" />

                            <label>Article Text</label>
							<textarea data-bind="text: article"></textarea>

                            <label>Tags</label>
                            <tags params="tags: tags"></tags>
						</fieldset>

						<fieldset class="post-type pressrelease" data-bind="visible: postType() == 'pressrelease', with: pressRelease">
                            <label>Press Release URL</label>
                            <input type="url" name="article-url" id="article-url" data-bind="text: external_url" />

                            <label>Press Release Date</label>
                            <datetime params="value: originated_at, type: 'date'"></datetime>

                            <label>Press Release Title</label>
                            <input type="text" name="article-author" id="article-author" data-bind="text: title" />

                            <label>Press Release Text</label>
                            <textarea data-bind="text: article"></textarea>

                            <label>Tags</label>
                            <tags params="tags: tags"></tags>
						</fieldset>

						<fieldset class="post-type redditcomment" data-bind="visible: postType() == 'redditcomment', with: redditComment">
                            <label>Permalink URL</label>
							<input type="url" name="redditcomment-url" id="redditcomment-url" data-bind="text: external_url">

                            <label>Comment Title</label>
                            <input type="text" name="article-author" id="article-author" data-bind="text: title" />

                            <label>Tags</label>
                            <tags params="tags: tags"></tags>
						</fieldset>

						<fieldset class="post-type nsfcomment" data-bind="visible: postType() == 'nsfcomment', with: nsfComment">
                            <label>Comment URL</label>
							<input type="url" name="nsfcomment-url" id="article-url" data-bind="text: external_url"/>

                            <label>Comment Title</label>
                            <input type="text" name="article-author" id="article-author" data-bind="text: title" />

                            <label>Comment Date</label>
                            <datetime params="value: originated_at, type: 'date'"></datetime>

                            <label>Comment Author</label>
							<input type="author" name="nsfcomment-author" id="article-author" />

                            <label>Comment</label>
							<textarea data-bind="text: comment"></textarea>

                            <label>Tags</label>
                            <tags params="tags: tags"></tags>
						</fieldset>

						<input type="submit" value="Submit" name="submit" id="post-submit" />
					</form>
				</section>
				
				<!-- Update -->
				<section class="upload-write" data-bind="visible: visibleSection() == 'write'">
					<form>
						<input type="radio" name="write-mission-related" value="yes">
						<input type="radio" name="write-mission-related" value="no">
						<select name="write-mission" id="write-mission-select">
							
						</select>
						<textarea></textarea>
						<input type="submit" value="Submit" name="submit" id="write-submit" />
					</form>
				</section>
			</main>
	</div>
@stop

