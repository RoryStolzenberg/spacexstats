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

                <div ng-show="activeUploadSection == 'data'" ng-form="uploadForm">
                    <ul class="files-list">
                        <li class="uploaded-file" ng-repeat="file in files" ng-class="{ valid: uploadForm['fileForm' + $index].$valid, invalid: uploadForm['fileForm' + $index].$invalid }"  ng-click="setVisibleFile(file)">
                            <img ng-attr-src="[[file.media_thumb_small]]"/><br/>
                            <span>[[ file.original_name ]]</span>
                        </li>
                    </ul>

                    <div class="delta-v" delta-v="files"></div>

                    <div class="files-details" ng-repeat="file in files">

                        <!-- IMAGE FILE TEMPLATE -->
                        <div ng-if="file.type == 1" ng-show="isVisibleFile(file)">
                            <h2>[[ file.original_name ]]</h2>
                            <form name="[['fileForm' + $index]]" novalidate>
                                <ul class="container">
                                    <li class="grid-4">
                                        <img ng-attr-src="[[file.media_thumb_small]]" ng-attr-alt="[[file.media_thumb_small]]" />
                                    </li>

                                    <li class="grid-4">
                                        <label>
                                            <p>Title</p>
                                            <input type="text" name="title" ng-model="file.title" placeholder="Enter a title for this image" minlength="10" required />
                                        </label>
                                    </li>

                                    <li class="grid-8">
                                        <label>
                                            <p>Summary</p>
                                            <textarea name="summary" ng-model="file.summary" placeholder="Write a summary about this image" minlength="100" required></textarea>
                                        </label>
                                    </li>

                                    <li class="grid-4">
                                        <label>
                                            <p>Related to Mission</p>
                                            <select-list
                                                    name="mission"
                                                    options="data.missions"
                                                    ng-model="file.mission_id"
                                                    unique-key="mission_id"
                                                    title-key="name"
                                                    searchable="true">
                                            </select-list>
                                        </label>
                                    </li>

                                    <li class="grid-6">
                                        <label>
                                            <p>Author</p>
                                            <input type="text" name="author" ng-model="file.author" placeholder="Who took this image?" required />
                                        </label>
                                    </li>

                                    <li class="grid-6">
                                        <label>
                                            <p>Attribution/Copyright</p>
                                            <textarea name="attribution" ng-model="file.attribution" placeholder="Include any license and author details here. CC-BY-SA, Public Domain, etc."></textarea>
                                        </label>
                                    </li>

                                    <li class="grid-6">
                                        <label>
                                            <p>Tags</p>
                                            <tags available-tags="data.tags" ng-model="file.tags" ></tags>
                                        </label>
                                    </li>

                                    <li class="grid-6">
                                        <label>
                                            <p>Type</p>
                                            <select ng-model="file.subtype" ng-options="subtype.value as subtype.display for subtype in data.subtypes.images">
                                                <option value="">None</option>
                                            </select>
                                        </label>
                                    </li>

                                    <li class="grid-6">
                                        <label>
                                            <p>When was this created?</p>
                                            <datetime type="[[ ::(file.datetimeExtractedFromEXIF ? 'datetime' : 'date') ]]"
                                                      ng-model="file.originated_at"
                                                      is-null="::file.datetimeExtractedFromEXIF"
                                                      nullable-toggle="false"></datetime>
                                        </label>

                                    </li>

                                    <li class="grid-12">
                                        <label>
                                            <p>Submit anonymously?</p>
                                            <input type="checkbox" name="anonymous" id="[[ 'anonymous-file' + $index ]]" value="true" ng-model="file.anonymous" />
                                            <label for="[[ 'anonymous-file' + $index ]]"></label>
                                        </label>
                                    </li>
                                </ul>
                            </form>
                        </div>

                        <!-- GIF FILE TEMPLATE -->
                        <div ng-if="file.type == 2" ng-show="isVisibleFile(file)">
                            <h2>[[ file.original_name ]]</h2>
                            <form name="[['fileForm' + $index]]" novalidate>
                                <ul class="container">
                                    <li class="grid-4">
                                        <img ng-attr-src="[[file.media_thumb_small]]" ng-attr-alt="[[file.media_thumb_small]]" />
                                    </li>

                                    <li class="grid-4">
                                        <label>
                                            <p>Title</p>
                                            <input type="text" name="title" ng-model="file.title" placeholder="Enter a title for this GIF" minlength="10" required />
                                        </label>
                                    </li>

                                    <li class="grid-8">
                                        <label>
                                            <p>Summary</p>
                                            <textarea name="summary" ng-model="file.summary" placeholder="Write a summary about this GIF" minlength="100" required></textarea>
                                        </label>
                                    </li>

                                    <li class="grid-4">
                                        <label>
                                            <p>Related to Mission</p>
                                            <select-list options="data.missions" ng-model="file.mission_id" unique-key="mission_id" title-key="name" searchable="true"></select-list>
                                        </label>
                                    </li>

                                    <li class="grid-6">
                                        <label>
                                            <p>Author</p>
                                            <input type="text" name="author" ng-model="file.author" placeholder="Who made this GIF?" required />
                                        </label>
                                    </li>

                                    <li class="grid-6">
                                        <label>
                                            <p>Attribution/Copyright</p>
                                            <textarea name="attribution" ng-model="file.attribution"  placeholder="Include any license and author details here. CC-BY-SA, Public Domain, etc."></textarea>
                                        </label>
                                    </li>

                                    <li class="grid-6">
                                        <label>
                                            <p>Tags</p>
                                            <tags available-tags="data.tags" ng-model="file.tags"></tags>
                                        </label>
                                    </li>

                                    <li class="grid-6">
                                    </li>

                                    <li class="grid-12">
                                        <label>
                                            <p>Submit anonymously?</p>
                                            <input type="checkbox" name="anonymous" id="[[ 'anonymous-file' + $index ]]" value="true" ng-model="file.anonymous" />
                                            <label for="[[ 'anonymous-file' + $index ]]"></label>
                                        </label>
                                    </li>
                                </ul>
                            </form>
                        </div>

                        <!-- AUDIO FILE TEMPLATE -->
                        <div ng-if="file.type == 3" ng-show="isVisibleFile(file)">
                            <h2>[[ file.original_name ]]</h2>
                            <form name="[['fileForm' + $index]]" novalidate>
                                <ul class="container">
                                    <li class="grid-4">
                                        <img ng-attr-src="[[file.media_thumb_small]]" ng-attr-alt="[[file.media_thumb_small]]" />
                                    </li>

                                    <li class="grid-4">
                                        <label>
                                            <p>Title</p>
                                            <input type="text" name="title" ng-model="file.title" placeholder="Enter a title for this audio clip" minlength="10" required />
                                        </label>
                                    </li>

                                    <li class="grid-8">
                                        <label>
                                            <p>Summary</p>
                                            <textarea name="summary" ng-model="file.summary" placeholder="Write a summary about this audio clip" minlength="100" required></textarea>
                                        </label>
                                    </li>

                                    <li class="grid-4">
                                        <label>
                                            <p>Related to Mission</p>
                                            <select-list options="data.missions" ng-model="file.mission_id" unique-key="mission_id" title-key="name" searchable="true"></select-list>
                                        </label>
                                    </li>

                                    <li class="grid-6">
                                        <label>
                                            <p>Author</p>
                                            <input type="text" name="author" ng-model="file.author" placeholder="Who authored this audio clip?" required />
                                        </label>
                                    </li>

                                    <li class="grid-6">
                                        <label>
                                            <p>Attribution/Copyright</p>
                                            <textarea name="attribution" ng-model="file.attribution" placeholder="Include any license and author details here. CC-BY-SA, Public Domain, etc."></textarea>
                                        </label>
                                    </li>

                                    <li class="grid-6">
                                        <label>
                                            <p>Tags</p>
                                            <tags available-tags="data.tags" ng-model="file.tags"></tags>
                                        </label>
                                    </li>

                                    <li class="grid-6">
                                    </li>

                                    <li class="grid-12">
                                        <label>
                                            <p>Submit anonymously?</p>
                                            <input type="checkbox" name="anonymous" id="[[ 'anonymous-file' + $index ]]" value="true" ng-model="file.anonymous" />
                                            <label for="[[ 'anonymous-file' + $index ]]"></label>
                                        </label>
                                    </li>
                                </ul>
                            </form>
                        </div>

                        <!-- VIDEO FILE TEMPLATE -->
                        <div ng-if="file.type == 4" ng-show="isVisibleFile(file)">
                            <h2>[[ file.original_name ]]</h2>
                            <form name="[['fileForm' + $index]]" novalidate>
                                <ul class="container">
                                    <li class="grid-4">
                                        <img ng-attr-src="[[file.media_thumb_small]]" ng-attr-alt="[[file.media_thumb_small]]" />
                                    </li>

                                    <li class="grid-4">
                                        <label>
                                            <p>Title</p>
                                            <input type="text" name="title" ng-model="file.title" placeholder="Enter a title for this video" minlength="10" required />
                                        </label>
                                    </li>

                                    <li class="grid-8">
                                        <label>
                                            <p>Summary</p>
                                            <textarea name="summary" ng-model="file.summary" placeholder="Write a summary about this video" minlength="100" required></textarea>
                                        </label>
                                    </li>

                                    <li class="grid-4">
                                        <label>
                                            <p>Youtube/Vimeo Link</p>
                                            <span>Adding a link to this video gains you extra deltaV and keeps site costs down.</span>
                                            <input type="text" name="external_url" ng-model="file.external_url" />
                                        </label>

                                    </li>

                                    <li class="grid-4">
                                        <label>
                                            <p>Related to Mission</p>
                                            <select-list options="data.missions" ng-model="file.mission_id" unique-key="mission_id" title-key="name" searchable="true"></select-list>
                                        </label>
                                    </li>

                                    <li class="grid-6">
                                        <label>
                                            <p>Author</p>
                                            <input type="text" name="author" ng-model="file.author" placeholder="Who created this video?" required/>
                                        </label>
                                    </li>

                                    <li class="grid-6">
                                        <label>
                                            <p>Attribution/Copyright</p>
                                            <textarea name="attribution" ng-model="file.attribution" placeholder="Include any license and author details here. CC-BY-SA, Public Domain, etc."></textarea>
                                        </label>
                                    </li>

                                    <li class="grid-6">
                                        <label>
                                            <p>Tags</p>
                                            <tags available-tags="data.tags" ng-model="file.tags"></tags>
                                        </label>
                                    </li>

                                    <li class="grid-6">
                                        <label>
                                            <p>Type</p>
                                            <select ng-model="file.subtype" ng-options="subtype.value as subtype.display for subtype in data.subtypes.video">
                                                <option value="">None</option>
                                            </select>
                                        </label>
                                    </li>

                                    <li class="grid-6">
                                    </li>

                                    <li class="grid-12">
                                        <label>
                                            <p>Submit anonymously?</p>
                                            <input type="checkbox" name="anonymous" id="[[ 'anonymous-file' + $index ]]" value="true" ng-model="file.anonymous"/>
                                            <label for="[[ 'anonymous-file' + $index ]]"></label>
                                        </label>
                                    </li>
                                </ul>
                            </form>
                        </div>

                        <!-- DOCUMENT FILE TEMPLATE -->
                        <div ng-if="file.type == 5" ng-show="isVisibleFile(file)">
                            <h2>[[ file.original_name ]]</h2>
                            <form name="[['fileForm' + $index]]" novalidate>
                                <ul class="container">
                                    <li class="grid-4">
                                        <img ng-attr-src="[[file.media_thumb_small]]" ng-attr-alt="[[file.media_thumb_small]]" />
                                    </li>

                                    <li class="grid-4">
                                        <label>
                                            <p>Title</p>
                                            <input type="text" name="title" ng-model="file.title" placeholder="Enter a title for this document" minlength="10" required />
                                        </label>
                                    </li>

                                    <li class="grid-8">
                                        <label>
                                            <p>Summary</p>
                                            <textarea name="summary" ng-model="file.summary" placeholder="Write a summary about this document" minlength="100" required></textarea>
                                        </label>
                                    </li>

                                    <li class="grid-4">
                                        <label>
                                            <p>Related to Mission</p>
                                            <select-list options="data.missions" ng-model="file.mission_id" unique-key="mission_id" title-key="name" searchable="true"></select-list>
                                        </label>
                                    </li>

                                    <li class="grid-6">
                                        <label>
                                            <p>Author</p>
                                            <input type="text" name="author" ng-model="file.author" placeholder="Who produced this document?" required />
                                        </label>
                                    </li>

                                    <li class="grid-6">
                                        <label>
                                            <p>Attribution/Copyright</p>
                                            <textarea name="attribution" ng-model="file.attribution" placeholder="Include any license and author details here. CC-BY-SA, Public Domain, etc."></textarea>
                                        </label>
                                    </li>

                                    <li class="grid-6">
                                        <label>
                                            <p>Tags</p>
                                            <tags available-tags="data.tags" ng-model="file.tags"></tags>
                                        </label>
                                    </li>

                                    <li class="grid-6">
                                        <label>
                                            <p>Type</p>
                                            <select ng-model="file.subtype" ng-options="subtype.value as subtype.display for subtype in data.subtypes.documents">
                                                <option value="">None</option>
                                            </select>
                                        </label>
                                    </li>

                                    <li class="grid-6">
                                    </li>

                                    <li class="grid-12">
                                        <label>
                                            <p>Submit anonymously?</p>
                                            <input type="checkbox" name="anonymous" id="[[ 'anonymous-file' + $index ]]" value="true" ng-model="file.anonymous"/>
                                            <label for="[[ 'anonymous-file' + $index ]]"></label>
                                        </label>
                                    </li>
                                </ul>
                            </form>
                        </div>

                    </div>
                    <button id="files-submit" ng-disabled="uploadForm.$invalid" ng-click="fileSubmitButtonFunction()">Submit</button>
                </div>
            </section>

            <!-- Post -->
            <section class="upload-post" ng-controller="postController" ng-show="activeSection == 'post'">
                <form name="postForm">
                    <fieldset class="post-type-selection container">
                        <div class="grid-2">
                            <span ng-click="postType = 'tweet'">Tweet</span>
                            <input type="radio" name="type" id="tweet" value="tweet" ng-model="postType" />
                            <label for="tweet"></label>

                            <span>Icons should become in colored when selected</span>
                        </div>

                        <div class="grid-2">
                            <span ng-click="postType = 'article'">News Article</span>
                            <input type="radio" name="type" id="article" value="article" ng-model="postType" />
                            <label for="article"></label>
                        </div>

                        <div class="grid-2">
                            <span ng-click="postType = 'pressrelease'">SpaceX Press Release</span>
                            <input type="radio" name="type" id="pressrelease" value="pressrelease" ng-model="postType" />
                            <label for="pressrelease"></label>
                        </div>

                        <div class="grid-2">
                            <span ng-click="postType = 'redditcomment'">Reddit Comment</span>
                            <input type="radio" name="type" id="redditcomment" value="redditcomment" ng-model="postType" />
                            <label for="redditcomment"></label>
                        </div>

                        <div class="grid-2">
                            <span ng-click="postType = 'NSFcomment'">NSF Comment</span>
                            <input type="radio" name="type" id="NSFcomment" value="NSFcomment" ng-model="postType" />
                            <label for="NSFcomment"></label>
                        </div>
                    </fieldset>

                    <fieldset ng-if="postType == 'tweet'" class="post-type tweet">
                        <!--<tweet params="action: 'write', tweet: tweet"></tweet>-->
                    </fieldset>

                    <fieldset class="post-type article" ng-if="postType == 'article'">
                        <label>Article URL</label>
                        <input type="url" name="article-url" id="article-url" ng-model="article.external_url" required />

                        <label>Article Date</label>

                        <label>Article News Source</label>
                        <input type="text" name="article-publisher" id="article-publisher" ng-model="article.publisher" required />

                        <label>Article Author</label>
                        <input type="text" name="article-author" id="article-author" ng-model="article.author" required />

                        <label>Article Title</label>
                        <input type="text" name="article-title" id="article-title" ng-model="article.title" required />

                        <label>Article Text</label>
                        <textarea ng-model="article.article" required></textarea>

                        <label>Select Mission</label>
                        <select-list
                                name="mission"
                                options="data.missions"
                                ng-model="article.mission_id"
                                unique-key="mission_id"
                                title-key="name"
                                searchable="true"
                                placeholder="Select a related mission...">
                        </select-list>

                        <label>Tags</label>
                    </fieldset>

                    <fieldset class="post-type pressrelease" ng-if="postType == 'pressrelease'">
                        <label>Press Release URL</label>
                        <input type="url" name="pressrelease-url" id="pressrelease-url" ng-model="pressrelease.external_url" required />

                        <label>Press Release Date</label>
                        <datetime ng-model="pressrelease.originated_at" type="date" start-year="2002" is-null="false"></datetime>

                        <label>Press Release Title</label>
                        <input type="text" name="pressrelease-author" id="pressrelease-author" ng-model="pressrelease.title" required />

                        <label>Press Release Text</label>
                        <textarea ng-model="pressrelease.article" required></textarea>

                        <label>Select Mission</label>
                        <select-list
                                name="mission"
                                options="data.missions"
                                ng-model="pressrelease.mission_id"
                                unique-key="mission_id"
                                title-key="name"
                                searchable="true"
                                placeholder="Select a related mission...">
                        </select-list>

                        <label>Tags</label>
                        <tags available-tags="data.tags" name="tags" ng-model="pressrelease.tags"></tags>
                        <span ng-show="postForm.tags.$error.taglength">Please enter 1 to 5 tags.</span>
                    </fieldset>

                    <fieldset class="post-type redditcomment" ng-if="postType == 'redditcomment'" required>
                        <label>Permalink URL</label>
                        <input type="url" name="redditcomment-url" id="redditcomment-url" ng-model="redditcomment.external_url" ng-change="retrieveRedditComment()" required placeholder="Please ensure this is a Reddit permalink">

                        <label>Title Describing The Comment</label>
                        <input type="text" name="article-author" id="article-author" ng-model="redditcomment.title" required />

                        <label>Select Mission</label>
                        <select-list
                                name="mission"
                                options="data.missions"
                                ng-model="redditcomment.mission_id"
                                unique-key="mission_id"
                                title-key="name"
                                searchable="true"
                                placeholder="Select a related mission...">
                        </select-list>

                        <label>Tags</label>
                        <tags available-tags="data.tags" name="tags" ng-model="redditcomment.tags"></tags>
                        <span ng-show="postForm.tags.$error.taglength">Please enter 1 to 5 tags.</span>
                    </fieldset>

                    <fieldset class="post-type nsf-comment" ng-if="postType == 'NSFcomment'">
                        <label>Comment URL</label>
                        <input type="url" name="nsfcomment-url" id="article-url" ng-model="NSFcomment.external_url" required />

                        <label>Title Describing The Comment</label>
                        <input type="text" name="article-author" id="article-author" ng-model="NSFcomment.title" required minlength="10" />

                        <label>Comment Date</label>
                        <datetime ng-model="NSFcomment.originated_at" type="datetime" start-year="2000" is-null="false"></datetime>

                        <label>Comment Author</label>
                        <input type="author" name="nsf-comment-author" id="article-author" ng-model="NSFcomment.author" required />

                        <label>Comment</label>
                        <textarea ng-model="NSFcomment.comment" required></textarea>

                        <label>Select Mission</label>
                        <select-list
                                name="mission"
                                options="data.missions"
                                ng-model="NSFcomment.mission_id"
                                unique-key="mission_id"
                                title-key="name"
                                searchable="true"
                                placeholder="Select a related mission...">
                        </select-list>

                        <label>Tags</label>
                        <tags available-tags="data.tags" name="tags" ng-model="NSFcomment.tags"></tags>
                        <span ng-show="postForm.tags.$error.taglength">Please enter 1 to 5 tags.</span>
                    </fieldset>

                    <input type="submit" value="Submit" name="submit" id="post-submit" ng-click="postSubmitButtonFunction()" ng-disabled="postForm.$invalid" />
                </form>
            </section>

            <!-- Write -->
            <section class="upload-text" ng-controller="writeController" ng-show="activeSection == 'write'">
                <form name="writeForm" novalidate>

                    <p>Post a mission update, share some news, ask a question, discuss a topic!</p>

                    <label>Title</label>
                    <input type="text" name="title" ng-model="text.title" placeholder="Enter a title for your post" minlength="10" required/>

                    <label>Content</label>
                    <textarea name="content" ng-model="text.content" placeholder="Write your post" rows="10" minlength="100" required></textarea>

                    <label>Select related mission</label>
                    <select-list
                            name="mission"
                            options="data.missions"
                            ng-model="text.mission_id"
                            unique-key="mission_id"
                            title-key="name"
                            searchable="true"
                            placeholder="Select a related mission...">
                    </select-list>

                    <p>Submit anonymously?</p>
                    <input type="checkbox" name="anonymous" id="anonymous-text" value="true" ng-model="text.anonymous" />
                    <label for="anonymous-text"></label>

                    <label>Tags</label>
                    <tags available-tags="data.tags" name="tags" ng-model="text.tags"></tags>
                    <span ng-show="writeForm.tags.$error.taglength">Please enter 1 to 5 tags.</span>

                    <input type="submit" value="Submit" name="submit" ng-disabled="writeForm.$invalid" ng-click="writeSubmitButtonFunction()" />
                </form>
            </section>
        </main>
    </div>
</body>
@stop

