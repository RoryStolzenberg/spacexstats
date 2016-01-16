@extends('templates.main')
@section('title', 'Live')

@section('content')
    <body class="live" ng-controller="liveController" ng-strict-di ng-cloak>
    <!-- Custom Header -->
    <div class="content-wrapper">

        <div id="flash-message-container">
        </div>

        <header class="container">
            <div class="access-links" id="logo"><a href="/">SpaceX Stats <span class="gold">Live</span></a></div>
            <h1 class="gr-8" ng-if="!isActive">SpaceX Stats Live</h1>
            <div class="gr-8" ng-if="isActive"><countdown specificity="7" countdown-to="liveParameters.countdown.to" is-paused="liveParameters.countdown.isPaused" type="live" callback="setTimeBetweenNowAndLaunch"></countdown></div>
            @if (Auth::check())
                <div class="access-links"><a target="_blank" href="/users/{{ Auth::user()->username }}">{{ Auth::user()->username }}</a></div>
            @else
                <div class="access-links"><a target="_blank" href="/auth/login">My Account</a></div>
            @endif
        </header>
        <main ng-cloak>
            <!-- SpaceXStats live is not running -->
            @if ((Auth::check() && Auth::user()->isLaunchController()) || Auth::isAdmin())
                <section ng-if="!isActive">
                    <p class="live-herotext exclaim" ng-bind-html="settings.getStartedHeroText"></p>

                    <div ng-if="settings.isGettingStarted == false">
                        <button class="wide-button" ng-click="settings.getStarted()">Get Started</button>
                    </div>

                    <form name="gettingStartedForm" ng-if="settings.isGettingStarted == true" novalidate>
                        <h3>Is this for @{{ data.upcomingMission.name }} or a miscellaneous event?</h3>
                        <input type="checkbox" id="isForLaunch" name="isForLaunch" ng-model="liveParameters.isForLaunch" ng-change="settings.toggleForLaunch()" />
                        <label for="isForLaunch"><span>@{{ liveParameters.isForLaunch == true ? data.upcomingMission.name : 'Miscellaneous Event' }}</span></label>


                        <ul class="container">
                            <li class="gr-6">
                                <label>Reddit Thread Title</label>
                                <input type="text" ng-model="liveParameters.reddit.title" id="reddit-title" name="reddit-title" placeholder="The Reddit Thread Title" required />
                            </li>
                            <li class="gr-6">
                                <label>SpaceXStats Live Title</label>
                                <input type="text" ng-model="liveParameters.title" id="title" name="title" placeholder="The SpaceXStats Live title. Generally just the mission name." required />
                            </li>
                        </ul>

                        <div ng-hide="liveParameters.isForLaunch">
                            <label for="countdownTo">Enter an event time (UTC)</label>
                            <datetime type="datetime" ng-model="liveParameters.countdown.to"></datetime>
                        </div>

                        <h3>What streams should be shown?</h3>

                        <input type="checkbox" id="spacexstream" name="spacexstream" value="true" ng-model="liveParameters.streams.spacex.isAvailable" />
                        <label for="spacexstream"><span>SpaceX Stream</span></label>

                        <input type="checkbox" id="nasastream" name="nasastream" value="true" ng-model="liveParameters.streams.nasa.isAvailable" />
                        <label for="nasastream"><span>NASA Stream</span></label>

                        <h2>Description</h2>
                        <textarea ng-model="liveParameters.description.raw" id="description" name="description" required character-counter ng-minlength="100" ng-maxlength="1000"
                                  placeholder="Write a small introduction about the launch here. 1000 < chars, use markdown just like you would on Reddit. This is shown at the top of the Reddit thread.">
                        </textarea>

                        <h2>Sections</h2>
                        <p>Add sections of information to appear below the live updates.</p>
                        <div ng-repeat="section in liveParameters.sections">
                            <input type="text" ng-model="section.title" required /><button ng-click="settings.removeSection(section)">Remove</button>
                            <textarea ng-model="section.content" placeholder="The section content. You can again use markdown here." required></textarea>
                        </div>
                        <button ng-click="settings.addSection()">Add Section</button>

                        <h2>Content</h2>
                        <p>This section of content contains links to helpful content (The FAQ, hazard maps, previous launches, etc)</p>
                        <ul>
                            <li ng-repeat="resource in liveParameters.resources">
                                <input type="text" ng-model="resource.title" required placeholder="title of resource" />
                                <input type="text" ng-model="resource.url" required placeholder="URL to resource" />
                                <input type="text" ng-model="resource.courtesy" required placeholder="courtesy /r/spacex" />
                                <button ng-click="settings.removeResource(resource)">Remove</button>
                            </li>
                        </ul>
                        <button ng-click="settings.addResource()">Add Resource</button>
                        <p>When you click create, the Reddit Live Thread will be created, and SpaceXStats Live will be started. You can begin posting updates immediately.</p>
                        <input type="submit" ng-click="settings.turnOnSpaceXStatsLive()" ng-disabled="gettingStartedForm.$invalid || settings.isCreating" value="@{{ !settings.isCreating ? 'Create' : 'Creating...' }}" />
                    </form>
                </section>
            @endif

            <section ng-if="!isActive && auth == false">
                <p class="exclaim">SpaceX Stats <span class="gold">Live</span> is not active at this time.</p>
                <p class="exclaim">The next launch is <a href="@{{ '/missions/' + data.upcomingMission.slug }}">@{{ data.upcomingMission.name }}</a>.</p>
            </section>

            <!-- If SpaceXStats live is running -->
            <nav class="in-page" ng-if="isActive" ng-class="{ 'dark':isLivestreamVisible() }">
                <ul class="container highlights">
                    <li class="gr-5">
                        @{{ liveParameters.title }} Event
                        <span ng-if="liveParameters.isForLaunch || liveParameters.reddit.thing !== null">
                            (<span ng-show="liveParameters.isForLaunch"><a ng-href="/missions/@{{data.upcomingMission.slug}}" target="_blank">Mission</a></span><span ng-show="liveParameters.reddit.thing !== null">, <a ng-href="http://reddit.com/@{{ liveParameters.reddit.thing.substring(3) }}" target="_blank">Reddit</a></span>)
                        </span>
                    </li>
                    <li class="gr-3 hide-small stream-options">
                        @{{ user.sanitizedStreamOption() }} stream <span ng-click="user.isConfiguringStreams = true">(Configure)</span>
                        <div class="modal" ng-show="user.isConfiguringStreams">
                            <div class="modal-content">
                                <form name="streamOptionsForm">
                                    <ul>
                                        <li>
                                            <input id="video-none" type="radio" name="streamoption" value="@{{ streamOption.noVideo }}" ng-model="user.streamOption" ng-click="user.isConfiguringStreams = false">
                                            <label for="video-none"><span class="stream-option">No Video</span></label>
                                            <p>Do not show any video or webcasts. This option suits viewers who want a low bandwidth stream of information.</p>
                                        </li>
                                        <li ng-if="liveParameters.streams.spacex.isAvailable">
                                            <input id="video-spacex" type="radio" name="streamoption" value="@{{ streamOption.spacex }}" ng-model="user.streamOption" ng-click="user.isConfiguringStreams = false">
                                            <label for="video-spacex"><span class="stream-option">SpaceX</span></label>
                                            <p>Show the official main SpaceX webcast. This includes commentary from hosts and is suitable for fans who are less familiar with rocketry.</p>
                                        </li>
                                        <li ng-if="liveParameters.streams.spacexClean.isAvailable">
                                            <input id="video-spacexclean" type="radio" name="streamoption" value="@{{ streamOption.spacexClean }}" ng-model="user.streamOption" ng-click="user.isConfiguringStreams = false">
                                            <label for="video-spacexclean"><span class="stream-option">SpaceX (Clean)</span></label>
                                            <p>Show the secondary SpaceX "cleancast". This webcast only includes the countdown net and camera views, with no commentary. Suitable for enthusiasts.</p>
                                        </li>
                                        <li ng-if="liveParameters.streams.nasa.isAvailable">
                                            <input id="video-nasa" type="radio" name="streamoption" value="@{{ streamOption.nasa }}" ng-model="user.streamOption" ng-click="user.isConfiguringStreams = false">
                                            <label for="video-nasa"><span class="stream-option">NASA</span></label>
                                            <p>Show the NASA TV webcast. This coverage is provided by NASA and includes commentary courtesy NASA. Benefits include a longer prelaunch experience.</p>
                                        </li>
                                        <li ng-if="liveParameters.streams.spacex.isAvailable && liveParameters.streams.nasa.isAvailable">
                                            <input id="video-spacex-nasa" type="radio" name="streamoption" value="@{{ streamOption.spacexAndNasa }}" ng-model="user.streamOption" ng-click="user.isConfiguringStreams = false">
                                            <label for="video-spacex-nasa"><span class="stream-option">SpaceX & NASA</span></label>
                                            <p>Show both the official main SpaceX webcast and NASA TV side-by-side in smaller windows.</p>
                                        </li>
                                        <li ng-if="liveParameters.streams.spacexClean.isAvailable && liveParameters.streams.nasa.isAvailable">
                                            <input id="video-spacexclean-nasa" type="radio" name="streamoption" value="@{{ streamOption.spacexCleanAndNasa }}" ng-model="user.streamOption" ng-click="user.isConfiguringStreams = false">
                                            <label for="video-spacexclean-nasa"><span class="stream-option">SpaceX (Clean) & NASA</span></label>
                                            <p>Show both the secondary SpaceX "cleancast" and NASA TV side-by-side in smaller windows.</p>
                                        </li>
                                        <li ng-if="liveParameters.streams.spacex.isAvailable && liveParameters.streams.spacexClean.isAvailable">
                                            <input id="video-spacex-spacexclean" type="radio" name="streamoption" value="@{{ streamOption.spacexAndSpacexClean }}" ng-model="user.streamOption" ng-click="user.isConfiguringStreams = false">
                                            <label for="video-spacex-spacexclean"><span class="stream-option">SpaceX & SpaceX (Clean)</span></label>
                                            <p>Show both the official main SpaceX webcast and secondary SpaceX "cleancast" side-by-side in smaller windows.</p>
                                        </li>
                                    </ul>
                                </form>
                            </div>
                        </div>
                    </li>

                    <li class="gr-3 gr-6@small stream-size-options segmented-control" ng-show="isAnyStreamAvailable()">
                        <ul>
                            <li ng-class="{ selected: user.streamSize == streamSize.smaller }" ng-click="user.streamSize = streamSize.smaller">
                                <span>Smaller</span>
                            </li>
                            <li ng-class="{ selected: user.streamSize == streamSize.normal }" ng-click="user.streamSize = streamSize.normal">
                                <span>Default</span>
                            </li>
                            <li ng-class="{ selected: user.streamSize == streamSize.larger }" ng-click="user.streamSize = streamSize.larger">
                                <span>Larger</span>
                            </li>
                        </ul>
                    </li>

                    @if ((Auth::check() && Auth::user()->isLaunchController()) || Auth::isAdmin())
                        <li class="gr-1"><i class="fa fa-cog" ng-click="settings.isEditingDetails = !settings.isEditingDetails"></i></li>
                    @endif

                </ul>
            </nav>

            @if ((Auth::check() && Auth::user()->isLaunchController()) || Auth::isAdmin())
                <section class="editing-details container" ng-if="isActive && settings.isEditingDetails">
                    <div class="gr-7">
                        <h3>Details</h3>
                        <form name="detailsForm">
                            <h2>Description</h2>
                            <textarea name="description" ng-model="liveParameters.description.raw" required></textarea>

                            <h2>Sections</h2>
                            <div ng-repeat="section in liveParameters.sections">
                                <input type="text" ng-model="section.title" required /><button ng-click="settings.removeSection(section)">Remove</button>
                                <textarea ng-model="section.content" placeholder="The section content. You can again use markdown here." required></textarea>
                            </div>
                            <button ng-click="settings.addSection()">Add Section</button>

                            <h2>Resources</h2>
                            <ul>
                                <li ng-repeat="resource in liveParameters.resources">
                                    <input type="text" ng-model="resource.title" required placeholder="title of resource" />
                                    <input type="text" ng-model="resource.url" required placeholder="URL to resource" />
                                    <input type="text" ng-model="resource.courtesy" required placeholder="courtesy /r/spacex" />
                                    <button ng-click="settings.removeResource(resource)">Remove</button>
                                </li>
                            </ul>
                            <button ng-click="settings.addResource()">Add Resource</button>
                            <input type="submit" ng-click="settings.updateDetails()" ng-disabled="detailsForm.$invalid || settings.isUpdating" value="@{{ !settings.isUpdating ? 'Update' : 'Updating...' }}" />

                        </form>
                        <div ng-if="!liveParameters.countdown.isPaused">
                            <h3>Pause Countdown</h3>
                            <p>In the event of a hold, you can pause the countdown below. Come back here once the launch has resumed to enter a new launch time.</p>
                            <button ng-click="settings.pauseCountdown()" ng-disabled="settings.isPausingCountdown">Pause Countdown</button>
                        </div>

                        <div ng-if="liveParameters.countdown.isPaused">
                            <h3>Resume Countdown</h3>
                            <p>In the event of a hold, you can pause the countdown below. Come back here once the launch has resumed to enter a new launch time.</p>
                            <form name="resumeLaunchForm">
                                <ul>
                                    <li>
                                        <datetime type="datetime" ng-model="liveParameters.countdown.newLaunchTime"></datetime>
                                    </li>
                                    <li>
                                        <button ng-click="settings.resumeCountdown()" ng-disabled="settings.isResumingCountdown">Resume Countdown</button>
                                    </li>
                                </ul>
                            </form>
                        </div>

                    </div>
                    <div class="gr-5 canned-responses" ng-if="liveParameters.isForLaunch">
                        <h3>Canned Responses</h3>
                        <p>Canned responses allow you quickly double click or tap a button to automatically send out an update without typing, simply set the update beforehand. Different responses will become available at different parts of the mission.</p>
                        <form name="cannedResponseSetupForm">
                            <ul>
                                <li>
                                    <label for="holdAbort">Hold/Abort</label>
                                    <textarea name="holdAbort" ng-model="buttons.cannedResponses.holdAbort" required></textarea>
                                </li>
                                <li>
                                    <label for="terminalCount">Terminal Count</label>
                                    <textarea name="terminalCount" ng-model="buttons.cannedResponses.terminalCount" required></textarea>
                                </li>
                                <li>
                                    <label for="inProgress">Liftoff</label>
                                    <textarea name="inProgress" ng-model="buttons.cannedResponses.inProgress" required></textarea>
                                </li>
                                <li>
                                    <label for="maxQ">Max-Q</label>
                                    <textarea name="maxQ" ng-model="buttons.cannedResponses.maxQ" required></textarea>
                                </li>
                                <li>
                                    <label for="meco">MECO</label>
                                    <textarea name="meco" ng-model="buttons.cannedResponses.MECO" required></textarea>
                                </li>
                                <li>
                                    <label for="stageSep">Stage Sep</label>
                                    <textarea name="stageSep" ng-model="buttons.cannedResponses.stageSep" required></textarea>
                                </li>
                                <li>
                                    <label for="mVacIgnition">mVac Ignition</label>
                                    <textarea name="mVacIgnition" ng-model="buttons.cannedResponses.mVacIgnition" required></textarea>
                                </li>
                                <li>
                                    <label for="seco">SECO</label>
                                    <textarea name="seco" ng-model="buttons.cannedResponses.SECO" required></textarea>
                                </li>
                                <li>
                                    <label for="missionSuccess">Mission Success</label>
                                    <textarea name="missionSuccess" ng-model="buttons.cannedResponses.missionSuccess" required></textarea>
                                </li>
                                <li>
                                    <label for="missionFailure">Mission Failure</label>
                                    <textarea name="missionFailure" ng-model="buttons.cannedResponses.missionFailure" required></textarea>
                                </li>
                            </ul>
                        </form>
                        <button ng-click="buttons.updateCannedResponses()" ng-disabled="cannedResponseSetupForm.$invalid">Save Canned Responses</button>
                    </div>
                    <div>
                        <h3>Turn Off SpaceXStats Live</h3>
                        <p>Are you sure?</p>
                        <p>What will this do? It will set SpaceXStats Live back to the original state when you created the event. It will archive all updates, and destroy any miscellaneous data. Once done, you will be unset as launch controller.</p>
                        <p>The Reddit Live Thread will remain visible and stickied, but you will no longer be able to edit the thread. </p>
                        <button class="warning" ng-click="settings.turnOffSpaceXStatsLive()" ng-disabled="settings.isTurningOff">Turn Off</button>
                    </div>
                </section>
            @endif

            <section id="streams" ng-if="isActive && isLivestreamVisible()" class="dark" ng-class="{
            'single-stream': user.isWatching.singleStream(),
            'double-stream': user.isWatching.doubleStream(),
            'stream-size-smaller': user.streamSize == streamSize.smaller,
            'stream-size-normal': user.streamSize == streamSize.normal,
            'stream-size-larger': user.streamSize == streamSize.larger }">
                <div ng-if="user.streamOption == streamOption.spacex">
                    <iframe ng-src="@{{ 'https://www.youtube.com/embed/' + liveParameters.streams.spacex.youtubeVideoId + '?rel=0&autoplay=1' }}" frameborder="0" allowfullscreen></iframe>
                </div>
                <div ng-if="user.streamOption == streamOption.spacexClean">
                    <iframe ng-src="@{{ 'https://www.youtube.com/embed/' + liveParameters.streams.spacexClean.youtubeVideoId + '?rel=0&autoplay=1' }}" frameborder="0" allowfullscreen></iframe>
                </div>
                <div ng-if="user.streamOption == streamOption.nasa">
                    <iframe ng-src="@{{ 'https://www.youtube.com/embed/' + liveParameters.streams.nasa.youtubeVideoId + '?rel=0&autoplay=1' }}" frameborder="0" allowfullscreen></iframe>
                </div>
                <div ng-if="user.streamOption == streamOption.spacexAndNasa">
                    <iframe ng-src="@{{ 'https://www.youtube.com/embed/' + liveParameters.streams.spacex.youtubeVideoId + '?rel=0&autoplay=1' }}" frameborder="0" allowfullscreen></iframe>
                    <iframe ng-src="@{{ 'https://www.youtube.com/embed/' + liveParameters.streams.nasa.youtubeVideoId + '?rel=0&autoplay=1' }}" frameborder="0" allowfullscreen></iframe>
                </div>
                <div ng-if="user.streamOption == streamOption.spacexCleanAndNasa">
                    <iframe ng-src="@{{ 'https://www.youtube.com/embed/' + liveParameters.streams.spacexClean.youtubeVideoId + '?rel=0&autoplay=1' }}" frameborder="0" allowfullscreen></iframe>
                    <iframe ng-src="@{{ 'https://www.youtube.com/embed/' + liveParameters.streams.nasa.youtubeVideoId + '?rel=0&autoplay=1' }}" frameborder="0" allowfullscreen></iframe>
                </div>
                <div ng-if="user.streamOption == streamOption.spacexAndSpacexClean">
                    <iframe ng-src="@{{ 'https://www.youtube.com/embed/' + liveParameters.streams.spacex.youtubeVideoId + '?rel=0&autoplay=1' }}" frameborder="0" allowfullscreen></iframe>
                    <iframe ng-src="@{{ 'https://www.youtube.com/embed/' + liveParameters.streams.spacexClean.youtubeVideoId + '?rel=0&autoplay=1' }}" frameborder="0" allowfullscreen></iframe>
                </div>

            </section>

            <p class="live-status text-center" ng-class="liveParameters.status.class()" ng-if="isActive && liveParameters.isForLaunch">@{{ liveParameters.status.text }}</p>

            @if ((Auth::check() && Auth::user()->isLaunchController()) || Auth::isAdmin())
                <section class="live-message-form" ng-if="isActive">
                    <form name="messageForm" novalidate>
                        <ul class="container" ng-if="liveParameters.isForLaunch">
                            <li class="gr-1">
                                <button class="canned-response" ng-class="{ unlocked: buttons.isUnlocked.holdAbort }"
                                        ng-click="buttons.click('holdAbort', messageForm)" ng-if="timeBetweenNowAndLaunch > -(60 * 60) && timeBetweenNowAndLaunch < 30">Hold/Abort</button>
                            </li>
                            <li class="gr-1">
                                <button class="canned-response" ng-class="{ unlocked: buttons.isUnlocked.terminalCount }"
                                        ng-click="buttons.click('terminalCount', messageForm)" ng-if="timeBetweenNowAndLaunch > -(60 * 15) && timeBetweenNowAndLaunch < -(60 * 8)">Terminal Count</button>
                            </li>
                            <li class="gr-1">
                                <button class="canned-response" ng-class="{ unlocked: buttons.isUnlocked.inProgress }"
                                        ng-click="buttons.click('inProgress', messageForm)" ng-if="timeBetweenNowAndLaunch > -30 && timeBetweenNowAndLaunch < 30">Liftoff</button>
                            </li>
                            <li class="gr-1">
                                <button class="canned-response" ng-class="{ unlocked: buttons.isUnlocked.maxQ }"
                                        ng-click="buttons.click('maxQ', messageForm)" ng-if="timeBetweenNowAndLaunch > 30 && timeBetweenNowAndLaunch < 120">Max-Q</button>
                            </li>
                            <li class="gr-1">
                                <button class="canned-response" ng-class="{ unlocked: buttons.isUnlocked.MECO }"
                                        ng-click="buttons.click('MECO', messageForm)" ng-if="timeBetweenNowAndLaunch > 120 && timeBetweenNowAndLaunch < 210">MECO</button>
                            </li>
                            <li class="gr-1">
                                <button class="canned-response" ng-class="{ unlocked: buttons.isUnlocked.stageSep }"
                                        ng-click="buttons.click('stageSep', messageForm)" ng-if="timeBetweenNowAndLaunch > 120 && timeBetweenNowAndLaunch < 210">Stage Sep</button>
                            </li>
                            <li class="gr-1">
                                <button class="canned-response" ng-class="{ unlocked: buttons.isUnlocked.mVacIgnition }"
                                        ng-click="buttons.click('mVacIgnition', messageForm)" ng-if="timeBetweenNowAndLaunch > 120 && timeBetweenNowAndLaunch < 210">MVac Ignition</button>
                            </li>
                            <li class="gr-1">
                                <button class="canned-response" ng-class="{ unlocked: buttons.isUnlocked.SECO }"
                                        ng-click="buttons.click('SECO', messageForm)" ng-if="timeBetweenNowAndLaunch > (60 * 8) && timeBetweenNowAndLaunch < (60 * 12)">SECO</button>
                            </li>
                            <li class="gr-1">
                                <button class="canned-response" ng-class="{ unlocked: buttons.isUnlocked.missionSuccess }"
                                        ng-click="buttons.click('missionSuccess', messageForm)" ng-if="timeBetweenNowAndLaunch > (60 * 8)">Mission Success</button>
                            </li>
                            <li class="gr-1">
                                <button class="canned-response" ng-class="{ unlocked: buttons.isUnlocked.missionFailure }"
                                        ng-click="buttons.click('missionFailure', messageForm)" ng-if="timeBetweenNowAndLaunch > -30">Mission Failure</button>
                            </li>
                        </ul>
                        <textarea class="new-live-update half" name="message" ng-model="send.new.message"
                                  placeholder="Enter a message here. Updates will be automatically timestamped, acronyms will be expanded, and tweets and images will be shown" required>
                        </textarea>
                        <input type="submit" ng-click="send.message(messageForm)" ng-disabled="messageForm.$invalid" value="Post" />
                    </form>
                </section>
            @endif

            <section ng-if="isActive" id="content" class="live-updates container">
                <div class="gr-9 gr-12@small">
                    <!--<h3>Information & Maps</h3>
                    <div class="description" ng-bind="liveParameters.description"></div>-->

                    <h3>Live Updates</h3>
                    <div class="update" ng-repeat="update in updates | orderBy:'id':true">
                        <div>
                            <p><span class="update-timestamp" ng-mouseover="update.isShowingTimestamp = true" ng-mouseleave="update.isShowingTimestamp = false">@{{ update.timestamp }}</span>
                                <small class="update-datetime" ng-show="update.isShowingTimestamp">@{{ update.createdAt }} UTC</small>
                                <i class="fa fa-edit" ng-if="auth == true" ng-click="update.isEditFormVisible = true"></i>
                            </p>
                        </div>

                        <div class="md" ng-bind-html="update.updateMd"></div>

                        <form name="editUpdateForm" ng-if="update.isEditFormVisible" novalidate>
                            <textarea class="half" required ng-model="update.update" name="update"></textarea>
                            <button ng-click="update.edit()" ng-disabled="update.isEditButtonDisabled || editUpdateForm.update.$pristine || editUpdateForm.$invalid">Save</button>
                            <button ng-click="update.isEditFormVisible = false">Close</button>
                        </form>

                        <div class="message-integration">
                            <div class="message-integration" ng-repeat="integration in update.integrations" ng-class="integration.type">
                                <!-- Imgur Integration -->
                                <a ng-href="@{{ integration.url }}" target="_blank"><img ng-if="integration.type == 'imgur'" ng-src="@{{ integration.url }}" /></a>

                                <!-- Tweet Integration -->
                                <p ng-if="integration.type == 'tweet'" ng-bind-html="integration.text"></p>
                            </div>
                        </div>
                    </div>

                    <p class="exclaim" ng-if="updates.length == 0">No updates :(</p>
                </div>

                <aside id="resources" class="gr-3 hide@small">
                    <h3>Resources</h3>
                    <ul>
                        <li ng-repeat="resource in liveParameters.resources"><span><a ng-href="@{{ resource.url }}">@{{ resource.title }}</a>, @{{ resource.courtesy }}</span></li>
                    </ul>
                </aside>
            </section>
        </main>
    </div>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/1.3.7/socket.io.js"></script>
    </body>
@stop