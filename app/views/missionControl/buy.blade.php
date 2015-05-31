@extends('templates.main')

@section('scripts')
@stop

@section('content')
<div class="content-wrapper single-page background">
	<h1>Get Mission Control</h1>
	<main>
		{{ Form::open(array('route' => 'missionControl.buy')) }}
			{{ Form::submit('Buy Now') }}
		{{ Form::close() }}		
	</main>
</div>
@stop

