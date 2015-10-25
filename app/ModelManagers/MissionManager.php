<?php
namespace SpaceXStats\Managers;

class MissionManager {
    private $input, $errors = [];
    private $mission;

    public function __construct(Mission $mission, Payload $payload, PartFlight $partFlight, Part $part, SpacecraftFlight $spacecraftFlight, Spacecraft $spacecraft, AstronautFlight $astronautFlight, Astronaut $astronaut, PrelaunchEvent $prelaunchEvent, Telemetry $telemetry) {
        $this->mission              = $mission;
        $this->payload              = $payload;
        $this->partFlight           = $partFlight;
        $this->part                 = $part;
        $this->spacecraftFlight     = $spacecraftFlight;
        $this->spacecraft           = $spacecraft;
        $this->astronautFlight      = $astronautFlight;
        $this->astronaut            = $astronaut;
        $this->telemetry            = $telemetry;
    }

    public function isValid() {
        // Get the input
        $this->input = Input::all();

        // Validate the mission model
        $missionValidity = $this->mission->isValid($this->input('mission'));
        if ($missionValidity !== true) {
            $this->errors[] = $missionValidity;
        }

        // Validate any payload models
        if (array_key_exists('payloads', $this->input['mission'])) {
            $payloads = $this->input('payloads');

            foreach ($payloads as $payload) {
                $payloadValidity = $this->payload->isValid($payload);
                if ($payloadValidity !== true) {
                    $this->errors['payloads'][] = $payloadValidity;
                }
            }
        }

        // Validate any partFlight models
        $partFlights = $this->input['mission']['part_flights'];
        foreach ($partFlights as $partFlight) {

            $partFlightValidity = $this->partFlight->isValid($partFlight);
            if ($partFlightValidity !== true) {
                $this->errors['part_flights'][] = $partFlightValidity;
            }

            // Validate the part model
            $partValidity = $this->part->isValid($partFlight['part']);
            if ($partValidity !== true) {
                $this->errors['parts'][] = $partValidity;
            }
        }

        // Validate the spacecraftFlight model
        if (!is_null($this->input['mission']['spacecraft_flight'])) {
            $spacecraftFlight = $this->input['mission']['spacecraft_flight'];

            $spacecraftFlightValidity = $this->spacecraftFlight->isValid($spacecraftFlight);
            if ($spacecraftFlightValidity !== true) {
                $this->errors['spacecraft_flight'][] = $spacecraftFlightValidity;
            }

            // Validate the spacecraft model
            $spacecraftValidity = $this->spacecraft->isValid($spacecraftFlight['spacecraft']);
            if ($spacecraftValidity !== true) {
                $this->errors['spacecraft'][] = $spacecraftValidity;
            }

            // Validate any astronaut flights model
            if (array_key_exists('astronaut_flights', $spacecraftFlight)) {
                foreach ($spacecraftFlight['astronaut_flights'] as $astronautFlight)
                {
                    $astronautFlightValidity = $this->astronautFlight->isValid($astronautFlight);
                    if ($astronautFlightValidity !== true) {
                        $this->errors['astronaut_flights'][] = $astronautFlightValidity;
                    }

                    // Validate the astronaut model
                    $astronautValidity = $this->astronaut->isValid($astronautFlight['astronaut']);
                    if ($astronautValidity !== true) {
                        $this->errors['astronauts'][] = $astronautValidity;
                    }
                }
            }
        }

        // Validate any prelaunch event models

        // Validate any telemetry models
        if (array_key_exists('telemetries', $this->input['mission'])) {
            foreach ($this->input['mission']['telemetries'] as $telemetry) {
                $telemetryValidity = $this->telemetry->isValid($telemetry);
                if ($telemetryValidity !== true) {
                    $this->errors['telemetries'][] = $telemetryValidity;
                }
            }
        }

        return empty($this->errors);
    }

    public function create() {
        // Create the mission
        \DB::beginTransaction();
        try {

            // Fill mission
            $this->mission->fill($this->input('mission'));
            $this->mission->status = 'Upcoming';
            $this->mission->push();

            $this->createPayloadRelations();
            $this->managePartFlightRelations();
            $this->createSpacecraftFlightRelation();
            $this->createPrelaunchEventRelation();

            \DB::commit();
        } catch (Exception $e) {
            \DB::rollback();
        }

        return $this->mission;
    }

    public function update() {

        $this->mission = Mission::with('payloads', 'partFlights', 'spacecraftFlight', 'telemetries')->find($this->input('mission')['mission_id']);

        \DB::beginTransaction();
        try {
            // Fill mission
            $this->mission->fill($this->input('mission'));
            $this->mission->save();
            $this->mission->push();

            // Update any relations, create new relations, delete any relations which have been removed.
            $this->updatePayloadRelations();
            $this->managePartFlightRelations();
            $this->manageTelemetryRelations();

            \DB::commit();
        } catch (Exception $e) {
            \DB::rollback();
        }

        return $this->mission;
    }

    private function input($filter) {
        if ($filter == 'mission') {
            $mission = $this->input['mission'];
            unset($mission['payloads'], $mission['part_flights'], $mission['spacecraft_flight'], $mission['prelaunch_events'], $mission['telemetries']);
            return $mission;

        } else if ($filter == 'payloads') {
            return $this->input['mission']['payloads'];

        }
    }

    private function createPayload($input) {
        $payload = new Payload($input);
        $payload->mission()->associate($this->mission);
        $payload->save();
    }

    private function createPayloadRelations() {
        foreach ($this->input('payloads') as $payloadInput) {
            $this->createPayload($payloadInput);
        }
    }

    private function updatePayloadRelations() {
        $currentPayloads = $this->mission->payloads->keyBy('payload_id');

        foreach ($this->input('payloads') as $payloadInput) {

            // If the payload exists, update it, otherwise, create it
            if (array_key_exists('payload_id', $payloadInput)) {
                $payload = $currentPayloads->pull($payloadInput['payload_id']);
                $payload->fill($payloadInput);
                $payload->save();

            } else {
                $this->createPayload($payloadInput);
            }
        }

        // Delete any remaining payloads
        if (!$currentPayloads->isEmpty()) {
            Payload::whereIn('payload_id', $currentPayloads->keys())->delete();
        }
    }

    private function managePartFlightRelations() {
        $currentPartFlights = $this->mission->partFlights->keyBy('part_flight_id');

        foreach ($this->input['mission']['part_flights'] as $partFlightInput) {

            // If the partFlight exists, update it, otherwise, create it
            if (array_key_exists('part_flight_id', $partFlightInput)) {
                $partFlight = $currentPartFlights->pull($partFlightInput['part_flight_id']);
            } else {
                $partFlight = new PartFlight();
            }

            // Create part if it is not being reused or otherwise find it
            $partInput = array_pull($partFlightInput, 'part');
            $part = array_key_exists('part_id', $partInput) ? Part::find($partInput['part_id']) : new Part();
            $part->fill($partInput);
            $part->save();

            $partFlight->part()->associate($part);
            $partFlight->mission()->associate($this->mission);
            $partFlight->save();
        }

        // Delete any remaining partflights
        if (!$currentPartFlights->isEmpty()) {
            PartFlight::whereIn('part_flight_id', $currentPartFlights->keys())->delete();
        }
    }

    private function createSpacecraftFlightRelation() {
        if (!is_null($this->input['mission']['spacecraft_flight'])) {
            $spacecraftFlight = new SpacecraftFlight();

            $spacecraftInput = array_pull($this->input['mission']['spacecraft_flight'], 'spacecraft');

            // Create part if it is not being reused or otherwise find it
            $spacecraft = array_key_exists('spacecraft_id', $spacecraftInput) ? Spacecraft::find($spacecraftInput['spacecraft_id']) : new Spacecraft();
            $spacecraft->fill($spacecraftInput);
            $spacecraft->save();

            $spacecraft->spacecraftFlights()->save($spacecraftFlight);
            $spacecraftFlight->mission()->associate($this->mission);

            if (array_key_exists($spacecraftFlight, 'astronaut_flights')) {
                foreach ($spacecraftFlight['astronaut_flights'] as $astronautFlightInput)
                {
                    $astronautFlight = new AstronautFlight();

                    $astronautId = $astronautFlightInput['astronaut']['astronaut_id'];
                    $astronaut = is_null($astronautId) ? new Astronaut() : Astronaut::find($astronautId);

                    $astronaut->fill($astronautFlightInput['astronaut']);

                    $astronaut->astronautFlights()->save($astronautFlightInput);
                    $astronautFlight->spacecraftFlight()->associate($spacecraftFlight);
                }
            }
        }
    }

    private function updateSpacecraftFlightRelation() {
        $currentSpacecraftFlight = $this->mission->spacecraftFlight;

        // If the input spacecraft flight exists and the current spacecraft flight does not (create)
        if (!is_null($this->input['mission']['spacecraft_flight']) && $currentSpacecraftFlight->count() == false) {

        // If the input spacecraft flight exists and the current spacecraft flight does (update)
        } elseif (!is_null($this->input['mission']['spacecraft_flight']) && $currentSpacecraftFlight->count() == true) {

        // If the input spacecraft flight does not exist and the current spacecraft flight does (delete)
        } elseif (is_null($this->input['mission']['spacecraft_flight']) && $currentSpacecraftFlight->count() == true) {

        }


        // -------------------------
        $currentPartFlights = $this->mission->partFlights->keyBy('part_flight_id');

        foreach ($this->input('partFlights') as $partFlightInput) {

            // If the partFlight exists, update it, otherwise, create it
            if (array_key_exists('part_flight_id', $partFlightInput)) {
                $partFlight = $currentPartFlights->pull($partFlightInput['part_flight_id']);
                $partFlight->fill($partFlightInput);

            } else {
                $partFlight = new Payload($partFlightInput);
                $partFlight->mission()->associate($this->mission);
            }

            $partFlight->save();
        }

        // Delete any remaining payloads
        if (!$currentPartFlights->isEmpty()) {
            PartFlight::whereIn('part_flight_id', $currentPartFlights->keys())->delete();
        }
    }

    private function createPrelaunchEventRelation() {
        $prelaunchEvent = new PrelaunchEvent();
        $prelaunchEvent->event = 'Announcement';
        $prelaunchEvent->occurred_at = Carbon::now();
        $prelaunchEvent->summary = 'Mission Created';
        $prelaunchEvent->mission()->associate($this->mission);
        $prelaunchEvent->save();
    }

    private function manageTelemetryRelations() {
        $currentTelemetries = $this->mission->telemetries->keyBy('telemetry_id');

        foreach ($this->input['mission']['telemetries'] as $telemetryInput) {

            // If the telemetry exists, update it, otherwise, create it
            if (array_key_exists('telemetry_id', $telemetryInput)) {
                $telemetry = $currentTelemetries->pull($telemetryInput['telemetry_id']);
                $telemetry->fill($telemetryInput);
                $telemetry->save();

            } else {
                $telemetry = new Telemetry($telemetryInput);
                $telemetry->mission()->associate($this->mission);
                $telemetry->save();
            }
        }

        // Delete any telemetry payloads
        if (!$currentTelemetries->isEmpty()) {
            Telemetry::whereIn('telemetry_id', $currentTelemetries->keys())->delete();
        }
    }

    public function getErrors() {
        return $this->errors;
    }
}