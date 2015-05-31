@extends('templates.main')

@section('title', 'Upload to Mission Control')
@section('bodyClass', 'upload')

@section('scripts')
	{{ HTML::style('/assets/css/dropzone.css') }}
	{{ HTML::script('/assets/js/dropzone.js') }}
	{{ HTML::script('/assets/js/viewmodels/UploadViewModel.js') }}
	<script type="text/javascript">
		$(document).ready(function() {
			ko.applyBindings(new UploadViewModel());
		});
	</script>
	<script type="text/html" id="uploaded-files-template">
		<li data-bind="text: original_name, attr: { 'data-index': $index }, click: $root.changeVisibleTemplate"></li>
	</script>
	<script type="text/html" id="image-file-template">
		<div data-bind="attr: { 'data-index': $index }, visible: $root.visibleTemplate() == ko.unwrap($index)">
			<h2 data-bind="text: original_name"></h2>
			<form>
				<ul class="container">
					<li class="grid-4">
						<img data-bind="attr : { src: '/' + thumb_small, alt: original_name }">
					</li>
					<li class="grid-4">
						<label><p>Title</p><input type="text" name="title" /></label>
					</li>
					<li class="grid-8"><label><p>Summary</p><textarea name="summary"></textarea></label></li>
					<li class="grid-4">
						<label><p>Related to Mission</p>
						{{ Form::richSelect('mission_id', $missions, array('identifier' => 'mission_id', 'title' => 'name', 'summary' => 'summary')) }}</label>
					</li>					
					<li class="grid-6"><label><p>Author</p><input type="text" name="author" /></label></li>
					<li class="grid-6"><label><p>Attribution/Copyright</p><textarea name="attribution"></textarea></label></li>
					<li class="grid-6"><label>Tags{{ Form::tags() }}</label></li>
					<li class="grid-6"><label>Type{{ Form::select('type', array(1 => 'Mission Patch', 2 => 'Photo', 4 => 'Chart', 5 => 'Screenshot', 11 => 'Infographic')) }}</label></li>
					<li class="grid-12"><label>Submit anonymously?<input type="checkbox" name="anonymous" /></label></li>
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
                        <img data-bind="attr : { src: '/' + thumb_small, alt: original_name }">
                    </li>
                    <li class="grid-4">
                        <label><p>Title</p><input type="text" name="title" /></label>
                    </li>
                    <li class="grid-8"><label><p>Summary</p><textarea name="summary"></textarea></label></li>
                    <li class="grid-4">
                        <label><p>Related to Mission</p>
                            {{ Form::richSelect('mission_id', $missions, array('identifier' => 'mission_id', 'title' => 'name', 'summary' => 'summary')) }}</label>
                    </li>
                    <li class="grid-6"><label><p>Author</p><input type="text" name="author" /></label></li>
                    <li class="grid-6"><label><p>Attribution/Copyright</p><textarea name="attribution"></textarea></label></li>
                    <li class="grid-6"><label>Tags{{ Form::tags() }}</label></li>
                    <li class="grid-12"><label>Submit anonymously?<input type="checkbox" name="anonymous" /></label></li>
                </ul>
            </form>
		</div>
	</script>
	<script type="text/html" id="audio-file-template">
		<div data-bind="attr: { 'data-index': $index }">
            <h2 data-bind="text: original_name"></h2>
            <form>
                <ul class="container">
                    <li class="grid-4">
                        <img data-bind="attr : { src: '/' + thumb_small, alt: original_name }">
                    </li>
                    <li class="grid-4">
                        <label><p>Title</p><input type="text" name="title" /></label>
                    </li>
                    <li class="grid-8"><label><p>Summary</p><textarea name="summary"></textarea></label></li>
                    <li class="grid-4">
                        <label><p>Related to Mission</p>
                            {{ Form::richSelect('mission_id', $missions, array('identifier' => 'mission_id', 'title' => 'name', 'summary' => 'summary')) }}</label>
                    </li>
                    <li class="grid-6"><label><p>Author</p><input type="text" name="author" /></label></li>
                    <li class="grid-6"><label><p>Attribution/Copyright</p><textarea name="attribution"></textarea></label></li>
                    <li class="grid-6"><label>Tags{{ Form::tags() }}</label></li>
                    <li class="grid-12"><label>Submit anonymously?<input type="checkbox" name="anonymous" /></label></li>
                </ul>
            </form>
		</div>
	</script>
	<script type="text/html" id="video-file-template">
		<div data-bind="attr: { 'data-index': $index }">
		</div>
	</script>
	<script type="text/html" id="document-file-template">
		<div data-bind="attr: { 'data-index': $index }">
		</div>
	</script>
@stop

@section('content')
	<div class="content-wrapper">	
			<h1>Upload to Mission Control</h1>
			<main>
				<!-- List of methods to upload -->
				<ul class="upload-type text-center">
					<li data-bind="click: changeVisibleSection.bind($data, 'upload')"><i class="fa fa-upload"></i> Upload</li>
					<li data-bind="click: changeVisibleSection.bind($data, 'post')"><i class="fa fa-paperclip"></i> Post</li>
					<li data-bind="click: changeVisibleSection.bind($data, 'write')"><i class="fa fa-pencil"></i> Write</li>
				</ul>
				<!-- Upload -->
				<section class="upload-upload" data-bind="visible: visibleSection() == 'upload'">
					<div data-bind="visible: uploadSection() == 'dropzone'">
						<form action="/missioncontrol/create/upload" method="post" id="uploadedFilesDropzone" class="dropzone" enctype="multipart/form-data">
						</form>
						<button id="upload">Upload</button>
					</div>
					<div data-bind="visible: uploadSection() == 'form'">
							<ul class="files-list" data-bind="template: { name: 'uploaded-files-template', foreach: uploadedFiles }">
							</ul>
							<div class="files-details" data-bind="template: { name: templateObjectType, foreach: uploadedFiles }">
							</div>
							<button id="files-submit" data-bind="text: formButtonText, click: submitFiles" />		
					</div>
				</section>

				<!-- Post -->
				<section class="upload-post" data-bind="visible: visibleSection() == 'post'">
					{{ Form::open(array('url' => '/missioncontrol/create/create', 'method' => 'post')) }}
						<fieldset class="post-type-selection">
							<label><input type="radio" name="type" value="tweet" data-bind="checked: postType" />Tweet</label>
                            <label><input type="radio" name="type" value="article" data-bind="checked: postType" />News Article</label>
                            <label><input type="radio" name="type" value="pressrelease" data-bind="checked: postType" />SpaceX press release</label>
                            <label><input type="radio" name="type" value="redditcomment" data-bind="checked: postType" />Reddit comment</label>
                            <label><input type="radio" name="type" value="nsfcomment" data-bind="checked: postType" />NSF comment</label>
						</fieldset>
						<fieldset class="post-type tweet" data-bind="visible: postType() == 'tweet'">
							<label for="tweet-url">Tweet URL</label>
							<input type="url" name="tweet-url" id="tweet-url" data-bind="event: { keyup: retrieveTweet }" />

                            <label for="tweet-author">Tweet Author</label>
                            <input type="text" name="tweet-author" id="tweet-author" />

                            <label for="tweet">Tweet</label>
                            <textarea name="tweet" id="tweet"></textarea>
						</fieldset>
						<fieldset class="post-type article" data-bind="visible: postType() == 'article'">
							<input type="url" name="article-url" id="article-url" />
							<input type="date" name="article-date" id="article-date" />
							<input type="publisher" name="article-publisher" id="article-publisher" />
							<input type="author" name="article-author" id="article-author" />
							<textarea></textarea>
						</fieldset>
						<fieldset class="post-type pressrelease" data-bind="visible: postType() == 'pressrelease'">
							<input type="url" name="pressrelease-url" id="pressrelease-url">
							<input type="date" name="article-date" id="article-date" />
							<textarea></textarea>
						</fieldset>
						<fieldset class="post-type redditcomment" data-bind="visible: postType() == 'redditcomment'">
							<input type="url" name="redditcomment-url" id="redditcomment-url">							
						</fieldset>
						<fieldset class="post-type nsfcomment" data-bind="visible: postType() == 'nsfcomment'">
							<input type="url" name="nsfcomment-url" id="article-url" />
							<input type="date" name="nsfcomment-date" id="article-date" />
							<input type="author" name="nsfcomment-author" id="article-author" />
							<textarea></textarea>							
						</fieldset>
						<fieldset class="post-type transcript">
							
						</fieldset>
						<fieldset class="tags">
						</fieldset>
						<input type="submit" value="Submit" name="submit" id="post-submit" />
					{{ Form::close() }}
				</section>
				
				<!-- Update -->
				<section class="upload-write" data-bind="visible: visibleSection() == 'write'">
					{{ Form::open(array('url' => '/missioncontrol/create/send', 'method' => 'post')) }}
						<input type="radio" name="write-mission-related" value="yes">
						<input type="radio" name="write-mission-related" value="no">
						<select name="write-mission" id="write-mission-select">
							
						</select>
						<textarea></textarea>
						<input type="submit" value="Submit" name="submit" id="write-submit" />
					{{ Form::close() }}					
				</section>
			</main>
	</div>
@stop

