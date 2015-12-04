<div class="card upper-stage-card proportional">
    <div>
        <div class="content container">

            @if ($mission->upperStage->upperstage_status == 'Decayed' || $mission->upperStage->upperstage_status == 'Deorbited')
                <span class="outcome">{{ $mission->upperStage->upperstage_status }}</span>
                <table class="countdown">
                    <tr>
                        <td class="value"></td>
                        <td class="value"></td>
                        <td class="value"></td>
                        <td class="value"></td>
                    </tr>
                    <tr>
                        <td class="unit"></td>
                        <td class="unit"></td>
                        <td class="unit"></td>
                        <td class="unit"></td>
                    </tr>
                </table>
                <p>Launched {{ $mission->present()->launchDateTime('M j, Y') }} - {{ $mission->upperStage->upperstage_status }} {{ $mission->orbitalElements->first()->epoch->toFormattedDateString() }}</p>

            @elseif ($mission->upperStage->upperstage_status == 'Earth Orbit')
                <span class="outcome">In Orbit</span>
                <countdown specificity="7" countdown-to="'{{ $mission->launch_date_time }}'" is-paused="false" type="classic"></countdown>
                <p>Launched {{ $mission->present()->launchDateTime('M j, Y') }}</p>

                @if ($mission->orbitalElements->count() > 0)
                    <p class="orbital-details">
                        <span>{{ round($mission->orbitalElements->first()->perigee) }}km x {{ round($mission->orbitalElements->first()->apogee) }}km <small>inclined</small> {{ $mission->orbitalElements->first()->inclination }}&deg;</span>
                        <span>({{ round($mission->orbitalElements->first()->period, 1) }} minutes)</span>
                        <span>As of {{ $mission->orbitalElements->first()->epoch->toFormattedDateString() }}</span>
                    </p>

                    <span class="tle-count">{{ $mission->orbitalElements()->count() }} TLE's</span>
                @endif
            @endif
        </div>
    </div>
</div>