<?php
namespace SpaceXStats\Services;

use \Mission;
use \Uses;
use \Core;
use \Payload;
use \Spacecraft;
use \SpacecraftFlight;

class MissionActionService implements ActionServiceInterface {
    protected $mission, $vehicle, $uses;

    protected $errors;

    public function __construct(\Mission $mission, \Vehicle $vehicle, \Uses $uses) {
        $this->mission = $mission;
        $this->vehicle = $vehicle;
        $this->uses = $uses;
    }

    public function isValid($input) {

        $missionValidation = $this->mission->isValid($input['mission']);

        if ($missionValidation === true) {
            return true;
        } else {
            $this->errors = $missionValidation;
            return false;
        }
    }

    public function create($input) {

        // Create the mission
        $missionInput = $input['mission'];
        $mission = Mission::create($missionInput);
        $mission->status = 'Upcoming';
        $mission->save();

        return $mission;
    }

    public function getErrors() {
        return $this->errors;
    }
}