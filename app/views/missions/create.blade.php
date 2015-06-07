@extends('templates.main')

@section('title', 'Create Mission')
@section('bodyClass', 'create-mission')

@section('scripts')
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

                {{ Form::label('mission[type]', 'Mission Type') }}
                <span>Selecting the type of mission determines the mission icon and image, if it is not set.</span>
                {{ Form::select('mission[type]', $missionTypes) }}

                {{ Form::label('mission[contractor]', 'Payload Contractor') }}
                {{ Form::text('mission[contractor]') }}

                {{ Form::label('mission[launch]', 'Launch Date Time') }}
                {{ Form::text('mission[launch]') }}

                {{ Form::label('mission[destination_id]', 'Destination') }}
                {{ Form::select('mission[destination_id]', $destinations) }}

                {{ Form::label('mission[launch_site_id]', 'Launch Site') }}
                {{ Form::select('mission[launch_site_id]', $launchSites) }}

                {{ Form::label('mission[summary]', 'Summary') }}
                {{ Form::textarea('mission[summary]') }}

                <fieldset>
                    <legend>Vehicle</legend>

                    {{ Form::label('core[name]', 'First Stage Core') }}
                    {{ Form::text('core[name]') }}

                    {{ Form::label('mission[vehicle_id]', 'Launch Vehicle')}}
                    {{ Form::select('mission[vehicle_id]', $vehicles) }}

                    <span class="label">First Stage Landing Legs?</span>
                    <label>{{ Form::radio('use[firststage_landing_legs]', 'true') }}Yes</label>
                    <label>{{ Form::radio('use[firststage_landing_legs]', 'false') }}No</label>


                    <span class="label">First Stage Grid Fins?</span>
                    <label>{{ Form::radio('use[firststage_grid_fins]', 'true') }}Yes</label>
                    <label>{{ Form::radio('use[firststage_grid_fins]', 'false') }}No</label>

                    {{ Form::label('vehicle[firststage_engine]', 'First Stage Engine') }}
                    {{ Form::select('vehicle[firststage_engine]', $firstStageEngines) }}

                    {{ Form::label('mission[upperstage_engine]', 'Upper Stage Engine') }}
                    {{ Form::select('mission[upperstage_engine]', $upperStageEngines) }}
                </fieldset>

                <fieldset>
                    <legend>Spacecraft & Payloads</legend>
                    <button type="button" data-bind="click: addSpacecraft, disable: spacecraft().length == 1">Add Spacecraft<i class="fa fa-plus-circle"></i></button>
                    <div data-bind="template: { name: 'spacecraft-template', foreach: spacecraft }"></div>

                    <button data-bind="click: addPayload">Add Payload <i class="fa fa-plus-circle"></i></button>
                    <ul data-bind="template: { name: 'payload-template', foreach: payloads }"></ul>

                </fieldset>

                {{ Form::submit('Create') }}

            {{ Form::close() }}
        </main>
    </div>
@stop