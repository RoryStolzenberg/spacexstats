<div class="card mission-card {{ $size }}">
	<div class="top">
		<div class="thumb" style="background-image:url('{{ !is_null($mission->featuredImage) ? $mission->featuredImage->media_thumb_small : null }}');"></div>
		<p>
            <span class="mission-name">
                <a href="/missions/{{ $mission->slug }}">{{ $mission->name }}</a>
            </span>
            <span class="for"> for </span>
            <span class="mission-contractor">{{ $mission->contractor }}</span>
        </p>
	</div>
	<div class="bottom">
		@if ($size == 'small')
			<div class="container">
				<div class="gr-4"><span class="launch-count">{{ ordinal($mission->generic_vehicle_count) }}</span></div>
				<div class="gr-4">{{ $mission->present()->launchDateTime() }}</div>
				<div class="gr-4">{{ $mission->launchSite->fullLocation }}</div>
			</div>
			<div class="container">
				<div class="gr-4 smallcaps">{{ $mission->vehicle->generic_vehicle }}<br/>Launch</div>
				<div class="gr-4 smallcaps">Launch (UTC)</div>
				<div class="gr-4 smallcaps">Launch Site</div>
			</div>
		@elseif ($size == 'large')
			<div class="container">
				<div class="gr-1on9"><span class="launch-count">{{ ordinal($mission->generic_vehicle_count) }}</span></div>
				<div class="gr-1on9">{{ $mission->present()->launchDateTime() }}</div>
                @if ($mission->status !== 'Upcoming')
                    <div class="gr-1on9 smallcaps">{{ $mission->present()->launchOfYear() }}</div>
                @endif
				@if ($mission->status == 'Upcoming')
					<div class="gr-1on9">42%</div>
				@endif
				<div class="gr-1on9">{{ $mission->vehicle->specificVehicle }}</div>
				<div class="gr-1on9">{{ $mission->destination->destination }}</div>
				<div class="gr-1on9">{{ $mission->launchSite->fullLocation }}</div>
				@if ($mission->status == 'Upcoming')
					<div class="gr-1on9"></div>
				@endif
			</div>
			<div class="container">
				<div class="gr-1on9 smallcaps">{{ $mission->vehicle->generic_vehicle }}<br/>Launch</div>
				<div class="gr-1on9 smallcaps">Launch (UTC)</div>
                @if ($mission->status !== 'Upcoming')
                    <div class="gr-1on9 smallcaps">Launch of the Year</div>
                @endif
                @if ($mission->status == 'Upcoming')
				    <div class="gr-1on9 smallcaps">Probability of Launch</div>
                @endif
				<div class="gr-1on9 smallcaps">Vehicle</div>
				<div class="gr-1on9 smallcaps">Destination</div>
				<div class="gr-1on9 smallcaps">Launch Site</div>
				@if ($mission->status == 'Upcoming')
					<div class="gr-1on9 smallcaps">Where to watch</div>
				@endif
			</div>
		@endif
		<p><em>{{ $mission->summary }}</em></p>
	</div>
</div>