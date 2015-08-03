<?php
namespace SpaceXStats\Services;

class MissionCreatorService {
    private $input, $errors = [];

    private $mission;

    public function __construct(\Mission $mission) {
        $this->mission = $mission;
    }

    public function isValid() {
        $input = \Input::get('data');
        $this->input['payloads'] = array_pull($input, 'payloads');
        $this->input['partFlights'] = array_pull($input, 'partFlights');
        $this->input['spacecraftFlight'] = array_pull($input, 'spacecraftFlight');
        $this->input['mission'] = $input;

        $validators = [];
        $validators['missionValidation'] = $this->mission->isValid($this->input['mission']);
        foreach ($this->input['payloads'] as $payload) {
            $validators['payloadValidation'] = $this->payload->isValid($payload);
        }

        foreach ($validators as $validator) {
            if ($validator !== true) {
                $this->errors = array_merge($this->errors, $validator->toArray());
            }
        }

        if (empty($this->errors)) {
            return true;
        } else {
            return false;
        }
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