@extends('templates.main')

@section('title', 'Editing User ' . $user->username)
@section('bodyClass', 'edit-user')

@section('scripts')
    <script data-main="/src/js/common" src="/src/js/require.js"></script>
    <script>
        require(['common'], function() {
            require(['knockout', 'viewmodels/EditUserViewModel', 'lib/sticky'], function(ko, EditUserViewModel, sticky) {
                ko.applyBindings(new EditUserViewModel('{{ $user->username  }}'));
            });
        });
    </script>
@stop

@section('content')
	<div class="content-wrapper">
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
                {{ Form::model($profile) }}
                    <div class="grid-6">
                        <h3>You</h3>
                        {{ Form::label('summary', 'Write about yourself') }}
                        {{ Form::textarea('summary', Input::old('summary'), array('data-bind' => 'getOriginalValue, value: profile.summary')) }}

                        {{ Form::label('twitter_account', 'Twitter') }}
                        <div class="prepended-input">
                            <span>@</span>{{ Form::text('twitter_account', Input::old('twitter_account'), array('data-bind' => 'getOriginalValue, value: profile.twitter_account')) }}
                        </div>

                        {{ Form::label('reddit_account', 'Reddit') }}
                        <div class="prepended-input">
                            <span>/u/</span>{{ Form::text('reddit_account', Input::old('reddit_account'), array('data-bind' => 'getOriginalValue, value: profile.reddit_account')) }}
                        </div>
                    </div>

                    <div class="grid-6">
                        <h3>Favorites</h3>
                        {{ Form::label('favorite_mission', 'Favorite Mission') }}
                        <rich-select params="fetchFrom: '/missions/all', default: {{ $user->profile->favorite_mission or 'true' }}, value: profile.favorite_mission, mapping: {}"></rich-select>

                        {{ Form::label('favorite_mission_patch', 'Favorite Mission Patch') }}
                        <rich-select params="fetchFrom: '/missions/patches', default: {{ $user->profile->favorite_mission_patch or 'true' }}, value: profile.favorite_mission_patch, mapping: {}"></rich-select>

                        {{ Form::label('favorite_quote', 'Favorite Elon Musk Quote') }}
                        {{ Form::textarea('favorite_quote', Input::old('favorite_quote'), array('data-bind' => 'getOriginalValue, value: profile.favorite_quote')) }}
                        <p>- Elon Musk.</p>
                    </div>

                    <div class="grid-12">
                        <h3>Change Your Banner</h3>

                        <p>If you're a Mission Control subscriber, you can change your banner from the default blue to a custom image.</p>
                    </div>

                    {{ Form::submit('Update Profile', array('data-bind' => 'click: updateProfile')) }}
                {{ Form::close() }}
			</section>

			<h2>Account</h2>
			<section class="account">
				<!-- Change password -->
				<!-- Buy More Mission Control -->	
			</section>

			<h2>Email Notifications</h2>
			<section class="email-notifications">
                <p>You can turn on and off email notifications here.</p>

                {{ Form::open() }}
                    <h3>Launch Change Notifications</h3>
                    <fieldset>
                        <legend>Notify me by email when</legend>
                        <ul>
                            <li>
                                {{ Form::label('launchTimeChange', 'A launch time has changed') }}
                                {{ Form::checkbox('launchTimeChange', true, null, array('data-bind' => 'checked: emailNotifications.launchTimeChange')) }}
                            </li>
                            <li>
                                {{ Form::label('newMission', 'When a new mission exists') }}
                                {{ Form::checkbox('newMission', true, null, array('data-bind' => 'checked: emailNotifications.launchTimeChange')) }}
                            </li>
                        </ul>
                    </fieldset>

                    <h3>Upcoming Launch Notifications</h3>
                    <fieldset>
                        <legend>Notify me by email when</legend>
                    </fieldset>
                    <ul>
                        <li>
                            {{ Form::label('tMinus24HoursEmail', 'There\'s a SpaceX launch is 24 hours') }}
                            {{ Form::checkbox('tMinus24HoursEmail', true, null, array('data-bind' => 'checked: emailNotifications.tMinus24HoursEmail')) }}
                        </li>
                        <li>
                            {{ Form::label('tMinus3HoursEmail', 'There\'s a SpaceX launch is 3 hours') }}
                            {{ Form::checkbox('tMinus3HoursEmail', true, null, array('data-bind' => 'checked: emailNotifications.tMinus3HoursEmail')) }}
                        </li>
                        <li>
                            {{ Form::label('tMinus1HoursEmail', 'There\'s a SpaceX launch is 1 hour') }}
                            {{ Form::checkbox('tMinus1HoursEmail', true, null, array('data-bind' => 'checked: emailNotifications.tMinus1HoursEmail')) }}
                        </li>
                    </ul>

                    <h3>Other stuff</h3>
                    <fieldset>
                        <legend>Send me</legend>
                        <ul>
                            <li>
                                {{ Form::label('newsSummaries', 'Monthly SpaceXStats News Summary Infographics') }}
                                {{ Form::checkbox('newsSummaries', true, null) }}
                            </li>
                        </ul>
                    </fieldset>
                    {{ Form::submit('Update Email Notifications', array('data-bind' => 'click: updateEmailNotifications')) }}
                {{ Form::close() }}
            </section>

            <h2>Text/SMS Notifications</h2>
            <section class="text-sms-notifications">
				<p>Get upcoming launch notifications delivered directly to your mobile.</p>
                {{ Form::open() }}
                    {{ Form::label('mobile', 'Enter your mobile number') }}
                    {{ Form::input('tel', 'mobile', $user->mobile) }}

                    <p>How long before a launch would you like to recieve a notification?</p>
                    {{ Form::label('off', 'Off') }}
                    {{ Form::radio('mobile_notification', 'Off', null, array('id' => 'Off')) }}

                    {{ Form::label('tMinus24HoursSMS', '24 Hours Before') }}
                    {{ Form::radio('mobile_notification', 'tMinus24HoursSMS', null, array('id' => 'tMinus24HoursSMS')) }}

                    {{ Form::label('tMinus3HoursSMS', '3 Hours Before') }}
                    {{ Form::radio('mobile_notification', 'tMinus3HoursSMS', null, array('id' => 'tMinus3HoursSMS')) }}

                    {{ Form::label('tMinus1HourSMS', '1 Hour Before') }}
                    {{ Form::radio('mobile_notification', 'tMinus1HourSMS', null, array('id' => 'tMinus1HourSMS')) }}
                {{ Form::close() }}
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

