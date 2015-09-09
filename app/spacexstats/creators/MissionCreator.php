<?php
namespace SpaceXStats\Services;

class MissionCreator {
    private $input, $errors = [];

    private $relatedModels = ['payloads', 'partFlights', 'spacecraftFlight'];

    private $mission;

    public function __construct(\Mission $mission, \Payload $payload, \PartFlight $partFlight, \Part $part, \SpacecraftFlight $spacecraftFlight, \Spacecraft $spacecraft, \AstronautFlight $astronautFlight, \Astronaut $astronaut) {
        $this->mission              = $mission;
        $this->payloads             = $payload;
        $this->partFlights          = $partFlight;
        $this->part                 = $part;
        $this->spacecraftFlight     = $spacecraftFlight;
        $this->spacecraft           = $spacecraft;
        $this->astronautFlights     = $astronautFlight;
        $this->astronaut            = $astronaut;
    }

    public function isValid() {
        // Get the input
        $this->input = \Input::all();
        $validators = [];

        // Validate the mission model
        $validators['mission'] = $this->mission->isValid($this->input['mission']);

        foreach ($this->input['mission'] as $model)

        // Walk through the array and check if any models are invalid
        array_walk_recursive($this->input['mission'], function($element, $index) {
        });

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

    private function

    public function getErrors() {
        return $this->errors;
    }
}