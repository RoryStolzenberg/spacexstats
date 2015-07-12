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

    <script type="text/html" id="spacecraft-template">
        {{ Form::label('spacecraft[type]', 'Type') }}
        {{ Form::select('spacecraft[type]', $spacecraft, array('data-bind' => 'value: type')) }}

        {{ Form::label('spacecraft[name]', 'Spacecraft Name') }}
        {{ Form::text('spacecraft[name]', '', array('data-bind' => 'value: spacecraftName')) }}

        {{ Form::label('spacecraftFlight[name]', 'Flight Name') }}
        {{ Form::text('spacecraftFlight[name]', '', array('data-bind' => 'value: flightName')) }}

        {{ Form::label('spacecraftFlight[return]', 'Spacecraft Return Datetime') }}
        {{ Form::input('datetime', 'spacecraftFlight[return]', '', array('data-bind' => 'value: spacecraftReturn')) }}

        {{ Form::label('spacecraftFlight[return_method]', 'Spacecraft Return Method') }}
        {{ Form::select('spacecraftFlight[return_method]', $spacecraftReturnMethods, array('data-bind' => 'value: returnMethod')) }}

        {{ Form::label('spacecraftFlight[upmass]', 'Upmass (kg)') }}
        {{ Form::text('spacecraftFlight[upmass]', '', array('data-bind' => 'value: upmass')) }}

        {{ Form::label('spacecraftFlight[downmass]', 'Downmass (kg)') }}
        {{ Form::text('spacecraftFlight[downmass]', '', array('data-bind' => 'value: downmass')) }}

        {{ Form::label('spacecraftFlight[iss_berth]', 'ISS Berth') }}
        {{ Form::input('datetime', 'spacecraftFlight[iss_berth]', '', array('data-bind' => 'value: issBerth')) }}

        {{ Form::label('spacecraftFlight[iss_unberth]', 'ISS Unberth') }}
        {{ Form::input('datetime', 'spacecraftFlight[iss_unberth]', '', array('data-bind' => 'value: issUnberth')) }}

        <button type="button" class="fa fa-minus-circle" data-bind="click: $parent.removeSpacecraft"></button>
    </script>
    <script type="text/html" id="payload-template">
        {{ Form::label('payload[name]', 'Payload Name') }}
        {{ Form::text('payload[name]', '', array('data-bind' => 'value: name, foreachNameAttr: $index')) }}

        {{ Form::label('payload[operator]', 'Payload Operator') }}
        {{ Form::text('payload[operator]', '', array('data-bind' => 'value: operator, foreachNameAttr: $index')) }}

        {{ Form::label('payload[mass]', 'Mass (kg)') }}
        {{ Form::text('payload[mass]', '', array('data-bind' => 'value: mass, foreachNameAttr: $index')) }}

        {{ Form::label('payload[link]', 'Gunters Spacepage Link') }}
        {{ Form::text('payload[link]', '', array('data-bind' => 'value: link, foreachNameAttr: $index')) }}

        <button type="button" class="fa fa-minus-circle" data-bind="click: $parent.removePayload"></button>
    </script>
@stop

@section('content')
    <div class="content-wrapper">
        <h1>Create A Mission</h1>
        <main>
            {{ Form::open(array('route' => 'missions.create', 'method' => 'post')) }}
                {{ Form::token() }}

                {{ Form::label('mission[name]', 'Mission Name') }}
                {{ Form::text('mission[name]') }}

                {{ Form::label('mission[mission_type_id]', 'Mission Type') }}
                <span>Selecting the type of mission determines the mission icon and image, if it is not set.</span>
                {{ Form::select('mission[mission_type_id]', $missionTypes) }}

                {{ Form::label('mission[contractor]', 'Payload Contractor') }}
                {{ Form::text('mission[contractor]') }}

                {{ Form::label('mission[launch_date_time]', 'Launch Date Time') }}
                {{ Form::text('mission[launch_date_time]') }}

                {{ Form::label('mission[destination_id]', 'Destination') }}
                {{ Form::select('mission[destination_id]', $destinations) }}

                {{ Form::label('mission[launch_site_id]', 'Launch Site') }}
                {{ Form::select('mission[launch_site_id]', $launchSites) }}

                {{ Form::label('mission[summary]', 'Summary') }}
                {{ Form::textarea('mission[summary]') }}



                    {{ Form::label('mission[vehicle_id]', 'Launch Vehicle')}}
                    {{ Form::select('mission[vehicle_id]', $vehicles) }}



                {{ Form::submit('Create') }}

            {{ Form::close() }}
        </main>
    </div>
@stop