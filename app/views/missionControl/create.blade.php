@extends('templates.main')
@section('title', 'Upload to Mission Control')

@section('content')
<body class="missioncontrol-upload" ng-app="uploadApp" ng-controller="uploadAppController" ng-strict-di>

    @include('templates.flashMessage')
    @include('templates.header')

    <div class="content-wrapper">
        <h1>Upload to Mission Control</h1>
        <main>
            <!-- List of methods to upload -->
            <nav>
                <ul class="upload-type text-center">
                    <li ng-click="changeSection('upload')"><i class="fa fa-upload"></i> Upload</li>
                    <li ng-click="changeSection('post')"><i class="fa fa-paperclip"></i> Post</li>
                    <li ng-click="changeSection('write')"><i class="fa fa-pencil"></i> Write</li>
                </ul>
            </nav>

            <!-- Upload -->
            <section class="upload-upload" ng-controller="uploadController" ng-show="activeSection == 'upload'">

                <div ng-show="activeUploadSection == 'dropzone'">
                    <p>Do not upload files that might violate SpaceX's Communications Policy. If you are unsure </p>
                    <form method="post" class="dropzone" upload enctype="multipart/form-data" action="/missioncontrol/create/upload" callback="uploadCallback(somescome)" multi-upload="true">
                    </form>
                    <button id="upload" ng-click="uploadFiles()">Upload</button>
                </div>

                <div ng-show="activeUploadSection == 'data'">
                    <ul class="files-list">
                        <li class="uploaded-file" ng-repeat="file in files" ng-show="isVisibleFile(file)" ng-click="setVisibleFile(file)">
                            <img ng-attr-src="file.media_thumb_small"/><br/>
                            <span>[[ file.original_name ]]</span>
                        </li>
                    </ul>

                    <div class="delta-v" delta-v="files"></div>

                    <div class="files-details" ng-repeat="file in files">

                        <!-- IMAGE FILE TEMPLATE -->
                        <div ng-if="file.type == 1" ng-show="isVisibleFile(file)">
                            <h2>[[ file.original_name ]]</h2>
                            <form>
                                <ul class="container">
                                    <li class="grid-4">
                                        <img ng-attr-src="[[file.media_thumb_small]]" ng-attr-alt="[[file.media_thumb_small]]" />
                                    </li>

                                    <li class="grid-4">
                                        <label>
                                            <p>Title</p>
                                            <input type="text" name="title" ng-model="file.title" />
                                        </label>
                                    </li>

                                    <li class="grid-8">
                                        <label>
                                            <p>Summary</p>
                                            <textarea name="summary" ng-model="file.summary"></textarea>
                                        </label>
                                    </li>

                                    <li class="grid-4">
                                        <label>
                                            <p>Related to Mission</p>
                                            <select-list options="missions" hasDefaultOption="false" selected-option="file.mission_id" unique-key="mission_id" searchable="true"></select-list>
                                        </label>
                                    </li>

                                    <li class="grid-6">
                                        <label>
                                            <p>Author</p>
                                            <input type="text" name="author" ng-model="file.author" />
                                        </label>
                                    </li>

                                    <li class="grid-6">
                                        <label>
                                            <p>Attribution/Copyright</p>
                                            <textarea name="attribution" ng-model="file.attribution"></textarea>
                                        </label>
                                    </li>

                                    <li class="grid-6">
                                        <label>
                                            <p>Tags</p>
                                            <tags available-tags="tags" selected-tags="file.tags"></tags>
                                        </label>
                                    </li>

                                    <li class="grid-6">
                                        <label>
                                            <p>Type</p>
                                            <select ng-model="file.subtype">
                                                <option>None</option>
                                                <option value="1">Mission Patch</option>
                                                <option value="2">Photo</option>
                                                <option value="5">Screenshot</option>
                                                <option value="11">Infographic</option>
                                                <option value="12">News Summary</option>
                                                <option value="16">Hazard Map</option>
                                                <optiom value="17">License</optiom>
                                            </select>
                                        </label>
                                    </li>

                                    <li class="grid-6">
                                        <datetime params="value: originated_at, type: 'date'"></datetime>
                                    </li>

                                    <li class="grid-12">
                                        <label>
                                            <p>Submit anonymously?</p>
                                            <input type="checkbox" name="anonymous" ng-model="file.anonymous" />
                                        </label>
                                    </li>
                                </ul>
                            </form>
                        </div>

                        <!-- GIF FILE TEMPLATE -->
                        <div ng-if="file.type == 2" ng-show="isVisibleFile(file)">
                            <h2>[[ file.original_name ]]</h2>
                            <form>
                                <ul class="container">
                                    <li class="grid-4">
                                        <img ng-attr-src="[[file.media_thumb_small]]" ng-attr-alt="[[file.media_thumb_small]]" />
                                    </li>

                                    <li class="grid-4">
                                        <label>
                                            <p>Title</p>
                                            <input type="text" name="title" ng-model="file.title" />
                                        </label>
                                    </li>

                                    <li class="grid-8">
                                        <label>
                                            <p>Summary</p>
                                            <textarea name="summary" ng-model="file.summary"></textarea>
                                        </label>
                                    </li>

                                    <li class="grid-4">
                                        <label>
                                            <p>Related to Mission</p>
                                            <select-list options="missions" hasDefaultOption="false" selected-option="file.mission_id" unique-key="mission_id" searchable="true"></select-list>
                                        </label>
                                    </li>

                                    <li class="grid-6">
                                        <label>
                                            <p>Author</p>
                                            <input type="text" name="author" ng-model="file.author" />
                                        </label>
                                    </li>

                                    <li class="grid-6">
                                        <label>
                                            <p>Attribution/Copyright</p>
                                            <textarea name="attribution" ng-model="file.attribution"></textarea>
                                        </label>
                                    </li>

                                    <li class="grid-6">
                                        <label>
                                            <p>Tags</p>
                                            <tags available-tags="tags" selected-tags="file.tags"></tags>
                                        </label>
                                    </li>

                                    <li class="grid-6">
                                        <datetime params="value: originated_at, type: 'date'"></datetime>
                                    </li>

                                    <li class="grid-12">
                                        <label>
                                            <p>Submit anonymously?</p>
                                            <input type="checkbox" name="anonymous" ng-model="file.anonymous" />
                                        </label>
                                    </li>
                                </ul>
                            </form>
                        </div>

                        <!-- AUDIO FILE TEMPLATE -->
                        <div ng-if="file.type == 3" ng-show="isVisibleFile(file)">
                            <h2>[[ file.original_name ]]</h2>
                            <form>
                                <ul class="container">
                                    <li class="grid-4">
                                        <img ng-attr-src="[[file.media_thumb_small]]" ng-attr-alt="[[file.media_thumb_small]]" />
                                    </li>

                                    <li class="grid-4">
                                        <label>
                                            <p>Title</p>
                                            <input type="text" name="title" ng-model="file.title" />
                                        </label>
                                    </li>

                                    <li class="grid-8">
                                        <label>
                                            <p>Summary</p>
                                            <textarea name="summary" ng-model="file.summary"></textarea>
                                        </label>
                                    </li>

                                    <li class="grid-4">
                                        <label>
                                            <p>Related to Mission</p>
                                            <select-list options="missions" hasDefaultOption="false" selected-option="file.mission_id" unique-key="mission_id" searchable="true"></select-list>
                                        </label>
                                    </li>

                                    <li class="grid-6">
                                        <label>
                                            <p>Author</p>
                                            <input type="text" name="author" ng-model="file.author" />
                                        </label>
                                    </li>

                                    <li class="grid-6">
                                        <label>
                                            <p>Attribution/Copyright</p>
                                            <textarea name="attribution" ng-model="file.attribution"></textarea>
                                        </label>
                                    </li>

                                    <li class="grid-6">
                                        <label>
                                            <p>Tags</p>
                                            <tags available-tags="tags" selected-tags="file.tags"></tags>
                                        </label>
                                    </li>

                                    <li class="grid-6">
                                        <datetime params="value: originated_at, type: 'date'"></datetime>
                                    </li>

                                    <li class="grid-12">
                                        <label>
                                            <p>Submit anonymously?</p>
                                            <input type="checkbox" name="anonymous" ng-model="file.anonymous" />
                                        </label>
                                    </li>
                                </ul>
                            </form>
                        </div>
                    </div>

                    <button id="files-submit" ng-click="fileSubmitButtonFunction()">[[ buttonText ]]</button>
                </div>
            </section>

            <!-- Post -->
            <section class="upload-post" ng-controller="postController" ng-show="activeSection == 'post'">
                <form>
                    <fieldset class="post-type-selection">
                        <label><input type="radio" name="type" value="tweet" data-bind="checked: postType" />Tweet</label>
                        <label><input type="radio" name="type" value="article" data-bind="checked: postType" />News Article</label>
                        <label><input type="radio" name="type" value="pressrelease" data-bind="checked: postType" />SpaceX press release</label>
                        <label><input type="radio" name="type" value="redditcomment" data-bind="checked: postType" />Reddit comment</label>
                        <label><input type="radio" name="type" value="NSFComment" data-bind="checked: postType" />NSF comment</label>
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

                        <label>Select Related Mission</label>
                        <rich-select params="data: $root.missionData, hasDefaultOption: true, value: mission_id, uniqueKey: 'mission_id', searchable: true"></rich-select>

                        <label>Tags</label>
                        <tags params="tags: tags"></tags>
                    </fieldset>

                    <fieldset class="post-type nsf-comment" data-bind="visible: postType() == 'NSFComment', with: NSFComment">
                        <label>Comment URL</label>
                        <input type="url" name="nsfcomment-url" id="article-url" data-bind="value: external_url"/>

                        <label>Comment Title</label>
                        <input type="text" name="article-author" id="article-author" data-bind="value: title" />

                        <label>Comment Date</label>
                        <datetime params="value: originated_at, type: 'date'"></datetime>

                        <label>Comment Author</label>
                        <input type="author" name="nsf-comment-author" id="article-author" data-bind="value: author" />

                        <label>Comment</label>
                        <textarea data-bind="value: comment"></textarea>

                        <label>Select Related Mission</label>
                        <rich-select params="data: $root.missionData, hasDefaultOption: true, value: mission_id, uniqueKey: 'mission_id', searchable: true"></rich-select>

                        <label>Tags</label>
                        <tags params="tags: tags"></tags>
                    </fieldset>

                    <input type="submit" value="Submit" name="submit" id="post-submit" data-bind="click: submitPost" />
                </form>
            </section>

            <!-- Write -->
            <section class="upload-text" ng-controller="writeController" ng-show="activeSection == 'write'">
                <form data-bind="with: text">
                    <label>Select related mission</label>
                    <rich-select params="data: $root.missionData, hasDefaultOption: true, value: mission_id, uniqueKey: 'mission_id', searchable: true"></rich-select>

                    <label>Title</label>
                    <input type="text" data-bind="value: title"/>

                    <label>Content</label>
                    <textarea data-bind="value: content"></textarea>

                    <p>Submit anonymously?</p>
                    <input type="checkbox" name="anonymous" data-bind="checked: anonymous" />

                    <label>Tags</label>
                    <tags params="tags: tags"></tags>

                    <input type="submit" value="Submit" name="submit" id="text-submit" data-bind="click: $root.submitText" />
                </form>
            </section>
        </main>
    </div>

        <!-- Knockout Templates -->

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
</body>
@stop

