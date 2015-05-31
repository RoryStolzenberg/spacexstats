@extends('templates.main')

@section('title', 'Sign Up')
@section('bodyClass', 'signup')

@section('scripts')
@stop

@section('content')
<div class="content-wrapper single-page">
	<h1>Join SpaceX Stats</h1>
	<main>
		{{ Form::open(array('route' => 'users.signup')) }}
			{{ Form::label('username', 'Username:') }}
			{{ Form::text('username') }}

			{{ Form::label('email', 'Email:') }}
			{{ Form::email('email') }}

			{{ Form::label('password', 'Password:') }}
			{{ Form::password('password') }}

			{{ Form::label('password_confirmation', 'Confirm Password:') }}
			{{ Form::password('password_confirmation') }}

			{{ Form::checkbox('eula', 'eula') }}
			{{ Form::label('eula', 'I agree to the terms and conditions') }}

			{{ Form::submit('Join') }}
		{{ Form::close() }}	
	</main>
</div>
@stop