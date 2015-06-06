@extends('templates.main')

@section('title', 'Home')
@section('bodyClass', 'home')

@section('scripts')
    <script data-main="src/js/common" src="src/js/require.js"></script>
    <script>
        require(['common'], function() {
            require(['pages/home']);
        });
    </script>
@stop

@section('content')
		<div class="content-wrapper single-page background">
				<h1>Welcome</h1>
				<main>
				</main>
		</div>
        <ul id="statistics-navigation">
            @foreach ($statistics as $name => $statistic)
                <li class="statistic-holder"><a class="statistic-link" data-stat="{{ $name }}" data-bind="click: goToClickedStatistic, css: { active: activeStatistic() == '{{ $name }}' }" href=""></a></li>
            @endforeach
        </ul>
        @foreach ($statistics as $name => $statistic)
            <div class="content-wrapper single-page background" data-stat="{{ $name }}">
                <h1>
                    @foreach ($statistic as $num => $substatistic)
                        @if ($substatistic['type'] === $substatistic['name'])
                            <span data-substat="{{ $num }}">{{ $substatistic['type'] }}</span>
                        @else
                            <span data-substat="{{ $num }}">{{ $substatistic['type'] . ' - ' . $substatistic['name']}}</span>
                        @endif
                    @endforeach
                </h1>
                <main>
                    <button class="previous-stat" data-bind="click: goToPreviousStatistic"><i class="fa fa-angle-up fa-3x"></i></button>
                    <nav data-bind="click: changeSubstatistic.bind($data, '{{ $name }}')">
                        <ul class="container">
                            @foreach ($statistic as $num => $substatistic)
                                <li class="grid-2" data-substat="{{ $num }}">{{ $substatistic['name'] }}</li>
                            @endforeach
                        </ul>
                    </nav>
                    @foreach ($statistic as $num => $substatistic)
                        @if ($substatistic['display'] === 'single')
                            <div data-substat="{{ $num }}" class="hero hero-centered statistic">
                                <table class="{{ $substatistic['display'] }}">
                                        <tr class="value">
                                            <td>{{ $substatistic['result'] }}</td>
                                        </tr>
                                        <tr class="unit">
                                            <td>{{ $substatistic['unit'] }}</td>
                                        </tr>
                                </table>
                            </div>
                        @elseif ($substatistic['display'] === 'count')
                            <countdown params="">
                            </countdown>
                        @endif
                    @endforeach
                    @foreach ($statistic as $num => $substatistic)
                        <p data-substat="{{ $num }}" class="description">
                            {{ $substatistic['description'] }}
                        </p>
                    @endforeach
                    <button class="next-stat" data-bind="click: goToNextStatistic"><i class="fa fa-angle-down fa-3x"></i></button>
                </main>
            </div>
        @endforeach
        <pre>{{ print_r($statistics) }}</pre>
@stop