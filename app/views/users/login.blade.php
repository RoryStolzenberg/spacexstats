@extends('templates.main')

@section('title', 'Log In')
@section('bodyClass', 'login')

@section('scripts')
@stop

@section('content')
	<div class="content-wrapper single-page">
		<h1>Log In</h1>
		<main>

			{{ Form::open(array('route' => 'users.login')) }}
                    {{ Form::token() }}

					{{ Form::label('email', 'Email:') }}
					{{ Form::email('email') }}

					{{ Form::label('password', 'Password:') }}
					{{ Form::password('password') }}

                    {{ Form::label('rememberMe', 'Remember Me!') }}
                    {{ Form::checkbox('rememberMe', true, true) }}

					{{ Form::submit('Log In') }}
			{{ Form::close() }}			
		</main>
	</div>
@stop

