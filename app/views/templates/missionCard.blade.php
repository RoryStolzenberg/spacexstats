<div class="card mission-card {{ $size }}">
	<div class="top">
		<div class="thumb" style="background-image:url(/media/1454e6bb28540a77.93511822.jpeg);"></div>
		<p><span>{{ link_to_route('missions.get', $mission->name, array($mission->slug)) }}</span> for <span>{{ $mission->contractor }}</span></p>
	</div>
	<div class="bottom">
		@if ($size == 'small')
			<div class="container">
				<div class="grid-4"><span class="launch-count">{{ $mission->present()->genericVehicleCount() }}</span></div>
				<div class="grid-4">{{ $mission->present()->launchDateTime() }}</div>
				<div class="grid-4">{{ $mission->launch_site->fullLocation }}</div>
			</div>
			<div class="container">
				<div class="grid-4 smallcaps">{{ $mission->vehicle->genericVehicle }}<br/>Launch</div>
				<div class="grid-4 smallcaps">Launch (UTC)</div>
				<div class="grid-4 smallcaps">Launch Site</div>
			</div>
		@elseif ($size == 'large')
			<div class="container">
				<div class="grid-1on9"><span class="launch-count">{{ $mission->present()->genericVehicleCount() }}</span></div>
				<div class="grid-1on9">{{ $mission->present()->launchDateTime() }}</div>
                @if ($mission->status !== 'Upcoming')
                    <div class="grid-1on9 smallcaps">{{ $mission->present()->launchOfYear() }}</div>
                @endif
				@if ($mission->status == 'Upcoming')
					<div class="grid-1on9">42%</div>
				@endif
				<div class="grid-1on9">{{ $mission->vehicle->specificVehicle }}</div>
				<div class="grid-1on9">{{ $mission->destination->destination }}</div>
				<div class="grid-1on9">{{ $mission->launch_site->fullLocation }}</div>
				@if ($mission->status == 'Upcoming')
					<div class="grid-1on9"></div>
				@endif
			</div>
			<div class="container">
				<div class="grid-1on9 smallcaps">{{ $mission->vehicle->genericVehicle }}<br/>Launch</div>
				<div class="grid-1on9 smallcaps">Launch (UTC)</div>
                @if ($mission->status !== 'Upcoming')
                    <div class="grid-1on9 smallcaps">Launch of the Year</div>
                @endif
                @if ($mission->status == 'Upcoming')
				    <div class="grid-1on9 smallcaps">Probability</div>
                @endif
				<div class="grid-1on9 smallcaps">Vehicle</div>
				<div class="grid-1on9 smallcaps">Destination</div>
				<div class="grid-1on9 smallcaps">Launch Site</div>
				@if ($mission->status == 'Upcoming')
					<div class="grid-1on9 smallcaps">Where to watch</div>
				@endif
			</div>
		@endif
		<p><em>{{ $mission->summary }}</em></p>
	</div>
</div>