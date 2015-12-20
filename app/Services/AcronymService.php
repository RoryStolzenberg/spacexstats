<?php
namespace SpaceXStats\Services;

class AcronymService
{
    protected $acronyms = [
        'ACS'   => 'Attitude Control System',
        'AGL'   => 'Above Ground Level',
        'AOS'   => 'Acquisition of Signal',
        'ASDS'  => 'Autonomous Spaceport Drone Ship',
        'AVI'   => 'Avionics Operator',
        'FTS'   => 'Flight Termination System',
        'GNC'   => 'Guidance, Navigation, & Control',
        'GTO'   => 'Geostationary Transfer Orbit',
        'JRTI'  => 'Just Read The Instructions',
        'LEO'   => 'Low Earth Orbit',
        'LES'   => 'Launch Escape System',
        'LOS'   => 'Loss of Signal',
        'LOX'   => 'Liquid Oxygen',
        'MECO'  => 'Main Engine Cutoff',
        'MEO'   => 'Mid Earth Orbit',
        'Max-Q' => 'Maximum Aerodynamic Pressure',
        'NET'   => 'No Earlier Than',
        'OCISLY'=> 'Of Course I Still Love You',
        'OSM'   => 'Operations Safety Manager',
        'PU'    => 'Propellant Utilization',
        'RCO'   => 'Range Control Officer',
        'RCS'   => 'Reaction Control System',
        'ROC'   => 'Range Operations Coordinator',
        'RP-1'  => 'Rocket Propellant 1',
        'RTLS'  => 'Return To Launch Site',
        'SECO'  => 'Second stage engine cutoff',
        'T/E'   => 'Transporter/Erector',
        'TDRSS' => 'Tracking Data and Relay Satellite System',
        'TVC'   => 'Thrust Vector Control'
    ];

    public function parseAndExpand($input, $replace = false) {

        if ($replace) {
            foreach ($this->acronyms as $acronym => $expansion) {
                $input = str_replace($acronym, $expansion, $input);
            }
        } else {
            foreach ($this->acronyms as $acronym => $expansion) {

                $escapedAcronym = str_replace('/','\/', $acronym);
                $escapedExpansion = str_replace('/', '\/', $expansion);

                $input = preg_replace('/('. $escapedAcronym . ')(?! \(' . $escapedExpansion . '\))/', $acronym . ' (' . $expansion . ')', $input);
            }
        }
        return $input;
    }
}