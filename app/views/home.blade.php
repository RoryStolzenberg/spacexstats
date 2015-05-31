@extends('templates.main')

@section('title', 'Home')
@section('bodyClass', 'home')

@section('scripts')
    {{ HTML::Script('/assets/js/jquery.fracs-0.15.0.js') }}
    {{ HTML::Script('/assets/js/jquery.ba-throttle-debounce.min.js') }}
    {{ HTML::script('/assets/js/viewmodels/HomePageViewModel.js') }}
    <script type="text/javascript">
        $(document).ready(function() {
            ko.applyBindings(new HomePageViewModel());
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
                        <div data-substat="{{ $num }}" class="hero hero-centered statistic">
                            <table class="{{ $substatistic['display'] }}">
                                @if ($substatistic['display'] === 'single')
                                    <tr class="value">
                                        <td>{{ $substatistic['result'] }}</td>
                                    </tr>
                                    <tr class="unit">
                                        <td>{{ $substatistic['unit'] }}</td>
                                    </tr>
                                @endif
                            </table>
                        </div>
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