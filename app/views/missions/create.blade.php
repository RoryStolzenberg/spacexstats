@extends('templates.main')
@section('title', 'Future Launches')

@section('content')
<body class="create-mission" ng-app="missionApp" ng-controller="missionController" ng-strict-di>

    @include('templates.flashMessage')
    @include('templates.header')

    <div class="content-wrapper">
        <h1>Create A Mission</h1>
        <main>
            <form name="createMissionForm">
                <fieldset>
                    <legend>[[ mission.name ]] Mission</legend>

                    <ul>
                        <li class="grid-12">
                            <label>Mission Name</label>
                            <input type="text" name="mission-name" ng-model="mission.name" placeholder="Enter a unique mission name here" required />
                        </li>

                        <li class="grid-6">
                            <label>Contractor</label>
                            <input type="text" ng-model="mission.contractor" required/>
                        </li>

                        <li class="grid-6">
                            <label>Mission Type</label>
                            <span>Selecting the type of mission determines the mission icon and image, if it is not set.</span>
                            <select ng-model="mission_type_id" ng-options="missionType.mission_type_id as missionType.name for missionType in data.missionTypes" required></select>
                        </li>

                        <li class="grid-12">
                            <label>Launch Date Time</label>
                            <input type="text" ng-model="mission.launchDateTime" placeholder="Entering a text string is okay, but if a precise date is needed, please follow MySQL date format" required/>
                        </li>

                        <li class="grid-4">
                            <label>Vehicle</label>
                            <select ng-model="mission.vehicle_id" ng-options="vehicle.vehicle_id as vehicle.vehicle for vehicle in data.vehicles" required></select>

                        </li>

                        <li class="grid-4">
                            <label for="">Launch Site</label>
                            <select ng-model="mission.launch_site_id" ng-options="launchSite.location_id as launchSite.fullLocation for launchSite in data.launchSites" required></select>

                        </li>

                        <li class="grid-4">
                            <label for="">Destination</label>
                            <select ng-model="mission.destination_id" ng-options="destination.destination_id as destination.destination for destination in data.destinations" required></select>

                        </li>

                        <li class="grid-12">
                            <label for="">Summary</label>
                            <textarea ng-model="mission.summary" placeholder="Short mission summary goes here. Please keep it less than 500 characters." required maxlength="500"></textarea>
                        </li>
                    </ul>
                </fieldset>

                <fieldset>
                    <legend>Parts</legend>
                    <div class="add-parts">
                        <button ng-click="partFilter.type = 'Booster'">Add a Booster</button>
                        <button ng-click="partFilter.type = 'First Stage'">Add a First Stage</button>
                        <button ng-click="partFilter.type = 'Upper Stage'">Add an Upper Stage</button>

                        <div ng-repeat="part in data.parts | filter:partFilter">
                            <span>[[ part.name ]]</span>
                            <button ng-click="mission.addPartFlight(part)">Reuse This [[ partFilter.type ]]</button>
                        </div>

                        <button ng-click="mission.addPartFlight()">Create A [[ partFilter.type ]]</button>
                    </div>

                    <div ng-repeat="partFlight in mission.partFlights">
                        <h3>[[ partFlight.part.name ]]</h3>

                        <label>Name</label>
                        <input type="text" ng-model="partFlight.part.name" />

                        <div ng-if="partFlight.part.type == 'Booster' || partFlight.part.type == 'First Stage'">
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

                    <div ng-repeat="payload in mission.payloads" ng-form="[[ 'payloadForm' + $index ]]">
                        <label>Payload Name</label>
                        <input type="text" ng-model="payload.name" required />

                        <label>Operator</label>
                        <input type="text" ng-model="payload.operator" required />

                        <label>Mass (KG)</label>
                        <input type="number" ng-model="payload.mass" min="0" step="0.5" />

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
                        <select ng-model="mission.spacecraftFlight.spacecraft.type" ng-options="spacecraftType for spacecraftType in data.spacecraftTypes"></select>

                        <label>Flight Name</label>
                        <input type="text" ng-model="mission.spacecraftFlight.flight_name" />

                        <label>End Of Mission</label>
                        <datetime type="datetime" ng-model="mission.spacecraftFlight.end_of_mission" is-nullable="true" start-year="2010"></datetime>

                        <label>Return Method</label>
                        <select ng-model="mission.spacecraftFlight.return_method" ng-options="returnMethod for returnMethod in data.returnMethods"></select>

                        <label>Upmass</label>
                        <input type="text" ng-model="mission.spacecraftFlight.upmass" />

                        <label>Downmass</label>
                        <input type="text" ng-model="mission.spacecraftFlight.downmass" />

                        <label>ISS Berth</label>

                        <label>ISS Unberth</label>

                        <fieldset>
                            <label>Astronauts</label>

                            <select ng-model="selected.astronaut" ng-options="astronaut as astronaut.fullName for astronaut in data.astronauts">
                                <option value="">New...</option>
                            </select>
                            <button ng-click="mission.spacecraftFlight.addAstronautFlight(selected.astronaut)">Add Astronaut</button>

                            <div ng-repeat="astronautFlight in mission.spacecraftFlight.astronautFlights">
                                <h3>[[ astronautFlight.astronaut.full_name ]]</h3>
                                <label>First Name</label>
                                <input type="text" ng-model="astronautFlight.astronaut.first_name" />

                                <label>Last Name</label>
                                <input type="text" ng-model="astronautFlight.astronaut.last_name" />

                                <label>Gender</label>
                                <input type="radio" name="gender" value="Male" ng-model="astronautFlight.astronaut.gender" />Male
                                <input type="radio" name="gender" value="Female" ng-model="astronautFlight.astronaut.gender" />Female

                                <label>Deceased</label>
                                <input type="checkbox" ng-model="astronautFlight.astronaut.deceased"  />

                                <label>Date of Birth</label>

                                <label>Nationality</label>
                                <input type="text" ng-model="astronautFlight.astronaut.nationality" />

                                <button ng-click="mission.spacecraftFlight.removeAstronautFlight(astronautFlight)">Remove Astronaut</button>
                            </div>
                        </fieldset>

                        <button ng-click="mission.removeSpacecraftFlight()">Remove Spacecraft</button>
                    </div>
                </fieldset>

                <input type="submit" ng-click="submitMission()" ng-disabled="createMissionForm.$invalid" value="Create Mission"/>
            </form>

        </main>
    </div>

    <script type="text/javascript">
        angular.module("missionApp").constant("CSRF_TOKEN", '{{ csrf_token() }}');
    </script>
</body>
@stop