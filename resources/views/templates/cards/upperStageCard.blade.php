<div class="card upper-stage-card proportional">
    <div>
        <div class="content container">
            <span class="outcome">{{ $mission->upperStage->upperstage_status }}</span>
            @if ($mission->upperStage->upperstage_status == 'Did not achieve orbit')
                <p>Did not achieve orbit.</p>
            @elseif ($mission->upperStage->upperstage_status == 'Decayed' || $mission->upperStage->upperstage_status == 'Deorbited')
            @else
                <p>614km x 128km <small>inclined</small> 19.7&deg;</p>
            @endif
        </div>
    </div>
</div>