<?php
namespace SpaceXStats\Services;

class MissionCreator {
    private $input, $errors = [];

    private $relatedModels = ['payloads', 'partFlights', 'spacecraftFlight'];

    private $mission;

    public function __construct(\Mission $mission, \Payload $payload, \PartFlight $partFlight, \Part $part, \SpacecraftFlight $spacecraftFlight, \Spacecraft $spacecraft, \AstronautFlight $astronautFlight, \Astronaut $astronaut) {
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
        $missionValidity = $this->mission->isValid($this->input['mission']);
        if ($missionValidity !== true) {
            $this->errors[] = $missionValidity;
        }

        // Validate any payload models
        if (array_key_exists('payloads', $this->input['mission'])) {

            $payloads = $this->input['mission']['payloads'];

            foreach ($payloads as $payload) {
                $payloadValidity = $this->payload->isValid($payload);
                if ($payloadValidity !== true) {
                    $this->errors['payloads'][] = $payloadValidity;
                }
            }
        }

        // Validate any partFlight models
        $partFlights = $this->input['mission']['partFlights'];
        foreach ($partFlights as $partFlight) {

            $partFlightValidity = $this->partFlight->isValid($partFlight);
            if ($partFlightValidity !== true) {
                $this->errors['partFlights'][] = $partFlightValidity;
            }

            // Validate the part model
            $partValidity = $this->part->isValid($partFlight['part']);
            if ($partValidity !== true) {
                $this->errors['parts'][] = $partValidity;
            }
        }

        // Validate the spacecraftFlight model
        if (array_key_exists('spacecraftFlight', $this->input['mission'])) {
            $spacecraftFlight = $this->input['mission']['spacecraftFlight'];

            $spacecraftFlightValidity = $this->spacecraftFlight->isValid($spacecraftFlight);
            if ($spacecraftFlightValidity !== true) {
                $this->errors['spacecraftFlight'][] = $spacecraftFlightValidity;
            }

            // Validate the spacecraft model
            $spacecraftValidity = $this->spacecraft->isValid($spacecraftFlight['spacecraft']);
            if ($spacecraftValidity !== true) {
                $this->errors['spacecraft'][] = $spacecraftValidity;
            }

            // Validate any astronaut flights model
            if (array_key_exists('astronautFlights', $spacecraftFlight)) {
                foreach ($spacecraftFlight['astronautFlights'] as $astronautFlight)
                {
                    $astronautFlightValidity = $this->astronautFlight->isValid($astronautFlight);
                    if ($astronautFlightValidity !== true) {
                        $this->errors['astronautFlights'][] = $astronautFlightValidity;
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
        \DB::transaction(function() {
            $this->mission->fill($this->input['mission']);
            $this->mission->status = 'Upcoming';
            $this->mission->save();

            $this->createPayloadRelations();
        });

        return $this->mission;
    }

    private function createPayloadRelations() {
        foreach ($this->input['payloads'] as $payloadInput) {
            $payload = new \Payload();
            $payload->fill($payloadInput);
            $payload->mission()->associate($this->mission);
        }
    }

    private function createSpacecraftRelation() {

    }

    public function getErrors() {
        return $this->errors;
    }
}