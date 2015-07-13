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

    <script type="text/html" id="payload-template">
        <div>
            <label>Payload Name</label>
            <input type="text" data-bind="name" />

            <label>Operator</label>
            <input type="text" data-bind="operator" />

            <label>Mass</label>
            <input type="text" data-bind="mass" />

            <label>Payload Name</label>
            <input type="checkbox" data-bind="primary" />

            <label>Gunter's Space Page Link</label>
            <input type="text" data-bind="link" />

            <button data-bind="click: $root.removePayload"></button>
        </div>
    </script>
@stop

@section('content')
    <div class="content-wrapper">
        <h1>Create A Mission</h1>
        <main>
            <form data-bind="with: mission">
                {{ Form::token() }}

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
                    <input type="text" data-bind="value launch_date_time"/>

                    <label for="">Destination</label>
                    <select data-bind="value: destination_id, options: $root.dataLists.destinations, optionsText: 'destination', optionsValue: 'destination_id'"></select>

                    <label for="">Launch Site</label>
                    <select data-bind="value: launch_site_id, options: $root.dataLists.launchSites, optionsText: 'name', optionsValue: 'location_id'"></select>

                    <label for="">Summary</label>
                    <input type="text" data-bind="value: summary"/>
                </fieldset>

                <fieldset data-bind="">
                    <legend>Parts</legend>
                    <button type="button" data-bind="click: $root.addPart">Add A Part</button>
                    <div class="add-parts">
                        <ul>
                            <li>Reuse A Part...</li>
                            <li>New Part...</li>
                        </ul>
                    </div>
                </fieldset>

                <fieldset data-bind="">
                    <legend>Spacecraft</legend>
                </fieldset>

                <fieldset data-bind="">
                    <legend>Payloads</legend>
                    <button type="button" data-bind="click: $root.addPayload">Add A Payload</button>
                    <!-- ko template: { name: 'payload-template', foreach: payloads, as: 'payload' } -->
                    <!-- /ko -->
                </fieldset>

                <input type="submit" data-bind="click: $root.createMission" />
            </form>

        </main>
    </div>
@stop