@extends('templates.main')

@section('title', 'Editing User ' . $user->username)
@section('bodyClass', 'edit-user')

@section('scripts')
	{{ HTML::script('/assets/js/editUserViewModel.js') }}
	<script type="text/javascript">
		$(document).ready(function() {
			ko.applyBindings(new editUserViewModel('{{ $user->username }}'));
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
					<li class="grid-2">Reddit Notifications</li>
				</ul>
			</nav>
			<h2>Profile</h2>
			<section class="profile">
				<ul class="container">
					<!-- Summary, Reddit, Twitter -->
					<li class="grid-6">
						{{ Form::model($profile, array('data-bind' => 'submit: updateDetails')) }}
							{{ Form::label('summary', 'Write about yourself') }}
							{{ Form::textarea('summary') }}

							{{ Form::label('twitter_account', 'Twitter') }}
							{{ Form::text('twitter_account') }}

							{{ Form::label('reddit_account', 'Reddit') }}
							{{ Form::text('reddit_account') }}

							{{ Form::submit('Update Details', array('class' => 'update-details')) }}
						{{ Form::close() }}
					</li>
					<!-- Edit Banner -->
					<li class="grid-6">
						<h3>Favorites</h3>
						{{ Form::model($profile, array('data-bind' => 'submit: updateFavorites')) }}

							{{ Form::label('favorite_mission', 'Favorite Mission') }}
							{{ Form::richSelect('favorite_mission', $missions,array('identifier' => 'mission_id', 'title' => 'name', 'summary' => 'summary')) }}

							{{ Form::label('favorite_quote', 'Favorite Elon Musk Quote') }}
							{{ Form::textarea('favorite_quote') }}
							<p>- Elon Musk.</p>

							{{ Form::submit('Update Favorites', array('class' => 'update-favorites')) }}
						{{ Form::close() }}
						<h3>Change Your Banner</h3>
						<p>If you're a Mission Control subscriber, you can change your banner from the default blue to a custom image.</p>
						@if (Auth::isSubscriber())
							<button>Edit Banner</button>
						@else
							<button disabled>Edit Banner (Mission Control Subscribers Only)</button>
						@endif
					</li>
					<li></li>
					<li></li>
					<li></li>
				</ul>
				<!-- Favourite Mission -->
				<!-- Favourite Mission Patch -->
				<!-- Favourite Elon Musk Quote -->
			</section>
			<h2>Account</h2>
			<section class="account">
				<!-- Change password -->
				<!-- Buy More Mission Control -->	
			</section>
			<h2>Email Notifications</h2>
			<section class="email-notifications">
				
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

