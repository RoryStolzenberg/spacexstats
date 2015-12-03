<div class="card mission-card {{ $size }}">
	<div class="top">
		<div class="thumb" style="background-image:url('{{ $mission->present()->featuredImageUrl() }}');"></div>
		<p>
            <a class="mission-name" href="/missions/{{ $mission->slug }}">{{ $mission->name }}</a>
            @if ($size == 'large')
                <span class="for hide@small"> for </span>
                <span class="mission-contractor hide@small">{{ $mission->contractor }}</span>
            @endif
        </p>
	</div>
	<div class="bottom">
		@if ($size == 'small')
			<div class="container values">
				<div class="gr-4"><span class="launch-count">{{ ordinal($mission->generic_vehicle_count) }}</span></div>
				<div class="gr-4">{{ $mission->present()->launchDateTime() }}</div>
				<div class="gr-4">{{ $mission->launchSite->full_location }}</div>
			</div>
			<div class="container keys">
				<div class="gr-4">{{ $mission->vehicle->generic_vehicle }}<br/>Launch</div>
				<div class="gr-4">Launch (UTC)</div>
				<div class="gr-4">Launch Site</div>
			</div>
		@elseif ($size == 'large')
			<div class="container values">
				<div>
					<span class="launch-count">{{ ordinal($mission->generic_vehicle_count) }}</span>
				</div>
				<div>{{ $mission->present()->launchDateTime() }}</div>
                <div>{{ ordinal($mission->launch_of_year) }}</div>
				@if ($mission->status == 'Upcoming')
					<div>42%</div>
				@endif
				<div>{{ $mission->vehicle->specific_vehicle }}</div>
				<div>{{ $mission->destination->destination }}</div>
				<div>{{ $mission->launchSite->full_location }}</div>
				@if ($mission->status == 'Upcoming')
					<div></div>
				@endif
                @if ($mission->status == 'Complete')
                    <div><img class="launch-illumination" src="/images/icons/illuminations/{{ $mission->launch_illumination }}.png" /></div>
                    @if ($mission->outcome == 'Success')
                        <div>{{ ordinal($mission->successful_consecutive_launch) }}</div>
                    @endif
                @endif
                <div>Mission Collection</div>
			</div>
			<div class="container keys">
				<div>{{ $mission->vehicle->generic_vehicle }}<br/>Launch</div>
				<div>Launch (UTC)</div>
                <div>Launch of the Year</div>
                @if ($mission->status == 'Upcoming')
				    <div>Probability of Launch</div>
                @endif
				<div>Vehicle</div>
				<div>Destination</div>
				<div>Launch Site</div>
				@if ($mission->status == 'Upcoming')
					<div>Where to watch</div>
				@endif
                @if ($mission->status == 'Complete')
                    <div>{{ $mission->launch_illumination }} Launch</div>
                    @if ($mission->outcome == 'Success')
                        <div>Successful Consecutive Launch</div>
                    @endif
                @endif
                <div>Mission Collection</div>
			</div>
		@endif
		<p><em>{{ $mission->summary }}</em></p>
	</div>
</div>