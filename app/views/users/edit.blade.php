@extends('templates.main')

@section('title', 'Editing User ' . $user->username)
@section('bodyClass', 'edit-user')

@section('scripts')
    <script src="/dest/js/app.js"></script>
@stop

@section('content')
	<div class="content-wrapper" ng-app="editUserApp" ng-controller="editUserController" ng-strict-di>
		<h1>Editing Your Profile</h1>
		<main>
			<nav class="sticky-bar">
				<ul class="container">
					<li class="grid-2">Profile</li>
					<li class="grid-2">Account</li>
					<li class="grid-2">Email Notifications</li>
                    <li class="grid-2">Text/SMS Notifications</li>
					<li class="grid-2">Reddit Notifications</li>
				</ul>
			</nav>
			<h2>Profile</h2>
			<section class="profile">
                <form>
                    <div class="grid-6">
                        <h3>You</h3>
                        <label for="summary">Write about yourself</label>
                        <textarea ng-model="profile.summary"></textarea>

                        <label for="twitter_account">Twitter</label>
                        <div class="prepended-input">
                            <span>@</span><input type="text" ng-model="profile.twitter_account" />
                        </div>

                        <label>Reddit</label>
                        <div class="prepended-input">
                            <span>/u/</span><input type="text" ng-model="profile.reddit_account" />
                        </div>
                    </div>

                    <div class="grid-6">
                        <h3>Favorites</h3>
                        <label>Favorite Mission</label>
                        <select-list options="missions" has-default-option="true" unique-key="mission_id" searchable="true" selected-option="profile.favorite_mission"></select-list>

                        <label>Favorite Mission Patch</label>

                        <label>Favorite Elon Musk Quote</label>
                        <textarea ng-model="profile.favorite_quote"></textarea>
                        <p>- Elon Musk.</p>
                    </div>

                    <!--<div class="grid-12">
                        <h3>Change Your Banner</h3>

                        <p>If you're a Mission Control subscriber, you can change your banner from the default blue to a custom image.</p>
                    </div>-->

                    <input type="submit" value="Update Profile" ng-click="updateProfile()" />
                </form>
			</section>

			<h2>Account</h2>
			<section class="account">
				<!-- Change password -->
				<!-- Buy More Mission Control -->	
			</section>

			<h2>Email Notifications</h2>
			<section class="email-notifications">
                <p>You can turn on and off email notifications here.</p>

                <form>
                    <h3>Launch Change Notifications</h3>
                    <fieldset>
                        <legend>Notify me by email when</legend>
                        <ul>
                            <li>
                                <label for="launchTimeChange">A launch time has changed</label>
                                <input type="checkbox" id="launchTimeChange" value="true" ng-model="emailNotifications.launchTimeChange" />
                            </li>
                            <li>
                                <label for="newMission">When a new mission exists</label>
                                <input type="checkbox" id="newMission" value="true" ng-model="emailNotifications.newMission" />
                            </li>
                        </ul>
                    </fieldset>

                    <h3>Upcoming Launch Notifications</h3>
                    <fieldset>
                        <legend>Notify me by email when</legend>
                    </fieldset>
                    <ul>
                        <li>
                            <label for="tMinus24HoursEmail">There's a SpaceX launch in 24 hours</label>
                            <input type="checkbox" id="tMinus24HoursEmail" value="true" ng-model="emailNotifications.tMinus24HoursEmail" />
                        </li>
                        <li>
                            <label for="tMinus3HoursEmail">There's a SpaceX launch in 3 hours</label>
                            <input type="checkbox" id="tMinus3HoursEmail" value="true" ng-model="emailNotifications.tMinus3HoursEmail" />
                        </li>
                        <li>
                            <label for="tMinus1HourEmail">There's a SpaceX launch in 1 hour</label>
                            <input type="checkbox" id="tMinus1HourEmail" value="true" ng-model="emailNotifications.tMinus1HourEmail" />
                        </li>
                    </ul>

                    <h3>Other stuff</h3>
                    <fieldset>
                        <legend>Send me</legend>
                        <ul>
                            <li>
                                <label for="newsSummaries">Monthly SpaceXStats News Summary Infographics</label>
                                <input type="checkbox" id="newsSummaries" value="true" ng-model="emailNotifications.newsSummaries" />
                            </li>
                        </ul>
                    </fieldset>
                    <input type="submit" ng-click="updateEmailNotifications()" />
                </form>
            </section>

            <h2>Text/SMS Notifications</h2>
            <section class="text-sms-notifications">
				<p>Get upcoming launch notifications delivered directly to your mobile.</p>
                <form>
                    <label for="mobile">Enter your mobile number</label>
                    <input type="tel" id="mobile" ng-model=""
                    {{ Form::input('tel', 'mobile', $user->mobile, array('id' => 'mobile', 'data-bind' => 'getOriginalValue, value: SMSNotification.mobile')) }}

                    <p>How long before a launch would you like to recieve a notification?</p>
                    {{ Form::label('off', 'Off') }}
                    {{ Form::radio('mobile_notification', 'Off', null, array('id' => 'Off', 'data-bind' => 'checked: SMSNotification.status')) }}

                    {{ Form::label('tMinus24HoursSMS', '24 Hours Before') }}
                    {{ Form::radio('mobile_notification', 'tMinus24HoursSMS', null, array('id' => 'tMinus24HoursSMS', 'data-bind' => 'checked: SMSNotification.status')) }}

                    {{ Form::label('tMinus3HoursSMS', '3 Hours Before') }}
                    {{ Form::radio('mobile_notification', 'tMinus3HoursSMS', null, array('id' => 'tMinus3HoursSMS', 'data-bind' => 'checked: SMSNotification.status')) }}

                    {{ Form::label('tMinus1HourSMS', '1 Hour Before') }}
                    {{ Form::radio('mobile_notification', 'tMinus1HourSMS', null, array('id' => 'tMinus1HourSMS', 'data-bind' => 'checked: SMSNotification.status')) }}

                    {{ Form::submit('Update SMS Notifications', array('data-bind' => 'click: updateSMSNotifications')) }}
                </form>
			</section>

			<h2>Reddit Notifications</h2>
			<section class="reddit-notifications container">
				<div class="grid-6">
					<h3>/r/SpaceX Notifications</h3>
					<p>/r/SpaceX notifications allow you to automatically receive Reddit notifications about comments and posts with certain words made within the /r/SpaceX community via Personal Messages. Simply enter up to 10 trigger words (these are case insensitive) and select how frequently you would like to be notified.</p>
				</div>
				<div class="grid-6">
					<h3>Redditwide Notifications</h3>
					<p>Get notified by Reddit private message when threads are created across all of Reddit with certain keywords. Enter up to 10 trigger words (these are case insensitive) and select how frequently you would like to be notified.</p>
				</div>
			</section>
		</main>
	</div>
@stop

