@extends('templates.main')
@section('title', 'Upload to Mission Control')

@section('content')
<body class="missioncontrol-upload" ng-controller="uploadAppController" ng-strict-di>

    @include('templates.header')

    <div class="content-wrapper">
        <h1>Upload to Mission Control</h1>
        <main>
            <!-- List of methods to upload -->
            <nav class="in-page">
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

                    <delta-v ng-model="files"></delta-v>

                    <div class="files-details" ng-repeat="file in files">

                        <!-- IMAGE FILE TEMPLATE -->
                        <div ng-if="file.type == 'Image'" ng-show="isVisibleFile(file)">
                            <h2>@{{ file.original_name }}</h2>
                            <form name="@{{'fileForm' + $index}}" novalidate>
                                <ul class="container">
                                    <li class="gr-4">
                                        <img ng-attr-src="@{{file.media_thumb_small}}" ng-attr-alt="@{{file.media_thumb_small}}" />
                                    </li>

                                    <li class="gr-4">
                                        <label>
                                            <p>Title</p>
                                            <input type="text" name="title" ng-model="file.title" placeholder="Enter a title for this image" minlength="10" required />
                                        </label>
                                    </li>

                                    <li class="gr-8">
                                        <label>
                                            <p>Summary</p>
                                            <textarea name="summary" ng-model="file.summary" placeholder="Write a summary about this image" minlength="100" required></textarea>
                                        </label>
                                    </li>

                                    <li class="gr-4">
                                        <label>
                                            <p>Related to Mission</p>
                                            <dropdown
                                                    name="mission"
                                                    options="data.missions"
                                                    ng-model="file.mission_id"
                                                    unique-key="mission_id"
                                                    title-key="name"
                                                    searchable="true">
                                            </dropdown>
                                        </label>
                                    </li>

                                    <li class="gr-6">
                                        <label>
                                            <p>Author</p>
                                            <input type="text" name="author" ng-model="file.author" placeholder="Who took this image?" required />
                                        </label>
                                    </li>

                                    <li class="gr-6">
                                        <label>
                                            <p>Attribution/Copyright</p>
                                            <textarea name="attribution" ng-model="file.attribution" placeholder="Include any license and author details here. CC-BY-SA, Public Domain, etc."></textarea>
                                        </label>
                                    </li>

                                    <li class="gr-6">
                                        <label>
                                            <p>Tags</p>
                                            <tags available-tags="data.tags" ng-model="file.tags" ></tags>
                                        </label>
                                    </li>

                                    <li class="gr-6">
                                        <label>
                                            <p>Type</p>
                                            <select ng-model="file.subtype" ng-options="subtype.value as subtype.display for subtype in data.subtypes.images">
                                                <option value="">None</option>
                                            </select>
                                        </label>
                                    </li>

                                    <li class="gr-6">
                                        <label>
                                            <p>When was this created?</p>
                                            <datetime type="@{{ ::(file.datetimeExtractedFromEXIF ? 'datetime' : 'date') }}"
                                                      ng-model="file.originated_at"
                                                      is-null="::file.datetimeExtractedFromEXIF"
                                                      nullable-toggle="false"></datetime>
                                        </label>
                                    </li>

                                    <li class="gr-12">
                                        <label>
                                            <p>Submit anonymously?</p>
                                            <input type="checkbox" name="anonymous" id="@{{ 'anonymous-file' + $index }}" value="true" ng-model="file.anonymous" />
                                            <label for="@{{ 'anonymous-file' + $index }}"></label>
                                        </label>
                                    </li>
                                </ul>
                            </form>
                        </div>

                        <!-- GIF FILE TEMPLATE -->
                        <div ng-if="file.type == 'GIF'" ng-show="isVisibleFile(file)">
                            <h2>@{{ file.original_name }}</h2>
                            <form name="@{{'fileForm' + $index}}" novalidate>
                                <ul class="container">
                                    <li class="gr-4">
                                        <img ng-attr-src="@{{file.media_thumb_small}}" ng-attr-alt="@{{file.media_thumb_small}}" />
                                    </li>

                                    <li class="gr-4">
                                        <label>
                                            <p>Title</p>
                                            <input type="text" name="title" ng-model="file.title" placeholder="Enter a title for this GIF" minlength="10" required />
                                        </label>
                                    </li>

                                    <li class="gr-8">
                                        <label>
                                            <p>Summary</p>
                                            <textarea name="summary" ng-model="file.summary" placeholder="Write a summary about this GIF" minlength="100" required></textarea>
                                        </label>
                                    </li>

                                    <li class="gr-4">
                                        <label>
                                            <p>Related to Mission</p>
                                            <dropdown options="data.missions" ng-model="file.mission_id" unique-key="mission_id" title-key="name" searchable="true"></dropdown>
                                        </label>
                                    </li>

                                    <li class="gr-6">
                                        <label>
                                            <p>Author</p>
                                            <input type="text" name="author" ng-model="file.author" placeholder="Who made this GIF?" required />
                                        </label>
                                    </li>

                                    <li class="gr-6">
                                        <label>
                                            <p>Attribution/Copyright</p>
                                            <textarea name="attribution" ng-model="file.attribution"  placeholder="Include any license and author details here. CC-BY-SA, Public Domain, etc."></textarea>
                                        </label>
                                    </li>

                                    <li class="gr-6">
                                        <label>
                                            <p>Tags</p>
                                            <tags available-tags="data.tags" ng-model="file.tags"></tags>
                                        </label>
                                    </li>

                                    <li class="gr-6">
                                        <label>
                                            <p>When was this created?</p>
                                            <datetime type="date"
                                                      ng-model="file.originated_at"
                                                      nullable-toggle="false"></datetime>
                                        </label>
                                    </li>

                                    <li class="gr-12">
                                        <label>
                                            <p>Submit anonymously?</p>
                                            <input type="checkbox" name="anonymous" id="@{{ 'anonymous-file' + $index }}" value="true" ng-model="file.anonymous" />
                                            <label for="@{{ 'anonymous-file' + $index }}"></label>
                                        </label>
                                    </li>
                                </ul>
                            </form>
                        </div>

                        <!-- AUDIO FILE TEMPLATE -->
                        <div ng-if="file.type == 'Audio'" ng-show="isVisibleFile(file)">
                            <h2>@{{ file.original_name }}</h2>
                            <form name="@{{'fileForm' + $index}}" novalidate>
                                <ul class="container">
                                    <li class="gr-4">
                                        <img ng-attr-src="@{{file.media_thumb_small}}" ng-attr-alt="@{{file.media_thumb_small}}" />
                                    </li>

                                    <li class="gr-4">
                                        <label>
                                            <p>Title</p>
                                            <input type="text" name="title" ng-model="file.title" placeholder="Enter a title for this audio clip" minlength="10" required />
                                        </label>
                                    </li>

                                    <li class="gr-8">
                                        <label>
                                            <p>Summary</p>
                                            <textarea name="summary" ng-model="file.summary" placeholder="Write a summary about this audio clip" minlength="100" required></textarea>
                                        </label>
                                    </li>

                                    <li class="gr-4">
                                        <label>
                                            <p>Related to Mission</p>
                                            <dropdown options="data.missions" ng-model="file.mission_id" unique-key="mission_id" title-key="name" searchable="true"></dropdown>
                                        </label>
                                    </li>

                                    <li class="gr-6">
                                        <label>
                                            <p>Author</p>
                                            <input type="text" name="author" ng-model="file.author" placeholder="Who authored this audio clip?" required />
                                        </label>
                                    </li>

                                    <li class="gr-6">
                                        <label>
                                            <p>Attribution/Copyright</p>
                                            <textarea name="attribution" ng-model="file.attribution" placeholder="Include any license and author details here. CC-BY-SA, Public Domain, etc."></textarea>
                                        </label>
                                    </li>

                                    <li class="gr-6">
                                        <label>
                                            <p>Tags</p>
                                            <tags available-tags="data.tags" ng-model="file.tags"></tags>
                                        </label>
                                    </li>

                                    <li class="gr-6">
                                        <label>
                                            <p>When was this created?</p>
                                            <datetime type="date"
                                                      ng-model="file.originated_at"
                                                      nullable-toggle="false"></datetime>
                                        </label>
                                    </li>

                                    <li class="gr-12">
                                        <label>
                                            <p>Submit anonymously?</p>
                                            <input type="checkbox" name="anonymous" id="@{{ 'anonymous-file' + $index }}" value="true" ng-model="file.anonymous" />
                                            <label for="@{{ 'anonymous-file' + $index }}"></label>
                                        </label>
                                    </li>
                                </ul>
                            </form>
                        </div>

                        <!-- VIDEO FILE TEMPLATE -->
                        <div ng-if="file.type == 'Video'" ng-show="isVisibleFile(file)">
                            <h2>@{{ file.original_name }}</h2>
                            <form name="@{{'fileForm' + $index}}" novalidate>
                                <ul class="container">
                                    <li class="gr-4">
                                        <img ng-attr-src="@{{file.media_thumb_small}}" ng-attr-alt="@{{file.media_thumb_small}}" />
                                    </li>

                                    <li class="gr-4">
                                        <label>
                                            <p>Title</p>
                                            <input type="text" name="title" ng-model="file.title" placeholder="Enter a title for this video" minlength="10" required />
                                        </label>
                                    </li>

                                    <li class="gr-8">
                                        <label>
                                            <p>Summary</p>
                                            <textarea name="summary" ng-model="file.summary" placeholder="Write a summary about this video" minlength="100" required></textarea>
                                        </label>
                                    </li>

                                    <li class="gr-4">
                                        <label>
                                            <p>Youtube/Vimeo Link</p>
                                            <span>Adding a link to this video gains you extra deltaV and keeps site costs down.</span>
                                            <input type="text" name="external_url" ng-model="file.external_url" />
                                        </label>

                                    </li>

                                    <li class="gr-4">
                                        <label>
                                            <p>Related to Mission</p>
                                            <dropdown options="data.missions" ng-model="file.mission_id" unique-key="mission_id" title-key="name" searchable="true"></dropdown>
                                        </label>
                                    </li>

                                    <li class="gr-6">
                                        <label>
                                            <p>Author</p>
                                            <input type="text" name="author" ng-model="file.author" placeholder="Who created this video?" required/>
                                        </label>
                                    </li>

                                    <li class="gr-6">
                                        <label>
                                            <p>Attribution/Copyright</p>
                                            <textarea name="attribution" ng-model="file.attribution" placeholder="Include any license and author details here. CC-BY-SA, Public Domain, etc."></textarea>
                                        </label>
                                    </li>

                                    <li class="gr-6">
                                        <label>
                                            <p>Tags</p>
                                            <tags available-tags="data.tags" ng-model="file.tags"></tags>
                                        </label>
                                    </li>

                                    <li class="gr-6">
                                        <label>
                                            <p>Type</p>
                                            <select ng-model="file.subtype" ng-options="subtype.value as subtype.display for subtype in data.subtypes.video">
                                                <option value="">None</option>
                                            </select>
                                        </label>
                                    </li>

                                    <li class="gr-6">
                                        <label>
                                            <p>When was this created?</p>
                                            <datetime type="date"
                                                      ng-model="file.originated_at"
                                                      nullable-toggle="false"></datetime>
                                        </label>
                                    </li>

                                    <li class="gr-12">
                                        <label>
                                            <p>Submit anonymously?</p>
                                            <input type="checkbox" name="anonymous" id="@{{ 'anonymous-file' + $index }}" value="true" ng-model="file.anonymous"/>
                                            <label for="@{{ 'anonymous-file' + $index }}"></label>
                                        </label>
                                    </li>
                                </ul>
                            </form>
                        </div>

                        <!-- DOCUMENT FILE TEMPLATE -->
                        <div ng-if="file.type == 'Document'" ng-show="isVisibleFile(file)">
                            <h2>@{{ file.original_name }}</h2>
                            <form name="@{{'fileForm' + $index}}" novalidate>
                                <ul class="container">
                                    <li class="gr-4">
                                        <img ng-attr-src="@{{file.media_thumb_small}}" ng-attr-alt="@{{file.media_thumb_small}}" />
                                    </li>

                                    <li class="gr-4">
                                        <label>
                                            <p>Title</p>
                                            <input type="text" name="title" ng-model="file.title" placeholder="Enter a title for this document" minlength="10" required />
                                        </label>
                                    </li>

                                    <li class="gr-8">
                                        <label>
                                            <p>Summary</p>
                                            <textarea name="summary" ng-model="file.summary" placeholder="Write a summary about this document" minlength="100" required></textarea>
                                        </label>
                                    </li>

                                    <li class="gr-4">
                                        <label>
                                            <p>Related to Mission</p>
                                            <dropdown options="data.missions" ng-model="file.mission_id" unique-key="mission_id" title-key="name" searchable="true"></dropdown>
                                        </label>
                                    </li>

                                    <li class="gr-6">
                                        <label>
                                            <p>Author</p>
                                            <input type="text" name="author" ng-model="file.author" placeholder="Who produced this document?" required />
                                        </label>
                                    </li>

                                    <li class="gr-6">
                                        <label>
                                            <p>Attribution/Copyright</p>
                                            <textarea name="attribution" ng-model="file.attribution" placeholder="Include any license and author details here. CC-BY-SA, Public Domain, etc."></textarea>
                                        </label>
                                    </li>

                                    <li class="gr-6">
                                        <label>
                                            <p>Tags</p>
                                            <tags available-tags="data.tags" ng-model="file.tags"></tags>
                                        </label>
                                    </li>

                                    <li class="gr-6">
                                        <label>
                                            <p>Type</p>
                                            <select ng-model="file.subtype" ng-options="subtype.value as subtype.display for subtype in data.subtypes.documents">
                                                <option value="">None</option>
                                            </select>
                                        </label>
                                    </li>

                                    <li class="gr-6">
                                        <label>
                                            <p>When was this created?</p>
                                            <datetime type="date"
                                                      ng-model="file.originated_at"
                                                      nullable-toggle="false"></datetime>
                                        </label>
                                    </li>

                                    <li class="gr-12">
                                        <label>
                                            <p>Submit anonymously?</p>
                                            <input type="checkbox" name="anonymous" id="@{{ 'anonymous-file' + $index }}" value="true" ng-model="file.anonymous"/>
                                            <label for="@{{ 'anonymous-file' + $index }}"></label>
                                        </label>
                                    </li>
                                </ul>
                            </form>
                        </div>

                    </div>
                    <button id="files-submit" class="wide-button" ng-disabled="uploadForm.$invalid || isSubmitting" ng-click="fileSubmitButtonFunction()" ng-disabled="isSubmitting">@{{ isSubmitting ? 'Submitting...' : 'Submit'  }}</button>
                </div>
            </section>

            <!-- Post -->
            <section class="upload-post" ng-controller="postController" ng-show="activeSection == 'post'">
                <form name="postForm">
                    <p>Select what type of resource you want to submit...</p>
                    <fieldset class="post-type-selection container">
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
                    <fieldset ng-if="postType == 'tweet'" class="post-type tweet">
                        <delta-v ng-model="tweet"></delta-v>
                        <tweet action="write" tweet="tweet"></tweet>
                    </fieldset>

                    <!-- Article -->
                    <fieldset class="post-type article" ng-if="postType == 'article'">
                        <delta-v ng-model="article"></delta-v>

                        <label>Article URL</label>
                        <input type="url" name="article-url" id="article-url" ng-model="article.external_url" required />

                        <label>Article Date</label>
                        <datetime ng-model="article.originated_at" type="date" is-null="false"></datetime>

                        <label>Publication</label>
                        <dropdown
                                name="publisher"
                                options="data.publishers"
                                ng-model="article.publisher_id"
                                unique-key="publisher_id"
                                title-key="name"
                                searchable="true"
                                placeholder="Select the publisher of the article">
                        </dropdown>
                        <p>Can't find the article publisher? <a href="/missioncontrol/publishers/create">Create them first</a>.</p>

                        <label>Article Author</label>
                        <input type="text" name="article-author" id="article-author" ng-model="article.author" />

                        <label>Article Title</label>
                        <input type="text" name="article-title" id="article-title" ng-model="article.title" required />

                        <label>Article</label>
                        <textarea ng-model="article.article" required></textarea>

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

                        <label>Tags</label>
                        <tags available-tags="data.tags" name="tags" ng-model="article.tags"></tags>
                        <span ng-show="postForm.tags.$error.taglength">Please enter 1 to 5 tags.</span>
                    </fieldset>

                    <!-- Press Release -->
                    <fieldset class="post-type pressrelease" ng-if="postType == 'pressrelease'">
                        <delta-v ng-model="pressrelease"></delta-v>

                        <label>Press Release URL</label>
                        <input type="url" name="pressrelease-url" id="pressrelease-url" ng-model="pressrelease.external_url" required />

                        <label>Press Release Date</label>
                        <datetime ng-model="pressrelease.originated_at" type="date" start-year="2002" is-null="false"></datetime>

                        <label>Press Release Title</label>
                        <input type="text" name="pressrelease-author" id="pressrelease-author" ng-model="pressrelease.title" required />

                        <label>Press Release Text</label>
                        <textarea ng-model="pressrelease.article" required></textarea>

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

                        <label>Tags</label>
                        <tags available-tags="data.tags" name="tags" ng-model="pressrelease.tags"></tags>
                        <span ng-show="postForm.tags.$error.taglength">Please enter 1 to 5 tags.</span>
                    </fieldset>

                    <!-- Reddit Comment -->
                    <fieldset class="post-type redditcomment" ng-if="postType == 'redditcomment'" required>
                        <delta-v ng-model="redditcomment"></delta-v>

                        <label>Permalink URL</label>
                        <input type="url" name="redditcomment-url" id="redditcomment-url" ng-model="redditcomment.external_url" ng-change="retrieveRedditComment" required ng-pattern="/reddit.com\//" placeholder="Please ensure this is a Reddit permalink">

                        <label>Title Describing The Comment</label>
                        <input type="text" name="redditcomment-author" id="redditcomment-author" ng-model="redditcomment.title" required ng-minlength="10"  />

                        <reddit-comment ng-model="redditcomment"></reddit-comment>

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

                        <label>Tags</label>
                        <tags available-tags="data.tags" name="tags" ng-model="redditcomment.tags"></tags>
                        <span ng-show="postForm.tags.$error.taglength">Please enter 1 to 5 tags.</span>
                    </fieldset>

                    <!-- NSF Comment -->
                    <fieldset class="post-type nsf-comment" ng-if="postType == 'NSFcomment'">
                        <label>Comment URL</label>
                        <input type="url" name="NSFcomment-url" id="article-url" ng-model="NSFcomment.external_url" placeholder="The direct URL to the comment" required ng-pattern="/nasaspaceflight.com\//" />

                        <label>Title Describing The Comment</label>
                        <input type="text" name="NSFcomment-title" id="article-author" ng-model="NSFcomment.title" placeholder="The title that appears on SpaceX Stats" required minlength="10" />

                        <label>Comment Date</label>
                        <datetime ng-model="NSFcomment.originated_at" type="datetime" start-year="2000" is-null="false"></datetime>

                        <label>Comment Author</label>
                        <input type="author" name="NSFcomment-author" id="article-author" ng-model="NSFcomment.author" placeholder="The author of the comment" required />

                        <label>Comment</label>
                        <textarea ng-model="NSFcomment.comment" placeholder="Enter in the comment body here" required></textarea>

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

                        <label>Tags</label>
                        <tags available-tags="data.tags" name="tags" ng-model="NSFcomment.tags"></tags>
                        <span ng-show="postForm.tags.$error.taglength">Please enter 1 to 5 tags.</span>

                        <delta-v ng-model="NSFcomment"></delta-v>
                    </fieldset>

                    <p class="exclaim" ng-if="postType == null">No Resource Selected</p>

                    <button name="submit" class="wide-button" ng-click="postSubmitButtonFunction()" ng-disabled="postType == null || postForm.$invalid || isSubmitting">@{{ isSubmitting ? 'Submitting...' : 'Submit' }}</button>
                </form>
            </section>

            <!-- Write -->
            <section class="upload-text" ng-controller="writeController" ng-show="activeSection == 'write'">
                <form name="writeForm" novalidate>

                    <p>Post a mission update, share some news, ask a question, discuss a topic!</p>

                    <delta-v ng-model="text"></delta-v>

                    <label>Title</label>
                    <input type="text" name="title" ng-model="text.title" placeholder="Enter a title for your post" minlength="10" required/>

                    <label>Content</label>
                    <textarea name="content" ng-model="text.content" placeholder="Write your post" rows="10" minlength="100" required></textarea>

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

                    <p>Submit anonymously?</p>
                    <input type="checkbox" name="anonymous" id="anonymous-text" value="true" ng-model="text.anonymous" />
                    <label for="anonymous-text"></label>

                    <label>Tags</label>
                    <tags available-tags="data.tags" name="tags" ng-model="text.tags"></tags>
                    <span ng-show="writeForm.tags.$error.taglength">Please enter 1 to 5 tags.</span>

                    <button name="submit" class="wide-button" ng-click="writeSubmitButtonFunction()" ng-disabled="writeForm.$invalid || isSubmitting">@{{ isSubmitting ? 'Submitting...' : 'Submit' }}</button>
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

