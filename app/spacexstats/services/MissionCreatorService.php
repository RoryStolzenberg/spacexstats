<?php
namespace SpaceXStats\Services;

class MissionCreatorService {
    private $input, $errors;

    private $mission;

    public function __construct(\Mission $mission) {
        $this->mission = $mission;
    }

    public function isValid() {
        $this->input = \Input::get('data');

        $validators = [];
        $validation['missionValidation'] = $this->mission->isValid($this->input['mission']);
        foreach ($this->input['partFlights'] as $partFlight) {

        }

        if ($missionValidation === true) {
            return true;
        } else {
            $this->errors = $missionValidation;
            return false;
        }
    }

    public function create() {
        // Create the mission
        $missionInput = $this->input['mission'];
        $mission = \Mission::create($missionInput);
        $mission->status = 'Upcoming';
        $mission->save();

        return $mission;
    }

    private function createPartRelations() {

    }

    private function createSpacecraftRelation() {

    }

    public function getErrors() {
        return $this->errors;
    }
}