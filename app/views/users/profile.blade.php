@extends('templates.main')

@section('title', 'User ' . $user->username)
@section('bodyClass', 'profile')

@section('scripts')
@stop

@section('content')
<div class="content-wrapper">
	<h1>{{ $user->username }}</h1>
	<main>
		<nav class="sticky-bar">
			<ul class="container">
				<li class="grid-1">Overview</li>
				<li class="grid-1">Favorites</li>
				@if (Auth::check() && Auth::user()->username === $user->username) 
					<li class="grid-1">Notes</li>
				@endif
				<li class="grid-1">Uploads</li>
				@if (Auth::check() && Auth::user()->username === $user->username) 
					<li class="grid-1"><a href="/users/{{ $user->username }}/edit"><i class="fa fa-pencil"></i></a></li>
				@endif
			</ul>
		</nav>
		<section class="overview container">
			<div class="grid-4">
				<table>
					<tr>
						<td>Bio</td>
						<td>{{ $user->profile->summary }}</td>
					</tr>
					<tr>
						<td>Twitter</td>
						<td>{{ $user->profile->twitter_account }}</td>
					</tr>
					<tr>
						<td>Reddit</td>
						<td>{{ $user->profile->reddit_account }}</td>
					</tr>
					<tr>
						<td>Member Since</td>
						<td>
							{{ $user->present()->created_at() }}
						</td>
					</tr>
					<tr>
						<td>Member Details</td>
						<td>
							{{ $user->present()->role_id() }}
                            {{ $user->present()->subscription_details($user) }}
						</td>
					</tr>
					<tr>
						<td>Uploads</td>
						<td>{{ $objects->count() }}</td>
					</tr>
					<tr>
						<td>Favorites</td>
						<td>{{ $user->favorites->count() }}</td>
					</tr>
				</table>
			</div>
			<div class="grid-8">
				<table>
					<tr>
						<td>Favorite Mission</td>
						<td>
                            @if ($user->favorite_mission)
                                @include('templates.missionCard', ['size' => 'small', 'mission' => $favoriteMission])
                            @else
                                <p>No favorite mission. Add one!</p>
                            @endif

						</td>
					</tr>
					<tr>
						<td>Favorite Mission Patch</td>
						<td>{{ $user->profile->favorite_patch }}</td>
					</tr>
					<tr>
						<td>Favorite Elon Musk Quote</td>
						<td>{{ $user->profile->favorite_quote }}</td>
					</tr>
				</table>
				
			</div>
		</section>
		<h2>Favorites</h2>
		<section class="favorites container">
			@foreach ($user->favorites as $favorite)
				<div class="grid-4">
					{{ $favorite->object->title }}
				</div>
			@endforeach			
		</section>
		@if (Auth::isAccessingSelf($user) || Auth::isAdministrator())
			<h2>Notes</h2>
			<section class="notes">
				
			</section>
		@endif
		<h2>Uploads</h2>
		<section class="uploads">
			@if ($objects->count() == 0) 
				<p>No Uploads</p>
			@else
                @foreach ($objects as $object)
                    {{ $object->name }}
                @endforeach
            @endif
		</section>
	</main>
</div>
@stop

