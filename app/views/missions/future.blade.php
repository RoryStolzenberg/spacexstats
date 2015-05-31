@extends('templates.main')

@section('title', 'Future Missions')
@section('bodyClass', 'future-missions')

@section('scripts')
@stop

@section('content')
	<div class="content-wrapper">
	<h1>Future Launches</h1>
	<main>
		<p>Browse all upcoming SpaceX launches &amp; missions here.</p>
		<h2>Next Launch</h2>
		@include('templates.missionCard', ['size' => 'large', 'mission' => $nextLaunch])
		<h2>More Launches</h2>
		<table>
			<tr>
				<th colspan="2">Scheduled Launch</th>
				<th>Payload</th>
				<th>Contractor</th>
				<th>Vehicle</th>
				<th>Launch Site</th>
			</tr>
			@foreach ($futureLaunches as $futureLaunch)
			<tr>
				<td>{{ $futureLaunch->launch_order_id }}</td>
				<td>{{ $futureLaunch->scheduledLaunch }}</td>
				<td>{{ $futureLaunch->name }}</td>
				<td>{{ $futureLaunch->contractor }}</td>
				<td>{{ $futureLaunch->vehicle->vehicle }}</td>
				<td>{{ $futureLaunch->launch_site->fullLocation }}</td>
			</tr>
			<tr>
				<td>{{ $futureLaunch->summary }}</td>
			</tr>
			@endforeach
		</table>
		<?php
			$calc = new LaunchProbabilityCalculator(3);
		?>

		<pre>{{ $calc->get() }}</pre>	
	</main>
</div>
@stop