<div class="card spacecraft-card proportional">
    <div>
        <div class="content">
            <div class="time-in-space">
                <p>320<small>d</small> 12<small>h</small> 27<small>m</small> 55<small>s</small></p>
                <p class="text">Time in space</p>
            </div>

            <div class="cargo upmass">
                2194 <small>kg</small><br/>
                <span class="unit">Cargo Up</span>
            </div>
            <div class="cargo downmass">
               1572 <small>kg</small><br/>
                <span class="unit">Cargo Down</span>
            </div>

            <div class="reuse">
                {{ ordinal($spacecraftFlight->flight_number_for_spacecraft) }}
            </div>

            @if ($spacecraftFlight->didVisitISS())
            <img src="iss" />
            @endif

            <div class="return-method">

            </div>
        </div>
    </div>
</div>