<div class="card payloads-card proportional">
    <div>
        <div class="content container">
            <div class="gr-4">
                <p>{{ $mission->payloads->count() }}</p>
                @if ($mission->payloads->count() == 1)
                    <p>Satellite</p>
                @else
                    <p>Satellites</p>
                @endif
            </div>
            <div class="gr-4">
                <p>{{ round($mission->payloads()->sum('mass')) }} kg</p>
                <p>Launched</p>
            </div>
            <div class="gr-4">
                <p>{{ ordinal($mission->payload_mass_ranking) }}</p>
                <p>Heaviest Flight</p>
            </div>
        </div>
    </div>
</div>