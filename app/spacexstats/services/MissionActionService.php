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
        //$vehicleValidation = $this->vehicle->isValid($input['vehicle']);

        //$missionValidation = true;
        //$usesValidation = $this->uses->isValid($input['uses']);

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
        $mission = Mission::create(array(
            'name' => $missionInput['name'],
            'launch_date_time' => $missionInput['launch'],
            'contractor' => $missionInput['contractor'],
            'vehicle_id' => $missionInput['vehicle_id'],
            'destination_id' => $missionInput['destination_id'],
            'launch_site_id' => $missionInput['launch_site_id'],
            'summary' => $missionInput['summary'],
            'status' => 'Upcoming',
            'upperstage_engine' => $missionInput['upperstage_engine']
        ));

        // Create the related vehicle
        $useInput = $input['use'];
        $use = Uses::create(array(
            'landing_site_id' => $useInput['landing_site_id'],
            'firststage_landing_legs' => $useInput['firststage_landing_legs'],
            'firststage_grid_fins' => $useInput['firststage_grid_fins'],
            'firststage_engine' => $useInput['firststage_engine'],
        ));

        $coreInput = $input['core'];
        $core = Core::create(array(
            'name' => $coreInput['name']
        ));

        // Create any payloads onboard
        if (isset($input['payloads'])) {
            $payloadInputs = $input['payloads'];
            $payloads = array();
            for ($i = 0; $i < count($payloadInputs); $i++) {
                $payloads[$i] = Payload::create(array(
                    'name' => $payloadInputs[$i]['name'],
                    'operator' => $payloadInputs[$i]['operator'],
                    'mass' => $payloadInputs[$i]['mass'],
                    'primary' => $payloadInputs[$i]['primary'],
                    'link' => $payloadInputs[$i]['link']
                ));
            }
        }

        // Add a spacecraft & spacecraft flight (naively assume no reuse for now)
        if (isset($input['payloads'])) {
            $spacecraftInput = $input['spacecraft'];
            $spacecraft = Spacecraft::create(array(
                'type' => $spacecraftInput['type'],
                'spacecraft_name' => $spacecraftInput['name']
            ));

            $spacecraftFlightInput = $input['spacecraft'];
            $spacecraftFlight = SpacecraftFlight::create(array(
                'flight_name' => $spacecraftFlightInput['name'],
                'return' => $spacecraftFlightInput['return'],
                'return_method' => $spacecraftFlightInput['return_method'],
                'upmass' => $spacecraftFlightInput['upmass'],
                'downmass' => $spacecraftFlightInput['downmass'],
                'iss_berth' => $spacecraftFlightInput['iss_berth'],
                'iss_unberth' => $spacecraftFlightInput['iss_unberth'],
            ));
        }

        // Hook up relationships
    }

    public function getErrors() {
        return $this->errors;
    }
}