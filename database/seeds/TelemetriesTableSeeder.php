<?php
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use SpaceXStats\Models\Telemtry;

class AstronautsTableSeeder extends Seeder {
    public function run() {
        Telemetry::create([
            'mission_id'    => 8,
            'timestamp'     => 1,
            'readout'       => "Stage 1",
            'altitude'      => null,
            'velocity'      => null,
            'downrange'     => null
        ]);

        Telemetry::create([
            'mission_id'    => 8,
            'timestamp'     => 3,
            'readout'       => "We have liftoff of the Falcon 9",
            'altitude'      => null,
            'velocity'      => null,
            'downrange'     => null
        ]);

        Telemetry::create([
            'mission_id'    => 8,
            'timestamp'     => 8,
            'readout'       => "Falcon 9 has cleared the tower",
            'altitude'      => null,
            'velocity'      => null,
            'downrange'     => null
        ]);

        Telemetry::create([
            'mission_id'    => 8,
            'timestamp'     => 10,
            'readout'       => "Starting pitchkick",
            'altitude'      => null,
            'velocity'      => null,
            'downrange'     => null
        ]);

        Telemetry::create([
            'mission_id'    => 8,
            'timestamp'     => 24,
            'readout'       => "Starting gravity turn",
            'altitude'      => null,
            'velocity'      => null,
            'downrange'     => null
        ]);

        Telemetry::create([
            'mission_id'    => 8,
            'timestamp'     => 28,
            'readout'       => "First stage engines at full power, looking good",
            'altitude'      => null,
            'velocity'      => null,
            'downrange'     => null
        ]);

        Telemetry::create([
            'mission_id'    => 8,
            'timestamp'     => 39,
            'readout'       => "We have a solid telemetry link and power systems are nominal",
            'altitude'      => null,
            'velocity'      => null,
            'downrange'     => null
        ]);

        Telemetry::create([
            'mission_id'    => 8,
            'timestamp'     => 51,
            'readout'       => "First stage propellant utilization is active",
            'altitude'      => null,
            'velocity'      => null,
            'downrange'     => null
        ]);

        Telemetry::create([
            'mission_id'    => 8,
            'timestamp'     => 57,
            'readout'       => "Vehicle is on a nominal trajectory. Altitude 5.3 kilometres, velocity 225 metres per second, and downrange distance of 6 tenths of a kilometre.",
            'altitude'      => 5300,
            'velocity'      => 225,
            'downrange'     => 600
        ]);

        Telemetry::create([
            'mission_id'    => 8,
            'timestamp'     => 71,
            'readout'       => "Vehicle is supersonic",
            'altitude'      => null,
            'velocity'      => null,
            'downrange'     => null
        ]);

        Telemetry::create([
            'mission_id'    => 8,
            'timestamp'     => 83,
            'readout'       => "Vehicle has reached maximum aerodynamic pressure",
            'altitude'      => null,
            'velocity'      => null,
            'downrange'     => null
        ]);

        Telemetry::create([
            'mission_id'    => 8,
            'timestamp'     => 90,
            'readout'       => "Propulsion's performing nominally, starting stage two engine chill",
            'altitude'      => null,
            'velocity'      => null,
            'downrange'     => null
        ]);

        Telemetry::create([
            'mission_id'    => 8,
            'timestamp'     => 99,
            'readout'       => "We have a solid RF link and power systems are nominal",
            'altitude'      => null,
            'velocity'      => null,
            'downrange'     => null
        ]);

        Telemetry::create([
            'mission_id'    => 8,
            'timestamp'     => 118,
            'readout'       => "Vehicle's on a nominal trajectory, 30 kilometres altitude, 1 kilometre per second velocity, and downrange distance 20 kilometres",
            'altitude'      => 30000,
            'velocity'      => 1000,
            'downrange'     => 20000
        ]);

        Telemetry::create([
            'mission_id'    => 8,
            'timestamp'     => 129,
            'readout'       => "Dragon power systems are nominal",
            'altitude'      => null,
            'velocity'      => null,
            'downrange'     => null
        ]);

        Telemetry::create([
            'mission_id'    => 8,
            'timestamp'     => 147,
            'readout'       => "Vehicle's on a nominal trajectory, 53 kilometres altitude, 1.7 kilometres per second velocity, and a downrange distance of 51 kilometres",
            'altitude'      => 53000,
            'velocity'      => 1700,
            'downrange'     => 51000
        ]);

        Telemetry::create([
            'mission_id'    => 8,
            'timestamp'     => 160,
            'readout'       => "Approaching MECO 1",
            'altitude'      => null,
            'velocity'      => null,
            'downrange'     => null
        ]);

        Telemetry::create([
            'mission_id'    => 8,
            'timestamp'     => 170,
            'readout'       => "MECO 1. Planned shutdown on engines 1 and 9.",
            'altitude'      => null,
            'velocity'      => null,
            'downrange'     => null
        ]);

        Telemetry::create([
            'mission_id'    => 8,
            'timestamp'     => 175,
            'readout'       => "First stage impact point past min-MECO",
            'altitude'      => null,
            'velocity'      => null,
            'downrange'     => null
        ]);

        Telemetry::create([
            'mission_id'    => 8,
            'timestamp'     => 181,
            'readout'       => "MECO 2",
            'altitude'      => null,
            'velocity'      => null,
            'downrange'     => null
        ]);

        Telemetry::create([
            'mission_id'    => 8,
            'timestamp'     => 183,
            'readout'       => "Nominal velocity at MECO",
            'altitude'      => null,
            'velocity'      => null,
            'downrange'     => null
        ]);

        Telemetry::create([
            'mission_id'    => 8,
            'timestamp'     => 183,
            'readout'       => "Stage sep confirmed",
            'altitude'      => null,
            'velocity'      => null,
            'downrange'     => null
        ]);

        Telemetry::create([
            'mission_id'    => 8,
            'timestamp'     => 183,
            'readout'       => "MVac ignition confirmed",
            'altitude'      => null,
            'velocity'      => null,
            'downrange'     => null
        ]);

        Telemetry::create([
            'mission_id'    => 8,
            'timestamp'     => 183,
            'readout'       => "The Dragon uh- The Dragon nosecone has been jettisoned",
            'altitude'      => null,
            'velocity'      => null,
            'downrange'     => null
        ]);

        Telemetry::create([
            'mission_id'    => 8,
            'timestamp'     => 183,
            'readout'       => "Stage 2 propulsion systems nominal",
            'altitude'      => null,
            'velocity'      => null,
            'downrange'     => null
        ]);

        Telemetry::create([
            'mission_id'    => 8,
            'timestamp'     => 183,
            'readout'       => "Vehicle remains on a nominal trajectory, 176 kilometres altitude, velocity of 3 kilometres per second, downrange distance 320 kilometres",
            'altitude'      => 176000,
            'velocity'      => 3000,
            'downrange'     => 320000
        ]);

        Telemetry::create([
            'mission_id'    => 8,
            'timestamp'     => 183,
            'readout'       => "And power systems are nominal and we still have a solid telemetry link",
            'altitude'      => null,
            'velocity'      => null,
            'downrange'     => null
        ]);

        Telemetry::create([
            'mission_id'    => 8,
            'timestamp'     => 183,
            'readout'       => "OSM [?] this is LC, please move to net A.",
            'altitude'      => null,
            'velocity'      => null,
            'downrange'     => null
        ]);

        Telemetry::create([
            'mission_id'    => 8,
            'timestamp'     => 183,
            'readout'       => "Stage 2 propellant utilization is active",
            'altitude'      => null,
            'velocity'      => null,
            'downrange'     => null
        ]);

        Telemetry::create([
            'mission_id'    => 8,
            'timestamp'     => 183,
            'readout'       => "Vehicle remains on a nominal trajectory. 220 kilometres altitude, 3.4 kilometres per second, and downrange distance of 470 kilometre",
            'altitude'      => 220000,
            'velocity'      => 3400,
            'downrange'     => 470000
        ]);

        Telemetry::create([
            'mission_id'    => 8,
            'timestamp'     => 183,
            'readout'       => "Second stage propulsion performing as expected",
            'altitude'      => null,
            'velocity'      => null,
            'downrange'     => null
        ]);

        Telemetry::create([
            'mission_id'    => 8,
            'timestamp'     => 183,
            'readout'       => "Second stage power systems looking good and we have a solid telemetry link",
            'altitude'      => null,
            'velocity'      => null,
            'downrange'     => null
        ]);

        Telemetry::create([
            'mission_id'    => 8,
            'timestamp'     => 183,
            'readout'       => "Vehicle remains on a nominal trajectory. 269 kilometres in altitude, velocity of 4 kilometres per second, and a downrange distance of 712 kilometres",
            'altitude'      => 269000,
            'velocity'      => 4000,
            'downrange'     => 712000
        ]);

        Telemetry::create([
            'mission_id'    => 8,
            'timestamp'     => 183,
            'readout'       => "All stations MD, step uh- procedure 7 dot 1 0 0 complete, we're on uh- procedure 7 dot 1 0 1.",
            'altitude'      => null,
            'velocity'      => null,
            'downrange'     => null
        ]);

        Telemetry::create([
            'mission_id'    => 8,
            'timestamp'     => 183,
            'readout'       => "MVac and stage 2 performance is good",
            'altitude'      => null,
            'velocity'      => null,
            'downrange'     => null
        ]);

        Telemetry::create([
            'mission_id'    => 8,
            'timestamp'     => 183,
            'readout'       => "Vehicle remains on a nominal trajectory. 300 kilometres in altitude, velocity of 5 kilometres per second, and a downrange distance of 1000 kilometres; IMU sensor remains healthly, and GPS lock is verified",
            'altitude'      => 300000,
            'velocity'      => 5000,
            'downrange'     => 1000000
        ]);

        Telemetry::create([
            'mission_id'    => 8,
            'timestamp'     => 183,
            'readout'       => "And we are picking up data from New Hampshire",
            'altitude'      => null,
            'velocity'      => null,
            'downrange'     => null
        ]);

        Telemetry::create([
            'mission_id'    => 8,
            'timestamp'     => 183,
            'readout'       => "Vehicle's in terminal guidance",
            'altitude'      => null,
            'velocity'      => null,
            'downrange'     => null
        ]);

        Telemetry::create([
            'mission_id'    => 8,
            'timestamp'     => 183,
            'readout'       => "Vehicle has passed the European gate",
            'altitude'      => null,
            'velocity'      => null,
            'downrange'     => null
        ]);

        Telemetry::create([
            'mission_id'    => 8,
            'timestamp'     => 183,
            'readout'       => "FTS is safed",
            'altitude'      => null,
            'velocity'      => null,
            'downrange'     => null
        ]);

        Telemetry::create([
            'mission_id'    => 8,
            'timestamp'     => 183,
            'readout'       => "Roughly 30 seconds till Dragon sep",
            'altitude'      => null,
            'velocity'      => null,
            'downrange'     => null
        ]);

        Telemetry::create([
            'mission_id'    => 8,
            'timestamp'     => 183,
            'readout'       => "MVac shutdown confirmed",
            'altitude'      => null,
            'velocity'      => null,
            'downrange'     => null
        ]);

        Telemetry::create([
            'mission_id'    => 8,
            'timestamp'     => 183,
            'readout'       => "Dragon's in separation",
            'altitude'      => null,
            'velocity'      => null,
            'downrange'     => null
        ]);

        Telemetry::create([
            'mission_id'    => 8,
            'timestamp'     => 183,
            'readout'       => "Falcon 9 and Dragon are in orbit",
            'altitude'      => null,
            'velocity'      => null,
            'downrange'     => null
        ]);

        Telemetry::create([
            'mission_id'    => 8,
            'timestamp'     => 183,
            'readout'       => "Dragon's in separation state",
            'altitude'      => null,
            'velocity'      => null,
            'downrange'     => null
        ]);

        Telemetry::create([
            'mission_id'    => 8,
            'timestamp'     => 183,
            'readout'       => "[inaudible] prime",
            'altitude'      => null,
            'velocity'      => null,
            'downrange'     => null
        ]);

        Telemetry::create([
            'mission_id'    => 8,
            'timestamp'     => 183,
            'readout'       => "[inaudible]",
            'altitude'      => null,
            'velocity'      => null,
            'downrange'     => null
        ]);

        Telemetry::create([
            'mission_id'    => 8,
            'timestamp'     => 183,
            'readout'       => "All stations continue procedures on 7 1 dot-",
            'altitude'      => null,
            'velocity'      => null,
            'downrange'     => null
        ]);

        Telemetry::create([
            'mission_id'    => 8,
            'timestamp'     => 183,
            'readout'       => "Apogee 346 kilometres, perigee 297 kilometres",
            'altitude'      => null,
            'velocity'      => null,
            'downrange'     => null
        ]);

        Telemetry::create([
            'mission_id'    => 8,
            'timestamp'     => 183,
            'readout'       => "Inclination 51.66 degrees",
            'altitude'      => null,
            'velocity'      => null,
            'downrange'     => null
        ]);

        Telemetry::create([
            'mission_id'    => 8,
            'timestamp'     => 183,
            'readout'       => "Cameras forward",
            'altitude'      => null,
            'velocity'      => null,
            'downrange'     => null
        ]);

        Telemetry::create([
            'mission_id'    => 8,
            'timestamp'     => 183,
            'readout'       => "Dragon sep",
            'altitude'      => null,
            'velocity'      => null,
            'downrange'     => null
        ]);

        Telemetry::create([
            'mission_id'    => 8,
            'timestamp'     => 183,
            'readout'       => "Start of payload settling deploy",
            'altitude'      => null,
            'velocity'      => null,
            'downrange'     => null
        ]);

        Telemetry::create([
            'mission_id'    => 8,
            'timestamp'     => 183,
            'readout'       => "Dragon is now freeflying in orbit around the Earth, we are very excited, if we maintain video coverage we hope to see deployment of the solar arrays, if we loose video, everything is likely still operating nominally, we're just at the limit of our signal. We have about a minute before the fairings that house the solar arrays are going to jettison, and that is going to automatically trigger their deployment. Right now the Dragon's propellant system's priming itself, and the thrusters are going to fire, and then it will- uh oh. Hopefully we can hold signal here. Boy, we have just about 40 seconds to wait for this. Let's see if we can't hold our signal and watch these solar arrays deploy.",
            'altitude'      => null,
            'velocity'      => null,
            'downrange'     => null
        ]);

        Telemetry::create([
            'mission_id'    => 8,
            'timestamp'     => 183,
            'readout'       => "Solar array deploy attitude",
            'altitude'      => null,
            'velocity'      => null,
            'downrange'     => null
        ]);

        Telemetry::create([
            'mission_id'    => 8,
            'timestamp'     => 183,
            'readout'       => "Confirm Draco thruster firings",
            'altitude'      => null,
            'velocity'      => null,
            'downrange'     => null
        ]);

        Telemetry::create([
            'mission_id'    => 8,
            'timestamp'     => 183,
            'readout'       => "Attitude looks good",
            'altitude'      => null,
            'velocity'      => null,
            'downrange'     => null
        ]);

        Telemetry::create([
            'mission_id'    => 8,
            'timestamp'     => 183,
            'readout'       => "Dragon is in array deploy",
            'altitude'      => null,
            'velocity'      => null,
            'downrange'     => null
        ]);

        Telemetry::create([
            'mission_id'    => 8,
            'timestamp'     => 183,
            'readout'       => "Props is nominal",
            'altitude'      => null,
            'velocity'      => null,
            'downrange'     => null
        ]);

        Telemetry::create([
            'mission_id'    => 8,
            'timestamp'     => 183,
            'readout'       => "Dragon solar array deployment confirmed",
            'altitude'      => null,
            'velocity'      => null,
            'downrange'     => null
        ]);

        Telemetry::create([
            'mission_id'    => 8,
            'timestamp'     => 183,
            'readout'       => "New Foundland AOS",
            'altitude'      => null,
            'velocity'      => null,
            'downrange'     => null
        ]);

        Telemetry::create([
            'mission_id'    => 8,
            'timestamp'     => 183,
            'readout'       => "Solar array deployment!",
            'altitude'      => null,
            'velocity'      => null,
            'downrange'     => null
        ]);

        Telemetry::create([
            'mission_id'    => 8,
            'timestamp'     => 183,
            'readout'       => "Solar array deployment!",
            'altitude'      => null,
            'velocity'      => null,
            'downrange'     => null
        ]);
    }
}