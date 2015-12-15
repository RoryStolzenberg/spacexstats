<div class="card payloads-card proportional">
    <div>
        <div class="content">
            <table>
                <tr class="values">
                    <td>
                        <p>{{ $mission->payloads->count() }}</p>
                    </td>
                    <td>
                        <p>{{ round($mission->payloads->sum('mass')) }} kg</p>
                    </td>
                    <td>
                        <p>{{ ordinal($mission->payload_mass_ranking) }}</p>
                    </td>
                </tr>
                <tr class="units">
                    <td>
                        @if ($mission->payloads->count() == 1)
                            <p>Satellite</p>
                        @else
                            <p>Satellites</p>
                        @endif
                    </td>
                    <td>
                        <p>Launched to {{ $mission->destination->destination }}</p>
                    </td>
                    <td>
                        <p>Heaviest Flight</p>
                    </td>
                </tr>
            </table>
            <div class="weights">
                @for($i= $mission->payloads->sum('mass'); $i > 0; $i = $i - 1000)
                    @if ($i > 1000)
                        <img src="/images/icons/weight.png" />
                    @else
                        <img class="clipped-{{ round($i / 100) }}" src="/images/icons/weight.png" />
                    @endif
                @endfor
            </div>
            <p class="satellites">Satellites:
                @for($i=0; $i < $mission->payloads->count(); $i++)
                    @if ($i == 0)
                        <a target="_blank" href="{{ $mission->payloads[$i]->link }}">{{ $mission->payloads[$i]->name }}</a>
                        ({{ round($mission->payloads[$i]->mass) }} kg)
                    @else
                        , <a target="_blank" href="{{ $mission->payloads[$i]->link }}">{{ $mission->payloads[$i]->name }}</a>
                        ({{ round($mission->payloads[$i]->mass) }} kg)
                    @endif
                @endfor
            </p>
        </div>
    </div>
</div>