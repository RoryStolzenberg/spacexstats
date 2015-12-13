@extends('templates.main')
@section('title', 'Upload to Mission Control')

@section('content')
<body class="missioncontrol-upload" ng-controller="uploadAppController" ng-strict-di>

    @include('templates.header')

    <div class="content-wrapper" ng-cloak>
        <h1>Upload to Mission Control</h1>
        <main>
            <!-- List of methods to upload -->
            <nav class="in-page" ng-hide="areSubmissionMethodsHidden">
                <ul class="upload-type text-center">
                    <li ng-click="changeSection('upload')"><i class="fa fa-upload"></i> Upload</li>
                    <li ng-click="changeSection('post')"><i class="fa fa-paperclip"></i> Post</li>
                    <li ng-click="changeSection('write')"><i class="fa fa-pencil"></i> Write</li>
                </ul>
            </nav>

            <!-- Upload -->
            <section class="upload-upload" ng-controller="uploadController" ng-show="activeSection == 'upload'">

                <div ng-show="activeUploadSection == 'dropzone'">
                    <p class="warning">Do not upload files that might violate SpaceX's Communications Policy or U.S. export control laws. If you are unsure about the status of a file, please <a href="/about/contact">contact us</a>.</p>
                    <form method="post" class="dropzone" upload enctype="multipart/form-data" action="/missioncontrol/create/upload" callback="uploadCallback(somescome)" multi-upload="true">
                        {{ csrf_field() }}
                        <div class="dz-message" data-dz-message><p class="exclaim">Drag & drop or click to upload files. Always upload the highest quality files as this gives you more deltaV!</p></div>
                    </form>
                    <button class="wide-button" ng-click="uploadFiles()" ng-disabled="queuedFiles == 0 || isUploading">@{{ isUploading ? 'Uploading...' : 'Upload' }}</button>
                </div>

                <div ng-show="activeUploadSection == 'data'" ng-form="uploadForm">
                    <ul class="files-list">
                        <li class="uploaded-file" ng-repeat="file in files" ng-class="{ valid: uploadForm['fileForm' + $index].$valid, invalid: uploadForm['fileForm' + $index].$invalid }"  ng-click="setVisibleFile(file)">
                            <img ng-attr-src="@{{file.media_thumb_small}}"/><br/>
                            <span>@{{ file.original_name }}</span>
                        </li>
                    </ul>

                    <div class="files-details" ng-repeat="file in files">
                        <!-- IMAGE FILE TEMPLATE -->
                        <div ng-if="file.type == 'Image'" class="container" ng-show="isVisibleFile(file)">
                            <h2>@{{ file.original_name }}</h2>
                            <form name="@{{'fileForm' + $index}}" novalidate>

                                <!-- New Form -->
                                <fieldset class="gr-8 upload-basic-info">
                                    <legend>Basic Info</legend>
                                    <ul>
                                        <li>
                                            <label>
                                                <p>Title</p>
                                                <input type="text" name="title" ng-model="file.title" placeholder="Enter a title for this image" ng-minlength="10" required />
                                            </label>
                                        </li>
                                        <li>
                                            <label>
                                                <p>Summary</p>
                                                <textarea name="summary" ng-model="file.summary" placeholder="Write a summary about this image" ng-minlength="100" required character-counter></textarea>
                                            </label>
                                        </li>
                                    </ul>
                                </fieldset>

                                <fieldset class="gr-4 upload-preview text-center">
                                    <img ng-attr-src="@{{file.media_thumb_small}}" ng-attr-alt="@{{file.media_thumb_small}}" />

                                    <delta-v ng-model="file" hint="@{{ file.type }}"></delta-v>
                                </fieldset>

                                <fieldset class="gr-8 upload-attribution">
                                    <legend>Attribution</legend>
                                    <ul>
                                        <li>
                                            <label>
                                                <p>Author</p>
                                                <input type="text" name="author" ng-model="file.author" placeholder="Who took this image? SpaceX, Elon Musk, etc." required />
                                            </label>
                                        </li>
                                        <li>
                                            <label>
                                                <p>Attribution/Copyright</p>
                                                <textarea name="attribution" ng-model="file.attribution" placeholder="Include any license and author details here. CC-BY-SA, Public Domain, etc."></textarea>
                                            </label>
                                        </li>
                                    </ul>
                                </fieldset>

                                <fieldset class="gr-4 upload-metadata">
                                    <legend>Metadata</legend>
                                    <ul>
                                        <li>
                                            <label>
                                                <p>Related to Mission</p>
                                                <dropdown
                                                        name="mission"
                                                        options="data.missions"
                                                        ng-model="file.mission_id"
                                                        unique-key="mission_id"
                                                        title-key="name"
                                                        searchable="true"
                                                        id-only="true">
                                                </dropdown>
                                            </label>
                                        </li>

                                        <li>
                                            <label>
                                                <p>Type of @{{ file.type }}</p>
                                                <select ng-model="file.subtype" ng-options="subtype as subtype for subtype in data.subtypes.images">
                                                    <option value="">None</option>
                                                </select>
                                            </label>
                                        </li>

                                        <li>
                                            <label>
                                                <p>When was this created?</p>
                                                <datetime ng-if="!file.datetimeExtractedFromEXIF" type="date"
                                                          ng-model="file.originated_at"
                                                          nullable-toggle="false"></datetime>
                                            </label>
                                        </li>
                                    </ul>
                                </fieldset>

                                <fieldset class="gr-12">
                                    <legend>Tags</legend>
                                    <ul>
                                        <li>
                                            <label>
                                                <p>Tags</p>
                                                <tags available-tags="data.tags" ng-model="file.tags" name="tags"></tags>
                                                <span ng-show="@{{'fileForm' + $index}}.tags.$error.taglength">Please enter 1 to 5 tags.</span>
                                            </label>
                                        </li>
                                    </ul>
                                </fieldset>

                                <fieldset class="gr-12">
                                    <legend>Finally...</legend>
                                    <ul>
                                        <li class="gr-6">
                                            <input type="checkbox" name="anonymous" id="@{{ 'anonymous-file' + $index }}" value="true" ng-model="file.anonymous" />
                                            <label for="@{{ 'anonymous-file' + $index }}">
                                                <span>Submit anonymously?</span>
                                            </label>
                                        </li>
                                        <li class="gr-6">
                                            <input type="checkbox" name="original_content" id="@{{ 'original-content' + $index }}" value="true" ng-model="file.original_content" />
                                            <label for="@{{ 'original-content' + $index }}">
                                                <span>Did you create this yourself?</span>
                                            </label>
                                        </li>
                                    </ul>
                                </fieldset>
                            </form>
                        </div>

                        <!-- GIF FILE TEMPLATE -->
                        <div ng-if="file.type == 'GIF'" ng-show="isVisibleFile(file)">
                            <h2>@{{ file.original_name }}</h2>
                            <form name="@{{'fileForm' + $index}}" class="container" novalidate>

                                <fieldset class="gr-8 upload-basic-info">
                                    <legend>Basic Info</legend>
                                    <ul>
                                        <li>
                                            <label>
                                                <p>Title</p>
                                                <input type="text" name="title" ng-model="file.title" placeholder="Enter a title for this GIF" ng-minlength="10" required />
                                            </label>
                                        </li>
                                        <li>
                                            <label>
                                                <p>Summary</p>
                                                <textarea name="summary" ng-model="file.summary" placeholder="Write a summary about this GIF" ng-minlength="100" required character-counter></textarea>
                                            </label>
                                        </li>
                                    </ul>
                                </fieldset>

                                <fieldset class="gr-4 upload-preview text-center">
                                    <img ng-attr-src="@{{file.media_thumb_small}}" ng-attr-alt="@{{file.media_thumb_small}}" />

                                    <delta-v ng-model="file" hint="@{{ file.type }}"></delta-v>
                                </fieldset>

                                <fieldset class="gr-8 upload-attribution">
                                    <legend>Attribution</legend>

                                    <ul>
                                        <li>
                                            <label>
                                                <p>Author</p>
                                                <input type="text" name="author" ng-model="file.author" placeholder="Who made this GIF?" required />
                                            </label>
                                        </li>
                                        <li>
                                            <label>
                                                <p>Attribution/Copyright</p>
                                                <textarea name="attribution" ng-model="file.attribution" placeholder="Include any license and author details here. CC-BY-SA, Public Domain, etc."></textarea>
                                            </label>
                                        </li>
                                    </ul>
                                </fieldset>

                                <fieldset class="gr-4 upload-metadata">
                                    <legend>Metadata</legend>

                                    <ul>
                                        <li>
                                            <label>
                                                <p>Related to Mission</p>
                                                <dropdown
                                                        name="mission"
                                                        options="data.missions"
                                                        ng-model="file.mission_id"
                                                        unique-key="mission_id"
                                                        title-key="name"
                                                        searchable="true"
                                                        id-only="true">
                                                </dropdown>
                                            </label>
                                        </li>

                                        <li>
                                            <label>
                                                <p>Type of @{{ file.type }}</p>
                                                <select ng-model="file.subtype" ng-options="subtype as subtype for subtype in data.subtypes.images">
                                                    <option value="">None</option>
                                                </select>
                                            </label>
                                        </li>

                                        <li>
                                            <label>
                                                <p>When was this created?</p>
                                                <datetime type="date"
                                                          ng-model="file.originated_at"
                                                          nullable-toggle="false"></datetime>
                                            </label>
                                        </li>
                                    </ul>
                                </fieldset>

                                <fieldset class="gr-12">
                                    <legend>Tags</legend>
                                    <ul>
                                        <li>
                                            <label>
                                                <p>Tags</p>
                                                <tags available-tags="data.tags" ng-model="file.tags" name="tags"></tags>
                                                <span ng-show="@{{'fileForm' + $index}}.tags.$error.taglength">Please enter 1 to 5 tags.</span>
                                            </label>
                                        </li>
                                    </ul>
                                </fieldset>

                                <fieldset class="gr-12">
                                    <legend>Finally...</legend>
                                    <ul>
                                        <li class="gr-6">
                                            <input type="checkbox" name="anonymous" id="@{{ 'anonymous-file' + $index }}" value="true" ng-model="file.anonymous" />
                                            <label for="@{{ 'anonymous-file' + $index }}">
                                                <span>Submit anonymously?</span>
                                            </label>
                                        </li>
                                        <li class="gr-6">
                                            <input type="checkbox" name="original_content" id="@{{ 'original-content' + $index }}" value="true" ng-model="file.original_content" />
                                            <label for="@{{ 'original-content' + $index }}">
                                                <span>Did you create this yourself?</span>
                                            </label>
                                        </li>
                                    </ul>
                                </fieldset>
                            </form>
                        </div>

                        <!-- AUDIO FILE TEMPLATE -->
                        <div ng-if="file.type == 'Audio'" ng-show="isVisibleFile(file)">
                            <h2>@{{ file.original_name }}</h2>
                            <form name="@{{'fileForm' + $index}}" class="container" novalidate>

                                <fieldset class="gr-8 upload-basic-info">
                                    <legend>Basic Info</legend>
                                    <ul>
                                        <li>
                                            <label>
                                                <p>Title</p>
                                                <input type="text" name="title" ng-model="file.title" placeholder="Enter a title for this audio clip" ng-minlength="10" required />
                                            </label>
                                        </li>
                                        <li>
                                            <label>
                                                <p>Summary</p>
                                                <textarea name="summary" ng-model="file.summary" placeholder="Write a summary about this audio clip" ng-minlength="100" required character-counter></textarea>
                                            </label>
                                        </li>
                                    </ul>
                                </fieldset>

                                <fieldset class="gr-4 upload-preview text-center">
                                    <img ng-attr-src="@{{file.media_thumb_small}}" ng-attr-alt="@{{file.media_thumb_small}}" />

                                    <delta-v ng-model="file" hint="@{{ file.type }}"></delta-v>
                                </fieldset>

                                <fieldset class="gr-8 upload-attribution">
                                    <legend>Attribution</legend>

                                    <ul>
                                        <li>
                                            <label>
                                                <p>Author</p>
                                                <input type="text" name="author" ng-model="file.author" placeholder="Who authored this audio clip?" required />
                                            </label>
                                        </li>
                                        <li>
                                            <label>
                                                <p>Attribution/Copyright</p>
                                                <textarea name="attribution" ng-model="file.attribution" placeholder="Include any license and author details here. CC-BY-SA, Public Domain, etc."></textarea>
                                            </label>
                                        </li>
                                    </ul>
                                </fieldset>

                                <fieldset class="gr-4 upload-metadata">
                                    <legend>Metadata</legend>

                                    <ul>
                                        <li>
                                            <label>
                                                <p>Related to Mission</p>
                                                <dropdown
                                                        name="mission"
                                                        options="data.missions"
                                                        ng-model="file.mission_id"
                                                        unique-key="mission_id"
                                                        title-key="name"
                                                        searchable="true"
                                                        id-only="true">
                                                </dropdown>
                                            </label>
                                        </li>

                                        <li>
                                            <label>
                                                <p>When was this created?</p>
                                                <datetime type="date"
                                                          ng-model="file.originated_at"
                                                          nullable-toggle="false"></datetime>
                                            </label>
                                        </li>
                                    </ul>
                                </fieldset>

                                <fieldset class="gr-12">
                                    <legend>Tags</legend>
                                    <ul>
                                        <li>
                                            <label>
                                                <p>Tags</p>
                                                <tags available-tags="data.tags" ng-model="file.tags" name="tags"></tags>
                                                <span ng-show="@{{'fileForm' + $index}}.tags.$error.taglength">Please enter 1 to 5 tags.</span>
                                            </label>
                                        </li>
                                    </ul>
                                </fieldset>

                                <fieldset class="gr-12">
                                    <legend>Finally...</legend>
                                    <ul>
                                        <li class="gr-6">
                                            <input type="checkbox" name="anonymous" id="@{{ 'anonymous-file' + $index }}" value="true" ng-model="file.anonymous" />
                                            <label for="@{{ 'anonymous-file' + $index }}">
                                                <span>Submit anonymously?</span>
                                            </label>
                                        </li>
                                        <li class="gr-6">
                                            <input type="checkbox" name="original_content" id="@{{ 'original-content' + $index }}" value="true" ng-model="file.original_content" />
                                            <label for="@{{ 'original-content' + $index }}">
                                                <span>Did you create this yourself?</span>
                                            </label>
                                        </li>
                                    </ul>
                                </fieldset>
                            </form>
                        </div>

                        <!-- VIDEO FILE TEMPLATE -->
                        <div ng-if="file.type == 'Video'" ng-show="isVisibleFile(file)">
                            <h2>@{{ file.original_name }}</h2>
                            <form name="@{{'fileForm' + $index}}" class="container" novalidate>
                                <fieldset class="gr-8 upload-basic-info">
                                    <legend>Basic Info</legend>
                                    <ul>
                                        <li>
                                            <label>
                                                <p>Title</p>
                                                <input type="text" name="title" ng-model="file.title" placeholder="Enter a title for this video" ng-minlength="10" required />
                                            </label>
                                        </li>
                                        <li>
                                            <label>
                                                <p>Summary</p>
                                                <textarea name="summary" ng-model="file.summary" placeholder="Write a summary about this video" ng-minlength="100" required character-counter></textarea>
                                            </label>
                                        </li>
                                    </ul>
                                </fieldset>

                                <fieldset class="gr-4 upload-preview text-center">
                                    <img ng-attr-src="@{{file.media_thumb_small}}" ng-attr-alt="@{{file.media_thumb_small}}" />

                                    <delta-v ng-model="file" hint="@{{ file.type }}"></delta-v>
                                </fieldset>

                                <fieldset class="gr-8 upload-attribution">
                                    <legend>Attribution</legend>
                                    <ul>
                                        <li>
                                            <label>
                                                <p>Author</p>
                                                <input type="text" name="author" ng-model="file.author" placeholder="Who created this video?" required />
                                            </label>
                                        </li>
                                        <li>
                                            <label>
                                                <p>Attribution/Copyright</p>
                                                <textarea name="attribution" ng-model="file.attribution" placeholder="Include any license and author details here. CC-BY-SA, Public Domain, etc."></textarea>
                                            </label>
                                        </li>
                                    </ul>
                                </fieldset>

                                <fieldset class="gr-4 upload-metadata">
                                    <legend>Metadata</legend>

                                    <ul>
                                        <li>
                                            <label>
                                                <p>Related to Mission</p>
                                                <dropdown
                                                        name="mission"
                                                        options="data.missions"
                                                        ng-model="file.mission_id"
                                                        unique-key="mission_id"
                                                        title-key="name"
                                                        searchable="true"
                                                        id-only="true">
                                                </dropdown>
                                            </label>
                                        </li>

                                        <li>
                                            <label>
                                                <p>Youtube/Vimeo Link</p>
                                                <span>Adding a link to this video gains you extra deltaV and keeps site costs down.</span>
                                                <input type="text" name="external_url"
                                                       ng-model="file.external_url"
                                                       ng-pattern="/https?:\/\/(www\.)?(youtube\.com\/watch\?v=|youtu\.be\/|vimeo\.com\/)([^\s]+)\/?/"
                                                       placeholder="YouTube or Vimeo URL here" />
                                            </label>
                                        </li>

                                        <li>
                                            <label>
                                                <p>Type of @{{ file.type }}</p>
                                                <select ng-model="file.subtype" ng-options="subtype as subtype for subtype in data.subtypes.videos">
                                                    <option value="">None</option>
                                                </select>
                                            </label>
                                        </li>

                                        <li>
                                            <label>
                                                <p>When was this created?</p>
                                                <datetime type="date"
                                                          ng-model="file.originated_at"
                                                          nullable-toggle="false"></datetime>
                                            </label>
                                        </li>
                                    </ul>
                                </fieldset>

                                <fieldset class="gr-12">
                                    <legend>Tags</legend>
                                    <ul>
                                        <li>
                                            <label>
                                                <p>Tags</p>
                                                <tags available-tags="data.tags" ng-model="file.tags" name="tags"></tags>
                                                <span ng-show="@{{'fileForm' + $index}}.tags.$error.taglength">Please enter 1 to 5 tags.</span>
                                            </label>
                                        </li>
                                    </ul>
                                </fieldset>

                                <fieldset class="gr-12">
                                    <legend>Finally...</legend>
                                    <ul>
                                        <li class="gr-6">
                                            <input type="checkbox" name="anonymous" id="@{{ 'anonymous-file' + $index }}" value="true" ng-model="file.anonymous" />
                                            <label for="@{{ 'anonymous-file' + $index }}">
                                                <span>Submit anonymously?</span>
                                            </label>
                                        </li>
                                        <li class="gr-6">
                                            <input type="checkbox" name="original_content" id="@{{ 'original-content' + $index }}" value="true" ng-model="file.original_content" />
                                            <label for="@{{ 'original-content' + $index }}">
                                                <span>Did you create this yourself?</span>
                                            </label>
                                        </li>
                                    </ul>
                                </fieldset>
                            </form>
                        </div>

                        <!-- DOCUMENT FILE TEMPLATE -->
                        <div ng-if="file.type == 'Document'" ng-show="isVisibleFile(file)">
                            <h2>@{{ file.original_name }}</h2>
                            <form name="@{{'fileForm' + $index}}" class="container" novalidate>

                                <fieldset class="gr-8 upload-basic-info">
                                    <legend>Basic Info</legend>
                                    <ul>
                                        <li>
                                            <label>
                                                <p>Title</p>
                                                <input type="text" name="title" ng-model="file.title" placeholder="Enter a title for this document" ng-minlength="10" required />
                                            </label>
                                        </li>
                                        <li>
                                            <label>
                                                <p>Summary</p>
                                                <textarea name="summary" ng-model="file.summary" placeholder="Write a summary about this document" ng-minlength="100" required character-counter></textarea>
                                            </label>
                                        </li>
                                    </ul>
                                </fieldset>

                                <fieldset class="gr-4 upload-preview text-center">
                                    <img ng-attr-src="@{{file.media_thumb_small}}" ng-attr-alt="@{{file.media_thumb_small}}" />

                                    <delta-v ng-model="file" hint="@{{ file.type }}"></delta-v>
                                </fieldset>

                                <fieldset class="gr-8 upload-attribution">
                                    <legend>Attribution</legend>
                                    <ul>
                                        <li>
                                            <label>
                                                <p>Author</p>
                                                <input type="text" name="author" ng-model="file.author" placeholder="Who created this document?" required />
                                            </label>
                                        </li>
                                        <li>
                                            <label>
                                                <p>Attribution/Copyright</p>
                                                <textarea name="attribution" ng-model="file.attribution" placeholder="Include any license and author details here. CC-BY-SA, Public Domain, etc."></textarea>
                                            </label>
                                        </li>
                                    </ul>
                                </fieldset>

                                <fieldset class="gr-4 upload-metadata">
                                    <legend>Metadata</legend>

                                    <ul>
                                        <li>
                                            <label>
                                                <p>Related to Mission</p>
                                                <dropdown
                                                        name="mission"
                                                        options="data.missions"
                                                        ng-model="file.mission_id"
                                                        unique-key="mission_id"
                                                        title-key="name"
                                                        searchable="true"
                                                        id-only="true">
                                                </dropdown>
                                            </label>
                                        </li>

                                        <li>
                                            <label>
                                                <p>Type of @{{ file.type }}</p>
                                                <select ng-model="file.subtype" ng-options="subtype as subtype for subtype in data.subtypes.documents">
                                                    <option value="">None</option>
                                                </select>
                                            </label>
                                        </li>

                                        <li>
                                            <label>
                                                <p>When was this created?</p>
                                                <datetime type="date"
                                                          ng-model="file.originated_at"
                                                          nullable-toggle="false"></datetime>
                                            </label>
                                        </li>
                                    </ul>
                                </fieldset>

                                <fieldset class="gr-12">
                                    <legend>Tags</legend>
                                    <ul>
                                        <li>
                                            <label>
                                                <p>Tags</p>
                                                <tags available-tags="data.tags" ng-model="file.tags" name="tags"></tags>
                                                <span ng-show="@{{'fileForm' + $index}}.tags.$error.taglength">Please enter 1 to 5 tags.</span>
                                            </label>
                                        </li>
                                    </ul>
                                </fieldset>

                                <fieldset class="gr-12">
                                    <legend>Finally...</legend>
                                    <ul>
                                        <li class="gr-6">
                                            <input type="checkbox" name="anonymous" id="@{{ 'anonymous-file' + $index }}" value="true" ng-model="file.anonymous" />
                                            <label for="@{{ 'anonymous-file' + $index }}">
                                                <span>Submit anonymously?</span>
                                            </label>
                                        </li>
                                        <li class="gr-6">
                                            <input type="checkbox" name="original_content" id="@{{ 'original-content' + $index }}" value="true" ng-model="file.original_content" />
                                            <label for="@{{ 'original-content' + $index }}">
                                                <span>Did you create this yourself?</span>
                                            </label>
                                        </li>
                                    </ul>
                                </fieldset>
                            </form>
                        </div>
                    </div>

                    <div class="make-collection-from-upload" ng-if="files.length > 1">
                        <h3><input id="make-collection" ng-model="isMakingCollection" value="true" type="checkbox" /><label for="make-collection">Make these items a collection</label></h3>
                        <p>If these items are similar, you can group them into a collection for easy access and sharing. Collections can always have items added or removed later.</p>
                        <form name="optionalCollectionForm" ng-if="isMakingCollection">
                            <ul>
                                <li>
                                    <label>Collection Title</label>
                                    <input type="text" name="title" ng-model="optionalCollection.title" ng-minlength="10" placeholder="A descriptive title for the collection">
                                </li>
                                <li>
                                    <label>Collection Summary</label>
                                    <textarea name="description" ng-model="optionalCollection.summary" ng-minlength="100" placeholder="A short summary of what this collection is about" required character-counter></textarea>
                                </li>
                            </ul>
                        </form>
                    </div>
                    <button id="files-submit" class="wide-button" ng-disabled="uploadForm.$invalid || isSubmitting" ng-click="fileSubmitButtonFunction()" ng-bind="fileSubmitButtonText(uploadForm)"></button>
                </div>
            </section>

            <!-- Post -->
            <section class="upload-post" ng-controller="postController" ng-show="activeSection == 'post'">
                <form name="postForm">
                    <p>Select what type of submission you want to submit...</p>
                    <fieldset class="post-type-selection container text-center">
                        <div class="gr-2">
                            <input type="radio" name="type" id="tweet" value="tweet" ng-model="postType" ng-click="postType = 'tweet'" />
                            <label for="tweet"><span>Tweet</span></label>
                        </div>

                        <div class="gr-2">
                            <input type="radio" name="type" id="article" value="article" ng-model="postType" ng-click="postType = 'article'" />
                            <label for="article"><span>News Article</span></label>
                        </div>

                        <div class="gr-2">
                            <input type="radio" name="type" id="pressrelease" value="pressrelease" ng-model="postType" ng-click="postType = 'pressrelease'" />
                            <label for="pressrelease"><span>SpaceX Press Release</span></label>
                        </div>

                        <div class="gr-2">
                            <input type="radio" name="type" id="redditcomment" value="redditcomment" ng-model="postType" ng-click="postType = 'redditcomment'" />
                            <label for="redditcomment"><span>Reddit Comment</span></label>
                        </div>

                        <div class="gr-2">
                            <input type="radio" name="type" id="NSFcomment" value="NSFcomment" ng-model="postType" ng-click="postType = 'NSFcomment'" />
                            <label for="NSFcomment"><span>NSF Comment</span></label>
                        </div>
                    </fieldset>

                    <!-- Tweet -->
                    <fieldset ng-if="postType == 'tweet'" class="post-type tweet container">
                        <h3>Tweet</h3>
                        <div class="gr-9">
                            <tweet tweet="tweet"></tweet>
                        </div>
                        <div class="gr-3">
                            <delta-v ng-model="tweet" hint="Tweet"></delta-v>
                        </div>
                    </fieldset>

                    <!-- Article -->
                    <fieldset class="post-type article" ng-if="postType == 'article'">
                        <h3>Article</h3>
                        <div class="gr-9">
                            <ul>
                                <li>
                                    <label>Article URL</label>
                                    <input type="url" name="article-url" id="article-url" ng-model="article.external_url" ng-change="detectPublisher()" required />
                                </li>
                                <li>
                                    <label>Article Date</label>
                                    <datetime ng-model="article.originated_at" type="date" is-null="false"></datetime>
                                </li>
                                <li>
                                    <label>Publication</label>
                                    <dropdown
                                            name="publisher"
                                            options="data.publishers"
                                            ng-model="article.publisher_id"
                                            unique-key="publisher_id"
                                            title-key="name"
                                            image-key="favicon"
                                            searchable="true"
                                            placeholder="Select the publisher of the article">
                                    </dropdown>
                                    <p ng-show="article.publisher_id == null">Can't find the article publisher? <a href="/missioncontrol/publishers">Create them first</a>.</p>
                                </li>
                                <li class="container">
                                    <div class="gr-8">
                                        <label>Article Title</label>
                                        <input type="text" name="article-title" id="article-title" ng-model="article.title" required />
                                    </div>
                                    <div class="gr-4">
                                        <label>Article Author</label>
                                        <input type="text" name="article-author" id="article-author" ng-model="article.author" />
                                    </div>
                                </li>
                                <li>
                                    <label>Article</label>
                                    <textarea ng-model="article.article" placeholder="You can use markdown here to format the article." required></textarea>
                                </li>
                                <li>
                                    <label>Summary</label>
                                    <textarea ng-model="article.summary" placeholder="A short summary describing the article" required character-counter></textarea>
                                </li>
                                <li>
                                    <label>Select Mission</label>
                                    <dropdown
                                            name="mission"
                                            options="data.missions"
                                            ng-model="article.mission_id"
                                            unique-key="mission_id"
                                            title-key="name"
                                            searchable="true"
                                            placeholder="Select a related mission...">
                                    </dropdown>
                                </li>
                                <li>
                                    <label>Tags</label>
                                    <tags available-tags="data.tags" name="tags" ng-model="article.tags"></tags>
                                    <span ng-show="postForm.tags.$error.taglength">Please enter 1 to 5 tags.</span>
                                </li>
                            </ul>
                        </div>

                        <div class="gr-3">
                            <delta-v ng-model="article" hint="Article"></delta-v>
                        </div>
                    </fieldset>

                    <!-- Press Release -->
                    <fieldset class="post-type pressrelease" ng-if="postType == 'pressrelease'">
                        <h3>SpaceX Press Release</h3>
                        <div class="gr-9">
                            <ul>
                                <li>
                                    <label>Press Release URL</label>
                                    <input type="url" name="pressrelease-url" id="pressrelease-url" ng-model="pressrelease.external_url" required />
                                </li>
                                <li>
                                    <label>Press Release Date</label>
                                    <datetime ng-model="pressrelease.originated_at" type="date" start-year="2002" is-null="false"></datetime>
                                </li>
                                <li>
                                    <label>Press Release Title</label>
                                    <input type="text" name="pressrelease-author" id="pressrelease-author" ng-model="pressrelease.title" required />
                                </li>
                                <li>
                                    <label>Press Release Text</label>
                                    <textarea ng-model="pressrelease.article" required></textarea>
                                </li>
                                <li>
                                    <label>Summary</label>
                                    <textarea ng-model="pressrelease.summary" placeholder="A short summary describing the press release" required character-counter></textarea>
                                </li>
                                <li>
                                    <label>Select Mission</label>
                                    <dropdown
                                            name="mission"
                                            options="data.missions"
                                            ng-model="pressrelease.mission_id"
                                            unique-key="mission_id"
                                            title-key="name"
                                            searchable="true"
                                            placeholder="Select a related mission...">
                                    </dropdown>
                                </li>
                                <li>
                                    <label>Tags</label>
                                    <tags available-tags="data.tags" name="tags" ng-model="pressrelease.tags"></tags>
                                    <span ng-show="postForm.tags.$error.taglength">Please enter 1 to 5 tags.</span>
                                </li>
                            </ul>
                        </div>

                        <div class="gr-3">
                            <delta-v ng-model="pressrelease" hint="Article"></delta-v>
                        </div>
                    </fieldset>

                    <!-- Reddit Comment -->
                    <fieldset class="post-type redditcomment" ng-if="postType == 'redditcomment'" required>
                        <h3>Reddit Comment</h3>
                        <div class="gr-9">
                            <ul>
                                <li>
                                    <label>Permalink URL</label>
                                    <input type="url" name="redditcomment-url" id="redditcomment-url" ng-model="redditcomment.external_url" ng-change="retrieveRedditComment" required ng-pattern="/reddit.com\//" placeholder="Please ensure this is a Reddit permalink">
                                </li>
                                <li>
                                    <label>Title Describing The Comment</label>
                                    <input type="text" name="redditcomment-author" id="redditcomment-author" ng-model="redditcomment.title" placeholder="The title that appears on SpaceX Stats" required ng-minlength="10"  />
                                </li>
                                <li>
                                    <label>A short summary describing the comment</label>
                                    <textarea ng-model="redditcomment.summary" placeholder="A short summary describing the comment" required character-counter></textarea>
                                </li>
                                <li>
                                    <reddit-comment ng-model="redditcomment"></reddit-comment>
                                </li>
                                <li>
                                    <label>Select Mission</label>
                                    <dropdown
                                            name="mission"
                                            options="data.missions"
                                            ng-model="redditcomment.mission_id"
                                            unique-key="mission_id"
                                            title-key="name"
                                            searchable="true"
                                            placeholder="Select a related mission...">
                                    </dropdown>
                                </li>
                                <li>
                                    <label>Tags</label>
                                    <tags available-tags="data.tags" name="tags" ng-model="redditcomment.tags"></tags>
                                    <span ng-show="postForm.tags.$error.taglength">Please enter 1 to 5 tags.</span>
                                </li>
                            </ul>
                        </div>

                        <div class="gr-3">
                            <delta-v ng-model="redditcomment" hint="Comment"></delta-v>
                        </div>
                    </fieldset>

                    <!-- NSF Comment -->
                    <fieldset class="post-type nsf-comment" ng-if="postType == 'NSFcomment'">
                        <h3>NasaSpaceFlight Comment</h3>
                        <div class="gr-9">
                            <ul>
                                <li>
                                    <label>Comment URL</label>
                                    <input type="url" name="NSFcomment-url" id="article-url" ng-model="NSFcomment.external_url" placeholder="The direct URL to the comment" required ng-pattern="/nasaspaceflight.com\//" />
                                </li>
                                <li>
                                    <label>Title Describing The Comment</label>
                                    <input type="text" name="NSFcomment-title" id="article-author" ng-model="NSFcomment.title" placeholder="The title that appears on SpaceX Stats" required ng-minlength="10" />
                                </li>
                                <li>
                                    <label>Comment Date</label>
                                    <datetime ng-model="NSFcomment.originated_at" type="datetime" start-year="2000" is-null="false"></datetime>
                                </li>
                                <li>
                                    <label>Comment Author</label>
                                    <input type="author" name="NSFcomment-author" id="article-author" ng-model="NSFcomment.author" placeholder="The author of the comment" required />
                                </li>
                                <li>
                                    <label>Comment Body</label>
                                    <textarea ng-model="NSFcomment.comment" placeholder="Enter in the comment body here" required></textarea>
                                </li>
                                <li>
                                    <label>A short summary of the comment</label>
                                    <textarea ng-model="NSFcomment.summary" placeholder="A short summary describing the comment" required character-counter></textarea>
                                </li>
                                <li>
                                    <label>Select Mission</label>
                                    <dropdown
                                            name="mission"
                                            options="data.missions"
                                            ng-model="NSFcomment.mission_id"
                                            unique-key="mission_id"
                                            title-key="name"
                                            searchable="true"
                                            placeholder="Select a related mission...">
                                    </dropdown>
                                </li>
                                <li>
                                    <label>Tags</label>
                                    <tags available-tags="data.tags" name="tags" ng-model="NSFcomment.tags"></tags>
                                    <span ng-show="postForm.tags.$error.taglength">Please enter 1 to 5 tags.</span>
                                </li>
                            </ul>
                        </div>

                        <div class="gr-3">
                            <delta-v ng-model="NSFcomment" hint="Comment"></delta-v>
                        </div>
                    </fieldset>

                    <p class="exclaim" ng-if="postType == null">No Submission Selected</p>

                    <button name="submit" class="wide-button" ng-click="postSubmitButtonFunction()" ng-disabled="postType == null || postForm.$invalid || isSubmitting" ng-bind="postSubmitButtonText(postForm)"></button>
                </form>
            </section>

            <!-- Write -->
            <section class="upload-text" ng-controller="writeController" ng-show="activeSection == 'write'">
                <form name="writeForm" class="container" novalidate>

                    <p>Post a mission update, share some news, ask a question, discuss a topic!</p>

                    <div class="gr-9">
                        <ul>
                            <li>
                                <label>Title</label>
                                <input type="text" name="title" ng-model="text.title" placeholder="Enter a title for your post" ng-minlength="10" required/>
                            </li>
                            <li>
                                <label>Content</label>
                                <textarea name="content" ng-model="text.summary" placeholder="Write your post" rows="10" ng-minlength="100" required character-counter></textarea>
                            </li>
                            <li>
                                <label>Select related mission</label>
                                <dropdown
                                        name="mission"
                                        options="data.missions"
                                        ng-model="text.mission_id"
                                        unique-key="mission_id"
                                        title-key="name"
                                        searchable="true"
                                        placeholder="Select a related mission...">
                                </dropdown>
                            </li>
                            <li>
                                <p>Submit anonymously?</p>
                                <input type="checkbox" name="anonymous" id="anonymous-text" value="true" ng-model="text.anonymous" />
                                <label for="anonymous-text"></label>
                            </li>
                            <li>
                                <label>Tags</label>
                                <tags available-tags="data.tags" name="tags" ng-model="text.tags"></tags>
                                <span ng-show="writeForm.tags.$error.taglength">Please enter 1 to 5 tags.</span>
                            </li>
                        </ul>
                    </div>
                    <div class="gr-3">
                        <delta-v ng-model="text" hint="Text"></delta-v>
                    </div>

                    <button name="submit" class="wide-button" ng-click="writeSubmitButtonFunction()" ng-disabled="writeForm.$invalid || isSubmitting" ng-bind="writeSubmitButtonText(writeForm)"></button>
                </form>
            </section>

            <h2>Recent Additions</h2>
            <section>
                @foreach($recentUploads as $recentUpload)
                    @include('templates.cards.objectCard', ['bias' => 'object', 'object' => $recentUpload])
                @endforeach
            </section>
        </main>
    </div>
    <script type="text/javascript">
        (function() {
            var app = angular.module("app");
            app.constant("CSRF_TOKEN", '{{ csrf_token() }}');
        })();
    </script>
</body>
@stop

