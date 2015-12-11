@extends('templates.main')
@section('title', 'Editing User ' . $user->username)

@section('content')
<body class="edit-user">


    @include('templates.header')

    <div class="content-wrapper" ng-controller="editUserController" ng-strict-di>
        <h1>Editing Your Profile</h1>
        <main>
            <nav class="in-page sticky-bar">
                <ul class="container">
                    <li class="gr-2"><a href="/users/{{ $user->username }}">Your Profile</a></li>
                    <li class="gr-2"><a href="#account">Account</a></li>
                    <li class="gr-2"><a href="#email-notifications">Email Notifications</a></li>
                    <li class="gr-2"><a href="#sms-notifications">Text/SMS Notifications</a></li>
                    <li class="gr-2"><a href="#reddit-notifications">Reddit Notifications</a></li>
                </ul>
            </nav>
            <h2>Profile</h2>
            <section class="scrollto" id="profile">
                <form>
                    <div class="gr-6">
                        <h3>You</h3>
                        <ul>
                            <li>
                                <label for="summary">Write about yourself</label>
                                <textarea ng-model="profile.summary"></textarea>
                            </li>
                            <li>
                                <label for="twitter_account">Twitter</label>
                                <input type="text" class="prepended-input twitter" ng-model="profile.twitter_account" />
                            </li>
                            <li>
                                <label>Reddit</label>
                                <input type="text" class="prepended-input reddit" ng-model="profile.reddit_account" />
                            </li>
                        </ul>
                    </div>

                    <div class="gr-6">
                        <h3>Favorites</h3>
                        <ul>
                            <li>
                                <label>Favorite Mission</label>
                                <dropdown options="missions" has-default-option="true" unique-key="mission_id" title-key="name" searchable="true" ng-model="profile.favorite_mission" id-only="true"></dropdown>
                            </li>
                            <li>
                                <label>Favorite Mission Patch</label>
                                <dropdown options="patches" has-default-option="true" unique-key="mission_id" title-key="name" searchable="true" ng-model="profile.favorite_patch" id-only="true"></dropdown>
                            </li>
                            <li>
                                <label>Favorite Elon Musk Quote</label>
                                <textarea ng-model="profile.favorite_quote"></textarea>
                                <p>- Elon Musk.</p>
                            </li>
                        </ul>
                    </div>

                    <!--<div class="gr-12">
                        <h3>Change Your Banner</h3>

                        <p>If you're a Mission Control subscriber, you can change your banner from the default blue to a custom image.</p>
                    </div>-->

                    <input type="submit" value="Update Profile" ng-click="updateProfile()" ng-disabled="isUpdating.profile" />
                </form>
            </section>

            <h2>Account</h2>
            <section id="account" class="scrollto">
                @if(!Auth::isSubscriber())
                    <p>You are not a Mission Control subscriber. Become one today!</p>
                @else
                    <h3>Current Subscription</h3>
                    @if (Auth::isCharterSubscriber())
                        Your subscription does not expire because you are a charter subscriber. Yay!
                    @endif

                    <h3>Past Payments</h3>
                @endif
                <!-- Change password -->
            </section>

            <h2>Email Notifications</h2>
            <section id="email-notifications" class="scrollto">
                <p>You can turn on and off email notifications here.</p>

                <form>
                    <h3>Launch Change Notifications</h3>
                    <fieldset>
                        <legend>Notify me by email when...</legend>
                        <ul class="container">
                            <li class="gr-2">
                                <span>A launch time has changed</span>
                                <input type="checkbox" id="LaunchTimeChange" value="true" ng-model="emailNotifications.LaunchChange" />
                                <label for="LaunchTimeChange"></label>
                            </li>
                            <li class="gr-2">
                                <span>When a new mission is created</span>
                                <input type="checkbox" id="NewMission" value="true" ng-model="emailNotifications.NewMission" />
                                <label for="NewMission"></label>
                            </li>
                        </ul>
                    </fieldset>

                    @if(Auth::isSubscriber())
                        <h3>Upcoming Launch Notifications</h3>
                        <fieldset>
                            <legend>Notify me by email when...</legend>
                        </fieldset>
                        <ul class="container">
                            <li class="gr-2">
                                <span>There's a SpaceX launch in 24 hours</span>
                                <input type="checkbox" id="TMinus24HoursEmail" value="true" ng-model="emailNotifications.TMinus24HoursEmail" />
                                <label for="TMinus24HoursEmail"></label>
                            </li>
                            <li class="gr-2">
                                <span>There's a SpaceX launch in 3 hours</span>
                                <input type="checkbox" id="TMinus3HoursEmail" value="true" ng-model="emailNotifications.TMinus3HoursEmail" />
                                <label for="TMinus3HoursEmail"></label>
                            </li>
                            <li class="gr-2">
                                <span>There's a SpaceX launch in 1 hour</span>
                                <input type="checkbox" id="TMinus1HourEmail" value="true" ng-model="emailNotifications.TMinus1HourEmail" />
                                <label for="TMinus1HourEmail"></label>
                            </li>
                        </ul>

                        <h3>Other stuff</h3>
                        <fieldset>
                            <legend>Send me...</legend>
                            <ul class="container">
                                <li class="gr-2">
                                    <span>Monthly SpaceXStats News Summaries</span>
                                    <input type="checkbox" id="NewsSummaries" value="true" ng-model="emailNotifications.NewsSummaries" />
                                    <label for="NewsSummaries"></label>
                                </li>
                            </ul>
                        </fieldset>
                    @endif
                    <input type="submit" ng-click="updateEmailNotifications()" ng-disabled="isUpdating.emailNotifications" value="Update Email Notifications" />
                </form>
            </section>

            <h2>Text/SMS Notifications</h2>
            <section id="sms-notifications" class="scrollto">
                <p>Get upcoming launch notifications delivered directly to your mobile.</p>
                @if (Auth::isSubscriber())
                <form>
                    <label for="mobile">Enter your mobile number</label>
                    <input type="tel" id="mobile" ng-model="SMSNotification.mobile" placeholder="If you are outside the U.S., please include your country code." />

                    <p>How long before a launch would you like to receive a notification?</p>

                    <ul>
                        <li>
                            <input type="radio" name="status" ng-model="SMSNotification.status" id="off" value="false" />
                            <label for="off"><span>Off</span></label>
                        </li>
                        <li>
                            <input type="radio" name="status" ng-model="SMSNotification.status" id="TMinus24HoursSMS" value="TMinus24HoursSMS" />
                            <label for="TMinus24HoursSMS"><span>24 Hours Before</span></label>
                        </li>
                        <li>
                            <input type="radio" name="status" ng-model="SMSNotification.status" id="TMinus3HoursSMS" value="TMinus3HoursSMS" />
                            <label for="TMinus3HoursSMS"><span>3 Hours Before</span></label>
                        </li>
                        <li>
                            <input type="radio" name="status" ng-model="SMSNotification.status" id="TMinus1HourSMS" value="TMinus1HourSMS" />
                            <label for="TMinus1HourSMS"><span>1 Hour Before</span></label>
                        </li>
                    </ul>

                    <input type="submit" ng-click="updateSMSNotifications()" ng-disabled="isUpdating.SMSNotifications" value="Update SMS Notifications" />
                </form>
                @else
                    <p class="exclaim">Sign up for mission control to enable this feature!</p>
                @endif
            </section>

            <h2>Reddit Notifications</h2>
            <section id="reddit-notifications" class="scrollto container">
                <p class="exclaim">Coming soon!</p>
                <!--<div class="gr-6">
                    <h3>/r/SpaceX Notifications</h3>
                    <p>/r/SpaceX notifications allow you to automatically receive Reddit notifications about comments and posts with certain words made within the /r/SpaceX community via Personal Messages. Simply enter up to 10 trigger words (these are case insensitive) and select how frequently you would like to be notified.</p>
                </div>
                <div class="gr-6">
                    <h3>Redditwide Notifications</h3>
                    <p>Get notified by Reddit private message when threads are created across all of Reddit with certain keywords. Enter up to 10 trigger words (these are case insensitive) and select how frequently you would like to be notified.</p>
                </div>-->
            </section>
        </main>
    </div>
</body>
@stop

