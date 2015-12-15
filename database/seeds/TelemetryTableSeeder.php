<?php
use Illuminate\Database\Seeder;
use SpaceXStats\Models\Telemetry;

class TelemetryTableSeeder extends Seeder {
    public function run() {
        $this->Falcon1Flight1();
        $this->Falcon1Flight2();
        $this->Falcon1Flight3();
        $this->Falcon1Flight4();
        $this->Falcon1Flight5();
        $this->DSQU();
        $this->COTS1();
        $this->COTS2Plus();
        $this->CRS1();
        $this->CRS2();
        //$this->CASSIOPE();
        $this->SES8();
    }

    public function Falcon1Flight1() {
        Telemetry::create([
            'mission_id'    => 1,
            'timestamp'     => 0,
            'readout'       => '0'
        ]);
        Telemetry::create([
            'mission_id'    => 1,
            'timestamp'     => 1,
            'readout'       => 'Plus One'
        ]);
        Telemetry::create([
            'mission_id'    => 1,
            'timestamp'     => 2,
            'readout'       => 'Plus Two'
        ]);
        Telemetry::create([
            'mission_id'    => 1,
            'timestamp'     => 3,
            'readout'       => 'Plus Three'
        ]);
        Telemetry::create([
            'mission_id'    => 1,
            'timestamp'     => 4,
            'readout'       => 'Plus Four'
        ]);
        Telemetry::create([
            'mission_id'    => 1,
            'timestamp'     => 5,
            'readout'       => 'Plus Five'
        ]);
        Telemetry::create([
            'mission_id'    => 1,
            'timestamp'     => 6,
            'readout'       => 'Plus Six'
        ]);
        Telemetry::create([
            'mission_id'    => 1,
            'timestamp'     => 7,
            'readout'       => 'Plus Seven'
        ]);
        Telemetry::create([
            'mission_id'    => 1,
            'timestamp'     => 8,
            'readout'       => 'Plus Eight'
        ]);
        Telemetry::create([
            'mission_id'    => 1,
            'timestamp'     => 9,
            'readout'       => 'Plus Nine'
        ]);
        Telemetry::create([
            'mission_id'    => 1,
            'timestamp'     => 10,
            'readout'       => 'Plus Ten'
        ]);
        Telemetry::create([
            'mission_id'    => 1,
            'timestamp'     => 13,
            'readout'       => 'We have liftoff confirmed'
        ]);
        Telemetry::create([
            'mission_id'    => 1,
            'timestamp'     => 16,
            'readout'       => 'Copy'
        ]);
        Telemetry::create([
            'mission_id'    => 1,
            'timestamp'     => 18,
            'readout'       => 'Good signal strength'
        ]);
        Telemetry::create([
            'mission_id'    => 1,
            'timestamp'     => 25,
            'readout'       => 'This is the LC on the countdown net, Falcon 1 is airborne at this time.'
        ]);
    }

    public function Falcon1Flight2() {
        Telemetry::create([
            'mission_id'    => 2,
            'timestamp'     => 5,
            'readout'       => 'We have liftoff'
        ]);
        Telemetry::create([
            'mission_id'    => 2,
            'timestamp'     => 6,
            'readout'       => 'And we have liftoff'
        ]);
        Telemetry::create([
            'mission_id'    => 2,
            'timestamp'     => 11,
            'readout'       => 'Falcon has cleared the tower'
        ]);
        Telemetry::create([
            'mission_id'    => 2,
            'timestamp'     => 19,
            'readout'       => 'Pitchover'
        ]);
        Telemetry::create([
            'mission_id'    => 2,
            'timestamp'     => 20,
            'readout'       => 'First stage engine performance nominal'
        ]);
        Telemetry::create([
            'mission_id'    => 2,
            'timestamp'     => 40,
            'readout'       => 'Velocity 128 metres per second, altitude 2.6 kilometres.',
            'velocity'      => 128,
            'altitude'      => 2600
        ]);
        Telemetry::create([
            'mission_id'    => 2,
            'timestamp'     => 46,
            'readout'       => 'Guidance nominal'
        ]);
        Telemetry::create([
            'mission_id'    => 2,
            'timestamp'     => 49,
            'readout'       => 'Kwajalein RF telemetry lock nominal'
        ]);
        Telemetry::create([
            'mission_id'    => 2,
            'timestamp'     => 59,
            'readout'       => 'First stage engine performance nominal'
        ]);
        Telemetry::create([
            'mission_id'    => 2,
            'timestamp'     => 62,
            'readout'       => 'Nominal velocity'
        ]);
        Telemetry::create([
            'mission_id'    => 2,
            'timestamp'     => 76,
            'readout'       => 'Max-Q'
        ]);
        Telemetry::create([
            'mission_id'    => 2,
            'timestamp'     => 79,
            'readout'       => "Vehicle's passing through Max-Q"
        ]);
        Telemetry::create([
            'mission_id'    => 2,
            'timestamp'     => 84,
            'readout'       => 'Velocity 450 metres per second, altitide 13.9 kilometres',
            'velocity'      => 450,
            'altitude'      => 13900
        ]);
        Telemetry::create([
            'mission_id'    => 2,
            'timestamp'     => 100,
            'readout'       => 'Kwajalein RF telemetry lock nominal'
        ]);
        Telemetry::create([
            'mission_id'    => 2,
            'timestamp'     => 110,
            'readout'       => 'First stage engine performance nominal'
        ]);
        Telemetry::create([
            'mission_id'    => 2,
            'timestamp'     => 125,
            'readout'       => 'Guidance nominal'
        ]);
        Telemetry::create([
            'mission_id'    => 2,
            'timestamp'     => 129,
            'readout'       => 'Telemetry lock nominal'
        ]);
        Telemetry::create([
            'mission_id'    => 2,
            'timestamp'     => 149,
            'readout'       => 'Merlin engine performance nominal'
        ]);
        Telemetry::create([
            'mission_id'    => 2,
            'timestamp'     => 165,
            'readout'       => 'Coming up on stage separation'
        ]);
        Telemetry::create([
            'mission_id'    => 2,
            'timestamp'     => 172,
            'readout'       => '[inaudible] [cheering] Stages are separated!'
        ]);
        Telemetry::create([
            'mission_id'    => 2,
            'timestamp'     => 177,
            'readout'       => 'Second stage ignition confirmed'
        ]);
        Telemetry::create([
            'mission_id'    => 2,
            'timestamp'     => 189,
            'readout'       => 'Second stage engine ignition nominal'
        ]);
        Telemetry::create([
            'mission_id'    => 2,
            'timestamp'     => 191,
            'readout'       => 'Coming up on fairing separation'
        ]);
        Telemetry::create([
            'mission_id'    => 2,
            'timestamp'     => 198,
            'readout'       => 'Fairing separaton is confirmed'
        ]);
        Telemetry::create([
            'mission_id'    => 2,
            'timestamp'     => 201,
            'readout'       => 'copy'
        ]);
        Telemetry::create([
            'mission_id'    => 2,
            'timestamp'     => 202,
            'readout'       => 'Fairing sep confirmed'
        ]);
        Telemetry::create([
            'mission_id'    => 2,
            'timestamp'     => 206,
            'readout'       => 'Vehicle velocity is 2634 metres per second, altitude 117 kilometres',
            'velocity'      => 2634,
            'altitude'      => 117000
        ]);
        Telemetry::create([
            'mission_id'    => 2,
            'timestamp'     => 212,
            'readout'       => 'Second stage engine performance nominal'
        ]);
        Telemetry::create([
            'mission_id'    => 2,
            'timestamp'     => 236,
            'readout'       => 'Second stage engine performance nominal'
        ]);
        Telemetry::create([
            'mission_id'    => 2,
            'timestamp'     => 241,
            'readout'       => 'yeah, guidance nominal too'
        ]);
        Telemetry::create([
            'mission_id'    => 2,
            'timestamp'     => 252,
            'readout'       => 'yep, velocity 2778 metres per second, altitude 161 kilometres down',
            'velocity'      => 2778,
            'altitude'      => 161000
        ]);
    }

    public function Falcon1Flight3() {
        Telemetry::create([
            'mission_id'    => 3,
            'timestamp'     => 1,
            'readout'       => 'We have liftoff'
        ]);
        Telemetry::create([
            'mission_id'    => 3,
            'timestamp'     => 2,
            'readout'       => 'We have liftoff of the SpaceX Falcon 1 launch vehicle. Falcon has cleared the tower.'
        ]);
        Telemetry::create([
            'mission_id'    => 3,
            'timestamp'     => 15,
            'readout'       => 'Plus Fifteen seconds'
        ]);
        Telemetry::create([
            'mission_id'    => 3,
            'timestamp'     => 16,
            'readout'       => 'Pitchover'
        ]);
        Telemetry::create([
            'mission_id'    => 3,
            'timestamp'     => 21,
            'readout'       => 'Plus Twenty seconds'
        ]);
        Telemetry::create([
            'mission_id'    => 3,
            'timestamp'     => 24,
            'readout'       => 'Velocity is 95 metres per second. Altitude is 1.4 kilometres.',
            'altitude'       => 1400,
            'velocity'      => 95
        ]);
        Telemetry::create([
            'mission_id'    => 3,
            'timestamp'     => 32,
            'readout'       => 'T plus thirty seconds'
        ]);
        Telemetry::create([
            'mission_id'    => 3,
            'timestamp'     => 41,
            'readout'       => 'This is the AVI, vehicle systems are nominal'
        ]);
        Telemetry::create([
            'mission_id'    => 3,
            'timestamp'     => 44,
            'readout'       => 'First stage propulsion is nominal'
        ]);
        Telemetry::create([
            'mission_id'    => 3,
            'timestamp'     => 46,
            'readout'       => 'Guidance nominal'
        ]);
        Telemetry::create([
            'mission_id'    => 3,
            'timestamp'     => 50,
            'readout'       => 'Approaching Mach 1'
        ]);
        Telemetry::create([
            'mission_id'    => 3,
            'timestamp'     => 54,
            'readout'       => 'Mach 1'
        ]);
        Telemetry::create([
            'mission_id'    => 3,
            'timestamp'     => 62,
            'readout'       => 'Falcon 1 is supersonic at this time.'
        ]);
        Telemetry::create([
            'mission_id'    => 3,
            'timestamp'     => 68,
            'readout'       => 'Approaching Max-Q'
        ]);
        Telemetry::create([
            'mission_id'    => 3,
            'timestamp'     => 70,
            'readout'       => 'Max-Q'
        ]);
        Telemetry::create([
            'mission_id'    => 3,
            'timestamp'     => 73,
            'readout'       => '[inaudible]'
        ]);
        Telemetry::create([
            'mission_id'    => 3,
            'timestamp'     => 80,
            'readout'       => 'T plus 1 minute and 20 seconds. Relative velocity 5- 600 metres per second, altitude 18.5 kilometres',
            'velocity'      => 600,
            'altitude'      => 18500
        ]);
        Telemetry::create([
            'mission_id'    => 3,
            'timestamp'     => 96,
            'readout'       => '[inaudible] safed'
        ]);
        Telemetry::create([
            'mission_id'    => 3,
            'timestamp'     => 100,
            'readout'       => 'T plus 1 minute 40 seconds. The vehicle is headed downrange a velocity of 1050 metres per second and an altitude of 35 kilometres',
            'velocity'      => 1050,
            'altitude'      => 35000
        ]);
        Telemetry::create([
            'mission_id'    => 3,
            'timestamp'     => 146,
            'readout'       => "Uhh. We are hearing from the launch control center that there has been an anomaly on the vehicle, we don't have any information about what that anomaly is at this time. Uhh, we will of course be doing an assessment situation and providing information as soon as it becomes available. Uhh, check back to the website www.spacex.com for the latest information"
        ]);
    }

    public function Falcon1Flight4() {
        Telemetry::create([
            'mission_id'    => 4,
            'timestamp'     => 2,
            'readout'       => "We're in stage 1"
        ]);
        Telemetry::create([
            'mission_id'    => 4,
            'timestamp'     => 2,
            'readout'       => "And we're flying"
        ]);
        Telemetry::create([
            'mission_id'    => 4,
            'timestamp'     => 2,
            'readout'       => 'We have liftoff indication'
        ]);
        Telemetry::create([
            'mission_id'    => 4,
            'timestamp'     => 5,
            'readout'       => 'We have liftoff'
        ]);
        Telemetry::create([
            'mission_id'    => 4,
            'timestamp'     => 8,
            'readout'       => 'SpaceX Falcon 1 launch vehicle, Falcon has cleared the tower'
        ]);
        Telemetry::create([
            'mission_id'    => 4,
            'timestamp'     => 13,
            'readout'       => 'Plus twelve'
        ]);
        Telemetry::create([
            'mission_id'    => 4,
            'timestamp'     => 16,
            'readout'       => 'Pitchkick'
        ]);
        Telemetry::create([
            'mission_id'    => 4,
            'timestamp'     => 22,
            'readout'       => 'Plus twenty seconds'
        ]);
        Telemetry::create([
            'mission_id'    => 4,
            'timestamp'     => 29,
            'readout'       => '[inaudible] transonic [inaudible]'
        ]);
        Telemetry::create([
            'mission_id'    => 4,
            'timestamp'     => 50,
            'readout'       => 'Vehicle now [inaudible] nominal, gravity turn'
        ]);
        Telemetry::create([
            'mission_id'    => 4,
            'timestamp'     => 58,
            'readout'       => 'Power systems nominal'
        ]);
        Telemetry::create([
            'mission_id'    => 4,
            'timestamp'     => 61,
            'readout'       => 'T plus sixty seconds'
        ]);
        Telemetry::create([
            'mission_id'    => 4,
            'timestamp'     => 71,
            'readout'       => 'Got Max-Q'
        ]);
        Telemetry::create([
            'mission_id'    => 4,
            'timestamp'     => 80,
            'readout'       => 'First stage propulsion performance is nominal'
        ]);
        Telemetry::create([
            'mission_id'    => 4,
            'timestamp'     => 82,
            'readout'       => 'Vehicle has a velocity of 630 metres per second and an altitude of 19 kilometres',
            'velocity'      => 630,
            'altitude'      => 19000
        ]);
        Telemetry::create([
            'mission_id'    => 4,
            'timestamp'     => 84,
            'readout'       => 'You can see the plume of the vehicle- the plume of the engine expanding as we get into more rareified atmosphere'
        ]);
        Telemetry::create([
            'mission_id'    => 4,
            'timestamp'     => 95,
            'readout'       => "It also gets blacker as there's less and less oxygen to support post-combustion"
        ]);
        Telemetry::create([
            'mission_id'    => 4,
            'timestamp'     => 102,
            'readout'       => 'Vehicle has a current velocity of 1000 metres per second and an altitude of 32 kilometres',
            'velocity'      => 1000,
            'altitude'      => 32000
        ]);
        Telemetry::create([
            'mission_id'    => 4,
            'timestamp'     => 121,
            'readout'       => 'T plus two minutes'
        ]);
        Telemetry::create([
            'mission_id'    => 4,
            'timestamp'     => 123,
            'readout'       => 'Vehicle is down- has an altitude of 50 kilometres, a velocity of 1700 metres per second',
            'velocity'      => 1700,
            'altitude'      => 50000
        ]);
        Telemetry::create([
            'mission_id'    => 4,
            'timestamp'     => 134,
            'readout'       => 'First stage performance still nominal'
        ]);
        Telemetry::create([
            'mission_id'    => 4,
            'timestamp'     => 138,
            'readout'       => 'We are approaching Main Engine Cutoff'
        ]);
        Telemetry::create([
            'mission_id'    => 4,
            'timestamp'     => 143,
            'readout'       => "There'll be a five second delay before stage separation"
        ]);
        Telemetry::create([
            'mission_id'    => 4,
            'timestamp'     => 146,
            'readout'       => '[inaudible]'
        ]);
        Telemetry::create([
            'mission_id'    => 4,
            'timestamp'     => 152,
            'readout'       => 'Second stage tank stable'
        ]);
        Telemetry::create([
            'mission_id'    => 4,
            'timestamp'     => 155,
            'readout'       => 'MECO'
        ]);
        Telemetry::create([
            'mission_id'    => 4,
            'timestamp'     => 160,
            'readout'       => 'Stage separation confirmed!'
        ]);
        Telemetry::create([
            'mission_id'    => 4,
            'timestamp'     => 163,
            'readout'       => 'And Kestrel ignition'
        ]);
        Telemetry::create([
            'mission_id'    => 4,
            'timestamp'     => 167,
            'readout'       => 'Perfect'
        ]);
        Telemetry::create([
            'mission_id'    => 4,
            'timestamp'     => 168,
            'readout'       => 'Second stage [inaudible]'
        ]);
        Telemetry::create([
            'mission_id'    => 4,
            'timestamp'     => 168,
            'readout'       => 'Capture manouver'
        ]);
        Telemetry::create([
            'mission_id'    => 4,
            'timestamp'     => 170,
            'readout'       => 'You can hear the cheers in the background'
        ]);
        Telemetry::create([
            'mission_id'    => 4,
            'timestamp'     => 171,
            'readout'       => 'There goes the stiffening bands'
        ]);
        Telemetry::create([
            'mission_id'    => 4,
            'timestamp'     => 172,
            'readout'       => '[inadible]'
        ]);
        Telemetry::create([
            'mission_id'    => 4,
            'timestamp'     => 177,
            'readout'       => 'You can see the limb of the Earth in the upper left side of the screen'
        ]);
        Telemetry::create([
            'mission_id'    => 4,
            'timestamp'     => 180,
            'readout'       => 'T plus three minutes we have a relative velocity of 2770 metres per second and an altitude of 130 kilometres',
            'velocity'      => 2770,
            'altitude'      => 130000
        ]);
        Telemetry::create([
            'mission_id'    => 4,
            'timestamp'     => 184,
            'readout'       => 'The Kestrel engine will burn for more than six minutes in the ride to orbit, here we see the fairing separation'
        ]);
        Telemetry::create([
            'mission_id'    => 4,
            'timestamp'     => 189,
            'readout'       => 'Approaching fairing sep'
        ]);
        Telemetry::create([
            'mission_id'    => 4,
            'timestamp'     => 193,
            'readout'       => 'There goes the fairing'
        ]);
        Telemetry::create([
            'mission_id'    => 4,
            'timestamp'     => 193,
            'readout'       => 'Fairing separation confirmed'
        ]);
        Telemetry::create([
            'mission_id'    => 4,
            'timestamp'     => 206,
            'readout'       => 'Second stage propulsion performance is nominal'
        ]);
        Telemetry::create([
            'mission_id'    => 4,
            'timestamp'     => 212,
            'readout'       => "We're at three minutes and thirty seconds into the flight, we have a relative velocity of 2800 metres per second and an altitude of 170 kilometres",
            'altitude'      => 170000,
            'velocity'      => 2800
        ]);
        Telemetry::create([
            'mission_id'    => 4,
            'timestamp'     => 225,
            'readout'       => 'Second stage guidance is nominal'
        ]);
        Telemetry::create([
            'mission_id'    => 4,
            'timestamp'     => 241,
            'readout'       => 'T plus four minutes'
        ]);
        Telemetry::create([
            'mission_id'    => 4,
            'timestamp'     => 244,
            'readout'       => "We're at T plus four minutes. We have a relative velocity of approximately 3000 metres per second and an altitude of 200 kilometres",
            'altitude'      => 200000,
            'velocity'      => 3000
        ]);
        Telemetry::create([
            'mission_id'    => 4,
            'timestamp'     => 266,
            'readout'       => "You can see the Kestrel nozzle glowing a dull red. It's actually designed to glow almost white-hot if necessary"
        ]);
        Telemetry::create([
            'mission_id'    => 4,
            'timestamp'     => 287,
            'readout'       => "Very steady attitude we're seeing"
        ]);
        Telemetry::create([
            'mission_id'    => 4,
            'timestamp'     => 300,
            'readout'       => "We're at T plus five minutes. We have a relative velocity of approximately 3200 metres per second and an altitude of 253 kilometres. All systems are nominal",
            'altitude'      => 253000,
            'velocity'      => 3200
        ]);
        Telemetry::create([
            'mission_id'    => 4,
            'timestamp'     => 333,
            'readout'       => "About four minutes remaining in the second stage burn."
        ]);
        Telemetry::create([
            'mission_id'    => 4,
            'timestamp'     => 359,
            'readout'       => "We're at T plus six minutes. Vehicle velocity is approximately 3600 metres per second and an altitude of 290 kilometres",
            'altitude'      => 290000,
            'velocity'      => 3600
        ]);
        Telemetry::create([
            'mission_id'    => 4,
            'timestamp'     => 399,
            'readout'       => "The vast majority of the acceleration occurs during this latter half of the second stage burn, as the mass of the vehicle- the propellant load, decreases"
        ]);
        Telemetry::create([
            'mission_id'    => 4,
            'timestamp'     => 419,
            'readout'       => "We're at T plus seven minutes we have a relative velocity of 4200 metres per second, and an altitude of 315 kilometres. We're beginning to lose stage 1 telemetry",
            'altitude'      => 315000,
            'velocity'      => 4200
        ]);
        Telemetry::create([
            'mission_id'    => 4,
            'timestamp'     => 443,
            'readout'       => "Second stage propulsion is performing nominally"
        ]);
        Telemetry::create([
            'mission_id'    => 4,
            'timestamp'     => 450,
            'readout'       => "Guidance is performing nominally"
        ]);
        Telemetry::create([
            'mission_id'    => 4,
            'timestamp'     => 480,
            'readout'       => "We're at T plus eight minutes with a relative velocity of 5200 metres per second and an altitude of 328 kilometres",
            'altitude'      => 328000,
            'velocity'      => 5200
        ]);
        Telemetry::create([
            'mission_id'    => 4,
            'timestamp'     => 481,
            'readout'       => "We are getting very close to orbital velocity"
        ]);
        Telemetry::create([
            'mission_id'    => 4,
            'timestamp'     => 8 * 60 + 32,
            'readout'       => "We appear to have loss of signal. This is not necessarily a bad thing, we were expecting to lose signal sometime around here. It can be highly variable depending on the weather conditions at the time. So, we of course want to see what happens over the next sixty seconds. We were about sixty seconds away from a nominal shutdown. We will be getting back to you as soon as we have more information."
        ]);
        Telemetry::create([
            'mission_id'    => 4,
            'timestamp'     => 9 * 60 + 14,
            'readout'       => "-telemetry and video."
        ]);
        Telemetry::create([
            'mission_id'    => 4,
            'timestamp'     => 9 * 60 + 28,
            'readout'       => "9 minutes 30 seconds"
        ]);
        Telemetry::create([
            'mission_id'    => 4,
            'timestamp'     => 9 * 60 + 30,
            'readout'       => "Second stage approaching SECO"
        ]);
        Telemetry::create([
            'mission_id'    => 4,
            'timestamp'     =>  9 * 60 + 31,
            'readout'       => "And that would be a nominal SECO!"
        ]);
        Telemetry::create([
            'mission_id'    => 4,
            'timestamp'     =>  9 * 60 + 35,
            'readout'       => "SECO confirmed!"
        ]);
        Telemetry::create([
            'mission_id'    => 4,
            'timestamp'     =>  9 * 60 + 39,
            'readout'       => "Which means Falcon 1 has made history as the first privately developed launch vehicle to reach orbit from the ground"
        ]);
        Telemetry::create([
            'mission_id'    => 4,
            'timestamp'     =>  9 * 60 + 41,
            'readout'       => "Payload separation confirmed"
        ]);
        Telemetry::create([
            'mission_id'    => 4,
            'timestamp'     =>  9 * 60 + 47,
            'readout'       => 'That was...'
        ]);
        Telemetry::create([
            'mission_id'    => 4,
            'timestamp'     =>  9 * 60 + 50,
            'readout'       => 'Repeating: simulated payload deploy confirmed'
        ]);
        Telemetry::create([
            'mission_id'    => 4,
            'timestamp'     =>  9 * 60 + 55,
            'readout'       => 'T plus ten minutes'
        ]);
        Telemetry::create([
            'mission_id'    => 4,
            'timestamp'     => 10 * 60 + 3,
            'readout'       => "You're seeing a forward shot, that is where we would nomrally see a payload separation, in this case we are not separating..."
        ]);
        Telemetry::create([
            'mission_id'    => 4,
            'timestamp'     => 10 * 60 + 5,
            'readout'       => 'FTS [inaudible]'
        ]);
        Telemetry::create([
            'mission_id'    => 4,
            'timestamp'     => 10 * 60 + 8,
            'readout'       => "Hey congratulations, this is fantastic"
        ]);
        Telemetry::create([
            'mission_id'    => 4,
            'timestamp'     => 10 * 60 + 11,
            'readout'       => "Thank you"
        ]);
        Telemetry::create([
            'mission_id'    => 4,
            'timestamp'     => 10 * 60 + 13,
            'readout'       => "We're still showing active on second stage telemetry"
        ]);
        Telemetry::create([
            'mission_id'    => 4,
            'timestamp'     => 10 * 60 + 16,
            'readout'       => "We are heading over the horizon with respect to the launch range, so we are expecting loss of signal any second now, you can see it starting to break up"
        ]);
        Telemetry::create([
            'mission_id'    => 4,
            'timestamp'     => 10 * 60 + 25,
            'readout'       => "But this is a very good day at SpaceX"
        ]);
        Telemetry::create([
            'mission_id'    => 4,
            'timestamp'     => 10 * 60 + 30,
            'readout'       => "Max I think it's important when we lose our signal here to put this in perspective, what SpaceX has been able to achieve today"
        ]);
        Telemetry::create([
            'mission_id'    => 4,
            'timestamp'     => 10 * 60 + 33,
            'readout'       => "LC we have a [inaudible] on safety radar, nominal [inaudible]"
        ]);
        Telemetry::create([
            'mission_id'    => 4,
            'timestamp'     => 10 * 60 + 37,
            'readout'       => '[inaudible]'
        ]);
        Telemetry::create([
            'mission_id'    => 4,
            'timestamp'     => 10 * 60 + 39,
            'readout'       => "SpaceX has designed and developed this vehicle from the ground up from a blank sheet of paper they've done all the design and all the testing in house. We don't outsource, and we have achieved this with a company that is only now 500 people, and it has all occurred in under 6 years. And this is just the groundbreaker; this is just the vanguard; of the much larger Falcon 9 launch vehicle debuting from Cape Canaveral next year, and the Dragon spacecraft that will be debuting in June o next year and will be providing cargo services to the International Space Station. So we have big plans, even beyond that, here at SpaceX. Including human space transportation in the Dragon launch vehicle and on the Falcon 9- uhh, Falcon 9 launch vehicle and the Dragon spacecraft, and this is really just the beginning, this is just the tip of the iceberg here. There's a lot of people who have worked very hard for a very long time., tremendous commitment from them and their families to get to this point. It's really an incredible achievement."
        ]);
        Telemetry::create([
            'mission_id'    => 4,
            'timestamp'     => 11 * 60 + 41,
            'readout'       => "You can hear the cheers in the background from the amazing team that we have here at SpaceX. Only about 550 people on the team and we've just managed to do what very few companies around the world have ever done"
        ]);
        Telemetry::create([
            'mission_id'    => 4,
            'timestamp'     => 12 * 60 + 0,
            'readout'       => "There's gonna be celebration on Kwajalein tonight I can tell you. Wish I was there."
        ]);
        /* MORE TELEMETRY */
    }

    public function Falcon1Flight5() {
        Telemetry::create([
            'mission_id'    => 5,
            'timestamp'     => 0,
            'readout'       => 'T-0'
        ]);

        Telemetry::create([
            'mission_id'    => 5,
            'timestamp'     => 1,
            'readout'       => 'Plus One'
        ]);

        Telemetry::create([
            'mission_id'    => 5,
            'timestamp'     => 2,
            'readout'       => 'Plus Two'
        ]);

        Telemetry::create([
            'mission_id'    => 5,
            'timestamp'     => 3,
            'readout'       => 'Plus Three'
        ]);

        Telemetry::create([
            'mission_id'    => 5,
            'timestamp'     => 4,
            'readout'       => 'We have liftoff of the SpaceX Falcon 1 carrying RazakSAT satellite for ATSB'
        ]);

        Telemetry::create([
            'mission_id'    => 5,
            'timestamp'     => 10,
            'readout'       => 'Falcon 1 has cleared the tower'
        ]);

        Telemetry::create([
            'mission_id'    => 5,
            'timestamp'     => 16,
            'readout'       => 'Vehicle has begun moving downrange'
        ]);

        Telemetry::create([
            'mission_id'    => 5,
            'timestamp'     => 21,
            'readout'       => "Vehicle's currently travelling 27 metres per second at point 3 kilometres above the pad",
            'altitude'      => 300,
            'velocity'      => 27
        ]);

        Telemetry::create([
            'mission_id'    => 5,
            'timestamp'     => 27,
            'readout'       => "Power systems nominal"
        ]);

        Telemetry::create([
            'mission_id'    => 5,
            'timestamp'     => 30,
            'readout'       => "First stage propulsion is nominal"
        ]);

        Telemetry::create([
            'mission_id'    => 5,
            'timestamp'     => 32,
            'readout'       => "Guidance nominal"
        ]);

        Telemetry::create([
            'mission_id'    => 5,
            'timestamp'     => 49,
            'readout'       => "Approaching Mach 1"
        ]);

        Telemetry::create([
            'mission_id'    => 5,
            'timestamp'     => 53,
            'readout'       => "Vehicle's in the transonic region about to go supersonic"
        ]);

        Telemetry::create([
            'mission_id'    => 5,
            'timestamp'     => 60,
            'readout'       => "T plus 1 minute"
        ]);

        Telemetry::create([
            'mission_id'    => 5,
            'timestamp'     => 66,
            'readout'       => "This is Max-Q, maximum dynamic pressure. This is the period of greatest stress on the vehicle structure"
        ]);

        Telemetry::create([
            'mission_id'    => 5,
            'timestamp'     => 72,
            'readout'       => "First stage propulsion performing nominally"
        ]);

        Telemetry::create([
            'mission_id'    => 5,
            'timestamp'     => 76,
            'readout'       => "Vehicle currently has a velocity of 500 m/s at an altitude of 15 km",
            'altitude'      => 15000,
            'velocity'      => 500
        ]);

        Telemetry::create([
            'mission_id'    => 5,
            'timestamp'     => 82,
            'readout'       => "Passed Max-Q"
        ]);

        Telemetry::create([
            'mission_id'    => 5,
            'timestamp'     => 99,
            'readout'       => "You can see the plume getting darker..."
        ]);

        Telemetry::create([
            'mission_id'    => 5,
            'timestamp'     => 100,
            'readout'       => "T plus 1 minute 40 seconds, velocity 830m/s at an altitude of 30km",
            'velocity'      => 830,
            'altitude'      => 30000
        ]);

        Telemetry::create([
            'mission_id'    => 5,
            'timestamp'     => 109,
            'readout'       => "...and blacker, as we get to higher rarified atmosphere"
        ]);

        Telemetry::create([
            'mission_id'    => 5,
            'timestamp'     => 120,
            'readout'       => "First stage propulsion still performing nominally"
        ]);

        Telemetry::create([
            'mission_id'    => 5,
            'timestamp'     => 130,
            'readout'       => "Vehicle's currently travelling 1300m/s at an altitude of 38km",
            'altitude'      => 38000,
            'velocity'      => 1300
        ]);

        Telemetry::create([
            'mission_id'    => 5,
            'timestamp'     => 140,
            'readout'       => "Inertial guidance"
        ]);

        Telemetry::create([
            'mission_id'    => 5,
            'timestamp'     => 142,
            'readout'       => "Vehicle's trimming out alpha in preparation for MECO. There'll be a 5 second delay between main engine cutoff, and stage separation, then 4 more seconds before second stage ignition. There's MECO!"
        ]);

        Telemetry::create([
            'mission_id'    => 5,
            'timestamp'     => 158,
            'readout'       => "First stage MECO"
        ]);

        Telemetry::create([
            'mission_id'    => 5,
            'timestamp'     => 162,
            'readout'       => "Stage separation, and Kestrel ingition"
        ]);

        Telemetry::create([
            'mission_id'    => 5,
            'timestamp'     => 166,
            'readout'       => "Stage separation confirmed"
        ]);

        Telemetry::create([
            'mission_id'    => 5,
            'timestamp'     => 171,
            'readout'       => "Second stage ignition confirmed"
        ]);

        Telemetry::create([
            'mission_id'    => 5,
            'timestamp'     => 175,
            'readout'       => "Okay, the stages have separated, the second stage has ignited. The second stage is currently travelling 2800m/s at an altitude of 108km",
            'altitude'      => 108000,
            'velocity'      => 2800
        ]);

        Telemetry::create([
            'mission_id'    => 5,
            'timestamp'     => 185,
            'readout'       => "Approaching fairing separation"
        ]);

        Telemetry::create([
            'mission_id'    => 5,
            'timestamp'     => 189,
            'readout'       => "Coming up to fairing sep"
        ]);

        Telemetry::create([
            'mission_id'    => 5,
            'timestamp'     => 192,
            'readout'       => "Camera move to forward view"
        ]);

        Telemetry::create([
            'mission_id'    => 5,
            'timestamp'     => 196,
            'readout'       => "Fairing separation confirmed"
        ]);

        Telemetry::create([
            'mission_id'    => 5,
            'timestamp'     => 200,
            'readout'       => "We've had a clean fairing sep, both halves looked equal"
        ]);

        Telemetry::create([
            'mission_id'    => 5,
            'timestamp'     => 205,
            'readout'       => "Second stage propulsion performance is nominal"
        ]);

        Telemetry::create([
            'mission_id'    => 5,
            'timestamp'     => 207,
            'readout'       => "Fairing came off beautifully"
        ]);

        Telemetry::create([
            'mission_id'    => 5,
            'timestamp'     => 213,
            'readout'       => "Guidance nominal"
        ]);

        Telemetry::create([
            'mission_id'    => 5,
            'timestamp'     => 214,
            'readout'       => "You'll see the stiffening bands fall of the Kestrel Nozzle in a minute [inaudible]"
        ]);

        Telemetry::create([
            'mission_id'    => 5,
            'timestamp'     => 218,
            'readout'       => "T+3 minutes 40 seconds, the vehicle's travelling 3000m/s at an altitude of 150km",
            'velocity'      => 3000,
            'altitude'      => 150000
        ]);

        Telemetry::create([
            'mission_id'    => 5,
            'timestamp'     => 228,
            'readout'       => "Good telemetry lock on both stages"
        ]);

        Telemetry::create([
            'mission_id'    => 5,
            'timestamp'     => 238,
            'readout'       => "The Kestrel engine fires for over 6 minutes on the way to orbit, the vast majority of acceleration occurs in this phase."
        ]);

        Telemetry::create([
            'mission_id'    => 5,
            'timestamp'     => 241,
            'readout'       => "Passing throught T+4 minutes, the vehicle's travelling 3000m/s at an altitude of 172km",
            'velocity'      => 3000,
            'altitude'      => 172000
        ]);

        Telemetry::create([
            'mission_id'    => 5,
            'timestamp'     => 258,
            'readout'       => "Power systems nominal"
        ]);

        Telemetry::create([
            'mission_id'    => 5,
            'timestamp'     => 260,
            'readout'       => "I should point out that we may lose video and telemetry, just prior to second stage shutdown, depending on the vagaries of upper atmosphere RF propogation"
        ]);

        Telemetry::create([
            'mission_id'    => 5,
            'timestamp'     => 261,
            'readout'       => "Second stage propulsion is nominal"
        ]);

        Telemetry::create([
            'mission_id'    => 5,
            'timestamp'     => 264,
            'readout'       => "Guidance nominal"
        ]);

        Telemetry::create([
            'mission_id'    => 5,
            'timestamp'     => 270,
            'readout'       => "T+4m30s, both velocity and altitude are nominal, at 3200m/s and an altitude of 196km",
            'velocity'      => 3200,
            'altitude'      => 196000
        ]);

        Telemetry::create([
            'mission_id'    => 5,
            'timestamp'     => 284,
            'readout'       => "But that's another 4 and a half minutes from now"
        ]);

        Telemetry::create([
            'mission_id'    => 5,
            'timestamp'     => 305,
            'readout'       => "Telemetry lock still good"
        ]);

        Telemetry::create([
            'mission_id'    => 5,
            'timestamp'     => 307,
            'readout'       => "Second stage propulsion performing nominally"
        ]);

        Telemetry::create([
            'mission_id'    => 5,
            'timestamp'     => 312,
            'readout'       => "Guidance nominal"
        ]);

        Telemetry::create([
            'mission_id'    => 5,
            'timestamp'     => 323,
            'readout'       => "We are still seeing nominal flight"
        ]);

        Telemetry::create([
            'mission_id'    => 5,
            'timestamp'     => 328,
            'readout'       => "T+5m30s, current velocity 3600m/s at an altitude of 230km",
            'altitude'      => 230000,
            'velocity'      => 3600
        ]);

        Telemetry::create([
            'mission_id'    => 5,
            'timestamp'     => 344,
            'readout'       => "At 230km altitude, Falcon 1 is currently well beyond the official boundary of space at 100km"
        ]);

        Telemetry::create([
            'mission_id'    => 5,
            'timestamp'     => 354,
            'readout'       => "Currently three minutes into the second stage burn, passing through T+6 minutes. Velocity 3800m/s at an altitude at 243km, both are above nominal",
            'velocity'      => 3800,
            'altitude'      => 243000
        ]);

        Telemetry::create([
            'mission_id'    => 5,
            'timestamp'     => 366,
            'readout'       => "Propulsion is performing nominally on the second stage"
        ]);

        Telemetry::create([
            'mission_id'    => 5,
            'timestamp'     => 391,
            'readout'       => "T+6 minutes 30 seconds, velocity 4150m/s, altitude 255km",
            'velocity'      => 4150,
            'altitude'      => 255000
        ]);

        Telemetry::create([
            'mission_id'    => 5,
            'timestamp'     => 408,
            'readout'       => "We are about 2 and a half minutes from SECO"
        ]);

        Telemetry::create([
            'mission_id'    => 5,
            'timestamp'     => 411,
            'readout'       => "Second stage propulsion's performing nominally"
        ]);

        Telemetry::create([
            'mission_id'    => 5,
            'timestamp'     => 418,
            'readout'       => "T+7 minutes, current velocity 4400m/s at an altitude of 260km",
            'velocity'      => 4400,
            'altitude'      => 260000
        ]);

        Telemetry::create([
            'mission_id'    => 5,
            'timestamp'     => 426,
            'readout'       => "Power systems still nominal"
        ]);

        Telemetry::create([
            'mission_id'    => 5,
            'timestamp'     => 429,
            'readout'       => "Guidance is nominal"
        ]);

        Telemetry::create([
            'mission_id'    => 5,
            'timestamp'     => 438,
            'readout'       => "At SECO, we will be in a parking orbit. 38 minutes later over Ascension Island in the South Pacific we will relight the second stage engine to circularize the orbit - and after that short second burn we will deploying the RazakSAT satellite into orbit"
        ]);

        Telemetry::create([
            'mission_id'    => 5,
            'timestamp'     => 448,
            'readout'       => "T+7minutes 30 seconds, velocity 4800m/s, altitude 265km",
            'altitude'      => 265000,
            'velocity'      => 4800
        ]);

        Telemetry::create([
            'mission_id'    => 5,
            'timestamp'     => 464,
            'readout'       => "Second stage telemetry still nominal"
        ]);

        Telemetry::create([
            'mission_id'    => 5,
            'timestamp'     => 471,
            'readout'       => "Second stage propulsion nominal"
        ]);

        Telemetry::create([
            'mission_id'    => 5,
            'timestamp'     => 481,
            'readout'       => "Guidance is nominal"
        ]);

        Telemetry::create([
            'mission_id'    => 5,
            'timestamp'     => 482,
            'readout'       => "Launchpad safing is complete. Passing through T+8 minutes, velocity 5400m/s, at an altitude of 267km",
            'altitude'      => 267000,
            'velocity'      => 5400
        ]);

        Telemetry::create([
            'mission_id'    => 5,
            'timestamp'     => 495,
            'readout'       => "As I mentioned, we are expectin to lose RF signal, telemetry, and video sometime in the next minute and a half, and it may be before second stage engine shutdown"
        ]);

        Telemetry::create([
            'mission_id'    => 5,
            'timestamp'     => 524,
            'readout'       => "Somewhere here we're expecting some dropouts"
        ]);

        Telemetry::create([
            'mission_id'    => 5,
            'timestamp'     => 533,
            'readout'       => "SECO is about 9 minutes 15 seconds"
        ]);

        Telemetry::create([
            'mission_id'    => 5,
            'timestamp'     => 534,
            'readout'       => "Vehicle's in terminal guidance"
        ]);

        Telemetry::create([
            'mission_id'    => 5,
            'timestamp'     => 536,
            'readout'       => "Propulsion performing nominally"
        ]);

        Telemetry::create([
            'mission_id'    => 5,
            'timestamp'     => 538,
            'readout'       => "T+9 minutes. Vehicle's travelling 6400m/s, at an altitude of 266km",
            'altitude'      => 266000,
            'velocity'      => 6400
        ]);

        Telemetry::create([
            'mission_id'    => 5,
            'timestamp'     => 555,
            'readout'       => "Seeing some dropouts in the telemetry and video"
        ]);

        Telemetry::create([
            'mission_id'    => 5,
            'timestamp'     => 566,
            'readout'       => "T+9m 30s, okay we've currently gone over the horizon, we are experiencing some losses in telemetry, but vehicle has completed shutdown"
        ]);

        Telemetry::create([
            'mission_id'    => 5,
            'timestamp'     => 580,
            'readout'       => "That's SECO. And with SECO, that places Falcon 1 Second Stage and RazakSAT satellite into the parking orbit."
        ]);

        Telemetry::create([
            'mission_id'    => 5,
            'timestamp'     => 590,
            'readout'       => "Excellent, well after that beautiful launch, we are looking at a loss of second stage signal, because as you have heard, it has passed over the horizon of the launch site. Everything looks to be going well, and this will end our live webcast of the RazakSAT mission today. Please continue to monitor the progress of this mission on our website spacex.com. You can also download photos and videos of todays launch in the coming days."
        ]);

        Telemetry::create([
            'mission_id'    => 5,
            'timestamp'     => 591,
            'readout'       => "[inaudible] power nominal"
        ]);
    }

    public function DSQU() {
        Telemetry::create([
            'mission_id'    => 6,
            'timestamp'     => 0 * 60 + 1,
            'readout'       => 'Liftoff!'
        ]);
        Telemetry::create([
            'mission_id'    => 6,
            'timestamp'     => 0 * 60 + 4,
            'readout'       => 'We have [inaudible]'
        ]);
        Telemetry::create([
            'mission_id'    => 6,
            'timestamp'     => 0 * 60 + 5,
            'readout'       => 'Liftoff of the Falcon 9'
        ]);
        Telemetry::create([
            'mission_id'    => 6,
            'timestamp'     => 0 * 60 + 10,
            'readout'       => 'Falcon 9 has cleared the towers'
        ]);
        Telemetry::create([
            'mission_id'    => 6,
            'timestamp'     => 0 * 60 + 15,
            'readout'       => 'Pitch kick'
        ]);
        Telemetry::create([
            'mission_id'    => 6,
            'timestamp'     => 0 * 60 + 17,
            'readout'       => "[inaudible] on the countdown net, have [inaudible] on net A please."
        ]);
        Telemetry::create([
            'mission_id'    => 6,
            'timestamp'     => 0 * 60 + 28,
            'readout'       => "Gravity turn"
        ]);
        Telemetry::create([
            'mission_id'    => 6,
            'timestamp'     => 0 * 60 + 34,
            'readout'       => "First stage propulsion is performing nominally"
        ]);
        Telemetry::create([
            'mission_id'    => 6,
            'timestamp'     => 0 * 60 + 35,
            'readout'       => "We have telemetry lock on both stages and power systems are go"
        ]);
        Telemetry::create([
            'mission_id'    => 6,
            'timestamp'     => 0 * 60 + 39,
            'readout'       => "Guidance is nominal"
        ]);
        Telemetry::create([
            'mission_id'    => 6,
            'timestamp'     => 0 * 60 + 42,
            'readout'       => "Vehicle is moving at 430m/s [inaudible], altitude 3km",
            'altitude'      => 3000,
            'velocity'      => 430
        ]);
        Telemetry::create([
            'mission_id'    => 6,
            'timestamp'     => 0 * 60 + 57,
            'readout'       => "As Falcon 9 ascends into the atmosphere, we are getting a little bit of audio trouble from the launch site. The vehicle is quickly approaching its Max-Q, where its increasing speed and the atmospheric density create the maximum resistance to the vehicle's flight, after Max-Q the forces acting on the vehicle will decrease dramatically, and the vehicle will begin to gain speed substantially"
        ]);
        Telemetry::create([
            'mission_id'    => 6,
            'timestamp'     => 1 * 60 + 48,
            'readout'       => "As the atmosphere thins, the exhaust plume will begin to expand greatly and begin to take on a darker color, [inaudible] plume"
        ]);
        Telemetry::create([
            'mission_id'    => 6,
            'timestamp'     => 2 * 60 + 35,
            'readout'       => "Guidance nominal"
        ]);
        Telemetry::create([
            'mission_id'    => 6,
            'timestamp'     => 2 * 60 + 57,
            'readout'       => "Approaching MECO 2"
        ]);
        Telemetry::create([
            'mission_id'    => 6,
            'timestamp'     => 3 * 60 + 7,
            'readout'       => "And we have stage separation!"
        ]);
        Telemetry::create([
            'mission_id'    => 6,
            'timestamp'     => 3 * 60 + 14,
            'readout'       => "And stage separation is confirmed."
        ]);
        Telemetry::create([
            'mission_id'    => 6,
            'timestamp'     => 3 * 60 + 16,
            'readout'       => 'MVac chamber ignition confirmed'
        ]);
        Telemetry::create([
            'mission_id'    => 6,
            'timestamp'     => 3 * 60 + 20,
            'readout'       => "And we have a clean stage separation and second stage ignition. The Merlin Vacuum engine has begun lifting the second stage and Dragon into orbit. As you saw, on the MVac nozzle expansion skirt, that fell away as designed."
        ]);
        Telemetry::create([
            'mission_id'    => 6,
            'timestamp'     => 3 * 60 + 31,
            'readout'       => "MVac performance nominal, and we have [inaudible]"
        ]);
        Telemetry::create([
            'mission_id'    => 6,
            'timestamp'     => 3 * 60 + 39,
            'readout'       => "Vehicle has an inertial velocity of 3500m/s, altitude of 140km. Let's turn off-",
            'altitude'      => 140000,
            'velocity'      => 3500
        ]);
        Telemetry::create([
            'mission_id'    => 6,
            'timestamp'     => 3 * 60 + 55,
            'readout'       => "MVac is performing nominally"
        ]);
        Telemetry::create([
            'mission_id'    => 6,
            'timestamp'     => 3 * 60 + 56,
            'readout'       => "[inaudible] back on."
        ]);
        Telemetry::create([
            'mission_id'    => 6,
            'timestamp'     => 3 * 60 + 59,
            'readout'       => "Guidance is nominal"
        ]);
        Telemetry::create([
            'mission_id'    => 6,
            'timestamp'     => 4 * 60 + 1,
            'readout'       => "And we have nominal avionics operation at this point"
        ]);
        Telemetry::create([
            'mission_id'    => 6,
            'timestamp'     => 4 * 60 + 5,
            'readout'       => "Stage 2 and MVac engine performing nominally"
        ]);
        Telemetry::create([
            'mission_id'    => 6,
            'timestamp'     => 4 * 60 + 13,
            'readout'       => "As the second stage continues its flight, you will see one of the roll-control actuators wiggle back and forth. That's simply the vehicle correcting its trajectory as it continues to orbit"
        ]);
        Telemetry::create([
            'mission_id'    => 6,
            'timestamp'     => 4 * 60 + 29,
            'readout'       => "Second stage continues to perform nominally"
        ]);
        Telemetry::create([
            'mission_id'    => 6,
            'timestamp'     => 4 * 60 + 32,
            'readout'       => "Second stage avionics looking nominal, and we have telemetry lock."
        ]);
        Telemetry::create([
            'mission_id'    => 6,
            'timestamp'     => 4 * 60 + 36,
            'readout'       => "Guidance is nominal"
        ]);
        Telemetry::create([
            'mission_id'    => 6,
            'timestamp'     => 4 * 60 + 39,
            'readout'       => "The vehicle's currently travelling at 4000m/s at an altitude of 189km",
            'altitude'      => 189000,
            'velocity'      => 4000
        ]);
        Telemetry::create([
            'mission_id'    => 6,
            'timestamp'     => 5 * 60 + 4,
            'readout'       => "And this is prop, still performing nominally"
        ]);
        Telemetry::create([
            'mission_id'    => 6,
            'timestamp'     => 5 * 60 + 11,
            'readout'       => 'Both stage and MVac performing nominally'
        ]);
        Telemetry::create([
            'mission_id'    => 6,
            'timestamp'     => 5 * 60 + 13,
            'readout'       => "New Hampshire station has acquired."
        ]);
        Telemetry::create([
            'mission_id'    => 6,
            'timestamp'     => 5 * 60 + 22,
            'readout'       => "As expected the radiatively cooled expansion nozzle on the engine is glowing red hot, and in some places even white hot, and are designed to operate just like our Falcon 1 vehicle"
        ]);
        Telemetry::create([
            'mission_id'    => 6,
            'timestamp'     => 5 * 60 + 25,
            'readout'       => "And second stage avionics [inaudible] power systems are nominal"
        ]);
        Telemetry::create([
            'mission_id'    => 6,
            'timestamp'     => 5 * 60 + 42,
            'readout'       => "Second stage is preparing to trim propellants"
        ]);
        Telemetry::create([
            'mission_id'    => 6,
            'timestamp'     => 5 * 60 + 54,
            'readout'       => "[inaudible] is good"
        ]);
        Telemetry::create([
            'mission_id'    => 6,
            'timestamp'     => 5 * 60 + 59,
            'readout'       => "MVac actively trimming performing nominally"
        ]);
        Telemetry::create([
            'mission_id'    => 6,
            'timestamp'     => 6 * 60 + 5,
            'readout'       => "And we have second stage telemetry lock and power systems are nominal."
        ]);
        Telemetry::create([
            'mission_id'    => 6,
            'timestamp'     => 6 * 60 + 8,
            'readout'       => "Guidance is still nominal"
        ]);
        Telemetry::create([
            'mission_id'    => 6,
            'timestamp'     => 6 * 60 + 17,
            'readout'       => "Vehicle's currently travelling at almost 5000m/s and an alt of 239km",
            'velocity'      => 5000,
            'altitude'      => 239000
        ]);
        Telemetry::create([
            'mission_id'    => 6,
            'timestamp'     => 6 * 60 + 27,
            'readout'       => "New Hampshire telemetry is cleaned up"
        ]);
        Telemetry::create([
            'mission_id'    => 6,
            'timestamp'     => 6 * 60 + 29,
            'readout'       => "MVac and second stage are performing nominally"
        ]);
        Telemetry::create([
            'mission_id'    => 6,
            'timestamp'     => 6 * 60 + 40,
            'readout'       => "LC we got grassfires all the way by the hanger"
        ]);
        Telemetry::create([
            'mission_id'    => 6,
            'timestamp'     => 6 * 60 + 45,
            'readout'       => "swap camera"
        ]);
        Telemetry::create([
            'mission_id'    => 6,
            'timestamp'     => 6 * 60 + 52,
            'readout'       => "Propulsion is performing nominally"
        ]);
        Telemetry::create([
            'mission_id'    => 6,
            'timestamp'     => 6 * 60 + 55,
            'readout'       => "Guidance nominal"
        ]);
        Telemetry::create([
            'mission_id'    => 6,
            'timestamp'     => 6 * 60 + 57,
            'readout'       => "And avionics systems are nominal"
        ]);
        Telemetry::create([
            'mission_id'    => 6,
            'timestamp'     => 7 * 60 + 28,
            'readout'       => "Second stage and MVac performing nominally"
        ]);
        Telemetry::create([
            'mission_id'    => 6,
            'timestamp'     => 7 * 60 + 32,
            'readout'       => "We have nominal avionics operation and telemetry lock"
        ]);
        Telemetry::create([
            'mission_id'    => 6,
            'timestamp'     => 7 * 60 + 37,
            'readout'       => "Guidance is nominal"
        ]);
        Telemetry::create([
            'mission_id'    => 6,
            'timestamp'     => 7 * 60 + 39,
            'readout'       => "As the vehicle is approaching the horizon as viewed from the launch site, we may lose video signal or it may become degraded"
        ]);
        Telemetry::create([
            'mission_id'    => 6,
            'timestamp'     => 7 * 60 + 44,
            'readout'       => "And this is prop, we have 1 minute of nominal SECO 1 time. MVac and the second stage continue to perform nominally"
        ]);
        Telemetry::create([
            'mission_id'    => 6,
            'timestamp'     => 8 * 60 + 0,
            'readout'       => "Vehicle's in terminal guidance"
        ]);
        Telemetry::create([
            'mission_id'    => 6,
            'timestamp'     => 8 * 60 + 14,
            'readout'       => "The vehicle's at an inertial velocity of 7000m/s, at 256km altitude",
            'altitude'      => 256000,
            'velocity'      => 7000
        ]);
        Telemetry::create([
            'mission_id'    => 6,
            'timestamp'     => 8 * 60 + 22,
            'readout'       => "Second stage is approaching SECO 1"
        ]);
        Telemetry::create([
            'mission_id'    => 6,
            'timestamp'     => 8 * 60 + 39,
            'readout'       => "MVac still performing nominally"
        ]);
        Telemetry::create([
            'mission_id'    => 6,
            'timestamp'     => 8 * 60 + 44,
            'readout'       => "And engine shutdown"
        ]);
        Telemetry::create([
            'mission_id'    => 6,
            'timestamp'     => 8 * 60 + 47,
            'readout'       => "Falcon 9 stage two and the Dragon capsule are now in orbit around the Earth"
        ]);
        Telemetry::create([
            'mission_id'    => 6,
            'timestamp'     => 8 * 60 + 52,
            'readout'       => "And with the shutdown of the second stage engine, SpaceX's Falcon 9 has achieved Earth orbit"
        ]);
        Telemetry::create([
            'mission_id'    => 6,
            'timestamp'     => 9 * 60 + 3,
            'readout'       => "Stage 2 attitude control systems are now active, during coast, second stage will perform a series of seven thruster and propellant..."
        ]);
        Telemetry::create([
            'mission_id'    => 6,
            'timestamp'     => 9 * 60 + 10,
            'readout'       => "As expected it looks like we have lost the signal- the video signal, from the Falcon 9 second stage as it passed over the horizon, but from here, everything looks every clean. In the time ahead our team will be reviewing- all in all this has been a good day for SpaceX-"
        ]);
    }

    public function COTS1() {
        Telemetry::create([
            'mission_id'    => 7,
            'timestamp'     => 0 * 60 + 2,
            'readout'       => "We have liftoff of the Falcon 9"
        ]);
        Telemetry::create([
            'mission_id'    => 7,
            'timestamp'     => 0 * 60 + 4,
            'readout'       => "Stage 1"
        ]);
        Telemetry::create([
            'mission_id'    => 7,
            'timestamp'     => 0 * 60 + 9,
            'readout'       => "Pitchkick"
        ]);
        Telemetry::create([
            'mission_id'    => 7,
            'timestamp'     => 0 * 60 + 11,
            'readout'       => "Falcon 9 has cleared the tower"
        ]);
        Telemetry::create([
            'mission_id'    => 7,
            'timestamp'     => 0 * 60 + 24,
            'readout'       => "First stage engines and tanks, looking good"
        ]);
        Telemetry::create([
            'mission_id'    => 7,
            'timestamp'     => 0 * 60 + 27,
            'readout'       => "Beginning gravity turn"
        ]);
        Telemetry::create([
            'mission_id'    => 7,
            'timestamp'     => 0 * 60 + 40,
            'readout'       => "Telemetry lock on both stages, power systems nominal"
        ]);
        Telemetry::create([
            'mission_id'    => 7,
            'timestamp'     => 0 * 60 + 44,
            'readout'       => "First stage propulsion is nominal"
        ]);
        Telemetry::create([
            'mission_id'    => 7,
            'timestamp'     => 0 * 60 + 47,
            'readout'       => "OK"
        ]);
        Telemetry::create([
            'mission_id'    => 7,
            'timestamp'     => 0 * 60 + 50,
            'readout'       => "Guidance nominal"
        ]);
        Telemetry::create([
            'mission_id'    => 7,
            'timestamp'     => 1 * 60 + 8,
            'readout'       => "The vehicle's now supersonic"
        ]);
        Telemetry::create([
            'mission_id'    => 7,
            'timestamp'     => 1 * 60 + 21,
            'readout'       => "Telemetry lock still on both stages, power systems continue to be nominal"
        ]);
        Telemetry::create([
            'mission_id'    => 7,
            'timestamp'     => 1 * 60 + 24,
            'readout'       => "Guidance is nominal at Max-Q"
        ]);
        Telemetry::create([
            'mission_id'    => 7,
            'timestamp'     => 1 * 60 + 26,
            'readout'       => "And propulsion is also nominal on the first stage"
        ]);
        Telemetry::create([
            'mission_id'    => 7,
            'timestamp'     => 1 * 60 + 51,
            'readout'       => "First stage propulsion performing nominally"
        ]);
        Telemetry::create([
            'mission_id'    => 7,
            'timestamp'     => 2 * 60 + 2,
            'readout'       => "Guidance is nominal"
        ]);
        Telemetry::create([
            'mission_id'    => 7,
            'timestamp'     => 2 * 60 + 27,
            'readout'       => "We have telemetry lock, and power systems are still nominal"
        ]);
        Telemetry::create([
            'mission_id'    => 7,
            'timestamp'     => 2 * 60 + 33,
            'readout'       => "First stage tank pressures and engines still nominal"
        ]);
        Telemetry::create([
            'mission_id'    => 7,
            'timestamp'     => 2 * 60 + 40,
            'readout'       => "Stage two MVac engine chilling in. First two M9 engines shut down"
        ]);

        Telemetry::create([
            'mission_id'    => 7,
            'timestamp'     => 2 * 60 + 56,
            'readout'       => "First stage MECO 2",
            'velocity'      => 3200
        ]);

        Telemetry::create([
            'mission_id'    => 7,
            'timestamp'     => 2 * 60 + 58,
            'readout'       => "First stage engine shutdown",
            'velocity'      => 3200
        ]);
        Telemetry::create([
            'mission_id'    => 7,
            'timestamp'     => 3 * 60 + 3,
            'readout'       => "Second stage has separated"
        ]);
        Telemetry::create([
            'mission_id'    => 7,
            'timestamp'     => 3 * 60 + 6,
            'readout'       => "Inertial velocity at MECO was approximately 3.2km/s, nominal"
        ]);
        Telemetry::create([
            'mission_id'    => 7,
            'timestamp'     => 3 * 60 + 10,
            'readout'       => "MVac ignition confirmed"
        ]);
        Telemetry::create([
            'mission_id'    => 7,
            'timestamp'     => 3 * 60 + 28,
            'readout'       => "Power systems look nominal, we have GPS lock"
        ]);
        Telemetry::create([
            'mission_id'    => 7,
            'timestamp'     => 3 * 60 + 30,
            'readout'       => "MVac stage and engine performance looking good"
        ]);
        Telemetry::create([
            'mission_id'    => 7,
            'timestamp'     => 3 * 60 + 49,
            'readout'       => "Dragon nosecone has been jettisoned"
        ]);
        Telemetry::create([
            'mission_id'    => 7,
            'timestamp'     => 3 * 60 + 56,
            'readout'       => "Second stage propulsion performance is nominal"
        ]);
        Telemetry::create([
            'mission_id'    => 7,
            'timestamp'     => 4 * 60 + 1,
            'readout'       => "Power system looks nominal, GPS and telemetry lock confirmed"
        ]);
        Telemetry::create([
            'mission_id'    => 7,
            'timestamp'     => 4 * 60 + 6,
            'readout'       => "Guidance is nominal"
        ]);
        Telemetry::create([
            'mission_id'    => 7,
            'timestamp'     => 4 * 60 + 12,
            'readout'       => "MVac stiffening ring has been jettisoned"
        ]);
        Telemetry::create([
            'mission_id'    => 7,
            'timestamp'     => 4 * 60 + 26,
            'readout'       => "MVac engine power looks good, stage is healthy, propulsion nominal"
        ]);
        Telemetry::create([
            'mission_id'    => 7,
            'timestamp'     => 4 * 60 + 32,
            'readout'       => "Stage two guidance is looking nominal"
        ]);
        Telemetry::create([
            'mission_id'    => 7,
            'timestamp'     => 4 * 60 + 36,
            'readout'       => "Vehicle is currently at 210km, and 3.7km/s",
            'altitude'      => 210000,
            'velocity'      => 3700
        ]);
        Telemetry::create([
            'mission_id'    => 7,
            'timestamp'     => 4 * 60 + 52,
            'readout'       => "AOS New Hampshire"
        ]);
        Telemetry::create([
            'mission_id'    => 7,
            'timestamp'     => 4 * 60 + 55,
            'readout'       => "Second stage power systems functioning nominally"
        ]);
        Telemetry::create([
            'mission_id'    => 7,
            'timestamp'     => 4 * 60 + 59,
            'readout'       => "Guidance nominal"
        ]);
        Telemetry::create([
            'mission_id'    => 7,
            'timestamp'     => 5 * 60 + 1,
            'readout'       => "The vehicle is now approximately 450km downrange",
            'downrange'     => 450000
        ]);
        Telemetry::create([
            'mission_id'    => 7,
            'timestamp'     => 5 * 60 + 6,
            'readout'       => "All second stage propulsion parameters are nominal"
        ]);
        Telemetry::create([
            'mission_id'    => 7,
            'timestamp'     => 5 * 60 + 23,
            'readout'       => "We currently lock on both stages, power systems look healthy on both stages"
        ]);
        Telemetry::create([
            'mission_id'    => 7,
            'timestamp'     => 5 * 60 + 29,
            'readout'       => "Guidance is still nominal"
        ]);
        Telemetry::create([
            'mission_id'    => 7,
            'timestamp'     => 5 * 60 + 32,
            'readout'       => "Propulsion is also nominal on the second stage"
        ]);
        Telemetry::create([
            'mission_id'    => 7,
            'timestamp'     => 5 * 60 + 48,
            'readout'       => "The vehicle is currently at an altitude of 264km, inertial velocity 4300m/s",
            'altitude'      => 264000,
            'velocity'      => 4300
        ]);
        Telemetry::create([
            'mission_id'    => 7,
            'timestamp'     => 6 * 60 + 0,
            'readout'       => "There are approximately 3 minutes left in stage two burn"
        ]);
        Telemetry::create([
            'mission_id'    => 7,
            'timestamp'     => 6 * 60 + 5,
            'readout'       => "All second stage propulsion performance parameters are nominal, both stage and engine look good"
        ]);
        Telemetry::create([
            'mission_id'    => 7,
            'timestamp'     => 6 * 60 + 20,
            'readout'       => "We have nominal RF system status, we have perfect power systems, and uh- telemetry lock is confirmed"
        ]);
        Telemetry::create([
            'mission_id'    => 7,
            'timestamp'     => 6 * 60 + 50,
            'readout'       => "Second stage propulsion is nominal"
        ]);
        Telemetry::create([
            'mission_id'    => 7,
            'timestamp'     => 7 * 60 + 3,
            'readout'       => "Guidance is nominal, approximately 2 minutes remaining left in second stage burn"
        ]);
        Telemetry::create([
            'mission_id'    => 7,
            'timestamp'     => 7 * 60 + 8,
            'readout'       => "AVI reporting: RF telemetry nominal"
        ]);
        Telemetry::create([
            'mission_id'    => 7,
            'timestamp'     => 7 * 60 + 18,
            'readout'       => "The vehicle's at approximately 300km altitude, 5500m/s",
            'altitude'      => 300000,
            'velocity'      => 5500
        ]);
        Telemetry::create([
            'mission_id'    => 7,
            'timestamp'     => 7 * 60 + 27,
            'readout'       => "All second stage propulsion performance parameters are within bounds"
        ]);
        Telemetry::create([
            'mission_id'    => 7,
            'timestamp'     => 8 * 60 + 4,
            'readout'       => "We have nominal lock on both telemetry streams, and we have charged recovery systems"
        ]);
        Telemetry::create([
            'mission_id'    => 7,
            'timestamp'     => 8 * 60 + 11,
            'readout'       => "Guidance is nominal, approximately 50 seconds remaining in this burn"
        ]);
        Telemetry::create([
            'mission_id'    => 7,
            'timestamp'     => 8 * 60 + 17,
            'readout'       => "Propulsion is also nominal, all systems are go"
        ]);
        Telemetry::create([
            'mission_id'    => 7,
            'timestamp'     => 8 * 60 + 23,
            'readout'       => "Vehicle is in terminal guidance."
        ]);
        Telemetry::create([
            'mission_id'    => 7,
            'timestamp'     => 8 * 60 + 44,
            'readout'       => "Second stage propulsion is performing nominally"
        ]);
        Telemetry::create([
            'mission_id'    => 7,
            'timestamp'     => 8 * 60 + 55,
            'readout'       => "MVac shutdown"
        ]);
        Telemetry::create([
            'mission_id'    => 7,
            'timestamp'     => 8 * 60 + 57,
            'readout'       => "Dragon is in orbit"
        ]);
        Telemetry::create([
            'mission_id'    => 7,
            'timestamp'     => 9 * 60 + 31,
            'readout'       => "Dragon deploy verified!"
        ]);
        Telemetry::create([
            'mission_id'    => 7,
            'timestamp'     => 9 * 60 + 49,
            'readout'       => "[inaudible] approximately 288km perigee, 301km apogee. Inclination 34.53 degrees."
        ]);
        Telemetry::create([
            'mission_id'    => 7,
            'timestamp'     => 10 * 60 + 27,
            'readout'       => "And as you can see, with separation of the Dragon spacecraft, it is on its way to begin 2 or possibly 3 orbits of the Earth. Great day here at SpaceX, looks like we had a great flight, we are probably going to go and join the employees now and celebrate. This will conclude this portion of our webcast, but as you know, the mission will be continuing for the next few hours. We will continue to post to post updates on the website, on Twitter, on Facebook; and let you know how the recovery and reentry efforts go. So this marks the end of our webcast, for the Falcon 9 Flight 2 Demonstration rocket carrying the first operational Dragon into orbit."
        ]);
    }

    public function COTS2Plus() {
        Telemetry::create([
            'mission_id'    => 8,
            'timestamp'     => 1,
            'readout'       => "Stage 1"
        ]);
        Telemetry::create([
            'mission_id'    => 8,
            'timestamp'     => 3,
            'readout'       => "We have liftoff of the Falcon 9"
        ]);
        Telemetry::create([
            'mission_id'    => 8,
            'timestamp'     => 8,
            'readout'       => "Falcon 9 has cleared the tower"
        ]);
        Telemetry::create([
            'mission_id'    => 8,
            'timestamp'     => 10,
            'readout'       => "Starting pitchkick"
        ]);
        Telemetry::create([
            'mission_id'    => 8,
            'timestamp'     => 24,
            'readout'       => "Starting gravity turn"
        ]);
        Telemetry::create([
            'mission_id'    => 8,
            'timestamp'     => 28,
            'readout'       => "First stage engines at full power, looking good"
        ]);
        Telemetry::create([
            'mission_id'    => 8,
            'timestamp'     => 39,
            'readout'       => "We have a solid telemetry link and power systems are nominal"
        ]);
        Telemetry::create([
            'mission_id'    => 8,
            'timestamp'     => 51,
            'readout'       => "First stage propellant utilization is active"
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
            'readout'       => "Vehicle is supersonic"
        ]);
        Telemetry::create([
            'mission_id'    => 8,
            'timestamp'     => 83,
            'readout'       => "Vehicle has reached maximum aerodynamic pressure"
        ]);
        Telemetry::create([
            'mission_id'    => 8,
            'timestamp'     => 90,
            'readout'       => "Propulsion's performing nominally, starting stage two engine chill"
        ]);
        Telemetry::create([
            'mission_id'    => 8,
            'timestamp'     => 99,
            'readout'       => "We have a solid RF link and power systems are nominal"
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
            'readout'       => "Dragon power systems are nominal"
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
            'readout'       => "Approaching MECO 1"
        ]);
        Telemetry::create([
            'mission_id'    => 8,
            'timestamp'     => 170,
            'readout'       => "MECO 1. Planned shutdown on engines 1 and 9."
        ]);
        Telemetry::create([
            'mission_id'    => 8,
            'timestamp'     => 175,
            'readout'       => "First stage impact point past min-MECO"
        ]);
        Telemetry::create([
            'mission_id'    => 8,
            'timestamp'     => 181,
            'readout'       => "MECO 2"
        ]);
        Telemetry::create([
            'mission_id'    => 8,
            'timestamp'     => 183,
            'readout'       => "Nominal velocity at MECO"
        ]);
        Telemetry::create([
            'mission_id'    => 8,
            'timestamp'     => 188,
            'readout'       => "Stage sep confirmed"
        ]);
        Telemetry::create([
            'mission_id'    => 8,
            'timestamp'     => 195,
            'readout'       => "MVac ignition confirmed"
        ]);
        Telemetry::create([
            'mission_id'    => 8,
            'timestamp'     => 235,
            'readout'       => "The Dragon uh- The Dragon nosecone has been jettisoned"
        ]);
        Telemetry::create([
            'mission_id'    => 8,
            'timestamp'     => 240,
            'readout'       => "Stage 2 propulsion systems nominal"
        ]);
        Telemetry::create([
            'mission_id'    => 8,
            'timestamp'     => 257,
            'readout'       => "Vehicle remains on a nominal trajectory, 176 kilometres altitude, velocity of 3 kilometres per second, downrange distance 320 kilometres",
            'altitude'      => 176000,
            'velocity'      => 3000,
            'downrange'     => 320000
        ]);
        Telemetry::create([
            'mission_id'    => 8,
            'timestamp'     => 267,
            'readout'       => "And power systems are nominal and we still have a solid telemetry link"
        ]);
        Telemetry::create([
            'mission_id'    => 8,
            'timestamp'     => 271,
            'readout'       => "OSM this is LC, please move to net A."
        ]);
        Telemetry::create([
            'mission_id'    => 8,
            'timestamp'     => 273,
            'readout'       => "Stage 2 propellant utilization is active"
        ]);
        Telemetry::create([
            'mission_id'    => 8,
            'timestamp'     => 317,
            'readout'       => "Vehicle remains on a nominal trajectory. 220 kilometres altitude, 3.4 kilometres per second, and downrange distance of 470 kilometre",
            'altitude'      => 220000,
            'velocity'      => 3400,
            'downrange'     => 470000
        ]);
        Telemetry::create([
            'mission_id'    => 8,
            'timestamp'     => 343,
            'readout'       => "Second stage propulsion performing as expected"
        ]);
        Telemetry::create([
            'mission_id'    => 8,
            'timestamp'     => 364,
            'readout'       => "Second stage power systems looking good and we have a solid telemetry link"
        ]);
        Telemetry::create([
            'mission_id'    => 8,
            'timestamp'     => 377,
            'readout'       => "Vehicle remains on a nominal trajectory. 269 kilometres in altitude, velocity of 4 kilometres per second, and a downrange distance of 712 kilometres",
            'altitude'      => 269000,
            'velocity'      => 4000,
            'downrange'     => 712000
        ]);
        Telemetry::create([
            'mission_id'    => 8,
            'timestamp'     => 418,
            'readout'       => "All stations MD, step uh- procedure 7 dot 1 0 0 complete, we're on uh- procedure 7 dot 1 0 1."
        ]);
        Telemetry::create([
            'mission_id'    => 8,
            'timestamp'     => 430,
            'readout'       => "MVac and stage 2 performance is good"
        ]);
        Telemetry::create([
            'mission_id'    => 8,
            'timestamp'     => 448,
            'readout'       => "Vehicle remains on a nominal trajectory. 300 kilometres in altitude, velocity of 5 kilometres per second, and a downrange distance of 1000 kilometres; IMU sensor remains healthly, and GPS lock is verified",
            'altitude'      => 300000,
            'velocity'      => 5000,
            'downrange'     => 1000000
        ]);
        Telemetry::create([
            'mission_id'    => 8,
            'timestamp'     => 465,
            'readout'       => "And we are picking up data from New Hampshire"
        ]);

        Telemetry::create([
            'mission_id'    => 8,
            'timestamp'     => 518,
            'readout'       => "Vehicle's in terminal guidance"
        ]);
        Telemetry::create([
            'mission_id'    => 8,
            'timestamp'     => 526,
            'readout'       => "Vehicle has passed the European gate"
        ]);
        Telemetry::create([
            'mission_id'    => 8,
            'timestamp'     => 546,
            'readout'       => "FTS is safed"
        ]);
        Telemetry::create([
            'mission_id'    => 8,
            'timestamp'     => 555,
            'readout'       => "Roughly 30 seconds till Dragon sep"
        ]);
        Telemetry::create([
            'mission_id'    => 8,
            'timestamp'     => 565,
            'readout'       => "MVac shutdown confirmed"
        ]);
        Telemetry::create([
            'mission_id'    => 8,
            'timestamp'     => 568,
            'readout'       => "Dragon's in separation"
        ]);
        Telemetry::create([
            'mission_id'    => 8,
            'timestamp'     => 569,
            'readout'       => "Falcon 9 and Dragon are in orbit"
        ]);
        Telemetry::create([
            'mission_id'    => 8,
            'timestamp'     => 570,
            'readout'       => "Dragon's in separation state"
        ]);
        Telemetry::create([
            'mission_id'    => 8,
            'timestamp'     => 571,
            'readout'       => "[inaudible] prime"
        ]);
        Telemetry::create([
            'mission_id'    => 8,
            'timestamp'     => 573,
            'readout'       => "[inaudible]"
        ]);
        Telemetry::create([
            'mission_id'    => 8,
            'timestamp'     => 578,
            'readout'       => "All stations continue procedures on 7 1 dot-"
        ]);
        Telemetry::create([
            'mission_id'    => 8,
            'timestamp'     => 580,
            'readout'       => "Apogee 346 kilometres, perigee 297 kilometre"
        ]);
        Telemetry::create([
            'mission_id'    => 8,
            'timestamp'     => 594,
            'readout'       => "Inclination 51.66 degrees"
        ]);
        Telemetry::create([
            'mission_id'    => 8,
            'timestamp'     => 598,
            'readout'       => "Cameras forward"
        ]);
        Telemetry::create([
            'mission_id'    => 8,
            'timestamp'     => 602,
            'readout'       => "Dragon sep"
        ]);
        Telemetry::create([
            'mission_id'    => 8,
            'timestamp'     => 610,
            'readout'       => "Start of payload settling deploy"
        ]);
        Telemetry::create([
            'mission_id'    => 8,
            'timestamp'     => 629,
            'readout'       => "Dragon is now freeflying in orbit around the Earth, we are very excited, if we maintain video coverage we hope to see deployment of the solar arrays, if we loose video, everything is likely still operating nominally, we're just at the limit of our signal. We have about a minute before the fairings that house the solar arrays are going to jettison, and that is going to automatically trigger their deployment. Right now the Dragon's propellant system's priming itself, and the thrusters are going to fire, and then it will- uh oh. Hopefully we can hold signal here. Boy, we have just about 40 seconds to wait for this. Let's see if we can't hold our signal and watch these solar arrays deploy."
        ]);
        Telemetry::create([
            'mission_id'    => 8,
            'timestamp'     => 678,
            'readout'       => "Solar array deploy attitude"
        ]);
        Telemetry::create([
            'mission_id'    => 8,
            'timestamp'     => 680,
            'readout'       => "Confirm Draco thruster firings"
        ]);
        Telemetry::create([
            'mission_id'    => 8,
            'timestamp'     => 687,
            'readout'       => "Attitude looks good"
        ]);
        Telemetry::create([
            'mission_id'    => 8,
            'timestamp'     => 696,
            'readout'       => "Dragon is in array deploy"
        ]);
        Telemetry::create([
            'mission_id'    => 8,
            'timestamp'     => 698,
            'readout'       => "Props is nominal"
        ]);
        Telemetry::create([
            'mission_id'    => 8,
            'timestamp'     => 700,
            'readout'       => "Dragon solar array deployment confirmed"
        ]);

        Telemetry::create([
            'mission_id'    => 8,
            'timestamp'     => 702,
            'readout'       => "New Foundland AOS"
        ]);
        Telemetry::create([
            'mission_id'    => 8,
            'timestamp'     => 11 * 60 + 43,
            'readout'       => "Solar array deployment!"
        ]);
        Telemetry::create([
            'mission_id'    => 8,
            'timestamp'     => 11 * 60 + 49,
            'readout'       => "Solar arrays have deployed"
        ]);
        Telemetry::create([
            'mission_id'    => 8,
            'timestamp'     => 11 * 60 + 55,
            'readout'       => "Well, we can see the solar arrays deploying, this is a great moment. Of course, this is just the first step of a very complex mission. Uhh... but from all accounts we have Dragon orbiting the Earth with the solar arrays deployed!"
        ]);
        Telemetry::create([
            'mission_id'    => 8,
            'timestamp'     => 12 * 60 + 2,
            'readout'       => "Power global"
        ]);
        Telemetry::create([
            'mission_id'    => 8,
            'timestamp'     => 12 * 60 + 11,
            'readout'       => "This is so good!"
        ]);
        Telemetry::create([
            'mission_id'    => 8,
            'timestamp'     => 12 * 60 + 14,
            'readout'       => "We have a couple days of really difficult challenges before we get to the space station, but, but both solar arrays are deployed. Dragon is performing nominally and we are looking forward to a great mission here to the International Space Station. Hopefully become the first private company to service our international community at the space station"
        ]);
        Telemetry::create([
            'mission_id'    => 8,
            'timestamp'     => 12 * 60 + 49,
            'readout'       => "Power global"
        ]);
        Telemetry::create([
            'mission_id'    => 8,
            'timestamp'     => 12 * 60 + 50,
            'readout'       => "Go ahead and acknowledge MD"
        ]);
        Telemetry::create([
            'mission_id'    => 8,
            'timestamp'     => 12 * 60 + 51,
            'readout'       => "Okay, power global ackn-"
        ]);
        Telemetry::create([
            'mission_id'    => 8,
            'timestamp'     => 12 * 60 + 56,
            'readout'       => "LD, MDI on countdown"
        ]);
        Telemetry::create([
            'mission_id'    => 8,
            'timestamp'     => 13 * 60 + 0,
            'readout'       => "LD's on a phone call right now MD"
        ]);
        Telemetry::create([
            'mission_id'    => 8,
            'timestamp'     => 13 * 60 + 2,
            'readout'       => "Yeah, I copy that LC. Uhh, we're gonna' be switching off countdown net, thanks for the ride."
        ]);
        Telemetry::create([
            'mission_id'    => 8,
            'timestamp'     => 13 * 60 + 12,
            'readout'       => "K, all stations. This is MD on Mission A. We're on 1 dot 1 0."
        ]);
        Telemetry::create([
            'mission_id'    => 8,
            'timestamp'     => 13 * 60 + 24,
            'readout'       => "Dragon is in coelliptic plan, no comm"
        ]);
        Telemetry::create([
            'mission_id'    => 8,
            'timestamp'     => 13 * 60 + 42,
            'readout'       => "Well as expected. Dragon is just about at the limit of the New Foundland groundstation, we're probably going to lose video shortly, but right now, Dragon is stil communicating with mission control here in Hawthorne, California, and everything looks great, it continues to circle the globe. We can hear the audience here. Everyone at SpaceX, we have 1800 plus people, we're all working really hard, and we're on our way to a great mission. We still have 3 and a half days, a lot of test manovuers before we get to the station, so stay in touch with us at spacex.com and Twitter, and continue to cheer us on."
        ]);
        Telemetry::create([
            'mission_id'    => 8,
            'timestamp'     => 14 * 60 + 22,
            'readout'       => "So, uhh, let's see if I can talk now. We had a great launch today. This is the third successful flight of Falcon 9; the second time we've put Dragon safely into orbit, this is so awesome. We definitely hope to continue to the success over the next two weeks, where we are making progress to the space station; and I feel pretty good that we are going to be the first private company to ever visit the International Space Station, this is so exciting. Please be sure to stay tuned to spacex.com, and Facebook, and Twitter, and all those things, because there's all kinds of great tweets right now. Yeah, please just stay up to date with what's going on."
        ]);
        Telemetry::create([
            'mission_id'    => 8,
            'timestamp'     => 14 * 60 + 58,
            'readout'       => "And we want to extend a special thanks to NASA for their teamwork and support, and todays mission, and getting here, to all of our customers and supporters over the years, to the worldwide network of trackign stations that are going to be helping us with Dragon going to the space station and back over the coming couple of weeks, and finally to the Air Force and the folks at Cape Canveral for the great support in getting todays launch off the pad!"
        ]);
        Telemetry::create([
            'mission_id'    => 8,
            'timestamp'     => 15 * 60 + 22,
            'readout'       => "So, on behalf of the 1800 people here at SpaceX, we thank you so much for watching this amazing mission today. It's a great day, it's almost surreal, so cool. Yeah, and just please continue to watch as Dragon makes its progress to the space station. Thank you."
        ]);
    }

    public function CRS1() {
        Telemetry::create([
            'mission_id'    => 9,
            'timestamp'     => 0 * 60 + 4,
            'readout'       => "Liftoff of the Falcon 9"
        ]);
        Telemetry::create([
            'mission_id'    => 9,
            'timestamp'     => 0 * 60 + 9,
            'readout'       => "Falcon 9 has cleared the tower"
        ]);
        Telemetry::create([
            'mission_id'    => 9,
            'timestamp'     => 0 * 60 + 14,
            'readout'       => "Starting pitchkick"
        ]);
        Telemetry::create([
            'mission_id'    => 9,
            'timestamp'     => 0 * 60 + 14,
            'readout'       => "All systems at full power"
        ]);
        Telemetry::create([
            'mission_id'    => 9,
            'timestamp'     => 0 * 60 + 23,
            'readout'       => "Starting gravity turn"
        ]);
        Telemetry::create([
            'mission_id'    => 9,
            'timestamp'     => 0 * 60 + 35,
            'readout'       => "JDMTA acquisition of signal"
        ]);
        Telemetry::create([
            'mission_id'    => 9,
            'timestamp'     => 0 * 60 + 42,
            'readout'       => "We have a solid telemetry lock on stage one and stage two"
        ]);
        Telemetry::create([
            'mission_id'    => 9,
            'timestamp'     => 0 * 60 + 57,
            'readout'       => "First stage propellant utilization is active"
        ]);
        Telemetry::create([
            'mission_id'    => 9,
            'timestamp'     => 1 * 60 + 3,
            'readout'       => "Vehicle is on a nominal trajectory at 5km in altitude, velocity of 230m/s, and downrange distance of 700m.",
            'velocity'      => 230,
            'altitude'      => 5000,
            'downrange'     => 700
        ]);
        Telemetry::create([
            'mission_id'    => 9,
            'timestamp'     => 1 * 60 + 14,
            'readout'       => "Vehicle is supersonic"
        ]);
        Telemetry::create([
            'mission_id'    => 9,
            'timestamp'     => 1 * 60 + 26,
            'readout'       => "Vehicle has reached maximum aerodynamic pressure"
        ]);
        Telemetry::create([
            'mission_id'    => 9,
            'timestamp'     => 1 * 60 + 46,
            'readout'       => "Second stage has started engine chill"
        ]);
        Telemetry::create([
            'mission_id'    => 9,
            'timestamp'     => 2 * 60 + 7,
            'readout'       => "Dragon power systems are nominal"
        ]);
        Telemetry::create([
            'mission_id'    => 9,
            'timestamp'     => 2 * 60 + 44,
            'readout'       => "Approaching MECO 1"
        ]);
        Telemetry::create([
            'mission_id'    => 9,
            'timestamp'     => 3 * 60 + 13,
            'readout'       => "Passed the min-MECO point"
        ]);
        Telemetry::create([
            'mission_id'    => 9,
            'timestamp'     => 3 * 60 + 18,
            'readout'       => "First stage shutdown"
        ]);
        Telemetry::create([
            'mission_id'    => 9,
            'timestamp'     => 3 * 60 + 21,
            'readout'       => "Stage separation confirmed"
        ]);
        Telemetry::create([
            'mission_id'    => 9,
            'timestamp'     => 3 * 60 + 29,
            'readout'       => "MVac ignition confirmed"
        ]);
        Telemetry::create([
            'mission_id'    => 9,
            'timestamp'     => 4 * 60 + 6,
            'readout'       => "The Dragon nosecone has been jettisoned"
        ]);
        Telemetry::create([
            'mission_id'    => 9,
            'timestamp'     => 4 * 60 + 18,
            'readout'       => "Vehicle remains on a nominal trajectory"
        ]);
        Telemetry::create([
            'mission_id'    => 9,
            'timestamp'     => 4 * 60 + 26,
            'readout'       => "Vehicle altitude is 150km, velocity is 3.1km/s, and downrange distance of 350km",
            'velocity'      => 3100,
            'altitude'      => 150000,
            'downrange'     => 350000
        ]);
        Telemetry::create([
            'mission_id'    => 9,
            'timestamp'     => 4 * 60 + 33,
            'readout'       => "Second stage propellant utilization active"
        ]);
        Telemetry::create([
            'mission_id'    => 9,
            'timestamp'     => 4 * 60 + 38,
            'readout'       => "Avionics systems nominal"
        ]);
        Telemetry::create([
            'mission_id'    => 9,
            'timestamp'     => 5 * 60 + 3,
            'readout'       => "New Hampshire acquisition of singal"
        ]);
        Telemetry::create([
            'mission_id'    => 9,
            'timestamp'     => 5 * 60 + 19,
            'readout'       => "Vehicle remains on a nominal trajectory. Altitude is 163km, velocity is 3.5km/s, downrange distance of 770km",
            'velocity'      => 3500,
            'altitude'      => 163000,
            'downrange'     => 770000
        ]);
        Telemetry::create([
            'mission_id'    => 9,
            'timestamp'     => 5 * 60 + 47,
            'readout'       => "MVac and stage two propulsion systems healthy"
        ]);
        Telemetry::create([
            'mission_id'    => 9,
            'timestamp'     => 5 * 60 + 54,
            'readout'       => "Avionics system and RF link are solid"
        ]);
        Telemetry::create([
            'mission_id'    => 9,
            'timestamp'     => 6 * 60 + 3,
            'readout'       => "LC this is OSM"
        ]);
        Telemetry::create([
            'mission_id'    => 9,
            'timestamp'     => 6 * 60 + 5,
            'readout'       => "Go Ahead"
        ]);
        Telemetry::create([
            'mission_id'    => 9,
            'timestamp'     => 6 * 60 + 6,
            'readout'       => "Uhh, yes sir. I've looked around the pad, it looks like- the only place we have any- even a small fire, is on the T/E- on the deck. Uhh, [inaudible] fire department gets here they can go ahead and do there sweep, over"
        ]);
        Telemetry::create([
            'mission_id'    => 9,
            'timestamp'     => 6 * 60 + 20,
            'readout'       => "Copy that, pad secured, they can go on"
        ]);
        Telemetry::create([
            'mission_id'    => 9,
            'timestamp'     => 6 * 60 + 21,
            'readout'       => "The vehicle remains on a nominal trajectory, Altitude is 186km, velocity is 4km/s",
            'velocity'      => 4000,
            'altitude'      => 186000
        ]);
        Telemetry::create([
            'mission_id'    => 9,
            'timestamp'     => 7 * 60 + 15,
            'readout'       => "MVac and stage two performance is good"
        ]);
        Telemetry::create([
            'mission_id'    => 9,
            'timestamp'     => 7 * 60 + 30,
            'readout'       => "The vehicle remains on a nominal trajectory. Altitude of 200km, and velocity of 4.9km/s",
            'velocity'      => 4900,
            'altitude'      => 200000
        ]);
        Telemetry::create([
            'mission_id'    => 9,
            'timestamp'     => 7 * 60 + 39,
            'readout'       => "LC this is OSM, they're just about there, I recommend we go ahead and [fade out]"
        ]);
        Telemetry::create([
            'mission_id'    => 9,
            'timestamp'     => 8 * 60 + 13,
            'readout'       => "Vehicle is passing through the head-on gate"
        ]);
        Telemetry::create([
            'mission_id'    => 9,
            'timestamp'     => 8 * 60 + 42,
            'readout'       => "Propulsion systems nominal"
        ]);
        Telemetry::create([
            'mission_id'    => 9,
            'timestamp'     => 8 * 60 + 48,
            'readout'       => "FTS has been safed"
        ]);
        Telemetry::create([
            'mission_id'    => 9,
            'timestamp'     => 8 * 60 + 50,
            'readout'       => "Vehicle is in terminal guidance mode"
        ]);
        Telemetry::create([
            'mission_id'    => 9,
            'timestamp'     => 8 * 60 + 53,
            'readout'       => "Avionic systems are nominal"
        ]);
        Telemetry::create([
            'mission_id'    => 9,
            'timestamp'     => 9 * 60 + 33,
            'readout'       => "Nominal LOS from the Cape"
        ]);
        Telemetry::create([
            'mission_id'    => 9,
            'timestamp'     => 9 * 60 + 34,
            'readout'       => "IIP left"
        ]);
        Telemetry::create([
            'mission_id'    => 9,
            'timestamp'     => 9 * 60 + 40,
            'readout'       => "MVac shutdown confirmed"
        ]);
        Telemetry::create([
            'mission_id'    => 9,
            'timestamp'     => 9 * 60 + 44,
            'readout'       => "Dragon's in separation"
        ]);
        Telemetry::create([
            'mission_id'    => 9,
            'timestamp'     => 9 * 60 + 45,
            'readout'       => "Prop-rate is in prime"
        ]);
        Telemetry::create([
            'mission_id'    => 9,
            'timestamp'     => 9 * 60 + 51,
            'readout'       => "Falcon 9 and Dragon are in orbit, perigee 197km, apogee 328km."
        ]);
        Telemetry::create([
            'mission_id'    => 9,
            'timestamp'     => 10 * 60 + 0,
            'readout'       => "All stations, MD, we're on step one dot two and step one dot four with nav-one and sys-two"
        ]);
        Telemetry::create([
            'mission_id'    => 9,
            'timestamp'     => 10 * 60 + 43,
            'readout'       => "Manifolds venting"
        ]);
        Telemetry::create([
            'mission_id'    => 9,
            'timestamp'     => 10 * 60 + 50,
            'readout'       => "[inaudible] open"
        ]);
        Telemetry::create([
            'mission_id'    => 9,
            'timestamp'     => 10 * 60 + 55,
            'readout'       => "[inaudible] open"
        ]);
        Telemetry::create([
            'mission_id'    => 9,
            'timestamp'     => 11 * 60 + 7,
            'readout'       => "Got a console arm on software"
        ]);
        Telemetry::create([
            'mission_id'    => 9,
            'timestamp'     => 11 * 60 + 9,
            'readout'       => "Dragon's in post-prime"
        ]);
        Telemetry::create([
            'mission_id'    => 9,
            'timestamp'     => 11 * 60 + 11,
            'readout'       => "Priming complete"
        ]);
        Telemetry::create([
            'mission_id'    => 9,
            'timestamp'     => 11 * 60 + 13,
            'readout'       => "Nominal AOS New Foundland"
        ]);
        Telemetry::create([
            'mission_id'    => 9,
            'timestamp'     => 11 * 60 + 13,
            'readout'       => "[inaudible] to deploy attitude"
        ]);
        Telemetry::create([
            'mission_id'    => 9,
            'timestamp'     => 11 * 60 + 15,
            'readout'       => "Flight software, you got on this software global?"
        ]);
        Telemetry::create([
            'mission_id'    => 9,
            'timestamp'     => 11 * 60 + 17,
            'readout'       => "Yeah, we're looking into it. I'm acknowledging."
        ]);
        Telemetry::create([
            'mission_id'    => 9,
            'timestamp'     => 11 * 60 + 22,
            'readout'       => "Thruster firings confirmed, props[inaudible] nominal"
        ]);
        Telemetry::create([
            'mission_id'    => 9,
            'timestamp'     => 11 * 60 + 24,
            'readout'       => "Dragon's in array deploy attitude"
        ]);
        Telemetry::create([
            'mission_id'    => 9,
            'timestamp'     => 11 * 60 + 28,
            'readout'       => "Slew looked good"
        ]);
        Telemetry::create([
            'mission_id'    => 9,
            'timestamp'     => 11 * 60 + 47,
            'readout'       => "Nominal LOS Wallops"
        ]);
        Telemetry::create([
            'mission_id'    => 9,
            'timestamp'     => 12 * 60 + 12,
            'readout'       => "Dragon's in array deploy state"
        ]);
        Telemetry::create([
            'mission_id'    => 9,
            'timestamp'     => 12 * 60 + 18,
            'readout'       => "It's expected MD"
        ]);
        Telemetry::create([
            'mission_id'    => 9,
            'timestamp'     => 12 * 60 + 20,
            'readout'       => "Copy, [inaudible]"
        ]);
        Telemetry::create([
            'mission_id'    => 9,
            'timestamp'     => 12 * 60 + 20,
            'readout'       => "Dragon's in array deploy"
        ]);
        Telemetry::create([
            'mission_id'    => 9,
            'timestamp'     => 12 * 60 + 21,
            'readout'       => "Array deploy"
        ]);
        Telemetry::create([
            'mission_id'    => 9,
            'timestamp'     => 12 * 60 + 57,
            'readout'       => "All stations MD, we're on one dot one zero"
        ]);
        Telemetry::create([
            'mission_id'    => 9,
            'timestamp'     => 13 * 60 + 4,
            'readout'       => "Nice work"
        ]);
        Telemetry::create([
            'mission_id'    => 9,
            'timestamp'     => 13 * 60 + 29,
            'readout'       => "As expected, Dragon has now passed beyond the viewable range of the New Foundland, Canada ground station. SpaceX mission control here in Hawthorne will continue to communicate with Dragon as it circles the globe"
        ]);
        Telemetry::create([
            'mission_id'    => 9,
            'timestamp'     => 13 * 60 + 45,
            'readout'       => "yay, and as always we're super excited we had a great launch today. This is the fourth successful flight of the Falcon 9 rocket, and our third operational Dragon spacecraft put into orbit. This- let's see- Dragon is going to spend the next, about, three days catching up with the International Space Station so it plans to arrive there Wednesday October 10th, around 2AM Pacific Time, 5AM Eastern Time. So- oh yes! And happy birthday John! Always good! Yes. A launch- a successful launch is the best-"
        ]);
        Telemetry::create([
            'mission_id'    => 9,
            'timestamp'     => 14 * 60 + 21,
            'readout'       => "A great candle!"
        ]);
        Telemetry::create([
            'mission_id'    => 9,
            'timestamp'     => 14 * 60 + 23,
            'readout'       => "Exactly. So be sure to stay tuned to our Facebook and Twitter pages and spacex.com and you can follow Dragon's entire mission from now until it actually attaches to the space station, and you can see a ton of live footage on our pages and nasa, of the astronauts inside the space station, unloading cargo. There's gonna' to be lots of cool stuff to watch over the next few weeks."
        ]);
        Telemetry::create([
            'mission_id'    => 9,
            'timestamp'     => 14 * 60 + 43,
            'readout'       => "And here at SpaceX we want to extend our special thanks to NASA for their partnership and support on the CRS program."
        ]);
        Telemetry::create([
            'mission_id'    => 9,
            'timestamp'     => 14 * 60 + 52,
            'readout'       => "And we have uhh, over 1800 people here at SpaceX. We thank you so much for tuning in, and yes, we'll look forward to a great rest of the mission, so thank you all again and bub bye!"
        ]);
    }

    public function CRS2() {
        Telemetry::create([
            'mission_id'    => 10,
            'timestamp'     => 3,
            'readout'       => "We have liftoff of the Falcon 9"
        ]);
        Telemetry::create([
            'mission_id'    => 10,
            'timestamp'     => 4,
            'readout'       => "Dragon has sensed first stage acceleration"
        ]);
        Telemetry::create([
            'mission_id'    => 10,
            'timestamp'     => 8,
            'readout'       => "Falcon 9 has cleared the tower"
        ]);
        Telemetry::create([
            'mission_id'    => 10,
            'timestamp'     => 12,
            'readout'       => "Solid pitchkick"
        ]);
        Telemetry::create([
            'mission_id'    => 10,
            'timestamp'     => 31,
            'readout'       => "Starting gravity turn"
        ]);
        Telemetry::create([
            'mission_id'    => 10,
            'timestamp'     => 35,
            'readout'       => "Terminal count launch is complete"
        ]);
        Telemetry::create([
            'mission_id'    => 10,
            'timestamp'     => 35,
            'readout'       => "First stage at full power"
        ]);
        Telemetry::create([
            'mission_id'    => 10,
            'timestamp'     => 41,
            'readout'       => "Standing by"
        ]);
        Telemetry::create([
            'mission_id'    => 10,
            'timestamp'     => 50,
            'readout'       => "Power systems nominal and we have a good telemetry lock on stage 1 and 2"
        ]);
        Telemetry::create([
            'mission_id'    => 10,
            'timestamp'     => 55,
            'readout'       => "First stage propellant utilization active"
        ]);
        Telemetry::create([
            'mission_id'    => 10,
            'timestamp'     => 60,
            'readout'       => "Vehicle is 6km in altitude, velocity of 241m/s and downrange distance of 1km",
            'velocity'      => 241,
            'altitude'      => 6000,
            'downrange'     => 1000
        ]);
        Telemetry::create([
            'mission_id'    => 10,
            'timestamp'     => 1 * 60 + 13,
            'readout'       => "Vehicle is supersonic"
        ]);
        Telemetry::create([
            'mission_id'    => 10,
            'timestamp'     => 1 * 60 + 25,
            'readout'       => "Vehicle has reached maximum aerodynamic pressure"
        ]);
        Telemetry::create([
            'mission_id'    => 10,
            'timestamp'     => 1 * 60 + 37,
            'readout'       => "Second stage has started engine chill"
        ]);
        Telemetry::create([
            'mission_id'    => 10,
            'timestamp'     => 2 * 60 + 1,
            'readout'       => "Vehicle remains on a nominal trajectory. Vehicle is 30km in altitude, velocity of 1km/s and downrange distance of 23km",
            'velocity'      => 1000,
            'altitude'      => 30000,
            'downrange'     => 23000
        ]);
        Telemetry::create([
            'mission_id'    => 10,
            'timestamp'     => 2 * 60 + 14,
            'readout'       => "Dragon power systems nominal"
        ]);
        Telemetry::create([
            'mission_id'    => 10,
            'timestamp'     => 2 * 60 + 30,
            'readout'       => "Vehicle remains on a nominal trajectory. Vehicle is 51km in altitude, velocity of 1.8km/s and downrange distance of 59km",
            'velocity'      => 1800,
            'altitude'      => 51000,
            'downrange'     => 59000
        ]);
        Telemetry::create([
            'mission_id'    => 10,
            'timestamp'     => 2 * 60 + 42,
            'readout'       => "Approaching MECO 1"
        ]);
        Telemetry::create([
            'mission_id'    => 10,
            'timestamp'     => 2 * 60 + 50,
            'readout'       => "MECO 1"
        ]);
        Telemetry::create([
            'mission_id'    => 10,
            'timestamp'     => 2 * 60 + 54,
            'readout'       => "Passed min-MECO"
        ]);
        Telemetry::create([
            'mission_id'    => 10,
            'timestamp'     => 2 * 60 + 59,
            'readout'       => "Flight computers in second stage"
        ]);
        Telemetry::create([
            'mission_id'    => 10,
            'timestamp'     => 3 * 60 + 0,
            'readout'       => "Dragon has sensed MECO"
        ]);
        Telemetry::create([
            'mission_id'    => 10,
            'timestamp'     => 3 * 60 + 2,
            'readout'       => "MECO 2, stage 1 shutdown"
        ]);
        Telemetry::create([
            'mission_id'    => 10,
            'timestamp'     => 3 * 60 + 4,
            'readout'       => "Stage separation confirmed"
        ]);
        Telemetry::create([
            'mission_id'    => 10,
            'timestamp'     => 3 * 60 + 13,
            'readout'       => "MVac ignition confirmed"
        ]);
        Telemetry::create([
            'mission_id'    => 10,
            'timestamp'     => 3 * 60 + 15,
            'readout'       => "AOS Wallops"
        ]);
        Telemetry::create([
            'mission_id'    => 10,
            'timestamp'     => 3 * 60 + 54,
            'readout'       => "Nosecone separation"
        ]);
        Telemetry::create([
            'mission_id'    => 10,
            'timestamp'     => 3 * 60 + 57,
            'readout'       => "All stations MD on mission A. Please proceed to procedure zero dot one zero one, Dragon On-Orbit Activation Deployment. Standing by for Dragon separation and prop-priming"
        ]);
        Telemetry::create([
            'mission_id'    => 10,
            'timestamp'     => 4 * 60 + 8,
            'readout'       => "Second stage propulsion systems nominal"
        ]);
        Telemetry::create([
            'mission_id'    => 10,
            'timestamp'     => 4 * 60 + 21,
            'readout'       => "Vehicle remains on a nominal trajectory. Vehicle is 148km in altitude, velocity of 3.2km/s and downrange distance of 346km",
            'velocity'      => 3200,
            'altitude'      => 148000,
            'downrange'     => 346000
        ]);
        Telemetry::create([
            'mission_id'    => 10,
            'timestamp'     => 4 * 60 + 39,
            'readout'       => "Second stage propellant utilization active"
        ]);
        Telemetry::create([
            'mission_id'    => 10,
            'timestamp'     => 5 * 60 + 22,
            'readout'       => "Vehicle remains on a nominal trajectory. Vehicle is 182km in altitude, velocity of 4km/s, and downrange distance of 541km",
            'velocity'      => 4000,
            'altitude'      => 182000,
            'downrange'     => 541000
        ]);
        Telemetry::create([
            'mission_id'    => 10,
            'timestamp'     => 6 * 60 + 0,
            'readout'       => "Second stage propulsion systems look good"
        ]);
        Telemetry::create([
            'mission_id'    => 10,
            'timestamp'     => 6 * 60 + 4,
            'readout'       => "Power systems look nominal and we have a good telemetry lock on stage 2"
        ]);
        Telemetry::create([
            'mission_id'    => 10,
            'timestamp'     => 6 * 60 + 24,
            'readout'       => "Vehicle is 200km in altitude, velocity of 4.6km/s and downrange distance of 767km",
            'velocity'      => 4600,
            'altitude'      => 200000,
            'downrange'     => 767000
        ]);
        Telemetry::create([
            'mission_id'    => 10,
            'timestamp'     => 7 * 60 + 32,
            'readout'       => "Vehicle remains on a nominal trajectory. Vehicle is 210km in altitude, velocity of 5.6km/s, and downrange distance of 1080km. IMU and GPS look good.",
            'velocity'      => 210000,
            'altitude'      => 56000,
            'downrange'     => 1080000
        ]);
        Telemetry::create([
            'mission_id'    => 10,
            'timestamp'     => 7 * 60 + 51,
            'readout'       => "Vehicle is passing through the head-on gate"
        ]);
        Telemetry::create([
            'mission_id'    => 10,
            'timestamp'     => 8 * 60 + 3,
            'readout'       => "Stage 2 propulsion systems continue to be nominal"
        ]);
        Telemetry::create([
            'mission_id'    => 10,
            'timestamp'     => 8 * 60 + 27,
            'readout'       => "Vehicle's in terminal guidance"
        ]);
        Telemetry::create([
            'mission_id'    => 10,
            'timestamp'     => 8 * 60 + 33,
            'readout'       => "FTS is safed"
        ]);
        Telemetry::create([
            'mission_id'    => 10,
            'timestamp'     => 9 * 60 + 8,
            'readout'       => "LOS Cape"
        ]);
        Telemetry::create([
            'mission_id'    => 10,
            'timestamp'     => 9 * 60 + 22,
            'readout'       => "MVac shutdown confirmed"
        ]);
        Telemetry::create([
            'mission_id'    => 10,
            'timestamp'     => 9 * 60 + 23,
            'readout'       => "Flight computers in separation state"
        ]);
        Telemetry::create([
            'mission_id'    => 10,
            'timestamp'     => 9 * 60 + 27,
            'readout'       => "Dragon has sensed SECO"
        ]);
        Telemetry::create([
            'mission_id'    => 10,
            'timestamp'     => 9 * 60 + 30,
            'readout'       => "Vehicle is orbital. Perigee 199km, apogee 323km, inclination 51.66 degrees"
        ]);
        Telemetry::create([
            'mission_id'    => 10,
            'timestamp'     => 9 * 60 + 46,
            'readout'       => "Cameras pointing forward"
        ]);
        Telemetry::create([
            'mission_id'    => 10,
            'timestamp'     => 9 * 60 + 55,
            'readout'       => "Dragon sep commanded"
        ]);
        Telemetry::create([
            'mission_id'    => 10,
            'timestamp'     => 10 * 60 + 10,
            'readout'       => "All stations, MD on mission A, succesful Dragon F9 sep, thank you for the ride F9"
        ]);
        Telemetry::create([
            'mission_id'    => 10,
            'timestamp'     => 10 * 60 + 39,
            'readout'       => "[inaudible] prop global"
        ]);
        Telemetry::create([
            'mission_id'    => 10,
            'timestamp'     => 10 * 60 + 51,
            'readout'       => "Prop global"
        ]);
        Telemetry::create([
            'mission_id'    => 10,
            'timestamp'     => 10 * 60 + 56,
            'readout'       => "All stations, prop software globals"
        ]);
        Telemetry::create([
            'mission_id'    => 10,
            'timestamp'     => 10 * 60 + 58,
            'readout'       => "Sys2 acknowedging prop global"
        ]);
        Telemetry::create([
            'mission_id'    => 10,
            'timestamp'     => 11 * 60 + 3,
            'readout'       => "Noting that prop alarms are inhibited. Flight computers in post-prime state. Software global"
        ]);
        Telemetry::create([
            'mission_id'    => 10,
            'timestamp'     => 11 * 60 + 12,
            'readout'       => "LOS Wallops"
        ]);
        Telemetry::create([
            'mission_id'    => 10,
            'timestamp'     => 11 * 60 + 45,
            'readout'       => "AOS New Foundland"
        ]);
        Telemetry::create([
            'mission_id'    => 10,
            'timestamp'     => 11 * 60 + 46,
            'readout'       => "Acknowledging software global"
        ]);
        Telemetry::create([
            'mission_id'    => 10,
            'timestamp'     => 11 * 60 + 54,
            'readout'       => "Flight computer in abort-passive"
        ]);
        Telemetry::create([
            'mission_id'    => 10,
            'timestamp'     => 13 * 60 + 40,
            'readout'       => "It appears that, although it achieved Earth orbit, Dragon is experiencing some type of problem right now. We'll have to learn about the nature of what happened. According to procedures, we expect a press conference to be held within a few hours from now. At that time, further information may be available. This will bring us to the conclusion of our live webcast for today. Please check our website, spacex.com, where we will be providing you with more information as it becomes available. Thank you for joining us today."
        ]);
    }

    // Add in non-readout telemetry
    public function CASSIOPE() {
        Telemetry::create([
            'mission_id'    => 11,
            'timestamp'     => 0 * 60 + 2,
            'readout'       => "Liftoff"
        ]);
        Telemetry::create([
            'mission_id'    => 11,
            'timestamp'     => 0 * 60 + 7,
            'readout'       => "PROP, AVI, GNC move to ten dot fifty-nine"
        ]);
        Telemetry::create([
            'mission_id'    => 11,
            'timestamp'     => 0 * 60 + 12,
            'readout'       => "GC move to ten dot fifty-eight"
        ]);
        Telemetry::create([
            'mission_id'    => 11,
            'timestamp'     => 0 * 60 + 14,
            'readout'       => "GC's in ten dot fifty-eight"
        ]);
        Telemetry::create([
            'mission_id'    => 11,
            'timestamp'     => 0 * 60 + 36,
            'readout'       => "First stage propellant utilization active"
        ]);
        Telemetry::create([
            'mission_id'    => 11,
            'timestamp'     => 0 * 60 + 40,
            'readout'       => "San- San Nicholas Island has data"
        ]);
        Telemetry::create([
            'mission_id'    => 11,
            'timestamp'     => 0 * 60 + 56,
            'readout'       => "OSM copies"
        ]);
        Telemetry::create([
            'mission_id'    => 11,
            'timestamp'     => 0 * 60 + 59,
            'readout'       => "The vehicle remains on a nominal trajectory, altitude is 5.8km, velocity of 467m/s, downrange distance of 600m",
            'velocity'      => 467,
            'altitude'      => 5800,
            'downrange'     => 600
        ]);
        Telemetry::create([
            'mission_id'    => 11,
            'timestamp'     => 1 * 60 + 8,
            'readout'       => "The vehicle is supersonic"
        ]);
        Telemetry::create([
            'mission_id'    => 11,
            'timestamp'     => 1 * 60 + 12,
            'readout'       => "Good telemetry, good power health"
        ]);
        Telemetry::create([
            'mission_id'    => 11,
            'timestamp'     => 1 * 60 + 15,
            'readout'       => "The vehicle is passing through maximum aerodynamic pressure"
        ]);
        Telemetry::create([
            'mission_id'    => 11,
            'timestamp'     => 0,
            'readout'       => "Telemetry still nominal, power still nominal"
        ]);
        Telemetry::create([
            'mission_id'    => 11,
            'timestamp'     => 1 * 60 + 56,
            'readout'       => "Second stage engine chill has started"
        ]);
        Telemetry::create([
            'mission_id'    => 11,
            'timestamp'     => 1 * 60 + 59,
            'readout'       => "The vehicle remains on a velocity of 1.1km/s downrange distance of [cutoff]",
            'velocity'      => 1100
        ]);
        Telemetry::create([
            'mission_id'    => 11,
            'timestamp'     => 2 * 60 + 30,
            'readout'       => "nominal trajectory, altitude is 61km, velocity of 1.8km/s, downrange distance of 45km",
            'velocity'      => 1800,
            'altitude'      => 61000,
            'downrange'     => 45000
        ]);
        Telemetry::create([
            'mission_id'    => 11,
            'timestamp'     => 2 * 60 + 31,
            'readout'       => "Approaching MECO 1"
        ]);
        Telemetry::create([
            'mission_id'    => 11,
            'timestamp'     => 0,
            'readout'       => "Stage 1 shutdown"
        ]);
        Telemetry::create([
            'mission_id'    => 11,
            'timestamp'     => 0,
            'readout'       => "First stage FTS safed"
        ]);
        Telemetry::create([
            'mission_id'    => 11,
            'timestamp'     => 0,
            'readout'       => "Stage sep confirmed [audience heard celebrating]"
        ]);
        Telemetry::create([
            'mission_id'    => 11,
            'timestamp'     => 2 * 60 + 56,
            'readout'       => "MVac ignition confirmed"
        ]);
        Telemetry::create([
            'mission_id'    => 11,
            'timestamp'     => 3 * 60 + 29,
            'readout'       => "Stage two propellant utilization active"
        ]);
        Telemetry::create([
            'mission_id'    => 11,
            'timestamp'     => 0,
            'readout'       => "Stage 2 propulsion looking good"
        ]);
        Telemetry::create([
            'mission_id'    => 11,
            'timestamp'     => 3 * 60 + 36,
            'readout'       => "Fairing separation confirmed"
        ]);
        Telemetry::create([
            'mission_id'    => 11,
            'timestamp'     => 0,
            'readout'       => "Telemetry still nominal"
        ]);
        Telemetry::create([
            'mission_id'    => 11,
            'timestamp'     => 0,
            'readout'       => "The vehicle remains on a nominal trajectory. Altitude of 232km, velocity of 2.9km/s, downrange distance of 383km",
            'velocity'      => 2900,
            'altitude'      => 232000,
            'downrange'     => 383000
        ]);
        Telemetry::create([
            'mission_id'    => 11,
            'timestamp'     => 0,
            'readout'       => "Stage two propulsion looking good"
        ]);
        Telemetry::create([
            'mission_id'    => 11,
            'timestamp'     => 0,
            'readout'       => "Power systems nominal"
        ]);
        Telemetry::create([
            'mission_id'    => 11,
            'timestamp'     => 6 * 60 + 17,
            'readout'       => "Vehicle remains on a nominal trajectory. Altitude of 274km, velocity of 3.7km/s, with a downrange distance of 565km",
            'velocity'      => 3700,
            'altitude'      => 274000,
            'downrange'     => 565000
        ]);
        Telemetry::create([
            'mission_id'    => 11,
            'timestamp'     => 0,
            'readout'       => "Cook link 13, link 51 from cook is still up"
        ]);
        Telemetry::create([
            'mission_id'    => 11,
            'timestamp'     => 0,
            'readout'       => "The vehicle remains on a nominal trajectory. Altitude of 310km, velocity of 5km/s, with a downrange distance of 850km",
            'velocity'      => 5000,
            'altitude'      => 310000,
            'downrange'     => 850000
        ]);
        Telemetry::create([
            'mission_id'    => 11,
            'timestamp'     => 7 * 60 + 57,
            'readout'       => "First stage is burning, err- relighting at this time"
        ]);
        Telemetry::create([
            'mission_id'    => 11,
            'timestamp'     => 8 * 60 + 25,
            'readout'       => "Stage 2 has transitioned to terminal guidance"
        ]);
        Telemetry::create([
            'mission_id'    => 11,
            'timestamp'     => 8 * 60 + 33,
            'readout'       => "FTS is safed"
        ]);
        Telemetry::create([
            'mission_id'    => 11,
            'timestamp'     => 8 * 60 + 59,
            'readout'       => "Approaching SECO 1"
        ]);
        Telemetry::create([
            'mission_id'    => 11,
            'timestamp'     => 9 * 60 + 8,
            'readout'       => "MVac shutdown confirmed"
        ]);
        Telemetry::create([
            'mission_id'    => 11,
            'timestamp'     => 11 * 60 + 10,
            'readout'       => "Vandenberg Air Force base loss of signal, on second stage. Expected loss of signal. That was a little bit better than we predicted."
        ]);
        Telemetry::create([
            'mission_id'    => 11,
            'timestamp'     => 13 * 60 + 9,
            'readout'       => "Ugh, what a ride! And you can hear the cheering behind us, as everybody was following along the Falcon 9 team, as we rode to space, is an amazing flight. So far I see tons of data coming back, it looks like it was a picture perfect flight everything was looking good, right down the middle of the track, looks like orbit's good, so we'll be waiting to hear, as we go onto the morning, uhh but I think right now, that brings us to the end of the scripted events for the morning! So I think right now lets throws it to Keiko, who's downstairs with the crowd, and then come back to us, and we'll be signing off"
        ]);
        Telemetry::create([
            'mission_id'    => 11,
            'timestamp'     => 13 * 60 + 56,
            'readout'       => "Well, that was a pretty awesome launch. Everybody down here is super excited, as you can hear them. I think uhh, we'll definitely want to get right back to work and get ready for the next one, that's what we do here."
        ]);
        Telemetry::create([
            'mission_id'    => 11,
            'timestamp'     => 14 * 60 + 12,
            'readout'       => "Thank you Keiko. Well, from the SpaceX team, Jessica, anything you want to say to wrap it up?"
        ]);
        Telemetry::create([
            'mission_id'    => 11,
            'timestamp'     => 14 * 60 + 18,
            'readout'       => "I just want to thank all of you for supporting us, this was a new demonstration launch and it went perfect, we were so excited and we're glad you all tuned in, so, stay up to date for us, we'll be doing more Grasshopper stuff, and we have a lot more Falcon 9 launches coming, so, stay up to date, and thank you!"
        ]);
        Telemetry::create([
            'mission_id'    => 11,
            'timestamp'     => 14 * 60 + 36,
            'readout'       => "I think right now the plan is there'll probably be some type of media conference later this afternoon. Tie in to our website, see what's happening, as well as we'll give updates as we go along in the mission, but for that, I also want to send thanks for not only the people that support us, but MDA Corporation who rode with us on the Falcon 9 as well as our other smallsat partners. It's been a great day here in Hawthorne, a great day in Vandenberg, and all over the SpaceX crews, in McGregor, DC, the Cape, everybody participating working along here. So with that, what we'd like to do is close the webcast with a thank you for tuning in, come back, we've got another launch coming out of the Cape coming up in just several weeks, where we get to live this all over again! So with that, a goodbye from Hawthorne, California at the SpaceX factory!"
        ]);
    }

    public function SES8() {
        Telemetry::create([
            'mission_id'    => 12,
            'timestamp'     => 1,
            'readout'       => "We have liftoff of the Falcon 9"
        ]);
        Telemetry::create([
            'mission_id'    => 12,
            'timestamp'     => 11,
            'readout'       => "Falcon 9 has cleared the towers"
        ]);
        Telemetry::create([
            'mission_id'    => 12,
            'timestamp'     => 19,
            'readout'       => "[inaudible]"
        ]);
        Telemetry::create([
            'mission_id'    => 12,
            'timestamp'     => 51 - 15,
            'readout'       => "First propellant utilization active"
        ]);
        Telemetry::create([
            'mission_id'    => 12,
            'timestamp'     => 54 - 15,
            'readout'       => "Power systems nominal and we have good telemetry lock"
        ]);
        Telemetry::create([
            'mission_id'    => 12,
            'timestamp'     => 68 - 15,
            'readout'       => "Vehicle remains on a nominal trajectory with an altitude of 6km, a downrange distance of one fifth of a kilometre, and a velocity of 230m/s",
            'altitude'      => 6000,
            'downrange'     => 200,
            'velocity'      => 230
        ]);
        Telemetry::create([
            'mission_id'    => 12,
            'timestamp'     => 78 - 15,
            'readout'       => "OSM [inaudible] please"
        ]);
        Telemetry::create([
            'mission_id'    => 12,
            'timestamp'     => 78 - 15,
            'readout'       => "[inaudible] supersonic"
        ]);
        Telemetry::create([
            'mission_id'    => 12,
            'timestamp'     => 90 - 15,
            'readout'       => "Vehicle is passing through maximum aerodynamic pressure"
        ]);
        Telemetry::create([
            'mission_id'    => 12,
            'timestamp'     => 101 - 15,
            'readout'       => "Avionics, power systems nominal, and we still have a good telemetry lock"
        ]);
        Telemetry::create([
            'mission_id'    => 12,
            'timestamp'     => 127 - 15,
            'readout'       => "The vehicle remains on a nominal trajectory with an altitude of 30km, a downrange distance of 26km, and a velocity of 1.2km/s",
            'velocity'      => 1200,
            'altitude'      => 30000,
            'downrange'     => 26000
        ]);
        Telemetry::create([
            'mission_id'    => 12,
            'timestamp'     => 136 - 15,
            'readout'       => "First stage propulsion performing nominally"
        ]);
        Telemetry::create([
            'mission_id'    => 12,
            'timestamp'     => 156 - 15,
            'readout'       => "The vehicle remains on a nominal trajectory with an altitude of 48km, a downrange distance of 64km, and a velocity of 1.9km/s",
            'velocity'      => 1900,
            'altitude'      => 48000,
            'downrange'     => 64000
        ]);
        Telemetry::create([
            'mission_id'    => 12,
            'timestamp'     => 168 - 15,
            'readout'       => "Second stage engine is chilling in"
        ]);
        Telemetry::create([
            'mission_id'    => 12,
            'timestamp'     => 186 - 15,
            'readout'       => "MECO 1"
        ]);
        Telemetry::create([
            'mission_id'    => 12,
            'timestamp'     => 188 - 15,
            'readout'       => "Stage Sep commanded"
        ]);
        Telemetry::create([
            'mission_id'    => 12,
            'timestamp'     => 199 - 15,
            'readout'       => "MVac ignition confirmed"
        ]);
        Telemetry::create([
            'mission_id'    => 12,
            'timestamp'     => 3 * 60 + 52 - 15,
            'readout'       => "Second stage propellant utilization active"
        ]);
        Telemetry::create([
            'mission_id'    => 12,
            'timestamp'     => 4 * 60 + 11 - 15,
            'readout'       => "Fairing sep commanded"
        ]);
        Telemetry::create([
            'mission_id'    => 12,
            'timestamp'     => 4 * 60 + 26 - 15,
            'readout'       => "The vehicle's on a nominal trajectory with an altitude of 129km, a downrange distance 355km, and a velocity of 3.2km/s",
            'velocity'      => 3200,
            'altitude'      => 129000,
            'downrange'     => 355000
        ]);
        Telemetry::create([
            'mission_id'    => 12,
            'timestamp'     => 4 * 60 + 37 - 15,
            'readout'       => "Avionics, power systems are nominal"
        ]);
        Telemetry::create([
            'mission_id'    => 12,
            'timestamp'     => 4 * 60 + 44 - 15,
            'readout'       => "Stage 2 propulsion systems look good"
        ]);
        Telemetry::create([
            'mission_id'    => 12,
            'timestamp'     => 5 * 60 + 25 - 15,
            'readout'       => "The vehicle remains on a nominal trajectory with an altitude of 153km, a downrange distance of 550km, and a velocity of 3.7km/s",
            'velocity'      => 3700,
            'altitude'      => 153000,
            'downrange'     => 550000
        ]);
        Telemetry::create([
            'mission_id'    => 12,
            'timestamp'     => 6 * 60 + 11 - 15,
            'readout'       => "Avionics, power systems nominal and we continue to have a good telemetry lock"
        ]);
        Telemetry::create([
            'mission_id'    => 12,
            'timestamp'     => 6 * 60 + 26 - 15,
            'readout'       => "Stage 2 propulsion also nominal"
        ]);
        Telemetry::create([
            'mission_id'    => 12,
            'timestamp'     => 6 * 60 + 35 - 15,
            'readout'       => "Vehicle's at an altitude of 168km, a downrange distance of 790km, and a velocity of 4.5km/s",
            'velocity'      => 4500,
            'altitude'      => 168000,
            'downrange'     => 790000
        ]);
        Telemetry::create([
            'mission_id'    => 12,
            'timestamp'     => 7 * 60 + 45 - 15,
            'readout'       => "The vehicle's at an altitude 177km, a downrange distance of 1150km, and a velocity of 5.7km/s",
            'velocity'      => 5700,
            'altitude'      => 177000,
            'downrange'     => 1150000
        ]);
        Telemetry::create([
            'mission_id'    => 12,
            'timestamp'     => 8 * 60 + 2 - 15,
            'readout'       => "Stage 2 and MVac propulsion still looking good"
        ]);
        Telemetry::create([
            'mission_id'    => 12,
            'timestamp'     => 8 * 60 + 12 - 15,
            'readout'       => "Terminal guidance has begun"
        ]);
        Telemetry::create([
            'mission_id'    => 12,
            'timestamp'     => 8 * 60 + 24 - 15,
            'readout'       => "FTS is safed"
        ]);
        Telemetry::create([
            'mission_id'    => 12,
            'timestamp'     => 8 * 60 + 45 - 15,
            'readout'       => "The vehicle remains on a nominal trajectory with an altitude of 178km, a downrange distance of 1500km, and a velocity of 7.6km/s",
            'velocity'      => 7600,
            'altitude'      => 178000,
            'downrange'     => 1500000
        ]);
        Telemetry::create([
            'mission_id'    => 12,
            'timestamp'     => 9 * 60 + 54,
            'readout'       => "All stations AOS Bermuda, TX1"
        ]);
        Telemetry::create([
            'mission_id'    => 12,
            'timestamp'     => 9 * 60 + 54,
            'readout'       => "MVac shutdown confirmed"
        ]);
        Telemetry::create([
            'mission_id'    => 12,
            'timestamp'     => 658,
            'readout'       => "Well, although we lost video, right as we flew out of range, the second stage of Falcon 9 and SEs spacecraft are now in orbit, as expect when we passed out of sight from the ground stations, we lost the signal and we weren't able to bring you any additional video. This is going to bring an end to the coverage from orbit. We've had a great launch today, and the seventh flight of our Falcon 9 rocket. We will continue to post updates on our web at spacex.com/webcast as well as our social media pages. Now for updates on the mission, please check those sites as we prepared for spacecraft deployment later in this flight. On behalf of the over 3000 people here at SpaceX, we want to thank our SES customer for their confidence, and selectnig SpaceX and the Falcon 9 for their launch service. Please continue to follow along for the rest of the mission, and thanks to all of you for joining today."
        ]);
        Telemetry::create([
            'mission_id'    => 12,
            'timestamp'     => 33 * 60,
            'readout'       => "Payload deploy commanded"
        ]);
    }

    public function Thaicom6() {
        Telemetry::create([
            'mission_id'    => 13,
            'timestamp'     => 0,
            'readout'       => "We have liftoff of the Falcon 9"
        ]);
        Telemetry::create([
            'mission_id'    => 13,
            'timestamp'     => 0,
            'readout'       => "Falcon 9 has cleared the towers"
        ]);
        Telemetry::create([
            'mission_id'    => 13,
            'timestamp'     => 0,
            'readout'       => "First stage propulsion healthy"
        ]);
        Telemetry::create([
            'mission_id'    => 13,
            'timestamp'     => 0,
            'readout'       => "OSM TC report to Net A"
        ]);
        Telemetry::create([
            'mission_id'    => 13,
            'timestamp'     => 0,
            'readout'       => "Reporting"
        ]);
        Telemetry::create([
            'mission_id'    => 13,
            'timestamp'     => 0,
            'readout'       => "First stage propellant utilization active"
        ]);
        Telemetry::create([
            'mission_id'    => 13,
            'timestamp'     => 0,
            'readout'       => "Good telemetry, power systems nominal"
        ]);
        Telemetry::create([
            'mission_id'    => 13,
            'timestamp'     => 0,
            'readout'       => "T+60 seconds, altitude 6km, velocity 266m/s, downrange distance 1.9km",
            'velocity'      => 266,
            'altitude'      => 6000,
            'downrange'     => 1900
        ]);
        Telemetry::create([
            'mission_id'    => 13,
            'timestamp'     => 0,
            'readout'       => "Vehicle's supersonic"
        ]);
        Telemetry::create([
            'mission_id'    => 13,
            'timestamp'     => 0,
            'readout'       => "Vehicle's reached maximum aerodynamic pressure"
        ]);
        Telemetry::create([
            'mission_id'    => 13,
            'timestamp'     => 0,
            'readout'       => "Good telemetry lock"
        ]);
        Telemetry::create([
            'mission_id'    => 13,
            'timestamp'     => 0,
            'readout'       => "T+2 minutes. Altitude 30km, speed 1.1km/s, downrange distance 30km",
            'velocity'      => 1100,
            'altitude'      => 30000,
            'downrange'     => 30000
        ]);
        Telemetry::create([
            'mission_id'    => 13,
            'timestamp'     => 0,
            'readout'       => "Stage 2 chilling in"
        ]);
        Telemetry::create([
            'mission_id'    => 13,
            'timestamp'     => 0,
            'readout'       => "T+2 minutes 30 seconds, vehicle's on the nominal trajectory"
        ]);
        Telemetry::create([
            'mission_id'    => 13,
            'timestamp'     => 0,
            'readout'       => "MECO 1"
        ]);
        Telemetry::create([
            'mission_id'    => 13,
            'timestamp'     => 0,
            'readout'       => "Stage sep confirmed"
        ]);
        Telemetry::create([
            'mission_id'    => 13,
            'timestamp'     => 0,
            'readout'       => "MVac ignition confirmed"
        ]);
        Telemetry::create([
            'mission_id'    => 13,
            'timestamp'     => 0,
            'readout'       => "Stage two propellant utilization active"
        ]);
        Telemetry::create([
            'mission_id'    => 13,
            'timestamp'     => 0,
            'readout'       => "Fairing separation confirmed"
        ]);
        Telemetry::create([
            'mission_id'    => 13,
            'timestamp'     => 0,
            'readout'       => "T+270 seconds, altitude 135km, speed 3km/s, downrange distance 383km",
            'velocity'      => 3000,
            'altitude'      => 135000,
            'downrange'     => 383000
        ]);
        Telemetry::create([
            'mission_id'    => 13,
            'timestamp'     => 0,
            'readout'       => "Good telemetry lock, power systems nominal"
        ]);
        Telemetry::create([
            'mission_id'    => 13,
            'timestamp'     => 0,
            'readout'       => "Stage 2 propulsion looking good"
        ]);
        Telemetry::create([
            'mission_id'    => 13,
            'timestamp'     => 0,
            'readout'       => "T+325 seconds, altitude 160km, speed 3.8km/s, downrange distance 582km",
            'velocity'      => 3800,
            'altitude'      => 160000,
            'downrange'     => 582000
        ]);
        Telemetry::create([
            'mission_id'    => 13,
            'timestamp'     => 0,
            'readout'       => "Power systems still nominal"
        ]);
        Telemetry::create([
            'mission_id'    => 13,
            'timestamp'     => 0,
            'readout'       => "T+400 seconds, vehicle remains on the nominal. Antigua AOS"
        ]);
        Telemetry::create([
            'mission_id'    => 13,
            'timestamp'     => 0,
            'readout'       => "T+410 seconds, altitude 175km, speed 4.8km/s, downrange distance 920km",
            'velocity'      => 4800,
            'altitude'      => 175000,
            'downrange'     => 920000
        ]);
        Telemetry::create([
            'mission_id'    => 13,
            'timestamp'     => 0,
            'readout'       => "Stage propulsion performance is good"
        ]);
        Telemetry::create([
            'mission_id'    => 13,
            'timestamp'     => 0,
            'readout'       => "T+460 seconds, altitude 178km, speed 5.6km/s, downrange distance 1200km",
            'velocity'      => 5600,
            'altitude'      => 178000,
            'downrange'     => 1200000
        ]);
        Telemetry::create([
            'mission_id'    => 13,
            'timestamp'     => 0,
            'readout'       => "Started terminal guidance"
        ]);
        Telemetry::create([
            'mission_id'    => 13,
            'timestamp'     => 0,
            'readout'       => "FTS is safed"
        ]);
        Telemetry::create([
            'mission_id'    => 13,
            'timestamp'     => 0,
            'readout'       => "[garbled] loss of signal. SpaceX operating on Antigua data at this time"
        ]);
        Telemetry::create([
            'mission_id'    => 13,
            'timestamp'     => 0,
            'readout'       => "T+515 seconds, altitude 178km, distance- downrange distance 1 point- 1500km",
            'altitude'      => 178000,
            'downrange'     => 1500000
        ]);
        Telemetry::create([
            'mission_id'    => 13,
            'timestamp'     => 0,
            'readout'       => "MVac shutdown confirmed"
        ]);
        Telemetry::create([
            'mission_id'    => 13,
            'timestamp'     => 0,
            'readout'       => "Park orbit insertion, looks like a good orbit insertion. 497 by 173km inclined 27.73 degrees to the equator"
        ]);
        Telemetry::create([
            'mission_id'    => 13,
            'timestamp'     => 0,
            'readout'       => "As you can see we're very excited here at SpaceX for another successful launch as the team continues to look intently into Mission Control right behind me. We hope you enjoyed watching from home too. We'll see you next time!"
        ]);
        Telemetry::create([
            'mission_id'    => 13,
            'timestamp'     => 0,
            'readout'       => "Thanks so much for joining us, everyone at SpaceX wishes you a very happy new year."
        ]);
        Telemetry::create([
            'mission_id'    => 13,
            'timestamp'     => 0,
            'readout'       => "And it looks like we have another successful launch of the Falcon 9 rocket to geosynchronous orbit. Now remember, you can follow SpaceX on our social media pages, spacex.com, look at our Twitter, see what future events we've got, as well as get further updates on today's flight. But right now that's going to end our webcast, we'd like to thank everybody including our Thaicom partners, and again, another great afternoon-evening for SpaceX and the Falcon 9 mission, and we'll see you next time for the flight of the CRS-3 Dragon to the International Space Station. Thanks, and goodnight everybody."
        ]);
    }

    public function CRS3() {
        Telemetry::create([
            'mission_id'    => 14,
            'timestamp'     => 0,
            'readout'       => "We have liftoff of the Falcon 9"
        ]);
        Telemetry::create([
            'mission_id'    => 14,
            'timestamp'     => 0,
            'readout'       => "Falcon 9 has cleared the tower"
        ]);
        Telemetry::create([
            'mission_id'    => 14,
            'timestamp'     => 0,
            'readout'       => "First stage propulsion is nominal"
        ]);
        Telemetry::create([
            'mission_id'    => 14,
            'timestamp'     => 0,
            'readout'       => "Solid [inaudible], power systems nominal"
        ]);
        Telemetry::create([
            'mission_id'    => 14,
            'timestamp'     => 0,
            'readout'       => "First stage propulsion is nominal"
        ]);
        Telemetry::create([
            'mission_id'    => 14,
            'timestamp'     => 0,
            'readout'       => "Power systems nominal, solid telemetry lock on both stages"
        ]);
        Telemetry::create([
            'mission_id'    => 14,
            'timestamp'     => 0,
            'readout'       => "T+110s, altitude 24km, speed 775m/s, downrange distance [inaudible]",
            'velocity'      => 775,
            'altitude'      => 24000
        ]);
        Telemetry::create([
            'mission_id'    => 14,
            'timestamp'     => 0,
            'readout'       => "MVac is chilling in"
        ]);
        Telemetry::create([
            'mission_id'    => 14,
            'timestamp'     => 0,
            'readout'       => "Vehicle's flying down the nominal"
        ]);
        Telemetry::create([
            'mission_id'    => 14,
            'timestamp'     => 0,
            'readout'       => "T+2 minutes 30 seconds, vehicle- correction- vehicle 63km altitude, speed 1.8km/s, downrange distance 55km",
            'velocity'      => 1800,
            'altitude'      => 63000,
            'downrange'     => 55000
        ]);
        Telemetry::create([
            'mission_id'    => 14,
            'timestamp'     => 0,
            'readout'       => "Stage separation confirmed"
        ]);
        Telemetry::create([
            'mission_id'    => 14,
            'timestamp'     => 0,
            'readout'       => "And we have MECO 1"
        ]);
        Telemetry::create([
            'mission_id'    => 14,
            'timestamp'     => 0,
            'readout'       => "And MVac ignition"
        ]);
        Telemetry::create([
            'mission_id'    => 14,
            'timestamp'     => 0,
            'readout'       => "T+3 minutes. Vehicle altitude 103km, speed 2km/s, downrange distance 103km",
            'velocity'      => 2000,
            'altitude'      => 103000,
            'downrange'     => 103000
        ]);
        Telemetry::create([
            'mission_id'    => 14,
            'timestamp'     => 0,
            'readout'       => "Stage two propulsion is nominal"
        ]);
        Telemetry::create([
            'mission_id'    => 14,
            'timestamp'     => 0,
            'readout'       => "Falcon power systems nominal, solid telemetry lock on both stages"
        ]);
        Telemetry::create([
            'mission_id'    => 14,
            'timestamp'     => 0,
            'readout'       => "T+4 minutes 45 seconds, vehicle altitude 205km, speed 2.4km/s, downrange distance 285km",
            'velocity'      => 2400,
            'altitude'      => 205000,
            'downrange'     => 285000
        ]);
        Telemetry::create([
            'mission_id'    => 14,
            'timestamp'     => 0,
            'readout'       => "Vehicle continues to fly down the nominal trajectory"
        ]);
        Telemetry::create([
            'mission_id'    => 14,
            'timestamp'     => 0,
            'readout'       => "All Dragon tracking stations nominal, TDRS nominal"
        ]);
        Telemetry::create([
            'mission_id'    => 14,
            'timestamp'     => 0,
            'readout'       => "Stage 2 propulsion is nominal"
        ]);
        Telemetry::create([
            'mission_id'    => 14,
            'timestamp'     => 0,
            'readout'       => "Falcon power systems nominal, solid telemetry lock on both stages"
        ]);
        Telemetry::create([
            'mission_id'    => 14,
            'timestamp'     => 0,
            'readout'       => "T+6 minutes 40 seconds, trajectory status. 284km altitude, speed 3.6km/s, downrange distance 600km",
            'velocity'      => 3600,
            'altitude'      => 284000,
            'downrange'     => 600000
        ]);
        Telemetry::create([
            'mission_id'    => 14,
            'timestamp'     => 0,
            'readout'       => "Stage 2 propulsion still nominal"
        ]);
        Telemetry::create([
            'mission_id'    => 14,
            'timestamp'     => 0,
            'readout'       => "Stage 2 propulsion is nominal"
        ]);
        Telemetry::create([
            'mission_id'    => 14,
            'timestamp'     => 0,
            'readout'       => "T+8 minutes 15 seconds. Altitude 322km, speed 5.3km/s, downrange distance 980km. Still getting excellent video of the first stage having performed its entry burn, and excellent video from the Air Force New Hampshire tracking station on the second stage",
            'velocity'      => 5300,
            'altitude'      => 322000,
            'downrange'     => 980000
        ]);
        Telemetry::create([
            'mission_id'    => 14,
            'timestamp'     => 0,
            'readout'       => "Vehicle continues to fly down the nominal"
        ]);
        Telemetry::create([
            'mission_id'    => 14,
            'timestamp'     => 0,
            'readout'       => "Terminal guidance has begun"
        ]);
        Telemetry::create([
            'mission_id'    => 14,
            'timestamp'     => 0,
            'readout'       => "And we're in terminal guidance"
        ]);
        Telemetry::create([
            'mission_id'    => 14,
            'timestamp'     => 0,
            'readout'       => "Standby for engine cutoff"
        ]);
        Telemetry::create([
            'mission_id'    => 14,
            'timestamp'     => 0,
            'readout'       => "FTS is safed"
        ]);
        Telemetry::create([
            'mission_id'    => 14,
            'timestamp'     => 0,
            'readout'       => "Dragon flight computers in separation"
        ]);
        Telemetry::create([
            'mission_id'    => 14,
            'timestamp'     => 0,
            'readout'       => "And we have SECO 1"
        ]);
        Telemetry::create([
            'mission_id'    => 14,
            'timestamp'     => 0,
            'readout'       => "New Foundland ground station has acquired Dragon"
        ]);
        Telemetry::create([
            'mission_id'    => 14,
            'timestamp'     => 0,
            'readout'       => "Dragon deploy confirmed"
        ]);
        Telemetry::create([
            'mission_id'    => 14,
            'timestamp'     => 0,
            'readout'       => "Enabling New Foundland telemetry"
        ]);
        Telemetry::create([
            'mission_id'    => 14,
            'timestamp'     => 0,
            'readout'       => "Dragon loss of signal [inaudible]"
        ]);
        Telemetry::create([
            'mission_id'    => 14,
            'timestamp'     => 0,
            'readout'       => "And this is John Insprucker, and you're looking at the live shot of Dragon, successfully separated from the Falcon 9, we're in a good orbit, we're watching Dragon slowly drift away, now right now the second stage is beginning to turn, that's a normal event, so we're probably not gonna' get to see the solar arrays come out on Dragon from the second stage but we'll try to see what the cameras can bring you, we'll follow along and go back in just a minute to see if we've still got coverage, but right now, it's a great mission, we're where we want to be, so let's go back and just take a look and wait and see if we can maybe get video coverage of the arrays coming out on Dragon"
        ]);
        Telemetry::create([
            'mission_id'    => 14,
            'timestamp'     => 0,
            'readout'       => "Dragon is in array deploy"
        ]);
        Telemetry::create([
            'mission_id'    => 14,
            'timestamp'     => 0,
            'readout'       => "Dragon has good solar array deploy"
        ]);
        Telemetry::create([
            'mission_id'    => 14,
            'timestamp'     => 0,
            'readout'       => "Dragon has nominal command and telemetry from TDRS"
        ]);
        Telemetry::create([
            'mission_id'    => 14,
            'timestamp'     => 0,
            'readout'       => "Prop global"
        ]);
        Telemetry::create([
            'mission_id'    => 14,
            'timestamp'     => 0,
            'readout'       => "As you can see, we're all very excited here for, at SpaceX for another successful launch and we hope you enjoyed watching from home. Today was an incredible day for me and the rest of the Dragon team and we can't wait for the cargo to arrive at the station in just a few days. Well, that concludes our webcast, and on behalf of all of us here at SpaceX, thanks for tuning in."
        ]);
        Telemetry::create([
            'mission_id'    => 14,
            'timestamp'     => 0,
            'readout'       => "And as you can hear, a lot of applause in the background. Looks like we've got another successful launch of the Falcon 9, we'll be releasing updates on how Dragon is doing, and also maybe we'll also get some insight on what happened at the first stage recovery, tune in for us, on the web, so we can see how Dragon is doing as it makes its quick flight to the International Space Station, but right now for Sarah and myself, great afternoon at the Cape, successful flight, and with that, we are going to sign off. Check our social media webpages for updates, and we'd like to also thank our NASA customer for the confidence in us, and hanging with us through the bad weather today as everything cleared up, and everything came together, and it looked great Sarah, and with that, thanks to all of you for watching us on the web, and as I said, check on our media pages for updates, and with that, we're going to sign off and say good afternoon, good evening, or good morning wherever you are around the world, goobye from SpaceX headquarters here in Hawthorne."
        ]);
    }

    public function OrbcommOG2Launch1() {
        Telemetry::create([
            'mission_id'    => 15,
            'timestamp'     => 0,
            'readout'       => "Liftoff of the Falcon 9"
        ]);
        Telemetry::create([
            'mission_id'    => 15,
            'timestamp'     => 0,
            'readout'       => "Falcon 9 has cleared the tower"
        ]);
        Telemetry::create([
            'mission_id'    => 15,
            'timestamp'     => 0,
            'readout'       => "Stage 1 propulsion is nominal"
        ]);
        Telemetry::create([
            'mission_id'    => 15,
            'timestamp'     => 0,
            'readout'       => "Vehicle programming downrange"
        ]);
        Telemetry::create([
            'mission_id'    => 15,
            'timestamp'     => 0,
            'readout'       => "[inaudible] we [inaudible]"
        ]);
        Telemetry::create([
            'mission_id'    => 15,
            'timestamp'     => 0,
            'readout'       => "Copy"
        ]);
        Telemetry::create([
            'mission_id'    => 15,
            'timestamp'     => 0,
            'readout'       => "Nominal power, nominal telemetry"
        ]);
        Telemetry::create([
            'mission_id'    => 15,
            'timestamp'     => 0,
            'readout'       => "T+60 seconds. Altitude 13km, speed 450m/s, downrange distance 2.5km",
            'velocity'      => 450,
            'altitude'      => 13000,
            'downrange'     => 2500
        ]);
        Telemetry::create([
            'mission_id'    => 15,
            'timestamp'     => 0,
            'readout'       => "First tstage propulsion is nominal"
        ]);
        Telemetry::create([
            'mission_id'    => 15,
            'timestamp'     => 0,
            'readout'       => "MVac chill has begin- begun"
        ]);
        Telemetry::create([
            'mission_id'    => 15,
            'timestamp'     => 0,
            'readout'       => "Go ahead"
        ]);
        Telemetry::create([
            'mission_id'    => 15,
            'timestamp'     => 0,
            'readout'       => "Go ahead"
        ]);
        Telemetry::create([
            'mission_id'    => 15,
            'timestamp'     => 0,
            'readout'       => "Power systems still nominal, good telemetry lock on both stages"
        ]);
        Telemetry::create([
            'mission_id'    => 15,
            'timestamp'     => 0,
            'readout'       => "Vehicle altitude 54km, speed 1.4km/s, downrange distance 21km",
            'velocity'      => 1400,
            'altitude'      => 54000,
            'downrange'     => 21000
        ]);
        Telemetry::create([
            'mission_id'    => 15,
            'timestamp'     => 0,
            'readout'       => "And we have MECO"
        ]);
        Telemetry::create([
            'mission_id'    => 15,
            'timestamp'     => 0,
            'readout'       => "Stage sep confirmed"
        ]);
        Telemetry::create([
            'mission_id'    => 15,
            'timestamp'     => 0,
            'readout'       => "And MVac ignition"
        ]);
        Telemetry::create([
            'mission_id'    => 15,
            'timestamp'     => 0,
            'readout'       => "T+3 minutes, altitude 112km, speed 1.7km/s, downrange distance 51km",
            'velocity'      => 1700,
            'altitude'      => 112000,
            'downrange'     => 51000
        ]);
        Telemetry::create([
            'mission_id'    => 15,
            'timestamp'     => 0,
            'readout'       => "Fairing separation confirmed"
        ]);
        Telemetry::create([
            'mission_id'    => 15,
            'timestamp'     => 0,
            'readout'       => "Stage 2 propulsion is nominal"
        ]);
        Telemetry::create([
            'mission_id'    => 15,
            'timestamp'     => 0,
            'readout'       => "Power nominal, telemetry nominal, both stages"
        ]);
        Telemetry::create([
            'mission_id'    => 15,
            'timestamp'     => 0,
            'readout'       => "T+4 minutes 30 seconds, altitude 240km, speed 1.8km/s, downrange distance 130km",
            'velocity'      => 1800,
            'altitude'      => 240000,
            'downrange'     => 130000
        ]);
        Telemetry::create([
            'mission_id'    => 15,
            'timestamp'     => 0,
            'readout'       => "Acquisition of signal at the New Hampshire tracking station"
        ]);
        Telemetry::create([
            'mission_id'    => 15,
            'timestamp'     => 0,
            'readout'       => "T+5 minutes 30 seconds, vehicle continues to fly down the nominal. Altitude 334km, speed 2.2km/s, downrange distance 209km",
            'velocity'      => 2200,
            'altitude'      => 334000,
            'downrange'     => 209000
        ]);
        Telemetry::create([
            'mission_id'    => 15,
            'timestamp'     => 0,
            'readout'       => "Stage propulsion remains nominal"
        ]);
        Telemetry::create([
            'mission_id'    => 15,
            'timestamp'     => 0,
            'readout'       => "Power systems nominal. Good telemetry lock on stage 2"
        ]);
        Telemetry::create([
            'mission_id'    => 15,
            'timestamp'     => 0,
            'readout'       => "T+6 minutes 30 seconds. Altitude 420km, speed 2.7km/s, downrange distance 305km",
            'velocity'      => 2700,
            'altitude'      => 420000,
            'downrange'     => 305000
        ]);
        Telemetry::create([
            'mission_id'    => 15,
            'timestamp'     => 0,
            'readout'       => "Stage 2 propulsion remains nominal"
        ]);
        Telemetry::create([
            'mission_id'    => 15,
            'timestamp'     => 0,
            'readout'       => "T+7 minutes 30 seconds. Altitude 511km, speed 3.6km/s, downrange distance 460km",
            'velocity'      => 3600,
            'altitude'      => 511000,
            'downrange'     => 460000
        ]);
        Telemetry::create([
            'mission_id'    => 15,
            'timestamp'     => 0,
            'readout'       => "Stage 2 propulsion remains nominal"
        ]);
        Telemetry::create([
            'mission_id'    => 15,
            'timestamp'     => 0,
            'readout'       => "Vehicle continues to fly down the nominal"
        ]);
        Telemetry::create([
            'mission_id'    => 15,
            'timestamp'     => 0,
            'readout'       => "Acquisition of Signal, Saint Johns New Foundland Tracking Station"
        ]);
        Telemetry::create([
            'mission_id'    => 15,
            'timestamp'     => 0,
            'readout'       => "T+8 minutes 45 seconds, altitude 600km, downrange speed- downrange distance 750km, speed 5.7km/s",
            'velocity'      => 5700,
            'altitude'      => 600000,
            'downrange'     => 750000
        ]);
        Telemetry::create([
            'mission_id'    => 15,
            'timestamp'     => 0,
            'readout'       => "Started terminal guidance"
        ]);
        Telemetry::create([
            'mission_id'    => 15,
            'timestamp'     => 0,
            'readout'       => "FTS is safed"
        ]);
        Telemetry::create([
            'mission_id'    => 15,
            'timestamp'     => 0,
            'readout'       => "T+9 minutes 30 seconds, altitude 620km, speed 7.2km/s, downrange distance 1000",
            'velocity'      => 7200,
            'altitude'      => 620000,
            'downrange'     => 1000000
        ]);
        Telemetry::create([
            'mission_id'    => 15,
            'timestamp'     => 0,
            'readout'       => "And, we have MECO"
        ]);
        Telemetry::create([
            'mission_id'    => 15,
            'timestamp'     => 0,
            'readout'       => "Vehicle's at 743 by 614km, inclined, 47 degrees to the equator"
        ]);
        Telemetry::create([
            'mission_id'    => 15,
            'timestamp'     => 0,
            'readout'       => "Vehicle's currently in coast state"
        ]);
        Telemetry::create([
            'mission_id'    => 15,
            'timestamp'     => 0,
            'readout'       => "And it looks like we've got another successful launch of the Falcon 9 rocket carrying the Orbcomm satellites into orbit. As you may have just heard, orbit looks like a good injection for Falcon 9. A little bit later on, Orbcomm spacecraft will be separated from the second stage, but that's going to bring and end to our webcast today. We'd like to thank our Orbcomm customer, the Air Force for the support at the Eastern Range and ground station support, and we'd like to thank you also for following us on today's launch. Now remember, you can follow us at spacex.com, our social media pages, as we provide updated status and pictures of today's launch, and we hope to see you tuned in with us next time for the launch of Falcon 9. Thank you and good day."
        ]);
    }

    public function AsiaSat8() {
        Telemetry::create([
            'mission_id'    => 16,
            'timestamp'     => 0,
            'readout'       => "Liftoff"
        ]);
        Telemetry::create([
            'mission_id'    => 16,
            'timestamp'     => 0,
            'readout'       => "Falcon 9 has cleared the tower"
        ]);
        Telemetry::create([
            'mission_id'    => 16,
            'timestamp'     => 0,
            'readout'       => "Power systems nominal, telemetry lock nominal"
        ]);
        Telemetry::create([
            'mission_id'    => 16,
            'timestamp'     => 0,
            'readout'       => "T+1 minute, altitude 6km, speed 270m/s, downrange distance 2km",
            'velocity'      => 270,
            'altitude'      => 6000,
            'downrange'     => 2000
        ]);
        Telemetry::create([
            'mission_id'    => 16,
            'timestamp'     => 0,
            'readout'       => "Vehicle's supersonic"
        ]);
        Telemetry::create([
            'mission_id'    => 16,
            'timestamp'     => 0,
            'readout'       => "And vehicle's reached maximum aerodynamic pressure"
        ]);
        Telemetry::create([
            'mission_id'    => 16,
            'timestamp'     => 0,
            'readout'       => "Stage 1 propulsion continues to be nominal"
        ]);
        Telemetry::create([
            'mission_id'    => 16,
            'timestamp'     => 0,
            'readout'       => "Power systems still nominal, good telemetry lock"
        ]);
        Telemetry::create([
            'mission_id'    => 16,
            'timestamp'     => 0,
            'readout'       => "T+2 minutes, altitude 28.9km, speed 1.1km/s, downrange distance 32km",
            'velocity'      => 1100,
            'altitude'      => 28900,
            'downrange'     => 32000
        ]);
        Telemetry::create([
            'mission_id'    => 16,
            'timestamp'     => 0,
            'readout'       => "MVac has begun chill in"
        ]);
        Telemetry::create([
            'mission_id'    => 16,
            'timestamp'     => 0,
            'readout'       => "T+2 minutes 30 seconds, vehicle's flying down the center. Altitude 48km, speed 1.9km/s, downrange distance 75km",
            'velocity'      => 1900,
            'altitude'      => 48000,
            'downrange'     => 75000
        ]);
        Telemetry::create([
            'mission_id'    => 16,
            'timestamp'     => 0,
            'readout'       => "And we have MECO 1"
        ]);
        Telemetry::create([
            'mission_id'    => 16,
            'timestamp'     => 0,
            'readout'       => "Stage sep"
        ]);
        Telemetry::create([
            'mission_id'    => 16,
            'timestamp'     => 0,
            'readout'       => "And we have MVac ignition"
        ]);
        Telemetry::create([
            'mission_id'    => 16,
            'timestamp'     => 0,
            'readout'       => "GC verify or vent the RP-1 storage tank"
        ]);
        Telemetry::create([
            'mission_id'    => 16,
            'timestamp'     => 0,
            'readout'       => "Fairing separation"
        ]);
        Telemetry::create([
            'mission_id'    => 16,
            'timestamp'     => 0,
            'readout'       => "Stage two propulsion continues to be nominal"
        ]);
        Telemetry::create([
            'mission_id'    => 16,
            'timestamp'     => 0,
            'readout'       => "Bermuda acquisition of signal"
        ]);
        Telemetry::create([
            'mission_id'    => 16,
            'timestamp'     => 0,
            'readout'       => "T+4 minutes 30 seconds, altitude 137km, speed 3.2km/s, downrange distance 400km",
            'velocity'      => 3200,
            'altitude'      => 137000,
            'downrange'     => 400000
        ]);
        Telemetry::create([
            'mission_id'    => 16,
            'timestamp'     => 0,
            'readout'       => "Power systems still nominal"
        ]);
        Telemetry::create([
            'mission_id'    => 16,
            'timestamp'     => 0,
            'readout'       => "T+5 minutes 20 seconds, altitude 158km, speed 3.8km/s, downrange distance 570km. Vehicle continues to fly down the nominal",
            'velocity'      => 3800,
            'altitude'      => 158000,
            'downrange'     => 570000
        ]);
        Telemetry::create([
            'mission_id'    => 16,
            'timestamp'     => 0,
            'readout'       => "Stage 2 propulsion continues to be nominal"
        ]);
        Telemetry::create([
            'mission_id'    => 16,
            'timestamp'     => 0,
            'readout'       => "T+6 minutes 20 seconds, altitude 173km, speed 4.4km/s, downrange distance 800km",
            'velocity'      => 4400,
            'altitude'      => 173000,
            'downrange'     => 800000
        ]);
        Telemetry::create([
            'mission_id'    => 16,
            'timestamp'     => 0,
            'readout'       => "Power systems still nominal, good telemetry lock"
        ]);
        Telemetry::create([
            'mission_id'    => 16,
            'timestamp'     => 0,
            'readout'       => "First stage engine relit."
        ]);
        Telemetry::create([
            'mission_id'    => 16,
            'timestamp'     => 0,
            'readout'       => "T+7 minutes 30 seconds. Altitude 180km, speed 5.6km/s, downrange distance 1150km",
            'velocity'      => 5600,
            'altitude'      => 180000,
            'downrange'     => 1150000
        ]);
        Telemetry::create([
            'mission_id'    => 16,
            'timestamp'     => 0,
            'readout'       => "Vehicle's entered terminal guidance mode"
        ]);
        Telemetry::create([
            'mission_id'    => 16,
            'timestamp'     => 0,
            'readout'       => "FTS is safed"
        ]);
        Telemetry::create([
            'mission_id'    => 16,
            'timestamp'     => 0,
            'readout'       => "There's MECO"
        ]);
        Telemetry::create([
            'mission_id'    => 16,
            'timestamp'     => 0,
            'readout'       => "Orbital parameters are 200 by 176km, inclined 27 decimal 7 degrees to the equator. Good orbit insertion, and we have [?] loss of signal."
        ]);
        Telemetry::create([
            'mission_id'    => 16,
            'timestamp'     => 0,
            'readout'       => "And it looks like we have another successful launch of the Falcon 9 rocket, carrying the Asiasat 8 satellite. As you heard, the first stage had a great flight, second stage separated, you saw engine ignition, payload fairing separation, and then just moments ago we had shutdown of the second stage engine. The orbit looks very good for insertion into parking orbit, a little bit later in the flight, we will have a restart of the upper stage engine that will carry the Asiasat 8 satellite to the final injection orbit from the Falcon 9. However, that is going to bring an end to the webcast, for this evening, this early morning. Here at SpaceX, we'd like to thank our AsiaSat customer, for their confidence in selecting us and we look forward to letting everybody know how things go a little bit later this morning. Also like to thank the Air Force for the Eastern Range and ground station support around the world, also the Federal Aviation Administration for working with us as we got the Falcon 9, both air and ground systems ready to go and fly, and then finally thank you for sticking with us through 2 and a half hours of delay, but it appears to have been worth it, as the launch looked outstanding coming off of the Pad at Complex 40 at the Cape. So remember to follow us at spacex.com, our social media pages, as we continue to mission and for our future events, and we will see you next time for the next flight of the Falcon 9. Goodnight everyone."
        ]);
    }

    public function AsiaSat6() {
        Telemetry::create([
            'mission_id'    => 17,
            'timestamp'     => 0,
            'readout'       => "We have liftoff of the Falcon 9"
        ]);
        Telemetry::create([
            'mission_id'    => 17,
            'timestamp'     => 0,
            'readout'       => "Stage 1 PU is active"
        ]);
        Telemetry::create([
            'mission_id'    => 17,
            'timestamp'     => 0,
            'readout'       => "Stage 1 and stage 2 telemetry look healthy, good bus voltage on both stages"
        ]);
        Telemetry::create([
            'mission_id'    => 17,
            'timestamp'     => 0,
            'readout'       => "T+60 seconds."
        ]);
        Telemetry::create([
            'mission_id'    => 17,
            'timestamp'     => 0,
            'readout'       => "Altitude 7km, speed 300m/s, downrange distance 2.4km",
            'altitude'      => 7000,
            'velocity'      => 300,
            'downrange'     => 2400
        ]);
        Telemetry::create([
            'mission_id'    => 17,
            'timestamp'     => 0,
            'readout'       => "Vehicle's supersonic"
        ]);
        Telemetry::create([
            'mission_id'    => 17,
            'timestamp'     => 0,
            'readout'       => "Vehicle's reached maximum aerodynamic pressure"
        ]);
        Telemetry::create([
            'mission_id'    => 17,
            'timestamp'     => 0,
            'readout'       => "Stage 1 propulsion continues to perform as expected"
        ]);
        Telemetry::create([
            'mission_id'    => 17,
            'timestamp'     => 0,
            'readout'       => "Solid telemetry lock on both stages, power systems nominal"
        ]);
        Telemetry::create([
            'mission_id'    => 17,
            'timestamp'     => 0,
            'readout'       => "Stage 2 engine chill has begun"
        ]);
        Telemetry::create([
            'mission_id'    => 17,
            'timestamp'     => 0,
            'readout'       => "T+2 minutes 15 seconds. Altitude 38km, speed 1.5km/s, downrange distance 50km",
            'altitude'      => 38000,
            'velocity'      => 1500,
            'downrange'     => 50000
        ]);
        Telemetry::create([
            'mission_id'    => 17,
            'timestamp'     => 0,
            'readout'       => "T+2 minutes 30 seconds, vehicle on the nominal trajectory. Altitude 52km, speed 2km/s, downrange distance 82km",
            'altitude'      => 52000,
            'velocity'      => 2000,
            'downrange'     => 82000
        ]);
        Telemetry::create([
            'mission_id'    => 17,
            'timestamp'     => 0,
            'readout'       => "And we have MECO 1"
        ]);
        Telemetry::create([
            'mission_id'    => 17,
            'timestamp'     => 0,
            'readout'       => "Stage separation confirmed"
        ]);
        Telemetry::create([
            'mission_id'    => 17,
            'timestamp'     => 0,
            'readout'       => "Stage 2 ignition"
        ]);
        Telemetry::create([
            'mission_id'    => 17,
            'timestamp'     => 0,
            'readout'       => "And we have MVac ignition"
        ]);
        Telemetry::create([
            'mission_id'    => 17,
            'timestamp'     => 0,
            'readout'       => "Stage 2 PU is active"
        ]);
        Telemetry::create([
            'mission_id'    => 17,
            'timestamp'     => 0,
            'readout'       => "Fairing separation confirmed"
        ]);
        Telemetry::create([
            'mission_id'    => 17,
            'timestamp'     => 0,
            'readout'       => "Stage 2 propulsion continues to perform as expected"
        ]);
        Telemetry::create([
            'mission_id'    => 17,
            'timestamp'     => 0,
            'readout'       => "T+4 minutes 20 seconds. Altitude 133km, speed 3.2km/s, downrange distance 370km",
            'altitude'      => 133000,
            'velocity'      => 3200,
            'downrange'     => 370000
        ]);
        Telemetry::create([
            'mission_id'    => 17,
            'timestamp'     => 0,
            'readout'       => "Bermuda tracking station acquisition of signal"
        ]);
        Telemetry::create([
            'mission_id'    => 17,
            'timestamp'     => 0,
            'readout'       => "Solid telemetry lock on both stages, power systems nominal"
        ]);
        Telemetry::create([
            'mission_id'    => 17,
            'timestamp'     => 0,
            'readout'       => "T+5 minutes, vehicle remains on the nominal"
        ]);
        Telemetry::create([
            'mission_id'    => 17,
            'timestamp'     => 0,
            'readout'       => "T+5 minutes 25 seconds. Altitude 159km, speed 3.75km/s, downrange distance 575km",
            'altitude'      => 159000,
            'velocity'      => 3750,
            'downrange'     => 575000
        ]);
        Telemetry::create([
            'mission_id'    => 17,
            'timestamp'     => 0,
            'readout'       => "Stage 2 propulsion is still nominal"
        ]);
        Telemetry::create([
            'mission_id'    => 17,
            'timestamp'     => 0,
            'readout'       => "Solid telemetry lock on stage 2, power systems nominal"
        ]);
        Telemetry::create([
            'mission_id'    => 17,
            'timestamp'     => 0,
            'readout'       => "T+6 minutes 20 seconds. Altitude 172km, velocity 4.5km/s, downrange distance 815km",
            'altitude'      => 172000,
            'velocity'      => 4500,
            'downrange'     => 815000
        ]);
        Telemetry::create([
            'mission_id'    => 17,
            'timestamp'     => 0,
            'readout'       => "First stage reignition"
        ]);
        Telemetry::create([
            'mission_id'    => 17,
            'timestamp'     => 0,
            'readout'       => "Stage 2 propulsion is nominal"
        ]);
        Telemetry::create([
            'mission_id'    => 17,
            'timestamp'     => 0,
            'readout'       => "T+7 minutes 30 seconds. Altitude 179km, speed 5.6km/s, downrange distance 1150km",
            'altitude'      => 179000,
            'velocity'      => 5600,
            'downrange'     => 1150000
        ]);
        Telemetry::create([
            'mission_id'    => 17,
            'timestamp'     => 0,
            'readout'       => "Second stage in terminal guidance"
        ]);
        Telemetry::create([
            'mission_id'    => 17,
            'timestamp'     => 0,
            'readout'       => "FTS is safed"
        ]);
        Telemetry::create([
            'mission_id'    => 17,
            'timestamp'     => 0,
            'readout'       => "T+8 minutes 30 seconds. Altitude 179km, speed 7000m/s, downrange distance 1500km",
            'altitude'      => 179000,
            'velocity'      => 7000,
            'downrange'     => 1500000
        ]);
        Telemetry::create([
            'mission_id'    => 17,
            'timestamp'     => 0,
            'readout'       => "Second stage engine cutoff"
        ]);
        Telemetry::create([
            'mission_id'    => 17,
            'timestamp'     => 0,
            'readout'       => "Initial orbit insertion at 202 by 175km, inclined 27.7 degrees to the equator"
        ]);
        Telemetry::create([
            'mission_id'    => 17,
            'timestamp'     => 0,
            'readout'       => "And it looks like we have another successful launch of Falcon 9 rocket into the parking orbit, carrying the AsiaSat 6 satellite. SpaceX will be ending the webcast now, but remember to follow us on the internet at spacex.com, as well as our social media pages, as we continue through the remainder of this morning's mission. This time SpaceX would like to thank our AsiaSat customer, the Air Force for Eastern Range and ground station support, like to thank the Federal Aviation Administation, and finally thank you for following us on this morning's launch. We'll see you next time here, from SpaceX headquarters, in Hawthorne, California; thanks for tuning in. Have a good morning or night wherever you are."
        ]);
        Telemetry::create([
            'mission_id'    => 17,
            'timestamp'     => 0,
            'readout'       => "And we have [inaudible] loss of signal"
        ]);
    }

    public function CRS4() {
        Telemetry::create([
            'mission_id'    => 18,
            'timestamp'     => 0,
            'readout'       => "[inaudible]"
        ]);
        Telemetry::create([
            'mission_id'    => 18,
            'timestamp'     => 0,
            'readout'       => "We have liftoff of the Falcon 9"
        ]);
        Telemetry::create([
            'mission_id'    => 18,
            'timestamp'     => 0,
            'readout'       => "Pitch kick is in, first stage propulsion performing nominally"
        ]);
        Telemetry::create([
            'mission_id'    => 18,
            'timestamp'     => 0,
            'readout'       => "Power systems and telemetry nominal"
        ]);
        Telemetry::create([
            'mission_id'    => 18,
            'timestamp'     => 0,
            'readout'       => "T+6o seconds. Altitude 5.8km, speed 250m/s, downrange distance .8km",
            'altitude'      => 5800,
            'velocity'      => 250,
            'downrange'     => 800
        ]);
        Telemetry::create([
            'mission_id'    => 18,
            'timestamp'     => 0,
            'readout'       => "Vehicle's flying down the nominal"
        ]);
        Telemetry::create([
            'mission_id'    => 18,
            'timestamp'     => 0,
            'readout'       => "Nominal [inaudible] and [inaudible] level"
        ]);
        Telemetry::create([
            'mission_id'    => 18,
            'timestamp'     => 0,
            'readout'       => "Vehicle's reached maximum aerodynamic pressure"
        ]);
        Telemetry::create([
            'mission_id'    => 18,
            'timestamp'     => 0,
            'readout'       => "First stage propulsion is still nominal"
        ]);
        Telemetry::create([
            'mission_id'    => 18,
            'timestamp'     => 0,
            'readout'       => "Power systems still nominal, telemetry lock solid"
        ]);
        Telemetry::create([
            'mission_id'    => 18,
            'timestamp'     => 0,
            'readout'       => "MVac chill in has begun"
        ]);
        Telemetry::create([
            'mission_id'    => 18,
            'timestamp'     => 0,
            'readout'       => "T+2 minutes 10 seconds. Altitude 38km, speed 1.16km/s, downrange distance 19km",
            'altitude'      => 38000,
            'velocity'      => 1160,
            'downrange'     => 19000
        ]);
        Telemetry::create([
            'mission_id'    => 18,
            'timestamp'     => 0,
            'readout'       => "T+2 minutes 30 seconds. Altitude 61km, speed 1.9km/s, downrange distance 40km",
            'altitude'      => 61000,
            'velocity'      => 1900,
            'downrange'     => 40000
        ]);
        Telemetry::create([
            'mission_id'    => 18,
            'timestamp'     => 0,
            'readout'       => "MECO confirmed"
        ]);
        Telemetry::create([
            'mission_id'    => 18,
            'timestamp'     => 0,
            'readout'       => "Stage separation confirmed"
        ]);
        Telemetry::create([
            'mission_id'    => 18,
            'timestamp'     => 0,
            'readout'       => "Flight computer's in second stage"
        ]);
        Telemetry::create([
            'mission_id'    => 18,
            'timestamp'     => 0,
            'readout'       => "Wallops Island acquisition of signal"
        ]);
        Telemetry::create([
            'mission_id'    => 18,
            'timestamp'     => 0,
            'readout'       => "And we have MVac ignition"
        ]);
        Telemetry::create([
            'mission_id'    => 18,
            'timestamp'     => 0,
            'readout'       => "Acquisition of signal, Wallops Island, Virginia"
        ]);
        Telemetry::create([
            'mission_id'    => 18,
            'timestamp'     => 0,
            'readout'       => "T+3 minutes, altitude 93km, speed 2.12km/s, downrange distance 79km",
            'altitude'      => 93000,
            'velocity'      => 2120,
            'downrange'     => 79000
        ]);
        Telemetry::create([
            'mission_id'    => 18,
            'timestamp'     => 0,
            'readout'       => "Nosecone sep confirmed"
        ]);
        Telemetry::create([
            'mission_id'    => 18,
            'timestamp'     => 0,
            'readout'       => "All stations proceed to 7 dot 1 0 1"
        ]);
        Telemetry::create([
            'mission_id'    => 18,
            'timestamp'     => 0,
            'readout'       => "Stage 2 propulsion is nominal"
        ]);
        Telemetry::create([
            'mission_id'    => 18,
            'timestamp'     => 0,
            'readout'       => "Stage 1 and stage 2 power systems still nominal"
        ]);
        Telemetry::create([
            'mission_id'    => 18,
            'timestamp'     => 0,
            'readout'       => "T+4 minutes 25 seconds. Altitude 156km, speed 2.5km/s, downrange distance 193km",
            'altitude'      => 156000,
            'velocity'      => 2500,
            'downrange'     => 193000
        ]);
        Telemetry::create([
            'mission_id'    => 18,
            'timestamp'     => 0,
            'readout'       => "Acquisition of signal, New Hampshire"
        ]);
        Telemetry::create([
            'mission_id'    => 18,
            'timestamp'     => 0,
            'readout'       => "Stage 2 propulsion is still nominal"
        ]);
        Telemetry::create([
            'mission_id'    => 18,
            'timestamp'     => 0,
            'readout'       => "T+6 minutes 20 seconds. Altitude 202km, speed 3.7km/s, downrange distance 420km",
            'altitude'      => 202000,
            'velocity'      => 3700,
            'downrange'     => 420000
        ]);
        Telemetry::create([
            'mission_id'    => 18,
            'timestamp'     => 0,
            'readout'       => "Nominal telemetry on both stage 1 and stage 2"
        ]);
        Telemetry::create([
            'mission_id'    => 18,
            'timestamp'     => 0,
            'readout'       => "Stage 2 prop is still nominal"
        ]);
        Telemetry::create([
            'mission_id'    => 18,
            'timestamp'     => 0,
            'readout'       => "T+7 minutes 30 seconds, altitude 210km, speed 4.7km/s, downrange distance 610km",
            'altitude'      => 210000,
            'velocity'      => 4700,
            'downrange'     => 610000
        ]);
        Telemetry::create([
            'mission_id'    => 18,
            'timestamp'     => 0,
            'readout'       => "FTS has been safed"
        ]);
        Telemetry::create([
            'mission_id'    => 18,
            'timestamp'     => 0,
            'readout'       => "T+9 minutes. Altitude 207km, speed 6.7km/s, downrange distance 925km",
            'altitude'      => 207000,
            'velocity'      => 6700,
            'downrange'     => 925000
        ]);
        Telemetry::create([
            'mission_id'    => 18,
            'timestamp'     => 0,
            'readout'       => "Vehicle's in terminal guidance"
        ]);
        Telemetry::create([
            'mission_id'    => 18,
            'timestamp'     => 0,
            'readout'       => "Engine cutoff"
        ]);
        Telemetry::create([
            'mission_id'    => 18,
            'timestamp'     => 0,
            'readout'       => "SECO 1 confirmed"
        ]);
        Telemetry::create([
            'mission_id'    => 18,
            'timestamp'     => 0,
            'readout'       => "Flight computers in separation"
        ]);
        Telemetry::create([
            'mission_id'    => 18,
            'timestamp'     => 0,
            'readout'       => "Orbital altitude at insertion. 359 by 199k, inclined 51.644 degrees to the equator."
        ]);
        Telemetry::create([
            'mission_id'    => 18,
            'timestamp'     => 0,
            'readout'       => "New Foundland acquisition of signal"
        ]);
        Telemetry::create([
            'mission_id'    => 18,
            'timestamp'     => 0,
            'readout'       => "Good orbital insertion"
        ]);
        Telemetry::create([
            'mission_id'    => 18,
            'timestamp'     => 0,
            'readout'       => "Loss of signal, Cape Canaveral, Florida"
        ]);
        Telemetry::create([
            'mission_id'    => 18,
            'timestamp'     => 0,
            'readout'       => "Dragon separation confirmed"
        ]);
        Telemetry::create([
            'mission_id'    => 18,
            'timestamp'     => 0,
            'readout'       => "And acquisition of signal New Foundland"
        ]);
        Telemetry::create([
            'mission_id'    => 18,
            'timestamp'     => 0,
            'readout'       => "Flight computers in post-primed"
        ]);
        Telemetry::create([
            'mission_id'    => 18,
            'timestamp'     => 0,
            'readout'       => "Well, we're looking at the view of one of the solar arrays on Dragon, Falcon 9 has deposited Dragon into the correct orbit. We're just gonna' watch along with everybody for the next minute, while we wait for the Dragon solar array deploy sequence to kick in."
        ]);
        Telemetry::create([
            'mission_id'    => 18,
            'timestamp'     => 0,
            'readout'       => "Prop-prime complete"
        ]);
        Telemetry::create([
            'mission_id'    => 18,
            'timestamp'     => 0,
            'readout'       => "Flight computers in array deploy"
        ]);
        Telemetry::create([
            'mission_id'    => 18,
            'timestamp'     => 0,
            'readout'       => "Loss of signal, Wallops Island, Virginia"
        ]);
        Telemetry::create([
            'mission_id'    => 18,
            'timestamp'     => 0,
            'readout'       => "K, MD on mission A, first (?) 7101 step 1.9, publishing command request 1 dot cabin RH safe, RH system command is published sys2 please verify and lock"
        ]);
        Telemetry::create([
            'mission_id'    => 18,
            'timestamp'     => 0,
            'readout'       => "Sys2 verifies command request 1 cabin RH safe RH system command is armed"
        ]);
        Telemetry::create([
            'mission_id'    => 18,
            'timestamp'     => 0,
            'readout'       => "And executing"
        ]);
        Telemetry::create([
            'mission_id'    => 18,
            'timestamp'     => 0,
            'readout'       => "Loss of signal, New Hampshire tracking station"
        ]);
        Telemetry::create([
            'mission_id'    => 18,
            'timestamp'     => 0,
            'readout'       => "Good feedback"
        ]);
        Telemetry::create([
            'mission_id'    => 18,
            'timestamp'     => 0,
            'readout'       => "And it looks like we have another successful launch of the Falcon 9 rocket and the Dragon spacecraft into orbit. A great ride by Falcon 9 and then Dragon separated, and as you just saw, deploy both of its solar arrays. With that, Dragon will then spend the next couple of days on its way to the International Space Station. So with that, SpaceX is ending the webcast, but remember to follow us on the internet at spacex.com, as well as our social media pages, as we continue through the remainder of Dragon's flight to the International Space Station. And wrapping up, SpaceX would like to thank our NASA customer for entrusting us with the cargo, critical experiments going to the International Space Station, thanks to the Air Force for the support out of the eastern range, and ground station support around the world, and also to the licensing agency- the Federal Aviation Administation, and finally again thanks to all of you who have followed us on the webcast, we leave you with this shot of Mission Control center SpaceX, as the team begins the job of guiding Dragon to rendezvous and berthing with the ISS, with that, we'll see you for the next SpaceX Falcon 9 launch. Good morning and thank you."
        ]);
    }

    public function CRS5() {
        Telemetry::create([
            'mission_id'    => 19,
            'timestamp'     => 0,
            'readout'       => "Falcon 9 has cleared the towers"
        ]);
        Telemetry::create([
            'mission_id'    => 19,
            'timestamp'     => 0,
            'readout'       => "Pitch kick is in"
        ]);
        Telemetry::create([
            'mission_id'    => 19,
            'timestamp'     => 0,
            'readout'       => "OSM GC proceed to section 10 dot 53"
        ]);
        Telemetry::create([
            'mission_id'    => 19,
            'timestamp'     => 0,
            'readout'       => "Stage 1 propulsion is nominal"
        ]);
        Telemetry::create([
            'mission_id'    => 19,
            'timestamp'     => 0,
            'readout'       => "F9 power and telemetry nominal"
        ]);
        Telemetry::create([
            'mission_id'    => 19,
            'timestamp'     => 0,
            'readout'       => "T+60 seconds. Altitude 5.5km, speed 250m/s, downrange distance .9km",
            'altitude'      => 5500,
            'velocity'      => 250,
            'downrange'     => 900
        ]);
        Telemetry::create([
            'mission_id'    => 19,
            'timestamp'     => 0,
            'readout'       => "Stage 1 propulsion continues to perform nominally"
        ]);
        Telemetry::create([
            'mission_id'    => 19,
            'timestamp'     => 0,
            'readout'       => "Vehicle is supersonic and has reached maximum aerodynamic pressure"
        ]);
        Telemetry::create([
            'mission_id'    => 19,
            'timestamp'     => 0,
            'readout'       => "F9 power and telemetry still nominal"
        ]);
        Telemetry::create([
            'mission_id'    => 19,
            'timestamp'     => 0,
            'readout'       => "Landing platform has received acquisition of signal"
        ]);
        Telemetry::create([
            'mission_id'    => 19,
            'timestamp'     => 0,
            'readout'       => "MVac has begun chill"
        ]);
        Telemetry::create([
            'mission_id'    => 19,
            'timestamp'     => 0,
            'readout'       => "Altitude 35km, speed 1km/s, downrange distance 14.5km",
            'altitude'      => 35000,
            'velocity'      => 1000,
            'downrange'     => 14500
        ]);
        Telemetry::create([
            'mission_id'    => 19,
            'timestamp'     => 0,
            'readout'       => "T+2 minutes 30 seconds. Altitude 58km, speed 1.8km/s, downrange distance 33km",
            'altitude'      => 58000,
            'velocity'      => 1800,
            'downrange'     => 33000
        ]);
        Telemetry::create([
            'mission_id'    => 19,
            'timestamp'     => 0,
            'readout'       => "And we have MECO 1"
        ]);
        Telemetry::create([
            'mission_id'    => 19,
            'timestamp'     => 0,
            'readout'       => "MECO confirmed"
        ]);
        Telemetry::create([
            'mission_id'    => 19,
            'timestamp'     => 0,
            'readout'       => "Stage separation confirmed"
        ]);
        Telemetry::create([
            'mission_id'    => 19,
            'timestamp'     => 0,
            'readout'       => "Flight computers in second stage"
        ]);
        Telemetry::create([
            'mission_id'    => 19,
            'timestamp'     => 0,
            'readout'       => "Second stage acceleration confirmed"
        ]);
        Telemetry::create([
            'mission_id'    => 19,
            'timestamp'     => 0,
            'readout'       => "And we have second stage ignition"
        ]);
        Telemetry::create([
            'mission_id'    => 19,
            'timestamp'     => 0,
            'readout'       => "Altitude 90km, speed 1.9km/s, downrange distance 67km",
            'altitude'      => 90000,
            'velocity'      => 1900,
            'downrange'     => 67000
        ]);
        Telemetry::create([
            'mission_id'    => 19,
            'timestamp'     => 0,
            'readout'       => "Wallops Island acquisition of signal"
        ]);
        Telemetry::create([
            'mission_id'    => 19,
            'timestamp'     => 0,
            'readout'       => "Nosecone pyros have triggered"
        ]);
        Telemetry::create([
            'mission_id'    => 19,
            'timestamp'     => 0,
            'readout'       => "T+4 minutes. Stage 2 propulsion is still nominal. Altitude 134km, speed 2.1km/s, downrange distance now 135km",
            'altitude'      => 134000,
            'velocity'      => 2100,
            'downrange'     => 135000
        ]);
        Telemetry::create([
            'mission_id'    => 19,
            'timestamp'     => 0,
            'readout'       => "First and second stage power and telemetry nominal"
        ]);
        Telemetry::create([
            'mission_id'    => 19,
            'timestamp'     => 0,
            'readout'       => "Stage 1 is in boostback startup"
        ]);
        Telemetry::create([
            'mission_id'    => 19,
            'timestamp'     => 0,
            'readout'       => "T+5 minutes. Altitude 166km, speed 2.6km/s, downrange distance now 225km",
            'altitude'      => 166000,
            'velocity'      => 2600,
            'downrange'     => 225000
        ]);
        Telemetry::create([
            'mission_id'    => 19,
            'timestamp'     => 0,
            'readout'       => "We have stage 1 boostback shutdown"
        ]);
        Telemetry::create([
            'mission_id'    => 19,
            'timestamp'     => 0,
            'readout'       => "Stage 2 propulsion is still nominal"
        ]);
        Telemetry::create([
            'mission_id'    => 19,
            'timestamp'     => 0,
            'readout'       => "Vehicle continues to fly down the nominal trajectory"
        ]);
        Telemetry::create([
            'mission_id'    => 19,
            'timestamp'     => 0,
            'readout'       => "First and second stage power and telemetry nominal"
        ]);
        Telemetry::create([
            'mission_id'    => 19,
            'timestamp'     => 0,
            'readout'       => "AOS at the New Hampshire tracking station"
        ]);
        Telemetry::create([
            'mission_id'    => 19,
            'timestamp'     => 0,
            'readout'       => "We have stage 1 entry burn startup"
        ]);
        Telemetry::create([
            'mission_id'    => 19,
            'timestamp'     => 0,
            'readout'       => "Stage 2 propulsion continues to perform as expected"
        ]);
        Telemetry::create([
            'mission_id'    => 19,
            'timestamp'     => 0,
            'readout'       => "Stage 1 entry shutdown"
        ]);
        Telemetry::create([
            'mission_id'    => 19,
            'timestamp'     => 0,
            'readout'       => "T+7 minutes 15 seconds. Altitude 205km, speed 4.2km/s, downrange [inaudible] km",
            'altitude'      => 205000,
            'velocity'      => 4200
        ]);
        Telemetry::create([
            'mission_id'    => 19,
            'timestamp'     => 0,
            'readout'       => "Stage 1 FTS is safed"
        ]);
        Telemetry::create([
            'mission_id'    => 19,
            'timestamp'     => 0,
            'readout'       => "Vehicle continues down the nominal trajectory"
        ]);
        Telemetry::create([
            'mission_id'    => 19,
            'timestamp'     => 0,
            'readout'       => "Stage 1 is transonic"
        ]);
        Telemetry::create([
            'mission_id'    => 19,
            'timestamp'     => 0,
            'readout'       => "Stage 2 propulsion is still nominal"
        ]);
        Telemetry::create([
            'mission_id'    => 19,
            'timestamp'     => 0,
            'readout'       => "Second stage FTS is safed"
        ]);
        Telemetry::create([
            'mission_id'    => 19,
            'timestamp'     => 0,
            'readout'       => "Uprange assets have lost signal on first stage. Vehicle is now at the horizon"
        ]);
        Telemetry::create([
            'mission_id'    => 19,
            'timestamp'     => 0,
            'readout'       => "T+9 minutes. Altitude 208km, speed 6.9km/s, downrange distance 850km",
            'altitude'      => 208000,
            'velocity'      => 6900,
            'downrange'     => 850000
        ]);
        Telemetry::create([
            'mission_id'    => 19,
            'timestamp'     => 0,
            'readout'       => "SECO confirmed"
        ]);
        Telemetry::create([
            'mission_id'    => 19,
            'timestamp'     => 0,
            'readout'       => "And MECO"
        ]);
        Telemetry::create([
            'mission_id'    => 19,
            'timestamp'     => 0,
            'readout'       => "Flight computers in separation"
        ]);
        Telemetry::create([
            'mission_id'    => 19,
            'timestamp'     => 0,
            'readout'       => "And we have second stage engine cutoff. Standing by for spacecraft separation."
        ]);
        Telemetry::create([
            'mission_id'    => 19,
            'timestamp'     => 0,
            'readout'       => "Dragon separation confirmed"
        ]);
        Telemetry::create([
            'mission_id'    => 19,
            'timestamp'     => 0,
            'readout'       => "New Foundland tracking station AOS"
        ]);
        Telemetry::create([
            'mission_id'    => 19,
            'timestamp'     => 0,
            'readout'       => "Flight computers in post prime"
        ]);
        Telemetry::create([
            'mission_id'    => 19,
            'timestamp'     => 0,
            'readout'       => "And as you can see, Falcon 9 and Dragon have successfully entered what appears to be a good orbit. Dragon has separated from the F9 second stage and we're gonna' just stay with it for a minute while we wait to see video of the solar array deploy on the Dragon spacecraft."
        ]);
        Telemetry::create([
            'mission_id'    => 19,
            'timestamp'     => 0,
            'readout'       => "And prop-priming complete"
        ]);
        Telemetry::create([
            'mission_id'    => 19,
            'timestamp'     => 0,
            'readout'       => "NAV I'm gonna' go ahead and MP 1 point 8"
        ]);
        Telemetry::create([
            'mission_id'    => 19,
            'timestamp'     => 0,
            'readout'       => "Sorry, I meant SYS2"
        ]);
        Telemetry::create([
            'mission_id'    => 19,
            'timestamp'     => 0,
            'readout'       => "New Foundland AOS"
        ]);
        Telemetry::create([
            'mission_id'    => 19,
            'timestamp'     => 0,
            'readout'       => "Flight computers in array deploy"
        ]);
        Telemetry::create([
            'mission_id'    => 19,
            'timestamp'     => 0,
            'readout'       => "SYS1 on mission A, sending bitmap of 20 for Omni-C and Omni-B force on. CC to verify and lock"
        ]);
        Telemetry::create([
            'mission_id'    => 19,
            'timestamp'     => 0,
            'readout'       => "CC verifies bitmap 20 command is locked"
        ]);
        Telemetry::create([
            'mission_id'    => 19,
            'timestamp'     => 0,
            'readout'       => "Command sent"
        ]);
        Telemetry::create([
            'mission_id'    => 19,
            'timestamp'     => 0,
            'readout'       => "Avionics global"
        ]);
        Telemetry::create([
            'mission_id'    => 19,
            'timestamp'     => 0,
            'readout'       => "We have return of TDRS telemetry on Omni-C"
        ]);
        Telemetry::create([
            'mission_id'    => 19,
            'timestamp'     => 0,
            'readout'       => "And we have nominal loss of signal from the New Hampshire tracking station"
        ]);
        Telemetry::create([
            'mission_id'    => 19,
            'timestamp'     => 0,
            'readout'       => "New Foundland continues to source telemetry to the launch control center"
        ]);
        Telemetry::create([
            'mission_id'    => 19,
            'timestamp'     => 0,
            'readout'       => "Avionics global"
        ]);
        Telemetry::create([
            'mission_id'    => 19,
            'timestamp'     => 0,
            'readout'       => "Well as you've seen and heard, it looks like we've had another successful launch of the Falcon 9 rocket and the Dragon spacecraft into orbit. It was a great ride from the Falcon 9 and then Dragon separated and then you saw the solar array deployement. Right now for those who are wondering about the first stage, we had data, but as we talked about in the press conference before launch the Falcon 9 first stage goes over the horizon so we lose data, and so right now we're waiting for the recovery team to provide information. We'll have an update on social media later on this morning on what's happened with the first stage. So for now SpaceX we're going to end our webcast, but remember to follow us online at spacex.com and on our social media pages as we continue through the remainder of Dragon's approach to the International Space Station over the next 48 hours. SpaceX would like to say thanks to our NASA customer, and to the Air Force for Eastern range and ground station support, and to the Federal Aviation Administation, as well as all of you who have tuned in to follow us with today's successful launch, and we'll see you for our next flight coming up in the near future. Thanks for tuning in, and good morning."
        ]);

    }

    public function DSCOVR() {
        Telemetry::create([
            'mission_id'    => 20,
            'timestamp'     => 0,
            'readout'       => "Liftoff of the Falcon 9"
        ]);
        Telemetry::create([
            'mission_id'    => 20,
            'timestamp'     => 0,
            'readout'       => "Falcon 9 has cleared the towers"
        ]);
        Telemetry::create([
            'mission_id'    => 20,
            'timestamp'     => 0,
            'readout'       => "[inaudible] set warning stage to flight"
        ]);
        Telemetry::create([
            'mission_id'    => 20,
            'timestamp'     => 0,
            'readout'       => "[inaudible]"
        ]);
        Telemetry::create([
            'mission_id'    => 20,
            'timestamp'     => 0,
            'readout'       => "GC OSM move to section 10 dot 55"
        ]);
        Telemetry::create([
            'mission_id'    => 20,
            'timestamp'     => 0,
            'readout'       => "[inaudible] is active"
        ]);
        Telemetry::create([
            'mission_id'    => 20,
            'timestamp'     => 0,
            'readout'       => "Power and telemetry nominal"
        ]);
        Telemetry::create([
            'mission_id'    => 20,
            'timestamp'     => 0,
            'readout'       => "Altitude 6.5km, downrange distance 1.3km, speed 599m/s",
            'altitude'      => 6500,
            'downrange'     => 1300,
            'velocity'      => 599
        ]);
        Telemetry::create([
            'mission_id'    => 20,
            'timestamp'     => 0,
            'readout'       => "Recovery has acquisition of signal"
        ]);
        Telemetry::create([
            'mission_id'    => 20,
            'timestamp'     => 0,
            'readout'       => "Vehicle is supersonic"
        ]);
        Telemetry::create([
            'mission_id'    => 20,
            'timestamp'     => 0,
            'readout'       => "First stage propulsion-"
        ]);
        Telemetry::create([
            'mission_id'    => 20,
            'timestamp'     => 0,
            'readout'       => "Vehicle has reached maximum aerodynamic pressure"
        ]);
        Telemetry::create([
            'mission_id'    => 20,
            'timestamp'     => 0,
            'readout'       => "First stage prop is still nominal"
        ]);
        Telemetry::create([
            'mission_id'    => 20,
            'timestamp'     => 0,
            'readout'       => "Power and telemetry remain nominal"
        ]);
        Telemetry::create([
            'mission_id'    => 20,
            'timestamp'     => 0,
            'readout'       => "MVac is chilling in"
        ]);
        Telemetry::create([
            'mission_id'    => 20,
            'timestamp'     => 0,
            'readout'       => "Vehicle remains on a nominal trajectory. Altitude 33.9km, downrange distance 20.9km, speed 1468m/s",
            'altitude'      => 33900,
            'downrange'     => 20900,
            'velocity'      => 1468
        ]);
        Telemetry::create([
            'mission_id'    => 20,
            'timestamp'     => 0,
            'readout'       => "Vehicle remains on a nominal trajectory. Altitude 57.9km, downrange distance 50.0km, speed 2350m/s",
            'altitude'      => 57900,
            'downrange'     => 50000,
            'velocity'      => 2350
        ]);
        Telemetry::create([
            'mission_id'    => 20,
            'timestamp'     => 0,
            'readout'       => "We have MECO 1"
        ]);
        Telemetry::create([
            'mission_id'    => 20,
            'timestamp'     => 0,
            'readout'       => "Stage separation confirmed"
        ]);
        Telemetry::create([
            'mission_id'    => 20,
            'timestamp'     => 0,
            'readout'       => "And we have stage 2 engine ignition"
        ]);
        Telemetry::create([
            'mission_id'    => 20,
            'timestamp'     => 0,
            'readout'       => "Fairing separation confirmed"
        ]);
        Telemetry::create([
            'mission_id'    => 20,
            'timestamp'     => 0,
            'readout'       => "Stage 2 propulsion is still nominal"
        ]);
        Telemetry::create([
            'mission_id'    => 20,
            'timestamp'     => 0,
            'readout'       => "Power and telemetry still nominal"
        ]);
        Telemetry::create([
            'mission_id'    => 20,
            'timestamp'     => 0,
            'readout'       => "Altitude 130km, downrange distance 215km, vehicle speed 2303m/s",
            'altitude'      => 130000,
            'downrange'     => 215000,
            'velocity'      => 2303
        ]);
        Telemetry::create([
            'mission_id'    => 20,
            'timestamp'     => 0,
            'readout'       => "Altitude 130km, downrange distance 320km, vehicle speed 2313m/s",
            'altitude'      => 130000,
            'downrange'     => 320000,
            'velocity'      => 2313
        ]);
        Telemetry::create([
            'mission_id'    => 20,
            'timestamp'     => 0,
            'readout'       => "Stage 2 propulsion is still nominal"
        ]);
        Telemetry::create([
            'mission_id'    => 20,
            'timestamp'     => 0,
            'readout'       => "AFCN AOS"
        ]);
        Telemetry::create([
            'mission_id'    => 20,
            'timestamp'     => 0,
            'readout'       => "Power and telemetry still nominal"
        ]);
        Telemetry::create([
            'mission_id'    => 20,
            'timestamp'     => 0,
            'readout'       => "Altitude 99km, downrange distance 417km, vehicle speed 2449m/s",
            'altitude'      => 99000,
            'downrange'     => 417000,
            'velocity'      => 2449
        ]);
        Telemetry::create([
            'mission_id'    => 20,
            'timestamp'     => 0,
            'readout'       => "We have stage 1 entry startup"
        ]);
        Telemetry::create([
            'mission_id'    => 20,
            'timestamp'     => 0,
            'readout'       => "Second stage FTS has been safed"
        ]);
        Telemetry::create([
            'mission_id'    => 20,
            'timestamp'     => 0,
            'readout'       => "Stage 2 prop is still nominal"
        ]);
        Telemetry::create([
            'mission_id'    => 20,
            'timestamp'     => 0,
            'readout'       => "First stage FTS has been safed"
        ]);
        Telemetry::create([
            'mission_id'    => 20,
            'timestamp'     => 0,
            'readout'       => "Altitude 191km, downrange distance 813km, vehicle speed 5615m/s",
            'altitude'      => 191000,
            'downrange'     => 813000,
            'velocity'      => 5615
        ]);
        Telemetry::create([
            'mission_id'    => 20,
            'timestamp'     => 0,
            'readout'       => "Stage 1 entry shutdown"
        ]);
        Telemetry::create([
            'mission_id'    => 20,
            'timestamp'     => 0,
            'readout'       => "Vehicle's in terminal guidance"
        ]);
        Telemetry::create([
            'mission_id'    => 20,
            'timestamp'     => 0,
            'readout'       => "And we have SECO 1"
        ]);
        Telemetry::create([
            'mission_id'    => 20,
            'timestamp'     => 0,
            'readout'       => "Eastern range loss of signal"
        ]);
        Telemetry::create([
            'mission_id'    => 20,
            'timestamp'     => 0,
            'readout'       => "We have stage 1 splashdown"
        ]);
        Telemetry::create([
            'mission_id'    => 20,
            'timestamp'     => 0,
            'readout'       => "Well as you saw and heard, Falcon 9 has carried the DSCOVR spacecraft into the Low Earth parking orbit. There is a second burn of the upper stage required in about 21 minutes to place DSCOVR in the final orbit, heading towards the L1 Lagrange point. SpaceX is ending the webcast now but remember to follow us online at spacex.com As well as on our social media pages as we continue through the remainder of todays mission. Also SpaceX would like to thanks to our NASA and NOAA spacecraft stakeholders, our Air Force customer, from the space and missile systems center, and to the Air Force for Eastern Range and ground station support, and all of you for following us on today's launch, and we'll you see next time here from SpaceX in Hawthorne, California."
        ]);
    }

    public function ABSEutelsat1() {
        Telemetry::create([
            'mission_id'    => 21,
            'timestamp'     => 0,
            'readout'       => "Liftoff"
        ]);
        Telemetry::create([
            'mission_id'    => 21,
            'timestamp'     => 0,
            'readout'       => "Falcon 9 has cleared the towers"
        ]);
        Telemetry::create([
            'mission_id'    => 21,
            'timestamp'     => 0,
            'readout'       => "[inaudible] set stage to flight"
        ]);
        Telemetry::create([
            'mission_id'    => 21,
            'timestamp'     => 0,
            'readout'       => "[inaudible] phase change"
        ]);
        Telemetry::create([
            'mission_id'    => 21,
            'timestamp'     => 0,
            'readout'       => "GC OSM proceed to section 10 dot 66"
        ]);
        Telemetry::create([
            'mission_id'    => 21,
            'timestamp'     => 0,
            'readout'       => "Copy"
        ]);
        Telemetry::create([
            'mission_id'    => 21,
            'timestamp'     => 0,
            'readout'       => "Stage 1 PU is active"
        ]);
        Telemetry::create([
            'mission_id'    => 21,
            'timestamp'     => 0,
            'readout'       => "Power and telemetry nominal"
        ]);
        Telemetry::create([
            'mission_id'    => 21,
            'timestamp'     => 0,
            'readout'       => "Vehicle altitude 3.8km, velocity 197m/s, downrange distance 1km",
            'altitude'      => 3800,
            'downrange'     => 1000,
            'velocity'      => 197
        ]);
        Telemetry::create([
            'mission_id'    => 21,
            'timestamp'     => 0,
            'readout'       => "Vehicle is supersonic"
        ]);
        Telemetry::create([
            'mission_id'    => 21,
            'timestamp'     => 0,
            'readout'       => "Vehicle has reached maximum aerodynamic pressure"
        ]);
        Telemetry::create([
            'mission_id'    => 21,
            'timestamp'     => 0,
            'readout'       => "Stage 1 propulsion is still nominal"
        ]);
        Telemetry::create([
            'mission_id'    => 21,
            'timestamp'     => 0,
            'readout'       => "Power and telemetry remain nominal"
        ]);
        Telemetry::create([
            'mission_id'    => 21,
            'timestamp'     => 0,
            'readout'       => "MVac chill has begun"
        ]);
        Telemetry::create([
            'mission_id'    => 21,
            'timestamp'     => 0,
            'readout'       => "Vehicle altitude 33km, velocity 1200m/s, downrange distance 36km",
            'altitude'      => 33000,
            'downrange'     => 36000,
            'velocity'      => 1200
        ]);
        Telemetry::create([
            'mission_id'    => 21,
            'timestamp'     => 0,
            'readout'       => "Vehicle remains on a nominal trajectory"
        ]);
        Telemetry::create([
            'mission_id'    => 21,
            'timestamp'     => 0,
            'readout'       => "Vehicle altitude 50km, velocity 1900m/s, downrange distance 70km",
            'altitude'      => 50000,
            'downrange'     => 70000,
            'velocity'      => 1900
        ]);
        Telemetry::create([
            'mission_id'    => 21,
            'timestamp'     => 0,
            'readout'       => "We have MECO 1"
        ]);
        Telemetry::create([
            'mission_id'    => 21,
            'timestamp'     => 0,
            'readout'       => "Stage separation confirmed"
        ]);
        Telemetry::create([
            'mission_id'    => 21,
            'timestamp'     => 0,
            'readout'       => "And we have MVac start"
        ]);
        Telemetry::create([
            'mission_id'    => 21,
            'timestamp'     => 0,
            'readout'       => "Fairing separation confirmed"
        ]);
        Telemetry::create([
            'mission_id'    => 21,
            'timestamp'     => 0,
            'readout'       => "Stage 2 propulsion is still nominal"
        ]);
        Telemetry::create([
            'mission_id'    => 21,
            'timestamp'     => 0,
            'readout'       => "Power and telemetry nominal"
        ]);
        Telemetry::create([
            'mission_id'    => 21,
            'timestamp'     => 0,
            'readout'       => "Bermuda acquisition of signal"
        ]);
        Telemetry::create([
            'mission_id'    => 21,
            'timestamp'     => 0,
            'readout'       => "Vehicle altitude 138km, velocity 3100m/s, downrange distance 370km",
            'altitude'      => 138000,
            'downrange'     => 370000,
            'velocity'      => 3100
        ]);
        Telemetry::create([
            'mission_id'    => 21,
            'timestamp'     => 0,
            'readout'       => "Vehicle remains on a nominal trajectory"
        ]);
        Telemetry::create([
            'mission_id'    => 21,
            'timestamp'     => 0,
            'readout'       => "Vehicle altitude is 165km, velocity is 3800m/s, downrange distance 590km",
            'altitude'      => 165000,
            'downrange'     => 590000,
            'velocity'      => 3800
        ]);
        Telemetry::create([
            'mission_id'    => 21,
            'timestamp'     => 0,
            'readout'       => "Stage 2 propulsion is still nominal"
        ]);
        Telemetry::create([
            'mission_id'    => 21,
            'timestamp'     => 0,
            'readout'       => "Power and telemetry remain nominal"
        ]);
        Telemetry::create([
            'mission_id'    => 21,
            'timestamp'     => 0,
            'readout'       => "Vehicle altitude 177km, velocity 4500m/s, downrange distance 806km",
            'altitude'      => 177000,
            'downrange'     => 806000,
            'velocity'      => 4500
        ]);
        Telemetry::create([
            'mission_id'    => 21,
            'timestamp'     => 0,
            'readout'       => "Stage 2 propulsion is still nominal"
        ]);
        Telemetry::create([
            'mission_id'    => 21,
            'timestamp'     => 0,
            'readout'       => "Vehicle altitude 180km, velocity is 5.5km/s, downrange distance 1100km",
            'altitude'      => 180000,
            'downrange'     => 1100000,
            'velocity'      => 5500
        ]);
        Telemetry::create([
            'mission_id'    => 21,
            'timestamp'     => 0,
            'readout'       => "Cape loss of signal"
        ]);
        Telemetry::create([
            'mission_id'    => 21,
            'timestamp'     => 0,
            'readout'       => "FTS has been safed"
        ]);
        Telemetry::create([
            'mission_id'    => 21,
            'timestamp'     => 0,
            'readout'       => "Vehicle remains on a nominal trajectory"
        ]);
        Telemetry::create([
            'mission_id'    => 21,
            'timestamp'     => 0,
            'readout'       => "And we have SECO 1"
        ]);
        Telemetry::create([
            'mission_id'    => 21,
            'timestamp'     => 0,
            'readout'       => "Vehicle altitude 178km, velocity is 7500m/s, downrange distance 1600km",
            'altitude'      => 178000,
            'downrange'     => 1600000,
            'velocity'      => 7500
        ]);
        Telemetry::create([
            'mission_id'    => 21,
            'timestamp'     => 0,
            'readout'       => "Well as you saw and heard, Falcon 9 has carried the ABS and Eutelsat satellites into the low earth parking orbit.There is a second burn of the upper stage required at just under 26 minutes into flight, that will place both payloads into the supersynchronous transfer orbit. SpaceX is ending the webcast now, but remember to follow us online at our twitter social media page and at spacex.com as we continue through the remainder of tonight's mission. SpaceX would like to say thanks to our Federal Aviation Administration Licensing Authority, thank you to the Air Force for Eastern range and ground station support, and of course to our EutelSat and Asia Broadcast Satellite customers for their confidence in SpaceX, and finally to all of you for following us on today's launch, with that we'll see you next time here from SpaceX headquarters from Hawthorne California."
        ]);
    }

    public function CRS6() {
        Telemetry::create([
            'mission_id'    => 22,
            'timestamp'     => 0,
            'readout'       => "We have liftoff of the Falcon 9"
        ]);
        Telemetry::create([
            'mission_id'    => 22,
            'timestamp'     => 0,
            'readout'       => "Falcon 9 has cleared the tower"
        ]);
        Telemetry::create([
            'mission_id'    => 22,
            'timestamp'     => 0,
            'readout'       => "Stage 1 vehicle's pitching downrange"
        ]);
        Telemetry::create([
            'mission_id'    => 22,
            'timestamp'     => 0,
            'readout'       => "Stage 1 and stage 2 power buses are both nominal, solid telemetry lock on both stages"
        ]);
        Telemetry::create([
            'mission_id'    => 22,
            'timestamp'     => 0,
            'readout'       => "OSM verify the fire department pads safety spacex safety and the pad leads are conducting initial pad sweeps are in route. Copy. VC abort all running autosequence after F9 and Dragon terminal count autosequences have ended"
        ]);
        Telemetry::create([
            'mission_id'    => 22,
            'timestamp'     => 0,
            'readout'       => "Vehicle's supersonic"
        ]);
        Telemetry::create([
            'mission_id'    => 22,
            'timestamp'     => 0,
            'readout'       => "And vehicle's reached maximum aerodynamic pressure"
        ]);
        Telemetry::create([
            'mission_id'    => 22,
            'timestamp'     => 0,
            'readout'       => "Stage 1 propulsion still nominal"
        ]);
        Telemetry::create([
            'mission_id'    => 22,
            'timestamp'     => 0,
            'readout'       => "Recovery platform has acquisition of signal"
        ]);
        Telemetry::create([
            'mission_id'    => 22,
            'timestamp'     => 0,
            'readout'       => "Stage 1 and stage 2 telemetry are uhh- telemetry links are nominal, power buses are also nominal"
        ]);
        Telemetry::create([
            'mission_id'    => 22,
            'timestamp'     => 0,
            'readout'       => "MVac is chilling in"
        ]);
        Telemetry::create([
            'mission_id'    => 22,
            'timestamp'     => 0,
            'readout'       => "T+2 minutes. Altitude 32km, speed 1km/s, downrange distance 13.5km",
            'altitude'      => 32000,
            'downrange'     => 13500,
            'velocity'      => 1000
        ]);
        Telemetry::create([
            'mission_id'    => 22,
            'timestamp'     => 0,
            'readout'       => "We have MECO 1"
        ]);
        Telemetry::create([
            'mission_id'    => 22,
            'timestamp'     => 0,
            'readout'       => "Stage separation confirmed, good luck stage 1"
        ]);
        Telemetry::create([
            'mission_id'    => 22,
            'timestamp'     => 0,
            'readout'       => "And we have MVac ignition"
        ]);
        Telemetry::create([
            'mission_id'    => 22,
            'timestamp'     => 0,
            'readout'       => "T+3 minutes. Altitude 86km, speed 1.96km/s, downrange distance 63km",
            'altitude'      => 86000,
            'downrange'     => 63000,
            'velocity'      => 1960
        ]);
        Telemetry::create([
            'mission_id'    => 22,
            'timestamp'     => 0,
            'readout'       => "Stage 2 propulsion still nominal"
        ]);
        Telemetry::create([
            'mission_id'    => 22,
            'timestamp'     => 0,
            'readout'       => "Stage 1 and stage 2 power buses are nominal, solid telemetry lock on both signal"
        ]);
        Telemetry::create([
            'mission_id'    => 22,
            'timestamp'     => 0,
            'readout'       => "Acquisition of signal Bermuda ground station"
        ]);
        Telemetry::create([
            'mission_id'    => 22,
            'timestamp'     => 0,
            'readout'       => "We have stage 1 boostback startup"
        ]);
        Telemetry::create([
            'mission_id'    => 22,
            'timestamp'     => 0,
            'readout'       => "T+5 minutes. Altitude 165km, speed 2.56km/s, downrange distance 221km. Vehicle's following the nominal",
            'altitude'      => 165000,
            'downrange'     => 221000,
            'velocity'      => 2560
        ]);
        Telemetry::create([
            'mission_id'    => 22,
            'timestamp'     => 0,
            'readout'       => "We have stage 1 boostback shutdown"
        ]);
        Telemetry::create([
            'mission_id'    => 22,
            'timestamp'     => 0,
            'readout'       => "Stage 2 propulsion is still nominal"
        ]);
        Telemetry::create([
            'mission_id'    => 22,
            'timestamp'     => 0,
            'readout'       => "New Hampshire acquisition of signal"
        ]);
        Telemetry::create([
            'mission_id'    => 22,
            'timestamp'     => 0,
            'readout'       => "Stage 1 and stage 2 power buses are nominal, solid telemetry lock on both stages"
        ]);
        Telemetry::create([
            'mission_id'    => 22,
            'timestamp'     => 0,
            'readout'       => "New Hampshire acquisition of signal"
        ]);
        Telemetry::create([
            'mission_id'    => 22,
            'timestamp'     => 0,
            'readout'       => "Stage 1 entry burn has started"
        ]);
        Telemetry::create([
            'mission_id'    => 22,
            'timestamp'     => 0,
            'readout'       => "Stage 2 propulsion still nominal"
        ]);
        Telemetry::create([
            'mission_id'    => 22,
            'timestamp'     => 0,
            'readout'       => "Stage 1 entry shutdown"
        ]);
        Telemetry::create([
            'mission_id'    => 22,
            'timestamp'     => 0,
            'readout'       => "Stage 1 FTS has been safed"
        ]);
        Telemetry::create([
            'mission_id'    => 22,
            'timestamp'     => 0,
            'readout'       => "T+7 minutes 30 seconds. Altitude 205km, speed 4.4km/s, downrange distance 530km",
            'altitude'      => 205000,
            'downrange'     => 530000,
            'velocity'      => 4400
        ]);
        Telemetry::create([
            'mission_id'    => 22,
            'timestamp'     => 0,
            'readout'       => "Stage 2 FTS has been safed"
        ]);
        Telemetry::create([
            'mission_id'    => 22,
            'timestamp'     => 0,
            'readout'       => "Stage 1 is transonic"
        ]);
        Telemetry::create([
            'mission_id'    => 22,
            'timestamp'     => 0,
            'readout'       => "Stage 2 propulsion still nominal"
        ]);
        Telemetry::create([
            'mission_id'    => 22,
            'timestamp'     => 0,
            'readout'       => "Stage 1 landing burn has started"
        ]);
        Telemetry::create([
            'mission_id'    => 22,
            'timestamp'     => 0,
            'readout'       => "[inaudible] LOS"
        ]);
        Telemetry::create([
            'mission_id'    => 22,
            'timestamp'     => 0,
            'readout'       => "Second stage is in terminal guidance"
        ]);
        Telemetry::create([
            'mission_id'    => 22,
            'timestamp'     => 0,
            'readout'       => "T+9 minutes. Altitude 208km, speed 6.5km/s, downrange distance 830km",
            'altitude'      => 208000,
            'downrange'     => 830000,
            'velocity'      => 6500
        ]);
        Telemetry::create([
            'mission_id'    => 22,
            'timestamp'     => 0,
            'readout'       => "And we have SECO 1"
        ]);
        Telemetry::create([
            'mission_id'    => 22,
            'timestamp'     => 0,
            'readout'       => "SECO confirmed"
        ]);
        Telemetry::create([
            'mission_id'    => 22,
            'timestamp'     => 0,
            'readout'       => "Dragon's in separation"
        ]);
        Telemetry::create([
            'mission_id'    => 22,
            'timestamp'     => 0,
            'readout'       => "Cape LOS"
        ]);
        Telemetry::create([
            'mission_id'    => 22,
            'timestamp'     => 0,
            'readout'       => "Acquisition of signal, New Foundland Canada"
        ]);
        Telemetry::create([
            'mission_id'    => 22,
            'timestamp'     => 0,
            'readout'       => "Dragon acquisition of signal, New Foundland"
        ]);
        Telemetry::create([
            'mission_id'    => 22,
            'timestamp'     => 0,
            'readout'       => "Dragon deploy confirmed"
        ]);
        Telemetry::create([
            'mission_id'    => 22,
            'timestamp'     => 0,
            'readout'       => "Solar array deploy nominal"
        ]);
        Telemetry::create([
            'mission_id'    => 22,
            'timestamp'     => 0,
            'readout'       => "New Hampshire Loss of Signal"
        ]);
        Telemetry::create([
            'mission_id'    => 22,
            'timestamp'     => 0,
            'readout'       => "Well as you saw and heard, looks like we've had another successful launch of the Falcon 9 rocket and the Dragon spacecraft into orbit. Again, another great ride from Falcon 9, right into the desired orbit, Dragon separated and as you saw in the webcast, deployed both of it's solar arrays. Right now we're waiting for word from the landing ship, but we'll have to give you that update after we close the webcast, so please check our social media pages, SpaceX is ending the webcast now, but remember us to follow us online at spacex.com, and at our social media pages, as we continue through the remainder of Dragon's approach to the International Space Station over the next couple of days. This time SpaceX would like to say thanks to our NASA customer, to the Air Force for Eastern Range and ground station support, to the Federal Aviation Administation, and all of you for watching today's launch with us. A great launch of Falcon 9 and Dragon out of Cape Canaveral, and we hope to see you later this month, as we countdown to the launch to TurkmenAlem52E/Monacosat on the Falcon 9. With that, good afternoon everybody from SpaceX headquarts from Hawthorne California."
        ]);
    }

    public function TurkmenAlem52E() {
        Telemetry::create([
            'mission_id'    => 23,
            'timestamp'     => 0,
            'readout'       => "We have liftoff of the Falcon 9"
        ]);
        Telemetry::create([
            'mission_id'    => 23,
            'timestamp'     => 0,
            'readout'       => "Falcon 9 has cleared the tower"
        ]);
        Telemetry::create([
            'mission_id'    => 23,
            'timestamp'     => 0,
            'readout'       => "First stage PU is active"
        ]);
        Telemetry::create([
            'mission_id'    => 23,
            'timestamp'     => 0,
            'readout'       => "Flight, telemetry, and power look nominal on both stages"
        ]);
        Telemetry::create([
            'mission_id'    => 23,
            'timestamp'     => 0,
            'readout'       => "T+60 seconds. Altitude 6km, speed 280m/s, downrange distance 2km",
            'altitude'      => 6000,
            'speed'         => 280,
            'downrange'     => 2000
        ]);
        Telemetry::create([
            'mission_id'    => 23,
            'timestamp'     => 0,
            'readout'       => "Vehicle's supersonic"
        ]);
        Telemetry::create([
            'mission_id'    => 23,
            'timestamp'     => 0,
            'readout'       => "Vehicle's passed through max aerodynamic pressure"
        ]);
        Telemetry::create([
            'mission_id'    => 23,
            'timestamp'     => 0,
            'readout'       => "Stage 1 propulsion is still nominal"
        ]);
        Telemetry::create([
            'mission_id'    => 23,
            'timestamp'     => 0,
            'readout'       => "[Inaudible] power and telemetry still look nominal"
        ]);
        Telemetry::create([
            'mission_id'    => 23,
            'timestamp'     => 0,
            'readout'       => "MVac chill has begun"
        ]);
        Telemetry::create([
            'mission_id'    => 23,
            'timestamp'     => 0,
            'readout'       => "T+2 minutes 20 seconds. Altitude 40km, speed 1.5km/s, downrange distance 50km",
            'altitude'      => 40000,
            'speed'         => 1500,
            'downrange'     => 50000
        ]);
        Telemetry::create([
            'mission_id'    => 23,
            'timestamp'     => 0,
            'readout'       => "We have MECO 1"
        ]);
        Telemetry::create([
            'mission_id'    => 23,
            'timestamp'     => 0,
            'readout'       => "Stage sep confirmed"
        ]);
        Telemetry::create([
            'mission_id'    => 23,
            'timestamp'     => 0,
            'readout'       => "And we have MVac ignition"
        ]);
        Telemetry::create([
            'mission_id'    => 23,
            'timestamp'     => 0,
            'readout'       => "Fairing sep confirmed"
        ]);
        Telemetry::create([
            'mission_id'    => 23,
            'timestamp'     => 0,
            'readout'       => "Bermuda acquisition of signal"
        ]);
        Telemetry::create([
            'mission_id'    => 23,
            'timestamp'     => 0,
            'readout'       => "T+4 minutes 20 seconds. Altitude 136km, speed 3.2km/s, downrange distance 365km",
            'altitude'      => 136000,
            'speed'         => 3200,
            'downrange'     => 365000
        ]);
        Telemetry::create([
            'mission_id'    => 23,
            'timestamp'     => 0,
            'readout'       => "Telemetry, health, and power still look nominal"
        ]);
        Telemetry::create([
            'mission_id'    => 23,
            'timestamp'     => 0,
            'readout'       => "Vehicle's flying right down the nominal"
        ]);
        Telemetry::create([
            'mission_id'    => 23,
            'timestamp'     => 0,
            'readout'       => "Stage 2 propulsion is still nominal"
        ]);
        Telemetry::create([
            'mission_id'    => 23,
            'timestamp'     => 0,
            'readout'       => "Altitude 168km, speed 3.95km/s, downrange distance 650km",
            'altitude'      => 168000,
            'speed'         => 3950,
            'downrange'     => 650000
        ]);
        Telemetry::create([
            'mission_id'    => 23,
            'timestamp'     => 0,
            'readout'       => "RF, telemetry, and power still look good"
        ]);
        Telemetry::create([
            'mission_id'    => 23,
            'timestamp'     => 0,
            'readout'       => "T+6 minutes 30 seconds. Altitude 176km, speed 4.5km/s, downrange distance 835km",
            'altitude'      => 176000,
            'speed'         => 4500,
            'downrange'     => 835000
        ]);
        Telemetry::create([
            'mission_id'    => 23,
            'timestamp'     => 0,
            'readout'       => "And vehicle continues to fly down the nominal"
        ]);
        Telemetry::create([
            'mission_id'    => 23,
            'timestamp'     => 0,
            'readout'       => "Stage 2 propulsion is still nominal"
        ]);
        Telemetry::create([
            'mission_id'    => 23,
            'timestamp'     => 0,
            'readout'       => "T+7 minutes 30 seconds. Altitude 181km, speed 5.5km/s, downrange distance 1150km",
            'altitude'      => 181000,
            'speed'         => 5500,
            'downrange'     => 1150000
        ]);
        Telemetry::create([
            'mission_id'    => 23,
            'timestamp'     => 0,
            'readout'       => "Vehicle's now in terminal guidance"
        ]);
        Telemetry::create([
            'mission_id'    => 23,
            'timestamp'     => 0,
            'readout'       => "FTS has been safed"
        ]);
        Telemetry::create([
            'mission_id'    => 23,
            'timestamp'     => 0,
            'readout'       => "And we have Cape LOS, [inaudible] on Bermuda data at this time"
        ]);
        Telemetry::create([
            'mission_id'    => 23,
            'timestamp'     => 0,
            'readout'       => "And we have SECO 1"
        ]);
        Telemetry::create([
            'mission_id'    => 23,
            'timestamp'     => 0,
            'readout'       => "We have a good park orbit insertion, 208 by 175km inclined 27.7 degrees to the equator"
        ]);
        Telemetry::create([
            'mission_id'    => 23,
            'timestamp'     => 0,
            'readout'       => "Well as you just saw and heard, we've had another successful launch of the Falcon 9 rocket, carrying the TurkmenAlem52E/MonacoSat into low earth parking orbit. Orbit injection appears to be accurate, after we had to wait for a 49 minute delay due to weather. The next activities will be restart of the second stage engine placing the spacecraft into geosynchronous transfer orbit. Spacecraft separation is planned to occur at approximately T+52 minutes and 15 seconds. However, SpaceX is ending the webcast now, but remember to follow us online at spacex.com, as well as on our social media pages for more mission updates over the next hour. We'd like to close the webcast with a thanks to our customer, to the Air Force for Eastern Range and ground station support, to the Federal Aviation Administation, to all of you who followed us on today's launch, and we invite you to follow us in May, when SpaceX conducts the Pad Abort test of our Crew Dragon capsule from Complex 40 at Cape Canaveral. Signing off until then, have a good afternoon."
        ]);
    }

    public function CRS7() {
        Telemetry::create([
            'mission_id'    => 24,
            'timestamp'     => 0,
            'readout'       => "We have liftoff of the Falcon 9"
        ]);
        Telemetry::create([
            'mission_id'    => 24,
            'timestamp'     => 0,
            'readout'       => "Falcon 9 has cleared the tower"
        ]);
        Telemetry::create([
            'mission_id'    => 24,
            'timestamp'     => 0,
            'readout'       => "Stage 1 propulsion is nominal"
        ]);
        Telemetry::create([
            'mission_id'    => 24,
            'timestamp'     => 0,
            'readout'       => "Vehicle's programming downrange"
        ]);
        Telemetry::create([
            'mission_id'    => 24,
            'timestamp'     => 0,
            'readout'       => "Stage 1 propellant utilization is active"
        ]);
        Telemetry::create([
            'mission_id'    => 24,
            'timestamp'     => 0,
            'readout'       => "Power and telemetry nominal"
        ]);
        Telemetry::create([
            'mission_id'    => 24,
            'timestamp'     => 0,
            'readout'       => "T+1 minute. Altitude [cutout], speed 290m/s, downrange distance 1.1km",
            'speed'         => 290,
            'downrange'     => 1100
        ]);
        Telemetry::create([
            'mission_id'    => 24,
            'timestamp'     => 0,
            'readout'       => "Vehicle's supersonic"
        ]);
        Telemetry::create([
            'mission_id'    => 24,
            'timestamp'     => 0,
            'readout'       => "Recovery droneship has AOS"
        ]);
        Telemetry::create([
            'mission_id'    => 24,
            'timestamp'     => 0,
            'readout'       => "Vehicle's reached maximum aerodynamic pressure"
        ]);
        Telemetry::create([
            'mission_id'    => 24,
            'timestamp'     => 0,
            'readout'       => "Stage 1 propulsion is still nominal"
        ]);
        Telemetry::create([
            'mission_id'    => 24,
            'timestamp'     => 0,
            'readout'       => "Power and telemetry remain nominal"
        ]);
        Telemetry::create([
            'mission_id'    => 24,
            'timestamp'     => 0,
            'readout'       => "MVac chill has begun"
        ]);
        Telemetry::create([
            'mission_id'    => 24,
            'timestamp'     => 0,
            'readout'       => "T+2 minutes. Altitude 32km, speed 1km/s, downrange distance 13km",
            'altitude'      => 32000,
            'speed'         => 1000,
            'downrange'     => 13000
        ]);
        Telemetry::create([
            'mission_id'    => 24,
            'timestamp'     => 0,
            'readout'       => "[Inaudible], this is the ROC, [inaudible]"
        ]);
        Telemetry::create([
            'mission_id'    => 24,
            'timestamp'     => 0,
            'readout'       => "ROC on the countdown net"
        ]);
        Telemetry::create([
            'mission_id'    => 24,
            'timestamp'     => 0,
            'readout'       => "Well, this is John Insprcker back at SpaceX broadcast headquarters in Hawthorne, we have lost the video from the vehicle, there was some type of anomaly during first stage flight, what we know is that the countdown was satisfactory, we did ignite the 9 Merlin engines, we successfully lifted off the Slick Forty launchpad at Cape Canaveral, we proceeded through the stressing events during flight, went through maximum aerodynamic pressure and went supersonic, however it appears something did occur during first stage operations. SpaceX engineers will be reviewing the data in order to learn more about what happened during the Falcon 9 flight. One of the unique features of Falcon 9 is the large amounts of data that come on separate telemetry streams from the first and the second stage. This will bring an end to the live webcast for today. Please check our website spacex.com, and our social media pages, where we will be providing you with more information as it becomes available. Thanks for joining us today."
        ]);
    }
}