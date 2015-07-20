@extends('templates.main')

@section('title', 'Create Mission')
@section('bodyClass', 'create-mission')

@section('scripts')
    <script data-main="/src/js/common" src="/src/js/require.js"></script>
    <script>
        require(['common'], function() {
            require(['knockout', 'viewmodels/MissionViewModel'], function(ko, MissionViewModel) {
                ko.applyBindings(new MissionViewModel());
            });
        });
    </script>

    <script type="text/html" id="partFlight-template">
        <div>
            <h3 data-bind="text: heading"></h3>

            <label>Name</label>
            <input type="text" data-bind="textInput: part.name"/>

            <!-- ko if: part.type() == 'Booster' || part.type() == 'First Stage' -->
                <label>Landing Legs?</label>
                <input type="checkbox" data-bind="checked: firststage_landing_legs" />

                <label>Grid Fins?</label>
                <input type="checkbox" data-bind="checked: firststage_grid_fins" />

                <label>Engine</label>
                <select data-bind="value: firststage_engine, options: $root.dataLists.firstStageEngines"></select>

                <label>Engine Failures</label>
                <input type="text" data-bind="value: firststage_engine_failures" />

                <label>MECO time</label>
                <input type="text" data-bind="value: firststage_meco" />

                <label>Landing Coords (lat)</label>
                <input type="text" data-bind="value: firststage_landing_coords_lat" />

                <label>Landing Coords (lng)</label>
                <input type="text" data-bind="value: firststage_landing_coords_lng" />

                <label>Baseplate Color</label>
                <input type="text" data-bind="value: baseplate_color" />
            <!-- /ko -->

            <!-- ko if: part.type() == 'Upper Stage' -->
                <label>Engine</label>
                <select data-bind="value: upperstage_engine, options: $root.dataLists.upperStageEngines, optionsCaption: 'null'"></select>

                <label>Status</label>
                <select data-bind="value: upperstage_status, options: $root.dataLists.upperStageStatuses, optionsCaption: 'null'"></select>

                <label>SECO time</label>
                <input type="text" data-bind="value: upperstage_seco"/>

                <label>Decay Date</label>
                <datetime params="value: upperstage_decay_date, type: 'date', startYear: 2006, nullable: true, isNull: true"></datetime>

                <label>NORAD ID</label>
                <input type="text" data-bind="value: upperstage_norad_id"/>

                <label>International Designator</label>
                <input type="text" data-bind="value: upperstage_intl_designator"/>
            <!-- /ko -->

            <label>Landed?</label>
            <input type="checkbox" data-bind="checked: landed" />

            <label>Notes</label>
            <textarea data-bind="text: note"></textarea>
        </div>
    </script>

    <script type="text/html" id="payload-template">
        <div>
            <label>Payload Name</label>
            <input type="text" data-bind="value: name" />

            <label>Operator</label>
            <input type="text" data-bind="value: operator" />

            <label>Mass</label>
            <input type="text" data-bind="value: mass" />

            <label>Payload Name</label>
            <input type="checkbox" data-bind="checked: primary" />

            <label>Gunter's Space Page Link</label>
            <input type="text" data-bind="value: link" />

            <button data-bind="click: $root.payloadActions.removePayload">Remove This Payload</button>
        </div>
    </script>

    <script type="text/html" id="spacecraftFlight-template">
        <div>
            <h3 data-bind="value: spacecraft.name"></h3>

            <label>Name</label>
            <input type="text" data-bind="textInput: spacecraft.name"/>

            <label>Type</label>
            <select data-bind="value: spacecraft.type, options: $root.dataLists.spacecraftTypes"></select>

            <label>Flight Name</label>
            <input type="text" data-bind="value: flight_name"/>

            <label>End Of Mission</label>
            <datetime params="value: end_of_mission, type: 'datetime', startYear: 2006, nullable: true, isNull: true"></datetime>

            <label>Return Method</label>
            <select data-bind="value: return_method, options: $root.dataLists.spacecraftReturnMethods"></select>

            <label>Upmass</label>
            <input type="text" data-bind="value: upmass"/>

            <label>Downmass</label>
            <input type="text" data-bind="value: downmass"/>

            <label>ISS Berth</label>
            <datetime params="value: iss_berth, type: 'datetime', startYear: 2006, nullable: true, isNull: true"></datetime>

            <label>ISS Unberth</label>
            <datetime params="value: iss_unberth, type: 'datetime', startYear: 2006, nullable: true, isNull: true"></datetime>

            <fieldset>
                <label>Astronauts</label>

                <!-- ko with: $root.astronautActions -->
                <select data-bind="value: selectedAstronaut, options: $root.dataLists.astronauts, optionsText: 'fullName', optionsCaption: 'New...'"></select>
                <button data-bind="click: addAstronaut">Add Astronaut</button>
                <!-- /ko -->

                <!-- ko template: { name: 'astronaut-template', foreach: astronautFlights, as: 'astronautFlight' } -->
                <!-- /ko -->
            </fieldset>

            <button data-bind="click: $root.spacecraftActions.removeSpacecraft">Remove Spacecraft</button>
        </div>
    </script>

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
    <div class="content-wrapper">
        <h1>Create A Mission</h1>
        <main>
            <form data-bind="with: mission">

                <input type="hidden" name="_token" value="{{ csrf_token() }}" data-bind="getOriginalValue, value: $root.csrfToken" />

                <fieldset>
                    <legend>Mission</legend>

                    <label>Mission Name</label>
                    <input type="text" data-bind="value: name"/>

                    <label>Mission Type</label>
                    <span>Selecting the type of mission determines the mission icon and image, if it is not set.</span>
                    <select data-bind="value: mission_type_id, options: $root.dataLists.missionTypes, optionsText: 'name', optionsValue: 'mission_type_id'"></select>

                    <label for="">Contractor</label>
                    <input type="text" data-bind="value: contractor"/>

                    <label for="">Launch Date Time</label>
                    <input type="text" data-bind="value: launch_date_time"/>

                    <label for="">Destination</label>
                    <select data-bind="value: destination_id, options: $root.dataLists.destinations, optionsText: 'destination', optionsValue: 'destination_id'"></select>

                    <label for="">Launch Site</label>
                    <select data-bind="value: launch_site_id, options: $root.dataLists.launchSites, optionsText: 'name', optionsValue: 'location_id'"></select>

                    <label for="">Summary</label>
                    <input type="text" data-bind="value: summary"/>
                </fieldset>

                <fieldset data-bind="with: $root.partActions">
                    <legend>Parts</legend>
                    <div class="add-parts">
                        <div data-bind="click: filterByBoosters">Add a Booster</div>
                        <div data-bind="click: filterByFirstStages">Add a First Stage</div>
                        <div data-bind="click: filterByUpperStages">Add an Upper Stage</div>

                        <select data-bind="value: selectedPart, options: filteredParts, optionsText: 'name', optionsCaption: 'New...'"></select>
                        <button data-bind="click: addPart">Add Part</button>
                    </div>

                    <!-- ko template: { name: 'partFlight-template', foreach: $root.mission().partFlights, as: 'partFlight' } -->
                    <!-- /ko -->
                </fieldset>

                <fieldset data-bind="with: $root.payloadActions">
                    <legend>Payloads</legend>
                    <button data-bind="click: addPayload">Add Payload</button>

                    <!-- ko template: { name: 'payload-template', foreach: $root.mission().payloads, as: 'payload' } -->
                    <!-- /ko -->
                </fieldset>

                <fieldset data-bind="with: $root.spacecraftActions">
                    <legend>Spacecraft</legend>
                    <button data-bind="click: addSpacecraft">Add Spacecraft</button>

                    <!-- ko template: { name: 'spacecraftFlight-template', foreach: $root.mission().spacecraftFlight, as: 'spacecraftFlight' } -->
                    <!-- /ko -->
                </fieldset>

                <input type="submit" data-bind="click: $root.submit" />
            </form>

        </main>
    </div>
@stop