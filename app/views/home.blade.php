@extends('templates.main')
@section('title', 'Home')

@section('content')
<body class="home" ng-app="homePageApp" ng-controller="homePageController" ng-strict-di>

    @include('templates.flashMessage')
    @include('templates.header', ['class' => 'no-background'])

    <!-- Main content -->
    <div class="content-wrapper single-page background subtract">
        <h1>Welcome</h1>
        <main>
        </main>
    </div>

    <!-- Navigation -->
    <ul id="statistics-navigation">
        <li class="statistic-holder" ng-repeat="statistic in statistics">
            <a class="statistic-link" ng-class="{ 'active' : statistic.isActiveStatistic }" ng-click="$parent.goToClickedStatistic(statistic.type)" href=""></a>
        </li>
    </ul>

    <!-- Statistics -->
    <div class="content-wrapper single-page background" ng-repeat="statistic in statistics">

        <h1>[[ statistic.activeSubstatistic.full_title ]]</h1>

        <main>
            <button class="previous-stat" ng-click="$parent.goToPreviousStatistic()"><i class="fa fa-angle-up fa-3x"></i></button>

            <nav>
                <ul class="container">
                    <li class="grid-2" ng-repeat="substatistic in statistic.substatistics" ng-click="statistic.changeSubstatistic(substatistic)">[[ substatistic.name ]]</li>
                </ul>
            </nav>

            <div class="hero hero-centered statistic" ng-repeat-start="substatistic in statistic.substatistics" ng-if="substatistic.display == 'single'" ng-show="statistic.activeSubstatistic == substatistic">
                <table class="">
                    <tr class="value">
                        <td>[[ substatistic.result ]]</td>
                    </tr>
                    <tr class="unit">
                        <td>[[ substatistic.unit ]]</td>
                    </tr>
                </table>
            </div>

            <countdown ng-repeat-end ng-if="substatistic.display == 'count'" countdown-to="substatistic.result.launchDateTime" specificity="substatistic.result.launch_specificity" callback=""></countdown>

            <p class="description">[[ statistic.activeSubstatistic.description ]]</p>

            <button class="next-stat" ng-click="$parent.goToNextStatistic()"><i class="fa fa-angle-down fa-3x"></i></button>
        </main>
    </div>
</body>
@stop