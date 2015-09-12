<?php
namespace SpaceXStats\Managers;

use Carbon\Carbon;
use \Part;
use \Spacecraft;
use \PartFlight;
use \SpacecraftFlight;
use \Mission;
use \Astronaut;
use \AstronautFlight;
use \Payload;
use \PrelaunchEvent;

class MissionManager {
    private $input, $errors = [];
    private $mission;

    public function __construct(Mission $mission, Payload $payload, PartFlight $partFlight, Part $part, SpacecraftFlight $spacecraftFlight, Spacecraft $spacecraft, AstronautFlight $astronautFlight, Astronaut $astronaut) {
        $this->mission              = $mission;
        $this->payload              = $payload;
        $this->partFlight           = $partFlight;
        $this->part                 = $part;
        $this->spacecraftFlight     = $spacecraftFlight;
        $this->spacecraft           = $spacecraft;
        $this->astronautFlight      = $astronautFlight;
        $this->astronaut            = $astronaut;
    }

    public function isValid() {
        // Get the input
        $this->input = \Input::all();

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

        return empty($this->errors);
    }

    public function create() {
        // Create the mission
        DB::beginTransaction();
        try {
            $this->mission->fill($this->input('mission'));
            $this->mission->status = 'Upcoming';
            $this->mission->save();

            $this->createPayloadRelations();
            $this->createPartFlightRelations();
            $this->createSpacecraftFlightRelation();
            $this->createPrelaunchEventRelation();

            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
        }

        return $this->mission;
    }

    public function update() {

    }

    private function input($filter) {
        if ($filter == 'mission') {
            $mission = $this->input['mission'];
            unset($mission['payloads'], $mission['part_flights'], $mission['spacecraft_flight'], $mission['prelaunch_events']);
            return $mission;

        } else if ($filter == 'payloads') {
            return $this->input['mission']['payloads'];

        } else if ($filter == 'partFlights') {
            return $this->input['mission']['part_flights'];
        }
    }

    private function createPayloadRelations() {
        foreach ($this->input('payloads') as $payloadInput) {
            $payload = new Payload();
            $payload->fill($payloadInput);
            $payload->mission()->associate($this->mission);
            $payload->save();
        }
    }

    private function createPartFlightRelations() {
        foreach ($this->input('part_flights') as $partFlightInput) {

            $partFlight = new PartFlight();

            // Create part if it is not being reused or otherwise find it
            $part = array_key_exists('part_id', $partFlightInput['part']) ? Part::find($partFlightInput['part']['part_id']) : new Part();
            $part->fill($partFlightInput['part']);
            $part->save();

            $partFlight->part()->associate($part);
            $partFlight->mission()->associate($this->mission);
            $partFlight->save();
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

    private function createPrelaunchEventRelation() {
        $prelaunchEvent = new PrelaunchEvent();
        $prelaunchEvent->event = 'Announcement';
        $prelaunchEvent->occurred_at = Carbon::now();
        $prelaunchEvent->summary = 'Mission Created';
        $prelaunchEvent->mission()->associate($this->mission);
        $prelaunchEvent->save();
    }

    public function getErrors() {
        return $this->errors;
    }
}