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
                        {{ Form::textarea('summary') }}

                        {{ Form::label('twitter_account', 'Twitter') }}
                        {{ Form::text('twitter_account') }}

                        {{ Form::label('reddit_account', 'Reddit') }}
                        {{ Form::text('reddit_account') }}
                    </div>

                    <div class="grid-6">
                        <h3>Favorites</h3>
                        {{ Form::label('favorite_mission', 'Favorite Mission') }}
                        <rich-select params="fetchFrom: '/missions/all', default: {{ $user->favorite_mission }}, value: favorite_mission_id, mapping: {}"></rich-select>

                        {{ Form::label('favorite_mission_patch', 'Favorite Mission Patch') }}
                        <rich-select params="fetchFrom: '/missions/patches', default: {{ $user->favorite_mission_patch }}, value: patch_mission_id, mapping: {}"></rich-select>

                        {{ Form::label('favorite_quote', 'Favorite Elon Musk Quote') }}
                        {{ Form::textarea('favorite_quote') }}
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
                        <legend>Notify me when</legend>
                        <ul>
                            <li>
                                {{ Form::label('launch_time_change', 'A launch time has changed') }}
                                {{ Form::checkbox('launch_time_change', 'launch_time_change') }}
                            </li>
                        </ul>
                    </fieldset>

                    <h3>Upcoming Launch Notifications</h3>
                    <fieldset>
                        <legend>Notify when</legend>
                    </fieldset>
                    <ul>
                        <li>
                            {{ Form::label('launch_in_24_hours', 'There\'s a SpaceX launch is 24 hours') }}
                            {{ Form::checkbox('launch_in_24_hours', 'launch_in_24_hours') }}
                        </li>
                        <li>
                            {{ Form::label('launch_in_3_hours', 'There\'s a SpaceX launch is 3 hours') }}
                            {{ Form::checkbox('launch_in_3_hours', 'launch_in_3_hours') }}
                        </li>
                        <li>
                            {{ Form::label('launch_in_1_hour', 'There\'s a SpaceX launch is 1 hour') }}
                            {{ Form::checkbox('launch_in_1_hour', 'launch_in_1_hour') }}
                        </li>
                    </ul>

                    <h3>Other stuff</h3>
                    <fieldset>
                        <legend>Send me</legend>
                        <ul>
                            <li>
                                {{ Form::label('news_summaries', 'Monthly SpaceXStats News Summary Infographics') }}
                                {{ Form::checkbox('news_summaries', 'news_summaries') }}
                            </li>
                        </ul>
                    </fieldset>

                {{ Form::close() }}
            </section>

            <h2>Text/SMS Notifications</h2>
            <section class="text-sms-notifications">
				<p>Get upcoming launch notifications delivered directly to your mobile.</p>
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

