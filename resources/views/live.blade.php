@extends('templates.main')
@section('title', 'Live')

@section('content')
    <body class="live" ng-controller="liveController" ng-strict-di>
    <!-- Custom Header -->
    <div class="content-wrapper">
        <h1>SpaceX Stats Live</h1>
        <main>
            <section>
                <div ng-if="auth == true && isActive == false">
                    <span class="live-herotext">@{{ settings.getStartedHeroText }}</span>

                    <div ng-if="settings.isGettingStarted == false">
                        <button ng-click="settings.getStarted()">Get Started</button>
                    </div>

                    <form name="gettingStartedForm" ng-if="settings.isGettingStarted == true" novalidate>
                        <span>Is this for the upcoming launch or a miscellaneous event?</span>
                        <input type="checkbox" id="isForLaunch" name="isForLaunch" ng-model="startingParameters.isForLaunch" ng-change="startingParameters.toggleForLaunch()" />
                        <label for="isForLaunch"></label>
                        @{{ data.upcomingMission.name }}

                        <input type="text" ng-model="startingParameters.threadName" id="threadName" name="threadName" placeholder="The Reddit Thread Title" required />

                        <div ng-hide="startingParameters.isForLaunch">
                            <label for="countdownTo">Enter an event time</label>
                            <datetime type="datetime" ng-model="startingParameters.countdownTo"></datetime>
                        </div>

                        <span>SpaceX Stream</span>
                        <input type="checkbox" id="spacexstream" name="spacexstream" value="true" ng-model="startingParameters.streamingSources.spacex" />
                        <label for="spacexstream"></label>
                        <span>NASA Stream</span>
                        <input type="checkbox" id="nasastream" name="nasastream" value="true" ng-model="startingParameters.streamingSources.nasa" />
                        <label for="nasastream"></label>

                        <textarea ng-model="startingParameters.description" id="description" name="description" required placeholder="Write a small introduction about the launch here. 500 < chars, use markdown just like you would on Reddit">
                        </textarea>

                        <input type="submit" ng-click="settings.turnOnSpaceXStatsLive()" ng-disabled="gettingStartedForm.$invalid" value="Create Thread" />
                    </form>


                </div>
                <form ng-if="auth == true && isActive == true">
                    <input type="text" ng-model="update.message" />
                    <input type="submit" ng-click="sendMessage()" />
                </form>
            </section>
        </main>
    </div>

        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/1.3.7/socket.io.js"></script>
    </body>
@stop