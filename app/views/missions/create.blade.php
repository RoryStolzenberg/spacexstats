@extends('templates.main')
@section('title', 'Future Launches')

@section('scripts')
    <script type="text/html" id="astronaut-template">
        <div>
            <h3 data-bind="text: astronaut.full_name"></h3>
            <label>First Name</label>
            <input type="text" data-bind="textInput: astronaut.first_name" />

            <label>Last Name</label>
            <input type="text" data-bind="textInput: astronaut.last_name" />

            <label>Gender</label>
            <input type="radio" name="gender" value="Male" data-bind="checked: astronaut.gender" />Male
            <input type="radio" name="gender" value="Female" data-bind="checked: astronaut.gender" />Female

            <label>Deceased</label>
            <input type="checkbox" data-bind="checked: astronaut.deceased" />

            <label>Date of Birth</label>
            <datetime params="value: astronaut.date_of_birth, type: 'date'"></datetime>

            <label>Nationality</label>
            <input type="text" data-bind="value: astronaut.nationality" />

            <button data-bind="click: $root.astronautActions.removeAstronaut">Remove Astronauut</button>
        </div>
    </script>
@stop

@section('content')
<body class="create-mission" ng-app="missionApp" ng-controller="missionController" ng-strict-di>

    @include('templates.flashMessage')
    @include('templates.header')

    <div class="content-wrapper">
        <h1>Create A Mission</h1>
        <main>
            <form name="createMission">
                <input type="hidden" name="_token" value="{{ csrf_token() }}" ng-model="CSRFToken" />

                <fieldset>
                    <legend>Mission</legend>

                    <label>Mission Name</label>
                    <input type="text" ng-model="mission.name" required />

                    <label>Mission Type</label>
                    <span>Selecting the type of mission determines the mission icon and image, if it is not set.</span>
                    <select ng-model="mission_type_id" ng-options="missionType.mission_type_id as missionType.name for missionType in data.missionTypes" required></select>

                    <label for="">Contractor</label>
                    <input type="text" ng-model="mission.contractor" required/>

                    <label for="">Launch Date Time</label>
                    <span>Entering a text string is okay, but if a precise date is needed, please follow MySQL date format.</span>
                    <input type="text" ng-model="mission.launchDateTime" required/>

                    <label>Vehicle</label>
                    <select ng-model="mission.vehicle_id" ng-options="vehicle.vehicle_id as vehicle.vehicle for vehicle in data.vehicles" required></select>

                    <label for="">Destination</label>
                    <select ng-model="mission.destination_id" ng-options="destination.destination_id as destination.destination for destination in data.destinations" required></select>

                    <label for="">Launch Site</label>
                    <select ng-model="mission.launch_site_id" ng-options="launchSite.launch_site_id as launchSite.name for launchSite in data.launchSites" required></select>

                    <label for="">Summary</label>
                    <input type="text" ng-model="mission.summary" required />
                </fieldset>

                <fieldset>
                    <legend>Parts</legend>
                    <div class="add-parts">
                        <button ng-click="filterByParts('Booster')">Add a Booster</button>
                        <button ng-click="filterByParts('First Stage')">Add a First Stage</button>
                        <button ng-click="filterByParts('Upper Stage')">Add an Upper Stage</button>

                        <div ng-repeat="part in data.parts | filter:partFilter">
                            <span>[[ part.name ]]</span>
                            <button ng-click="mission.addPartFlight(part)">Reuse This Part</button>
                        </div>

                        <button ng-click="mission.addPartFlight()">Create A Part</button>
                    </div>

                    <div ng-repeat="partFlight in mission.partFlights">
                        <h3></h3>

                        <label>Name</label>
                        <input type="text" ng-model="partFlight.part.name" />

                        <div ng-if="partFlight.part.type == 'Booster' || partFlightpart.type == 'First Stage'">
                            <label>Landing Legs?</label>
                            <input type="checkbox" ng-model="firststage_landing_legs" />

                            <label>Grid Fins?</label>
                            <input type="checkbox" ng-model="firststage_grid_fins" />

                            <label>Engine</label>
                            <select ng-model="firststage_engine" ng-options="firstStageEngine.first_stage_engine in firstStageEngines"></select>

                            <label>Engine Failures</label>
                            <input type="text" ng-model="firststage_engine_failures" />

                            <label>MECO time</label>
                            <input type="text" ng-model="firststage_meco" />

                            <label>Landing Coords (lat)</label>
                            <input type="text" ng-model="firststage_landing_coords_lat" />

                            <label>Landing Coords (lng)</label>
                            <input type="text" ng-model="firststage_landing_coords_lng" />

                            <label>Baseplate Color</label>
                            <input type="text" ng-model="baseplate_color" />
                        </div>


                        <div ng-if="part.type == 'Upper Stage'">
                            <label>Engine</label>
                            <select ng-model="upperstage_engine" ng-options="upperstageEngine in data.upperstageEngines"></select>

                            <label>Status</label>
                            <select data-bind="value: upperstage_status, options: $root.dataLists.upperStageStatuses, optionsCaption: 'null'"></select>

                            <label>SECO time</label>
                            <input type="text" ng-model="upperstage_seco"/>

                            <label>Decay Date</label>
                            <datetime type="date" ng-model="decay_date" startYear="2002" nullable="true"></datetime>

                            <label>NORAD ID</label>
                            <input type="text" ng-model="upperstage_norad_id" />

                            <label>International Designator</label>
                            <input type="text" ng-model="upperstage_intl_designator" />
                        </div>

                        <label>Landed?</label>
                        <input type="checkbox" ng-model="landed"/>

                        <label>Notes</label>
                        <textarea ng-model="note"></textarea>
                    </div>
                </fieldset>

                <fieldset>
                    <legend>Payloads</legend>
                    <button ng-click="mission.addPayload()">Add Payload</button>

                    <div ng-repeat="payload in mission.payloads">
                        <label>Payload Name</label>
                        <input type="text" ng-model="payload.name" required />

                        <label>Operator</label>
                        <input type="text" ng-model="payload.operator" required />

                        <label>Mass (KG)</label>
                        <input type="text" ng-model="payload.mass" />

                        <label>Is Payload Primary?</label>
                        <input type="checkbox" ng-model="payload.primary" />

                        <label>Gunter's Space Page Link</label>
                        <input type="text" ng-model="payload.link" />

                        <button ng-click="mission.removePayload(payload)">Remove This Payload</button>
                    </div>
                </fieldset>

                <fieldset>
                    <legend>Spacecraft</legend>

                    <div class="add-spacecraft">
                        <div ng-repeat="spacecraft in data.spacrcraft">
                            <span>[[ spacecraft.name ]]</span>
                            <button ng-click="mission.addSpacecraftFlight(spacecraft)" ng-disabled="mission.spacecraftFlight != null">Reuse This Spacecraft</button>
                        </div>

                        <button ng-click="mission.addSpacecraftFlight()" ng-disabled="mission.spacecraftFlight != null">Create A Spacecraft</button>
                    </div>

                    <div ng-if="mission.spacecraftFlight != null">
                        <h3>[[ mission.spacecraftFlight.spacecraft.name ]]</h3>

                        <label>Name</label>
                        <input type="text" ng-model="mission.spacecraftFlight.spacecraft.name" />

                        <label>Type</label>
                        <select ng-model="spacecraftFlight.spacecraft.type" ng-options="spacecraftType in data.spacecraftTypes"></select>

                        <label>Flight Name</label>
                        <input type="text" ng-model="spacecraftFlight.flight_name" required/>

                        <label>End Of Mission</label>

                        <label>Return Method</label>
                        <select ng-model="spacecraftFlight.return_method" ng-options="returnMethod in data.returnMethods"></select>

                        <label>Upmass</label>
                        <input type="text" ng-model="upmass" />

                        <label>Downmass</label>
                        <input type="text" ng-model="downmass" />

                        <label>ISS Berth</label>

                        <label>ISS Unberth</label>

                        <fieldset>
                            <label>Astronauts</label>

                            <!-- ko with: $root.astronautActions -->
                            <select data-bind="value: selectedAstronaut, options: $root.dataLists.astronauts, optionsText: 'fullName', optionsCaption: 'New...'"></select>
                            <button data-bind="click: addAstronaut">Add Astronaut</button>
                            <!-- /ko -->

                            <!-- ko template: { name: 'astronaut-template', foreach: astronautFlights, as: 'astronautFlight' } -->
                            <!-- /ko -->
                        </fieldset>

                        <button ng-model="mission.removeSpacecraft()">Remove Spacecraft</button>
                    </div>
                </fieldset>

                <input type="submit" ng-submit="submitMission()" ng-disabled="createMission.$invalid" />
            </form>

        </main>
    </div>
</body>
@stop