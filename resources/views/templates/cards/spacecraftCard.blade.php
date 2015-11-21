<div class="card spacecraft-card">
    <div>
        <div class="content">
            <div class="time-in-space">
                <p>320<small>d</small> 12<small>h</small> 27<small>m</small> 55<small>s</small></p>
                <p>Time in space</p>
            </div>

            <div class="cargo">
                <p><span>Upmass</span> kg</p>
                <p><span>Downmass</span> kg</p>
            </div>

            <div class="reuse">
                {{ $spacecraft->flight_number_for_spacecraft }}
            </div>

            @if (is_null($spacecraft->iss_berth))
            <img src="iss" />
            @endif

            <div class="return-method">

            </div>


        </div>
    </div>
</div>