@extends('templates.main')

@section('title', 'Create Mission')
@section('bodyClass', 'create-mission')

@section('scripts')
    <script data-main="/src/js/common" src="/src/js/require.js"></script>
    <script>
        require(['common'], function() {
            require(['knockout', 'viewmodels/CreateMissionViewModel'], function(ko, CreateMissionViewModel) {
                ko.applyBindings(new CreateMissionViewModel());
            });
        });
    </script>
@stop

@section('content')
    <div class="content-wrapper">
        <h1>Create A Mission</h1>
        <main>
            <form>
                {{ Form::token() }}

                <fieldset data-bind="with: mission">
                    <legend>Mission</legend>

                    <label>Mission Name</label>
                    <input type="text" data-bind="value: name"/>

                    <label>Mission Type</label>
                    <span>Selecting the type of mission determines the mission icon and image, if it is not set.</span>
                    <select data-bind="value: mission_type_id, options: $root.mission_types, optionsText: 'name', optionsValue: 'mission_type_id"></select>

                    <label for="">Contractor</label>
                    <input type="text" data-bind="value: contractor"/>

                    <label for="">Launch Date Time</label>
                    <input type="text" data-bind="value launch_date_time"/>

                    <label for="">Destination</label>
                    <select data-bind="value: destination_id, options: $root.destinations, optionsText: 'name', optionsValue: 'destination_id"></select>

                    <label for="">Launch Site</label>
                    <select data-bind="value: launch_site_id, options: $root.launch_sites, optionsText: 'name', optionsValue: 'location_id"></select>

                    <label for="">Summary</label>
                    <input type="text" data-bind="value: summary"/>
                </fieldset>

                <fieldset data-bind="width: parts">
                    <legend>Parts</legend>
                </fieldset>

                <fieldset data-bind="width: spacecraft">
                    <legend>Spacecraft</legend>
                </fieldset>

                <fieldset data-bind="width: payloads">
                    <legend>Payloads</legend>
                </fieldset>

                <input type="submit" data-bind="click: createMission" />
            </form>

                <button type="button" data-bind="click: addPart">Add A Part</button>
                <div class="add-parts">
                    <ul>
                        <li>Reuse A Part...</li>
                        <li>New Part...</li>
                    </ul>
                </div>
        </main>
    </div>
@stop