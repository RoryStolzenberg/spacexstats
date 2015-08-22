@extends('templates.main')
@section('title', 'Home')

@section('content')
<body class="home" ng-app="homePageApp" ng-controller="homePageController" ng-strict-di>

    <div id="flash-message-container">
        @if (Session::has('flashMessage'))
            <p class="flash-message {{ Session::get('flashMessage.type') }}">{{ Session::get('flashMessage.contents') }}</p>
        @endif
    </div>

    @yield('templates.header')

    <!-- Main content -->
    <div class="content-wrapper single-page background subtract">
        <h1>Welcome</h1>
        <main>
        </main>
    </div>

    <!-- Navigation -->
    <ul id="statistics-navigation">
        <li class="statistic-holder" ng-repeat="statistic in statistics">
            <a class="statistic-link" ng-class="{ 'active' : isActiveStatistic() }" ng-click="$parent.goToClickedStatistic()" href=""></a>
        </li>
    </ul>

    <!-- Statistics -->
    <div class="content-wrapper single-page background" ng-repeat="statistic in statistics">
        <h1>
                <span ng-repeat="substatistic in statistic">
                    [[ fullTitle ]]
                </span>
        </h1>

        <main>
            <button class="previous-stat" ng-click="$parent.goToPreviousStatistic()"><i class="fa fa-angle-up fa-3x"></i></button>

            <nav ng-click="changeSubstatistic()">
                <ul class="container">
                    <li class="grid-2" ng-repeat="substatistic in statistic">[[ name ]]</li>
                </ul>
            </nav>

            <div ng-repeat="substatistic in statistic">
                <div class="hero hero-centered statistic" ng-if="display == 'single'">

                </div>

                <countdown ng-if="display == 'countdown'" countdown-to="result.launchDateTime" specificity="result.launch_specificity" callback=""></countdown>
            </div>

            <p class="description" ng-repeat="substatistic in statistic">
                <span>[[ description ]]</span>
            </p>


            <button class="next-stat" ng-click="$parent.goToNextStatistic()"><i class="fa fa-angle-down fa-3x"></i></button>
        </main>
    </div>
</body>
@stop