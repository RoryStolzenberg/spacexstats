@extends('templates.main')
@section('title', 'Home')

@section('content')
<body class="home" ng-controller="homeController" ng-strict-di>


    @include('templates.header', ['class' => 'no-background'])

    <!-- Main content -->
    <div class="content-wrapper single-page background" id="home">
        <h1>Welcome</h1>
        <main>
            <button class="next-stat" ng-click="goToFirstStatistic()"><i class="fa fa-angle-down fa-3x"></i></button>
        </main>
    </div>

    <!-- Navigation -->
    <ul id="statistics-navigation">
        <li class="statistic-holder">
            <a class="statistic-link" ng-class="{ 'active' : activeStatistic == false }" ng-click="goHome()"></a>
        </li>
        <li class="statistic-holder" ng-repeat="statistic in statistics">
            <a class="statistic-link" ng-class="{ 'active' : statistic.isActiveStatistic }" ng-click="goToClickedStatistic(statistic.camelCaseType)"></a>
        </li>
    </ul>

    <!-- Statistics -->
    <div class="content-wrapper single-page background" ng-repeat="statistic in statistics" id="@{{ statistic.camelCaseType }}">

        <h1 class="fade" ng-repeat="substatistic in statistic.substatistics" ng-show="statistic.activeSubstatistic == substatistic">@{{ substatistic.full_title }}</h1>

        <main>
            <button class="previous-stat" ng-click="goToNeighborStatistic($index - 1)"><i class="fa fa-angle-up fa-3x"></i></button>

            <nav>
                <ul class="container">
                    <li class="gr-2" ng-repeat="substatistic in statistic.substatistics" ng-click="statistic.changeSubstatistic(substatistic)">@{{ substatistic.name }}</li>
                </ul>
            </nav>

            <div class="hero hero-centered statistic" ng-repeat-start="substatistic in statistic.substatistics" ng-if="substatistic.display == 'single'" ng-show="statistic.activeSubstatistic == substatistic">
                <table class="">
                    <tr class="value">
                        <td>@{{ substatistic.result }}</td>
                    </tr>
                    <tr class="unit">
                        <td>@{{ substatistic.unit }}</td>
                    </tr>
                </table>
            </div>

            <countdown ng-repeat-end ng-if="substatistic.display == 'count'" ng-show="statistic.activeSubstatistic == substatistic" countdown-to="substatistic.result.launchDateTime" specificity="substatistic.result.launch_specificity"></countdown>

            <p class="description" ng-repeat="substatistic in statistic.substatistics" ng-show="statistic.activeSubstatistic == substatistic">@{{ substatistic.description }}</p>
            <button class="next-stat" ng-click="goToNeighborStatistic($index + 1)"><i class="fa fa-angle-down fa-3x"></i></button>
        </main>
    </div>
</body>
@stop