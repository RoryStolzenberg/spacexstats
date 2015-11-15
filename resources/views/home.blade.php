@extends('templates.main')
@section('title', 'SpaceX Stats - SpaceX News, Countdowns, & Fan Community')

@section('content')
<body class="home" ng-controller="homeController" ng-strict-di ng-keydown="keypress($event)">


    @include('templates.header', ['class' => 'no-background'])

    <!-- Main content -->
    <div class="content-wrapper single-page background" id="home" du-scrollspy="home">
        <h1>Welcome</h1>
        <main>
            <p>SpaceX Stats is the first website dedicated entirely to following SpaceX and their missions. Countdown to upcoming launches, read about past missions, watch and follow missions live as they happen, and much more!</p>

            <p>Subscribe to Mission Control to get exclusive content, mission notifications via SMS and email, participate in the spaceflight fan community, </p>
            <button class="next-stat" ng-click="goToFirstStatistic()"><i class="fa fa-angle-down fa-3x"></i></button>
        </main>
    </div>

    <!-- Navigation -->
    <ul id="side-navigation">
        <li class="statistic-holder">
            <a class="link" ng-class="{ 'active' : activeStatistic == null }" ng-click="goHome()"></a>
        </li>
        <li class="statistic-holder" ng-repeat="statistic in statistics">
            <a class="link" ng-class="{ 'active' : statistic == activeStatistic }" ng-click="goToClickedStatistic(statistic)"></a>
        </li>
    </ul>

    <!-- Statistics -->
    <div class="content-wrapper single-page background" ng-repeat="statistic in statistics" id="@{{ statistic.camelCaseType }}" du-scrollspy="@{{ substatistic.camelCaseType }}" href="#@{{ statistic.camelCaseType }}">

        <h1 class="fade-in-out" ng-show="statistic.show" ng-class="{ fadeIn : statistic.fadeInModel, fadeOut : statistic.fadeOutModel }">@{{ statistic.activeSubstatistic.full_title }}</h1>

        <main class="invert">
            <button class="previous-stat" ng-click="goToNeighborStatistic($index - 1)"><i class="fa fa-angle-up fa-3x"></i></button>

            <nav class="in-page">
                <ul class="container">
                    <li class="gr-2" ng-repeat="substatistic in statistic.substatistics" ng-class="{ 'active':statistic.activeSubstatistic == substatistic }" ng-click="statistic.changeSubstatistic(substatistic)">@{{ substatistic.name }}</li>
                </ul>
            </nav>

            <div class="hero fade-in-out statistic" ng-repeat="substatistic in statistic.substatistics" ng-show="statistic.activeSubstatistic == substatistic && statistic.show" ng-class="{ fadeIn : statistic.fadeInModel, fadeOut : statistic.fadeOutModel }">
                <table style="color:inherit;" ng-if="substatistic.display == 'single'">
                    <tr class="value">
                        <td>@{{ substatistic.result }}</td>
                    </tr>
                    <tr class="unit">
                        <td>@{{ substatistic.unit }}</td>
                    </tr>
                </table>

                <countdown ng-if="substatistic.display == 'count'" countdown-to="substatistic.result.launchDateTime" specificity="substatistic.result.launch_specificity" type="classic"></countdown>
            </div>

            <p class="description fade-in-out" ng-show="statistic.show" ng-class="{ fadeIn : statistic.fadeInModel, fadeOut : statistic.fadeOutModel }">@{{ statistic.activeSubstatistic.description }}</p>
            <button class="next-stat" ng-click="goToNeighborStatistic($index + 1)"><i class="fa fa-angle-down fa-3x"></i></button>
        </main>
    </div>
</body>
@stop