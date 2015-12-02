<?php
use Illuminate\Database\Seeder;
use SpaceXStats\Models\Telemetry;

class TelemetryTableSeeder extends Seeder {
    public function run() {
        $this->Falcon1Flight1();
        $this->Falcon1Flight2();
        $this->Falcon1Flight3();
        //$this->Falcon1Flight4();
        $this->Falcon1Flight5();
        $this->COTS2Plus();
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
            'altitude'     => 117000
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
            'timestamp'     => 1,
            'readout'       => "We're in stage 1"
        ]);
        Telemetry::create([
            'mission_id'    => 4,
            'timestamp'     => 1,
            'readout'       => 'We have liftoff indication'
        ]);
        Telemetry::create([
            'mission_id'    => 4,
            'timestamp'     => 1,
            'readout'       => 'We have liftoff'
        ]);
        Telemetry::create([
            'mission_id'    => 4,
            'timestamp'     => 1,
            'readout'       => 'SpaceX Falcon 1 launch vehicle, Falcon has cleared the tower'
        ]);
        Telemetry::create([
            'mission_id'    => 4,
            'timestamp'     => 1,
            'readout'       => 'Plus twelve'
        ]);
        Telemetry::create([
            'mission_id'    => 4,
            'timestamp'     => 1,
            'readout'       => 'Pitchkick'
        ]);
        Telemetry::create([
            'mission_id'    => 4,
            'timestamp'     => 1,
            'readout'       => 'Plus twenty seconds'
        ]);
        Telemetry::create([
            'mission_id'    => 4,
            'timestamp'     => 1,
            'readout'       => '[inaudible]'
        ]);
        Telemetry::create([
            'mission_id'    => 4,
            'timestamp'     => 1,
            'readout'       => 'Vehicle now [inaudible] nominal, gravity turn'
        ]);
        Telemetry::create([
            'mission_id'    => 4,
            'timestamp'     => 1,
            'readout'       => 'Power systems nominal'
        ]);
        Telemetry::create([
            'mission_id'    => 4,
            'timestamp'     => 1,
            'readout'       => 'T plus sixty seconds'
        ]);
        Telemetry::create([
            'mission_id'    => 4,
            'timestamp'     => 1,
            'readout'       => 'Got Max-Q'
        ]);
        Telemetry::create([
            'mission_id'    => 4,
            'timestamp'     => 1,
            'readout'       => 'First stage propulsion performance is nominal'
        ]);
        Telemetry::create([
            'mission_id'    => 4,
            'timestamp'     => 1,
            'readout'       => 'Vehicle has a velocity of 630 metres per second and an altitude of 19 kilometres'
        ]);
        Telemetry::create([
            'mission_id'    => 4,
            'timestamp'     => 1,
            'readout'       => 'You can see the plume of the vehicle- the plume of the engine expanding as we get into more rareified atmosphere'
        ]);
        Telemetry::create([
            'mission_id'    => 4,
            'timestamp'     => 1,
            'readout'       => "It also gets blacker as there's less and less oxygen to support post-combustion"
        ]);
        Telemetry::create([
            'mission_id'    => 4,
            'timestamp'     => 1,
            'readout'       => 'Vehicle has a current velocity of 1000 metres per second and an altitude of 32 kilometres'
        ]);
        Telemetry::create([
            'mission_id'    => 4,
            'timestamp'     => 1,
            'readout'       => 'T plus two minutes'
        ]);
        Telemetry::create([
            'mission_id'    => 4,
            'timestamp'     => 1,
            'readout'       => 'Vehicle is down- has an altitude of 50 kilometres, a velocity of 1700 metres per second'
        ]);
        Telemetry::create([
            'mission_id'    => 4,
            'timestamp'     => 1,
            'readout'       => 'First stage performance still nominal'
        ]);
        Telemetry::create([
            'mission_id'    => 4,
            'timestamp'     => 1,
            'readout'       => 'We are approaching Main Engine Cutoff'
        ]);
        Telemetry::create([
            'mission_id'    => 4,
            'timestamp'     => 1,
            'readout'       => "There'll be a five second delay before stage separation"
        ]);
        Telemetry::create([
            'mission_id'    => 4,
            'timestamp'     => 1,
            'readout'       => '[inaudible]'
        ]);
        Telemetry::create([
            'mission_id'    => 4,
            'timestamp'     => 1,
            'readout'       => 'Second stage tank stable'
        ]);
        Telemetry::create([
            'mission_id'    => 4,
            'timestamp'     => 1,
            'readout'       => 'MECO'
        ]);
        Telemetry::create([
            'mission_id'    => 4,
            'timestamp'     => 1,
            'readout'       => 'Stage separation confirmed'
        ]);
        Telemetry::create([
            'mission_id'    => 4,
            'timestamp'     => 1,
            'readout'       => 'And Kestrel ignition'
        ]);
        Telemetry::create([
            'mission_id'    => 4,
            'timestamp'     => 1,
            'readout'       => 'Perfect'
        ]);
        Telemetry::create([
            'mission_id'    => 4,
            'timestamp'     => 1,
            'readout'       => 'Second stage [inaudible]'
        ]);
        Telemetry::create([
            'mission_id'    => 4,
            'timestamp'     => 1,
            'readout'       => '[inaudible] manouver'
        ]);
        Telemetry::create([
            'mission_id'    => 4,
            'timestamp'     => 1,
            'readout'       => 'You can hear the cheers in the background'
        ]);
        Telemetry::create([
            'mission_id'    => 4,
            'timestamp'     => 1,
            'readout'       => 'There goes the stiffening bands'
        ]);
        Telemetry::create([
            'mission_id'    => 4,
            'timestamp'     => 1,
            'readout'       => '[inadible]'
        ]);
        Telemetry::create([
            'mission_id'    => 4,
            'timestamp'     => 1,
            'readout'       => 'You can see the limb of the Earth in the upper left side of the screen'
        ]);
        Telemetry::create([
            'mission_id'    => 4,
            'timestamp'     => 1,
            'readout'       => 'T plus three minutes we have a relative velocity of 2770 metres per second and an altitude of 130 kilometres'
        ]);
        Telemetry::create([
            'mission_id'    => 4,
            'timestamp'     => 1,
            'readout'       => 'The Kestrel engine will burn for more than six minutes in the ride to orbit, here we see the fairing separation'
        ]);
        Telemetry::create([
            'mission_id'    => 4,
            'timestamp'     => 1,
            'readout'       => 'There goes the fairing'
        ]);
        Telemetry::create([
            'mission_id'    => 4,
            'timestamp'     => 1,
            'readout'       => 'Fairing separation confirmed'
        ]);
        Telemetry::create([
            'mission_id'    => 4,
            'timestamp'     => 1,
            'readout'       => 'Second stage propulsion performance is nominal'
        ]);
        Telemetry::create([
            'mission_id'    => 4,
            'timestamp'     => 1,
            'readout'       => "We're at three minutes and thirty seconds into the flight, we have a relative velocity of 2800 metres per second and an altitude of 170 kilometres"
        ]);
        Telemetry::create([
            'mission_id'    => 4,
            'timestamp'     => 1,
            'readout'       => 'Second stage guidance is nominal'
        ]);
        Telemetry::create([
            'mission_id'    => 4,
            'timestamp'     => 1,
            'readout'       => 'T plus four minutes'
        ]);
        Telemetry::create([
            'mission_id'    => 4,
            'timestamp'     => 1,
            'readout'       => "We're at T plus four minutes. We have a relative velocity of approximately 3000 metres per second and an altitude of 200 kilometres"
        ]);
        Telemetry::create([
            'mission_id'    => 4,
            'timestamp'     => 1,
            'readout'       => "You can see the Kestrel nozzle glowing a dull red. It's actually designed to glow almost white-hot if necessary"
        ]);
        Telemetry::create([
            'mission_id'    => 4,
            'timestamp'     => 1,
            'readout'       => "Very steady attitude we're seeing"
        ]);
        Telemetry::create([
            'mission_id'    => 4,
            'timestamp'     => 1,
            'readout'       => "We're at T plus five minutes. We have a relative velocity of approximately 3200 metres per second and an altitude of 253 kilometres. All systems are nominal"
        ]);
        Telemetry::create([
            'mission_id'    => 4,
            'timestamp'     => 1,
            'readout'       => "About four minutes remaining in the second stage burn."
        ]);
        Telemetry::create([
            'mission_id'    => 4,
            'timestamp'     => 1,
            'readout'       => "We're at T plus six minutes. Vehicle velocity is approximately 3600 metres per second and an altitude of 290 kilometres"
        ]);
        Telemetry::create([
            'mission_id'    => 4,
            'timestamp'     => 1,
            'readout'       => "The vast majority of the acceleration occurs during this latter half of the second stage burn, as the mass of the vehicle- the propellant load, decreases"
        ]);
        Telemetry::create([
            'mission_id'    => 4,
            'timestamp'     => 1,
            'readout'       => "We're at T plus seven minutes we have a relative velocity of 4200 metres per second, and an altitude of 315 kilometres. We're beginning to lose stage 1 telemetry"
        ]);
        Telemetry::create([
            'mission_id'    => 4,
            'timestamp'     => 1,
            'readout'       => "Second stage propulsion is performing nominally"
        ]);
        Telemetry::create([
            'mission_id'    => 4,
            'timestamp'     => 1,
            'readout'       => "Guidance is performing nominally"
        ]);
        Telemetry::create([
            'mission_id'    => 4,
            'timestamp'     => 1,
            'readout'       => "We're at T plus eight minutes with a relative velocity of 5200 metres per second and an altitude of 328 kilometres"
        ]);
        Telemetry::create([
            'mission_id'    => 4,
            'timestamp'     => 1,
            'readout'       => "We are getting very close to orbital velocity"
        ]);
        Telemetry::create([
            'mission_id'    => 4,
            'timestamp'     => 1,
            'readout'       => "We appear to have loss of signal. This is not necessarily a bad thing, we were expecting to lose signal sometime around here. It can be highly variable depending on the weather conditions at the time. So, we of course want to see what happens over the next sixty seconds. We were about sixty seconds away from a nominal shutdown. We will be getting back to you as soon as we have more information."
        ]);
        Telemetry::create([
            'mission_id'    => 4,
            'timestamp'     => 1,
            'readout'       => "-telemetry and video."
        ]);
        Telemetry::create([
            'mission_id'    => 4,
            'timestamp'     => 1,
            'readout'       => "9 minutes 30 seconds"
        ]);
        Telemetry::create([
            'mission_id'    => 4,
            'timestamp'     => 1,
            'readout'       => "Second stage approaching SECO"
        ]);
        Telemetry::create([
            'mission_id'    => 4,
            'timestamp'     => 1,
            'readout'       => "And that would be a nominal SECO!"
        ]);
        Telemetry::create([
            'mission_id'    => 4,
            'timestamp'     => 1,
            'readout'       => "SECO confirmed!"
        ]);
        Telemetry::create([
            'mission_id'    => 4,
            'timestamp'     => 1,
            'readout'       => "Which means Falcon 1 has made history as the first privately developed launch vehicle to reach orbit from the ground"
        ]);
        Telemetry::create([
            'mission_id'    => 4,
            'timestamp'     => 1,
            'readout'       => "Payload separation confirmed"
        ]);
        Telemetry::create([
            'mission_id'    => 4,
            'timestamp'     => 1,
            'readout'       => 'That was...'
        ]);
        Telemetry::create([
            'mission_id'    => 4,
            'timestamp'     => 1,
            'readout'       => 'Repeating: simulated payload deploy confirmed'
        ]);
        Telemetry::create([
            'mission_id'    => 4,
            'timestamp'     => 1,
            'readout'       => 'T plus ten minutes'
        ]);
        Telemetry::create([
            'mission_id'    => 4,
            'timestamp'     => 1,
            'readout'       => "You're seeing a forward shot, that is where we would nomrally see a payload separation, in this case we are not separating..."
        ]);
        Telemetry::create([
            'mission_id'    => 4,
            'timestamp'     => 1,
            'readout'       => 'FTS [inaudible]'
        ]);
        Telemetry::create([
            'mission_id'    => 4,
            'timestamp'     => 1,
            'readout'       => "Hey congratulations, this is fantastic"
        ]);
        Telemetry::create([
            'mission_id'    => 4,
            'timestamp'     => 1,
            'readout'       => "Thank you"
        ]);
        Telemetry::create([
            'mission_id'    => 4,
            'timestamp'     => 1,
            'readout'       => "We're still showing active on second stage telemetry"
        ]);
        Telemetry::create([
            'mission_id'    => 4,
            'timestamp'     => 1,
            'readout'       => "We are heading over the horizon with respect to the launch range, so we are expecting loss of signal any second now, you can see it starting to break up"
        ]);
        Telemetry::create([
            'mission_id'    => 4,
            'timestamp'     => 1,
            'readout'       => "But this is a very good day at SpaceX"
        ]);
        Telemetry::create([
            'mission_id'    => 4,
            'timestamp'     => 1,
            'readout'       => "Max I think it's important when we lose our signal here to put this in perspective, what SpaceX has been able to achieve today"
        ]);
        Telemetry::create([
            'mission_id'    => 4,
            'timestamp'     => 1,
            'readout'       => "LC we have a [inaudible] on safety radar, nominal [inaudible]"
        ]);
        Telemetry::create([
            'mission_id'    => 4,
            'timestamp'     => 1,
            'readout'       => '[inaudible]'
        ]);
        Telemetry::create([
            'mission_id'    => 4,
            'timestamp'     => 1,
            'readout'       => "SpaceX has designed and developed this vehicle from the ground up from a blank sheet of paper they've done all the design and all the testing in house. We don't outsource, and we have achieved this with a company that is only now 500 people, and it has all occurred in under 6 years. And this is just the groundbreaker; this is just the vanguard; of the much larger Falcon 9 launch vehicle debuting from Cape Canaveral next year, and the Dragon spacecraft that will be debuting in June o next year and will be providing cargo services to the International Space Station. So we have big plans, even beyond that, here at SpaceX. Including human space transportation in the Dragon launch vehicle and on the Falcon 9- uhh, Falcon 9 launch vehicle and the Dragon spacecraft, and this is really just the beginning, this is just the tip of the iceberg here. There's a lot of people who have worked very hard for a very long time., tremendous commitment from them and their families to get to this point. It's really an incredible achievement."
        ]);
        /* STILL MORE TELEMETRY
        Telemetry::create([
            'mission_id'    => 4,
            'timestamp'     => 1,
            'readout'       => 'Fairing separation confirmed'
        ]);
        Telemetry::create([
            'mission_id'    => 4,
            'timestamp'     => 1,
            'readout'       => 'Fairing separation confirmed'
        ]);
        Telemetry::create([
            'mission_id'    => 4,
            'timestamp'     => 1,
            'readout'       => 'Fairing separation confirmed'
        ]);*/

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
            'readout'       => "Passing throught T+4 minutes, the vehicle's travelling 3000m/s at an altitude of 172km"
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
            'timestamp'     => 0,
            'readout'       => 'Liftoff!'
        ]);
        Telemetry::create([
            'mission_id'    => 6,
            'timestamp'     => 0,
            'readout'       => 'We have [inaudible]'
        ]);
        Telemetry::create([
            'mission_id'    => 6,
            'timestamp'     => 0,
            'readout'       => 'Liftoff of the Falcon 9'
        ]);
        Telemetry::create([
            'mission_id'    => 6,
            'timestamp'     => 0,
            'readout'       => 'Falcon 9 has cleared the towers'
        ]);
        Telemetry::create([
            'mission_id'    => 6,
            'timestamp'     => 0,
            'readout'       => 'Pitch kick'
        ]);
        Telemetry::create([
            'mission_id'    => 6,
            'timestamp'     => 0,
            'readout'       => "[inaudible] on the countdown net, have [inaudible] on net A please."
        ]);
        Telemetry::create([
            'mission_id'    => 6,
            'timestamp'     => 0,
            'readout'       => "Gravity turn"
        ]);
        Telemetry::create([
            'mission_id'    => 6,
            'timestamp'     => 0,
            'readout'       => "First stage propulsion is performing nominally"
        ]);
        Telemetry::create([
            'mission_id'    => 6,
            'timestamp'     => 0,
            'readout'       => "We have telemetry lock on both stages and power systems are go"
        ]);
        Telemetry::create([
            'mission_id'    => 6,
            'timestamp'     => 0,
            'readout'       => "Guidance is nominal"
        ]);
        Telemetry::create([
            'mission_id'    => 6,
            'timestamp'     => 0,
            'readout'       => "Vehicle is moving at 430m/s [inaudible], altitude 3km"
        ]);
        Telemetry::create([
            'mission_id'    => 6,
            'timestamp'     => 0,
            'readout'       => "As Falcon 9 ascends into the atmosphere, we are getting a little bit of audio trouble from the launch site. The vehicle is quickly approaching its Max-Q, where its increasing speed and the atmospheric density create the maximum resistance to the vehicle's flight, after Max-Q the forces acting on the vehicle will decrease dramatically, and the vehicle will begin to gain speed substantially"
        ]);
        Telemetry::create([
            'mission_id'    => 6,
            'timestamp'     => 0,
            'readout'       => "As the atmosphere thins, the exhaust plume will begin to expand greatly and begin to take on a darker color, [inaudible] plume"
        ]);
        Telemetry::create([
            'mission_id'    => 6,
            'timestamp'     => 0,
            'readout'       => "Guidance nominal"
        ]);
        Telemetry::create([
            'mission_id'    => 6,
            'timestamp'     => 0,
            'readout'       => "Approaching MECO 2"
        ]);
        Telemetry::create([
            'mission_id'    => 6,
            'timestamp'     => 0,
            'readout'       => "And we have stage separation!"
        ]);
        Telemetry::create([
            'mission_id'    => 6,
            'timestamp'     => 0,
            'readout'       => "And stage separation is confirmed. Mvac chamb-"
        ]);
        Telemetry::create([
            'mission_id'    => 6,
            'timestamp'     => 0,
            'readout'       => "And we have a clean stage separation and second stage ignition. The Merlin Vacuum engine has begun lifting the second stage and Dragon into orbit. As you saw, on the MVac nozzle expansion skirt, that fell away as designed."
        ]);
        Telemetry::create([
            'mission_id'    => 6,
            'timestamp'     => 0,
            'readout'       => "MVac performance nominal, and we have [inaudible]"
        ]);
        Telemetry::create([
            'mission_id'    => 6,
            'timestamp'     => 0,
            'readout'       => "Vehicle has an inertial velocity of 3500m/s, altitude of 140km. Let's turn off-"
        ]);
        Telemetry::create([
            'mission_id'    => 6,
            'timestamp'     => 0,
            'readout'       => "MVac is performing nominally"
        ]);
        Telemetry::create([
            'mission_id'    => 6,
            'timestamp'     => 0,
            'readout'       => "[inaudible] back on."
        ]);
        Telemetry::create([
            'mission_id'    => 6,
            'timestamp'     => 0,
            'readout'       => "Guidance is nominal"
        ]);
        Telemetry::create([
            'mission_id'    => 6,
            'timestamp'     => 0,
            'readout'       => "And we have nominal avionics operation at this point"
        ]);
        Telemetry::create([
            'mission_id'    => 6,
            'timestamp'     => 0,
            'readout'       => "Stage 2 [inaudible]"
        ]);
        Telemetry::create([
            'mission_id'    => 6,
            'timestamp'     => 0,
            'readout'       => "As the second stage continues its flight, you will see one of the roll-control actuators wiggle back and forth. That's simply the vehicle correcting its trajectory as it continues to orbit"
        ]);
        Telemetry::create([
            'mission_id'    => 6,
            'timestamp'     => 0,
            'readout'       => "Second stage continues to perform nominally"
        ]);
        Telemetry::create([
            'mission_id'    => 6,
            'timestamp'     => 0,
            'readout'       => "Second stage avionics looking nominal, and we have telemetry lock."
        ]);
        Telemetry::create([
            'mission_id'    => 6,
            'timestamp'     => 0,
            'readout'       => "Guidance is nominal"
        ]);
        Telemetry::create([
            'mission_id'    => 6,
            'timestamp'     => 0,
            'readout'       => "We are flying at 4000m/s at an altitude of 189km"
        ]);
        Telemetry::create([
            'mission_id'    => 6,
            'timestamp'     => 0,
            'readout'       => "And this is prop, still performing nominally"
        ]);
        Telemetry::create([
            'mission_id'    => 6,
            'timestamp'     => 0,
            'readout'       => "New Hampshire station has acquired."
        ]);
        Telemetry::create([
            'mission_id'    => 6,
            'timestamp'     => 0,
            'readout'       => "As expected the radiatively cooled expansion nozzle on the engine is glowing red hot, and in some places even white hot, and are designed to operate just like our Falcon 1 vehicle"
        ]);
        Telemetry::create([
            'mission_id'    => 6,
            'timestamp'     => 0,
            'readout'       => "And second stage avionics [inaudible] power systems are nominal"
        ]);
        Telemetry::create([
            'mission_id'    => 6,
            'timestamp'     => 0,
            'readout'       => "Second stage is preparing to trim propellants"
        ]);
        Telemetry::create([
            'mission_id'    => 6,
            'timestamp'     => 0,
            'readout'       => "[inaudible] is good"
        ]);
        Telemetry::create([
            'mission_id'    => 6,
            'timestamp'     => 0,
            'readout'       => "MVac actively trimming performing nominally"
        ]);
        Telemetry::create([
            'mission_id'    => 6,
            'timestamp'     => 0,
            'readout'       => "And we have / power systems are nominal."
        ]);
        Telemetry::create([
            'mission_id'    => 6,
            'timestamp'     => 0,
            'readout'       => "Guidance is still nominal"
        ]);
        Telemetry::create([
            'mission_id'    => 6,
            'timestamp'     => 0,
            'readout'       => "Vehicle's currently travelling at almost 5000m/s and an alt of [inaudible]39km"
        ]);
        Telemetry::create([
            'mission_id'    => 6,
            'timestamp'     => 0,
            'readout'       => "New Hampshire telemetry as cleaned up"
        ]);
        Telemetry::create([
            'mission_id'    => 6,
            'timestamp'     => 0,
            'readout'       => "MVac and second stage are performing nominally"
        ]);
        Telemetry::create([
            'mission_id'    => 6,
            'timestamp'     => 0,
            'readout'       => "LC we got grassfires all the way by the hanger"
        ]);
        Telemetry::create([
            'mission_id'    => 6,
            'timestamp'     => 0,
            'readout'       => "[inaudible] camera"
        ]);
        Telemetry::create([
            'mission_id'    => 6,
            'timestamp'     => 0,
            'readout'       => "Propulsion is performing nominally"
        ]);
        Telemetry::create([
            'mission_id'    => 6,
            'timestamp'     => 0,
            'readout'       => "And avionics systems are nominal"
        ]);
        Telemetry::create([
            'mission_id'    => 6,
            'timestamp'     => 0,
            'readout'       => "MVac performing nominally"
        ]);
        Telemetry::create([
            'mission_id'    => 6,
            'timestamp'     => 0,
            'readout'       => "We have nominal avionics operation and telemetry lock"
        ]);
        Telemetry::create([
            'mission_id'    => 6,
            'timestamp'     => 0,
            'readout'       => "Guidance is nominal"
        ]);
        Telemetry::create([
            'mission_id'    => 6,
            'timestamp'     => 0,
            'readout'       => "As the vehicle is approaching the horizon as viewed from the launch site, we may lose video signal-"
        ]);
        Telemetry::create([
            'mission_id'    => 6,
            'timestamp'     => 0,
            'readout'       => "1 minute of nominal SECO 1 time. MVac and the second stage continue to perform nominally"
        ]);
        Telemetry::create([
            'mission_id'    => 6,
            'timestamp'     => 0,
            'readout'       => "Vehicle's at an interial altitude of 7000m/s, 400km altitude"
        ]);
        Telemetry::create([
            'mission_id'    => 6,
            'timestamp'     => 0,
            'readout'       => "Second stage is approaching SECO 1"
        ]);
        Telemetry::create([
            'mission_id'    => 6,
            'timestamp'     => 0,
            'readout'       => "MVac still performing nominally"
        ]);
        Telemetry::create([
            'mission_id'    => 6,
            'timestamp'     => 0,
            'readout'       => "And engine shutdown"
        ]);
        Telemetry::create([
            'mission_id'    => 6,
            'timestamp'     => 0,
            'readout'       => "Falcon 9 stage two and the Dragon capsule are now in orbit around the Earth"
        ]);
        Telemetry::create([
            'mission_id'    => 6,
            'timestamp'     => 0,
            'readout'       => "And with the shutdown of the second stage engine, SpaceX's Falcon 9 has achieved Earth orbit"
        ]);
        Telemetry::create([
            'mission_id'    => 6,
            'timestamp'     => 0,
            'readout'       => "Stage 2 attitude control systems are now active, during coast, second stage will perform [inaudible]"
        ]);
        Telemetry::create([
            'mission_id'    => 6,
            'timestamp'     => 0,
            'readout'       => "As expected it looks like we have lost the signal- the video signal, from the Falcon 9 second stage as it passed over the horizon, but from here, everything looks every clean. In the time ahead our team will be reviewing- all in all this has been a good day for SpaceX-"
        ]);
    }

    public function COTS1() {
        Telemetry::create([
            'mission_id'    => 7,
            'timestamp'     => 0,
            'readout'       => "We have liftoff of the Falcon 9"
        ]);
        Telemetry::create([
            'mission_id'    => 7,
            'timestamp'     => 0,
            'readout'       => "Stage 1"
        ]);
        Telemetry::create([
            'mission_id'    => 7,
            'timestamp'     => 0,
            'readout'       => "Pitchkick"
        ]);
        Telemetry::create([
            'mission_id'    => 7,
            'timestamp'     => 0,
            'readout'       => "Falcon 9 has cleared the tower"
        ]);
        Telemetry::create([
            'mission_id'    => 7,
            'timestamp'     => 0,
            'readout'       => "First stage engines and tanks, looking good"
        ]);
        Telemetry::create([
            'mission_id'    => 7,
            'timestamp'     => 0,
            'readout'       => "Beginning gravity turn"
        ]);
        Telemetry::create([
            'mission_id'    => 7,
            'timestamp'     => 0,
            'readout'       => "Telemetry lock on both stages, power systems nominal"
        ]);
        Telemetry::create([
            'mission_id'    => 7,
            'timestamp'     => 0,
            'readout'       => "First stage propulsion is nominal"
        ]);
        Telemetry::create([
            'mission_id'    => 7,
            'timestamp'     => 0,
            'readout'       => "OK"
        ]);
        Telemetry::create([
            'mission_id'    => 7,
            'timestamp'     => 0,
            'readout'       => "Guidance nominal"
        ]);
        Telemetry::create([
            'mission_id'    => 7,
            'timestamp'     => 0,
            'readout'       => "The vehicle's now supersonic"
        ]);
        Telemetry::create([
            'mission_id'    => 7,
            'timestamp'     => 0,
            'readout'       => "Telemetry lock still on both stages, power systems continue to be nominal"
        ]);
        Telemetry::create([
            'mission_id'    => 7,
            'timestamp'     => 0,
            'readout'       => "Guidance is nominal at Max-Q"
        ]);
        Telemetry::create([
            'mission_id'    => 7,
            'timestamp'     => 0,
            'readout'       => "And propulsion is also nominal on the first stage"
        ]);
        Telemetry::create([
            'mission_id'    => 7,
            'timestamp'     => 0,
            'readout'       => "First stage propulsion performing nominally"
        ]);
        Telemetry::create([
            'mission_id'    => 7,
            'timestamp'     => 0,
            'readout'       => "Guidance is nominal"
        ]);
        Telemetry::create([
            'mission_id'    => 7,
            'timestamp'     => 0,
            'readout'       => "We have telemetry lock, and power systems are still nominal"
        ]);
        Telemetry::create([
            'mission_id'    => 7,
            'timestamp'     => 0,
            'readout'       => "First stage tank pressures and engines still nominal"
        ]);
        Telemetry::create([
            'mission_id'    => 7,
            'timestamp'     => 0,
            'readout'       => "Stage two MVac engine chilling in. First two M9 engines shut down"
        ]);

        Telemetry::create([
            'mission_id'    => 7,
            'timestamp'     => 0,
            'readout'       => "First stage MECO 2"
        ]);

        Telemetry::create([
            'mission_id'    => 7,
            'timestamp'     => 0,
            'readout'       => "First stage engine shutdown"
        ]);
        Telemetry::create([
            'mission_id'    => 7,
            'timestamp'     => 0,
            'readout'       => "Second stage has separated"
        ]);
        Telemetry::create([
            'mission_id'    => 7,
            'timestamp'     => 0,
            'readout'       => "Inertial velocity at MECO was approximately 3.2km/s, nominal"
        ]);
        Telemetry::create([
            'mission_id'    => 7,
            'timestamp'     => 0,
            'readout'       => "MVac ignition confirmed"
        ]);
        Telemetry::create([
            'mission_id'    => 7,
            'timestamp'     => 0,
            'readout'       => "Power systems look nominal, we have GPS lock"
        ]);
        Telemetry::create([
            'mission_id'    => 7,
            'timestamp'     => 0,
            'readout'       => "MVac stage and engine performance looking good"
        ]);
        Telemetry::create([
            'mission_id'    => 7,
            'timestamp'     => 0,
            'readout'       => "Dragon nosecone has been jettisoned"
        ]);
        Telemetry::create([
            'mission_id'    => 7,
            'timestamp'     => 0,
            'readout'       => "Second stage propulsion performance is nominal"
        ]);
        Telemetry::create([
            'mission_id'    => 7,
            'timestamp'     => 0,
            'readout'       => "Power system looks nominal, GPS and telemetry lock confirmed"
        ]);
        Telemetry::create([
            'mission_id'    => 7,
            'timestamp'     => 0,
            'readout'       => "Guidance is nominal"
        ]);
        Telemetry::create([
            'mission_id'    => 7,
            'timestamp'     => 0,
            'readout'       => "MVac stiffening ring has been jettisoned"
        ]);
        Telemetry::create([
            'mission_id'    => 7,
            'timestamp'     => 0,
            'readout'       => "MVac engine power looks good, stage is healthy, propulsion nominal"
        ]);
        Telemetry::create([
            'mission_id'    => 7,
            'timestamp'     => 0,
            'readout'       => "Stage two guidance is looking nominal"
        ]);
        Telemetry::create([
            'mission_id'    => 7,
            'timestamp'     => 0,
            'readout'       => "Vehicle is currently at 210km, and 3.7km/s"
        ]);
        Telemetry::create([
            'mission_id'    => 7,
            'timestamp'     => 0,
            'readout'       => "AOS New Hampshire"
        ]);
        Telemetry::create([
            'mission_id'    => 7,
            'timestamp'     => 0,
            'readout'       => "Second stage power systems functioning nominally"
        ]);
        Telemetry::create([
            'mission_id'    => 7,
            'timestamp'     => 0,
            'readout'       => "Guidance nominal"
        ]);
        Telemetry::create([
            'mission_id'    => 7,
            'timestamp'     => 0,
            'readout'       => "The vehicle is now approximately 450km downrange"
        ]);
        Telemetry::create([
            'mission_id'    => 7,
            'timestamp'     => 0,
            'readout'       => "All second stage propulsion parameters are nominal"
        ]);
        Telemetry::create([
            'mission_id'    => 7,
            'timestamp'     => 0,
            'readout'       => "We currently lock on both stages, power systems look healthy on both stages"
        ]);
        Telemetry::create([
            'mission_id'    => 7,
            'timestamp'     => 0,
            'readout'       => "Guidance is still nominal"
        ]);
        Telemetry::create([
            'mission_id'    => 7,
            'timestamp'     => 0,
            'readout'       => "Propulsion is also nominal on the second stage"
        ]);
        Telemetry::create([
            'mission_id'    => 7,
            'timestamp'     => 0,
            'readout'       => "The vehicle is currently at an altitude of 264km, inertial velocity 4300m/s"
        ]);
        Telemetry::create([
            'mission_id'    => 7,
            'timestamp'     => 0,
            'readout'       => "There are approximately 3 minutes left in stage two burn"
        ]);
        Telemetry::create([
            'mission_id'    => 7,
            'timestamp'     => 0,
            'readout'       => "All second stage propulsion performance parameters are nominal, both stage and engine look good"
        ]);
        Telemetry::create([
            'mission_id'    => 7,
            'timestamp'     => 0,
            'readout'       => "We have nominal RF system status, we have perfect power systems, and uh- telemetry lock is confirmed"
        ]);
        Telemetry::create([
            'mission_id'    => 7,
            'timestamp'     => 0,
            'readout'       => "Second stage propulsion is nominal"
        ]);
        Telemetry::create([
            'mission_id'    => 7,
            'timestamp'     => 0,
            'readout'       => "Guidance is nominal, approximately 2 minutes remaining left in second stage burn"
        ]);
        Telemetry::create([
            'mission_id'    => 7,
            'timestamp'     => 0,
            'readout'       => "AVI reporting: RF telemetry nominal"
        ]);
        Telemetry::create([
            'mission_id'    => 7,
            'timestamp'     => 0,
            'readout'       => "The vehicle's at approximately 300km altitude, 5500m/s"
        ]);
        Telemetry::create([
            'mission_id'    => 7,
            'timestamp'     => 0,
            'readout'       => "All second stage propulsion performance parameters are within bounds"
        ]);
        Telemetry::create([
            'mission_id'    => 7,
            'timestamp'     => 0,
            'readout'       => "We have nominal lock on both telemetry streams, and we have charged recovery systems"
        ]);
        Telemetry::create([
            'mission_id'    => 7,
            'timestamp'     => 0,
            'readout'       => "Guidance is nominal, approximately 50 seconds remaining in this burn"
        ]);
        Telemetry::create([
            'mission_id'    => 7,
            'timestamp'     => 0,
            'readout'       => "Propulsion is also nominal, all systems are go"
        ]);
        Telemetry::create([
            'mission_id'    => 7,
            'timestamp'     => 0,
            'readout'       => "Vehicle is in terminal guidance."
        ]);
        Telemetry::create([
            'mission_id'    => 7,
            'timestamp'     => 0,
            'readout'       => "Second stage propulsion is performing nominally"
        ]);
        Telemetry::create([
            'mission_id'    => 7,
            'timestamp'     => 0,
            'readout'       => "MVac shutdown"
        ]);
        Telemetry::create([
            'mission_id'    => 7,
            'timestamp'     => 0,
            'readout'       => "Dragon is in orbit"
        ]);
        Telemetry::create([
            'mission_id'    => 7,
            'timestamp'     => 0,
            'readout'       => "Dragon deploy verified!"
        ]);
        Telemetry::create([
            'mission_id'    => 7,
            'timestamp'     => 0,
            'readout'       => "[inaudible] approximately 288km perigee, 301km apogee. Inclination 34.53 degrees."
        ]);
        Telemetry::create([
            'mission_id'    => 7,
            'timestamp'     => 0,
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
            'timestamp'     => 703,
            'readout'       => "Solar array deployment!"
        ]);
        /*Telemetry::create([
            'mission_id'    => 8,
            'timestamp'     => 183,
            'readout'       => "Solar arrays have deployed"
        ]);
        Telemetry::create([
            'mission_id'    => 8,
            'timestamp'     => 183,
            'readout'       => "Well, you can see the solar arrays deploying, this is a great moment. Of course, this is just the first step of a very complex mission. Uhh... but from all accounts we have Dragon orbiting the Earth with the solar arrays deployed!"
        ]);
        Telemetry::create([
            'mission_id'    => 8,
            'timestamp'     => 183,
            'readout'       => "Power global"
        ]);
        Telemetry::create([
            'mission_id'    => 8,
            'timestamp'     => 183,
            'readout'       => "This is so good!"
        ]);
        Telemetry::create([
            'mission_id'    => 8,
            'timestamp'     => 183,
            'readout'       => "We have a couple days of really difficult challenges before we get to the space station, but, but both solar arrays are deployed. Dragon is performing nominally and we are looking forward to a great mission here to the International Space Station. Hopefully become the first private company to service our international community at the space station"
        ]);
        Telemetry::create([
            'mission_id'    => 8,
            'timestamp'     => 183,
            'readout'       => "Power global"
        ]);
        Telemetry::create([
            'mission_id'    => 8,
            'timestamp'     => 183,
            'readout'       => "Go ahead and acknowledge MD"
        ]);
        Telemetry::create([
            'mission_id'    => 8,
            'timestamp'     => 183,
            'readout'       => "Okay, power global ackn-"
        ]);
        Telemetry::create([
            'mission_id'    => 8,
            'timestamp'     => 183,
            'readout'       => "LD, MDI on countdown"
        ]);
        Telemetry::create([
            'mission_id'    => 8,
            'timestamp'     => 183,
            'readout'       => "LD's on a phone call right now MD"
        ]);
        Telemetry::create([
            'mission_id'    => 8,
            'timestamp'     => 183,
            'readout'       => "Yeah, I copy that LC. Uhh, we're gonna' be switching off countdown net, thanks for the ride."
        ]);
        Telemetry::create([
            'mission_id'    => 8,
            'timestamp'     => 183,
            'readout'       => "K, all stations. This is MD on Mission A. We're on 1 dot 1 0."
        ]);
        Telemetry::create([
            'mission_id'    => 8,
            'timestamp'     => 183,
            'readout'       => "Dragon is in coelliptic plan, no comm"
        ]);
        Telemetry::create([
            'mission_id'    => 8,
            'timestamp'     => 183,
            'readout'       => "Well as expected. Dragon is just about at the limit of the New Foundland groundstation, we're probably going to lose video shortly, but right now, Dragon is stil communicating with mission control here in Hawthorne, California, and everything looks great, it continues to circle the globe. We can hear the audience here. Everyone at SpaceX, we have 1800 plus people, we're all working really hard, and we're on our way to a great mission. We still have 3 and a half days, a lot of test manovuers before we get to the station, so stay in touch with us at spacex.com and Twitter, and continue to cheer us on."
        ]);
        Telemetry::create([
            'mission_id'    => 8,
            'timestamp'     => 183,
            'readout'       => "So, uhh, let's see if I can talk now. We had a great launch today. This is the third successful flight of Falcon 9; the second time we've put Dragon safely into orbit, this is so awesome. We definitely hope to continue to the success over the next two weeks, where we are making progress to the space station; and I feel pretty good that we are going to be the first private company to ever visit the International Space Station, this is so exciting. Please be sure to stay tuned to spacex.com, and Facebook, and Twitter, and all those things, because there's all kinds of great tweets right now. Yeah, please just stay up to date with what's going on."
        ]);
        Telemetry::create([
            'mission_id'    => 8,
            'timestamp'     => 183,
            'readout'       => "And we want to extend a special thanks to NASA for their teamwork and support, and todays mission, and getting here, to all of our customers and supporters over the years, to the worldwide network of trackign stations that are going to be helping us with Dragon going to the space station and back over the coming couple of weeks, and finally to the Air Force and the folks at Cape Canveral for the great support in getting todays launch off the pad!"
        ]);
        Telemetry::create([
            'mission_id'    => 8,
            'timestamp'     => 183,
            'readout'       => "So, on behalf of the 1800 people here at SpaceX, we thank you so much for watching this amazing mission today. It's a great day, it's almost surreal, so cool. Yeah, and just please continue to watch as Dragon makes its progress to the space station. Thank you."
        ]);*/
    }

    public function CRS1() {
        Telemetry::create([
            'mission_id'    => 9,
            'timestamp'     => 0,
            'readout'       => "Liftoff of the Falcon 9"
        ]);
        Telemetry::create([
            'mission_id'    => 9,
            'timestamp'     => 0,
            'readout'       => "Falcon 9 has cleared the tower"
        ]);
        Telemetry::create([
            'mission_id'    => 9,
            'timestamp'     => 0,
            'readout'       => "Starting pitchkick"
        ]);
        Telemetry::create([
            'mission_id'    => 9,
            'timestamp'     => 0,
            'readout'       => "All systems at full power"
        ]);
        Telemetry::create([
            'mission_id'    => 9,
            'timestamp'     => 0,
            'readout'       => "Starting gravity turn"
        ]);
        Telemetry::create([
            'mission_id'    => 9,
            'timestamp'     => 0,
            'readout'       => "JDMTA acquisition of signal"
        ]);
        Telemetry::create([
            'mission_id'    => 9,
            'timestamp'     => 0,
            'readout'       => "We have a solid telemetry lock on stage one and stage two"
        ]);
        Telemetry::create([
            'mission_id'    => 9,
            'timestamp'     => 0,
            'readout'       => "First stage propellant utilization is active"
        ]);
        Telemetry::create([
            'mission_id'    => 9,
            'timestamp'     => 0,
            'readout'       => "Vehicle is on a nominal trajectory at 5km in altitude, velocity of 230m/s, and downrange distance of 700m."
        ]);
        Telemetry::create([
            'mission_id'    => 9,
            'timestamp'     => 0,
            'readout'       => "Vehicle is supersonic"
        ]);
        Telemetry::create([
            'mission_id'    => 9,
            'timestamp'     => 0,
            'readout'       => "Vehicle has reached maximum aerodynamic pressure"
        ]);
        Telemetry::create([
            'mission_id'    => 9,
            'timestamp'     => 0,
            'readout'       => "Second stage has started engine chill"
        ]);
        Telemetry::create([
            'mission_id'    => 9,
            'timestamp'     => 0,
            'readout'       => "Dragon power systems are nominal"
        ]);
        Telemetry::create([
            'mission_id'    => 9,
            'timestamp'     => 0,
            'readout'       => "Approaching MECO 1"
        ]);
        Telemetry::create([
            'mission_id'    => 9,
            'timestamp'     => 0,
            'readout'       => "Passed the min-MECO point"
        ]);
        Telemetry::create([
            'mission_id'    => 9,
            'timestamp'     => 0,
            'readout'       => "First stage shutdown"
        ]);
        Telemetry::create([
            'mission_id'    => 9,
            'timestamp'     => 0,
            'readout'       => "Stage separation confirmed"
        ]);
        Telemetry::create([
            'mission_id'    => 9,
            'timestamp'     => 0,
            'readout'       => "MVac ignition confirmed"
        ]);
        Telemetry::create([
            'mission_id'    => 9,
            'timestamp'     => 0,
            'readout'       => "The Dragon nosecone has been jettisoned"
        ]);
        Telemetry::create([
            'mission_id'    => 9,
            'timestamp'     => 0,
            'readout'       => "Vehicle remains on a nominal trajectory"
        ]);
        Telemetry::create([
            'mission_id'    => 9,
            'timestamp'     => 0,
            'readout'       => "Vehicle altitude is 150km, velocity is 3.1km/s, and downrange distance of 350km"
        ]);
        Telemetry::create([
            'mission_id'    => 9,
            'timestamp'     => 0,
            'readout'       => "Second stage propellant utilization active"
        ]);
        Telemetry::create([
            'mission_id'    => 9,
            'timestamp'     => 0,
            'readout'       => "Avionics systems nominal"
        ]);
        Telemetry::create([
            'mission_id'    => 9,
            'timestamp'     => 0,
            'readout'       => "New Hampshire acquisition of singal"
        ]);
        Telemetry::create([
            'mission_id'    => 9,
            'timestamp'     => 0,
            'readout'       => "Vehicle remains on a nominal trajectory. Altitude is 163km, velocity is 3.5km/s, downrange distance of 770km"
        ]);
        Telemetry::create([
            'mission_id'    => 9,
            'timestamp'     => 0,
            'readout'       => "MVac and stage two propulsion systems healthy"
        ]);
        Telemetry::create([
            'mission_id'    => 9,
            'timestamp'     => 0,
            'readout'       => "Avionics system and RF link are solid"
        ]);
        Telemetry::create([
            'mission_id'    => 9,
            'timestamp'     => 0,
            'readout'       => "LC this is OSM"
        ]);
        Telemetry::create([
            'mission_id'    => 9,
            'timestamp'     => 0,
            'readout'       => "Go Ahead"
        ]);
        Telemetry::create([
            'mission_id'    => 9,
            'timestamp'     => 0,
            'readout'       => "Uhh, yes sir. I've looked around the pad, it looks like- the only place we have any- even a small fire, is on the T/E- on the deck. Uhh, [inaudible] fire department gets here they can go ahead and do there sweep, over"
        ]);
        Telemetry::create([
            'mission_id'    => 9,
            'timestamp'     => 0,
            'readout'       => "Copy that, pad secured, they can go on"
        ]);
        Telemetry::create([
            'mission_id'    => 9,
            'timestamp'     => 0,
            'readout'       => "The vehicle remains on a nominal trajectory, Altitude is 186km, velocity is 4km/s"
        ]);
        Telemetry::create([
            'mission_id'    => 9,
            'timestamp'     => 0,
            'readout'       => "MVac and stage performance is good"
        ]);
        Telemetry::create([
            'mission_id'    => 9,
            'timestamp'     => 0,
            'readout'       => "The vehicle remains on a nominal trajectory. Altitude of 200km, and velocity of 4.9km/s"
        ]);
        Telemetry::create([
            'mission_id'    => 9,
            'timestamp'     => 0,
            'readout'       => "LC this is OSM, I recommend we go ahead and [fade out]"
        ]);
        Telemetry::create([
            'mission_id'    => 9,
            'timestamp'     => 0,
            'readout'       => "Vehicle is passing through the head-on gate"
        ]);
        Telemetry::create([
            'mission_id'    => 9,
            'timestamp'     => 0,
            'readout'       => "Propulsion systems nominal"
        ]);
        Telemetry::create([
            'mission_id'    => 9,
            'timestamp'     => 0,
            'readout'       => "FTS has been safed"
        ]);
        Telemetry::create([
            'mission_id'    => 9,
            'timestamp'     => 0,
            'readout'       => "Vehicle is in terminal guidance mode"
        ]);
        Telemetry::create([
            'mission_id'    => 9,
            'timestamp'     => 0,
            'readout'       => "Avionic systems are nominal"
        ]);
        Telemetry::create([
            'mission_id'    => 9,
            'timestamp'     => 0,
            'readout'       => "Nominal LOS from the Cape"
        ]);
        Telemetry::create([
            'mission_id'    => 9,
            'timestamp'     => 0,
            'readout'       => "IIP left"
        ]);
        Telemetry::create([
            'mission_id'    => 9,
            'timestamp'     => 0,
            'readout'       => "MVac shutdown confirmed"
        ]);
        Telemetry::create([
            'mission_id'    => 9,
            'timestamp'     => 0,
            'readout'       => "Dragon's in separation"
        ]);
        Telemetry::create([
            'mission_id'    => 9,
            'timestamp'     => 0,
            'readout'       => "Prop-rate is in prime"
        ]);
        Telemetry::create([
            'mission_id'    => 9,
            'timestamp'     => 0,
            'readout'       => "Falcon 9 and Dragon are in orbit, perigee 197km, apogee 328km."
        ]);
        Telemetry::create([
            'mission_id'    => 9,
            'timestamp'     => 0,
            'readout'       => "All stations, MD, we're on step one dot two and step one dot four with nav-one and sys-two"
        ]);
        Telemetry::create([
            'mission_id'    => 9,
            'timestamp'     => 0,
            'readout'       => "Manifolds venting"
        ]);
        Telemetry::create([
            'mission_id'    => 9,
            'timestamp'     => 0,
            'readout'       => "[inaudible] open"
        ]);
        Telemetry::create([
            'mission_id'    => 9,
            'timestamp'     => 0,
            'readout'       => "[inaudible] open"
        ]);
        Telemetry::create([
            'mission_id'    => 9,
            'timestamp'     => 0,
            'readout'       => "Got a console arm on software"
        ]);
        Telemetry::create([
            'mission_id'    => 9,
            'timestamp'     => 0,
            'readout'       => "Dragon's in post-prime"
        ]);
        Telemetry::create([
            'mission_id'    => 9,
            'timestamp'     => 0,
            'readout'       => "Priming complete"
        ]);
        Telemetry::create([
            'mission_id'    => 9,
            'timestamp'     => 0,
            'readout'       => "Nominal AOS New Foundland"
        ]);
        Telemetry::create([
            'mission_id'    => 9,
            'timestamp'     => 0,
            'readout'       => "[inaudible] to deploy attitude"
        ]);
        Telemetry::create([
            'mission_id'    => 9,
            'timestamp'     => 0,
            'readout'       => "Flight software, you got on this software global?"
        ]);
        Telemetry::create([
            'mission_id'    => 9,
            'timestamp'     => 0,
            'readout'       => "Yeah, we're looking into it. I'm acknowledging."
        ]);
        Telemetry::create([
            'mission_id'    => 9,
            'timestamp'     => 0,
            'readout'       => "Thruster firings confirmed, props[inaudible] nominal"
        ]);
        Telemetry::create([
            'mission_id'    => 9,
            'timestamp'     => 0,
            'readout'       => "Dragon's in array deploy attitude"
        ]);
        Telemetry::create([
            'mission_id'    => 9,
            'timestamp'     => 0,
            'readout'       => "Slew looked good"
        ]);
        Telemetry::create([
            'mission_id'    => 9,
            'timestamp'     => 0,
            'readout'       => "Nominal LOS Wallops"
        ]);
        Telemetry::create([
            'mission_id'    => 9,
            'timestamp'     => 0,
            'readout'       => "Dragon's in array deploy state"
        ]);
        Telemetry::create([
            'mission_id'    => 9,
            'timestamp'     => 0,
            'readout'       => "It's expected MD"
        ]);
        Telemetry::create([
            'mission_id'    => 9,
            'timestamp'     => 0,
            'readout'       => "Copy, [inaudible]"
        ]);
        Telemetry::create([
            'mission_id'    => 9,
            'timestamp'     => 0,
            'readout'       => "Dragon's in array deploy"
        ]);
        Telemetry::create([
            'mission_id'    => 9,
            'timestamp'     => 0,
            'readout'       => "Array deploy"
        ]);
        Telemetry::create([
            'mission_id'    => 9,
            'timestamp'     => 0,
            'readout'       => "All stations MD, we're on one dot one zero"
        ]);
        Telemetry::create([
            'mission_id'    => 9,
            'timestamp'     => 0,
            'readout'       => "Nice work"
        ]);
        Telemetry::create([
            'mission_id'    => 9,
            'timestamp'     => 0,
            'readout'       => "As expected, Dragon has now passed beyond the viewable range of the New Foundland, Canada ground station. SpaceX mission control here in Hawthorne will continue to communicate with Dragon as it circles the globe"
        ]);
        Telemetry::create([
            'mission_id'    => 9,
            'timestamp'     => 0,
            'readout'       => "yay, and as always we're super excited we had a great launch today. This is the fourth successful flight of the Falcon 9 rocket, and our third operational Dragon spacecraft put into orbit. This- let's see- Dragon is going to spend the next, about, three days catching up with the International Space Station so it plans to arrive there Wednesday October 10th, around 2AM Pacific Time, 5AM Eastern Time. So- oh yes! And happy birthday John! Always good! Yes. A launch- a successful launch is the best-"
        ]);
        Telemetry::create([
            'mission_id'    => 9,
            'timestamp'     => 0,
            'readout'       => "A great candle!"
        ]);
        Telemetry::create([
            'mission_id'    => 9,
            'timestamp'     => 0,
            'readout'       => "Exactly. So be sure to stay tuned to our Facebook and Twitter pages and spacex.com and you can follow Dragon's entire mission from now until it actually attaches to the space station, and you can see a ton of live footage on our pages and nasa, of the astronauts inside the space station, unloading cargo. There's gonna' to be lots of cool stuff to watch over the next few weeks."
        ]);
        Telemetry::create([
            'mission_id'    => 9,
            'timestamp'     => 0,
            'readout'       => "And here at SpaceX we want to extend our special thanks to NASA for their partnership and support on the CRS program."
        ]);
        Telemetry::create([
            'mission_id'    => 9,
            'timestamp'     => 0,
            'readout'       => "And we have uhh, over 1800 people here at SpaceX. We thank you so much for tuning in, and yes, we'll look forward to a great rest of the mission, so thank you all again and bub bye!"
        ]);
    }

    public function CRS2() {
        Telemetry::create([
            'mission_id'    => 10,
            'timestamp'     => 0,
            'readout'       => "We have liftoff of the Falcon 9"
        ]);
        Telemetry::create([
            'mission_id'    => 10,
            'timestamp'     => 0,
            'readout'       => "Dragon has sensed first stage acceleration"
        ]);
        Telemetry::create([
            'mission_id'    => 10,
            'timestamp'     => 0,
            'readout'       => "Falcon 9 has cleared the tower"
        ]);
        Telemetry::create([
            'mission_id'    => 10,
            'timestamp'     => 0,
            'readout'       => "Solid pitchkick"
        ]);
        Telemetry::create([
            'mission_id'    => 10,
            'timestamp'     => 0,
            'readout'       => "Starting gravity turn"
        ]);
        Telemetry::create([
            'mission_id'    => 10,
            'timestamp'     => 0,
            'readout'       => "Terminal count launch is complete"
        ]);
        Telemetry::create([
            'mission_id'    => 10,
            'timestamp'     => 0,
            'readout'       => "First stage at full power"
        ]);
        Telemetry::create([
            'mission_id'    => 10,
            'timestamp'     => 0,
            'readout'       => "Standing by"
        ]);
        Telemetry::create([
            'mission_id'    => 10,
            'timestamp'     => 0,
            'readout'       => "Power systems nominal and we have a good telemetry lock on stage 1 and 2"
        ]);
        Telemetry::create([
            'mission_id'    => 10,
            'timestamp'     => 0,
            'readout'       => "First stage propellant utilization active"
        ]);
        Telemetry::create([
            'mission_id'    => 10,
            'timestamp'     => 0,
            'readout'       => "Vehicle is 6km in altitude, velocity of 241m/s and downrange distance of 1km"
        ]);
        Telemetry::create([
            'mission_id'    => 10,
            'timestamp'     => 0,
            'readout'       => "Vehicle is supersonic"
        ]);
        Telemetry::create([
            'mission_id'    => 10,
            'timestamp'     => 0,
            'readout'       => "Vehicle has reached maximum aerodynamic pressure"
        ]);
        Telemetry::create([
            'mission_id'    => 10,
            'timestamp'     => 0,
            'readout'       => "Second stage has started engine chill"
        ]);
        Telemetry::create([
            'mission_id'    => 10,
            'timestamp'     => 0,
            'readout'       => "Vehicle remains on a nominal trajectory. Vehicle is 30km in altitude, velocity of 1km/s and downrange distance of 23km"
        ]);
        Telemetry::create([
            'mission_id'    => 10,
            'timestamp'     => 0,
            'readout'       => "Dragon power systems nominal"
        ]);
        Telemetry::create([
            'mission_id'    => 10,
            'timestamp'     => 0,
            'readout'       => "Vehicle remains on a nominal trajectory. Vehicle is 51km in altitude, velocity of 1.8km/s and downrange distance of 59km"
        ]);
        Telemetry::create([
            'mission_id'    => 10,
            'timestamp'     => 0,
            'readout'       => "Approaching MECO 1"
        ]);
        Telemetry::create([
            'mission_id'    => 10,
            'timestamp'     => 0,
            'readout'       => "MECO 1"
        ]);
        Telemetry::create([
            'mission_id'    => 10,
            'timestamp'     => 0,
            'readout'       => "Passed min-MECO"
        ]);
        Telemetry::create([
            'mission_id'    => 10,
            'timestamp'     => 0,
            'readout'       => "Flight computers in second stage"
        ]);
        Telemetry::create([
            'mission_id'    => 10,
            'timestamp'     => 0,
            'readout'       => "Dragon has sensed MECO"
        ]);
        Telemetry::create([
            'mission_id'    => 10,
            'timestamp'     => 0,
            'readout'       => "MECO 2, stage 1 shutdown"
        ]);
        Telemetry::create([
            'mission_id'    => 10,
            'timestamp'     => 0,
            'readout'       => "Stage separation confirmed"
        ]);
        Telemetry::create([
            'mission_id'    => 10,
            'timestamp'     => 0,
            'readout'       => "MVac ignition confirmed"
        ]);
        Telemetry::create([
            'mission_id'    => 10,
            'timestamp'     => 0,
            'readout'       => "AOS Wallops"
        ]);
        Telemetry::create([
            'mission_id'    => 10,
            'timestamp'     => 0,
            'readout'       => "Nosecone separation"
        ]);
        Telemetry::create([
            'mission_id'    => 10,
            'timestamp'     => 0,
            'readout'       => "All stations MD on mission A. Please proceed to procedure zero dot one zero one, Dragon On-Orbit Activation Deployment. Standing by for Dragon separation and prop-priming"
        ]);
        Telemetry::create([
            'mission_id'    => 10,
            'timestamp'     => 0,
            'readout'       => "Second stage propulsion systems nominal"
        ]);
        Telemetry::create([
            'mission_id'    => 10,
            'timestamp'     => 0,
            'readout'       => "Vehicle remains on a nominal trajectory. Vehicle is 148km in altitude, velocity of 3.2km/s and downrange distance of 346km"
        ]);
        Telemetry::create([
            'mission_id'    => 10,
            'timestamp'     => 0,
            'readout'       => "Second stage propellant utilization active"
        ]);
        Telemetry::create([
            'mission_id'    => 10,
            'timestamp'     => 0,
            'readout'       => "Vehicle remains on a nominal trajectory. Vehicle is 182km in altitude, velocity of 4km/s, and downrange distance of 541km"
        ]);
        Telemetry::create([
            'mission_id'    => 10,
            'timestamp'     => 0,
            'readout'       => "Second stage propulsion systems look good"
        ]);
        Telemetry::create([
            'mission_id'    => 10,
            'timestamp'     => 0,
            'readout'       => "Power systems look nominal and we have a good telemetry lock on stage 2"
        ]);
        Telemetry::create([
            'mission_id'    => 10,
            'timestamp'     => 0,
            'readout'       => "Vehicle is 200km in altitude, velocity of 4.6km/s and downrange distance of 767km"
        ]);
        Telemetry::create([
            'mission_id'    => 10,
            'timestamp'     => 0,
            'readout'       => "Vehicle remains on a nominal trajectory. Vehicle is 210km in altitude, velocity of 5.6km/s, and downrange distance of 1080km. IMU and GPS look good."
        ]);
        Telemetry::create([
            'mission_id'    => 10,
            'timestamp'     => 0,
            'readout'       => "Vehicle is passing through the head-on gate"
        ]);
        Telemetry::create([
            'mission_id'    => 10,
            'timestamp'     => 0,
            'readout'       => "Stage 2 propulsion systems continue to be nominal"
        ]);
        Telemetry::create([
            'mission_id'    => 10,
            'timestamp'     => 0,
            'readout'       => "Vehicle's in terminal guidance"
        ]);
        Telemetry::create([
            'mission_id'    => 10,
            'timestamp'     => 0,
            'readout'       => "FTS is safed"
        ]);
        Telemetry::create([
            'mission_id'    => 10,
            'timestamp'     => 0,
            'readout'       => "LOS Cape"
        ]);
        Telemetry::create([
            'mission_id'    => 10,
            'timestamp'     => 0,
            'readout'       => "MVac shutdown confirmed"
        ]);
        Telemetry::create([
            'mission_id'    => 10,
            'timestamp'     => 0,
            'readout'       => "Flight computers in separation state"
        ]);
        Telemetry::create([
            'mission_id'    => 10,
            'timestamp'     => 0,
            'readout'       => "Dragon has sensed SECO"
        ]);
        Telemetry::create([
            'mission_id'    => 10,
            'timestamp'     => 0,
            'readout'       => "Vehicle is orbital. Perigee 199km, apogee 323km, inclination 51.66 degrees"
        ]);
        Telemetry::create([
            'mission_id'    => 10,
            'timestamp'     => 0,
            'readout'       => "Cameras pointing forward"
        ]);
        Telemetry::create([
            'mission_id'    => 10,
            'timestamp'     => 0,
            'readout'       => "Dragon sep commanded"
        ]);
        Telemetry::create([
            'mission_id'    => 10,
            'timestamp'     => 0,
            'readout'       => "All stations, MD on mission A, succesful Dragon F9 sep, thank you for the ride F9"
        ]);
        Telemetry::create([
            'mission_id'    => 10,
            'timestamp'     => 0,
            'readout'       => "[inaudible] prop global"
        ]);
        Telemetry::create([
            'mission_id'    => 10,
            'timestamp'     => 0,
            'readout'       => "Prop global"
        ]);
        Telemetry::create([
            'mission_id'    => 10,
            'timestamp'     => 0,
            'readout'       => "All stations, prop software globals"
        ]);
        Telemetry::create([
            'mission_id'    => 10,
            'timestamp'     => 0,
            'readout'       => "Sys2 acknowedging prop global"
        ]);
        Telemetry::create([
            'mission_id'    => 10,
            'timestamp'     => 0,
            'readout'       => "Noting that prop alarms are inhibited. Flight computers in post-prime state. Software global"
        ]);
        Telemetry::create([
            'mission_id'    => 10,
            'timestamp'     => 0,
            'readout'       => "LOS Wallops"
        ]);
        Telemetry::create([
            'mission_id'    => 10,
            'timestamp'     => 0,
            'readout'       => "AOS New Foundland"
        ]);
        Telemetry::create([
            'mission_id'    => 10,
            'timestamp'     => 0,
            'readout'       => "Acknowledging software global"
        ]);
        Telemetry::create([
            'mission_id'    => 10,
            'timestamp'     => 0,
            'readout'       => "Flight computer in abort-passive"
        ]);
        Telemetry::create([
            'mission_id'    => 10,
            'timestamp'     => 0,
            'readout'       => "It appears that, although it achieved Earth orbit, Dragon is experiencing some type of problem right now. We'll have to learn about the nature of what happened. According to procedures, we expect a press conference to be held within a few hours from now. At that time, further information may be available. This will bring us to the conclusion of our live webcast for today. Please check our website, spacex.com, where we will be providing you with more information as it becomes available. Thank you for joining us today."
        ]);
    }

    public function CASSIOPE() {
        Telemetry::create([
            'mission_id'    => 11,
            'timestamp'     => 0,
            'readout'       => "Liftoff"
        ]);
        Telemetry::create([
            'mission_id'    => 11,
            'timestamp'     => 0,
            'readout'       => "PROP, AVI, GNC move to ten dot fifty-nine"
        ]);
        Telemetry::create([
            'mission_id'    => 11,
            'timestamp'     => 0,
            'readout'       => "GC move to ten dot fifty-eight"
        ]);
        Telemetry::create([
            'mission_id'    => 11,
            'timestamp'     => 0,
            'readout'       => "GC's in ten dot fifty-eight"
        ]);
        Telemetry::create([
            'mission_id'    => 11,
            'timestamp'     => 0,
            'readout'       => "First stage propellant utilization active"
        ]);
        Telemetry::create([
            'mission_id'    => 11,
            'timestamp'     => 0,
            'readout'       => "San- San Nicholas Island has data"
        ]);
        Telemetry::create([
            'mission_id'    => 11,
            'timestamp'     => 0,
            'readout'       => "OSM copies"
        ]);
        Telemetry::create([
            'mission_id'    => 11,
            'timestamp'     => 0,
            'readout'       => "The vehicle remains on a nominal trajectory, altitude is 5.8km, velocity of 467m/s, downrange distance of 600m"
        ]);
        Telemetry::create([
            'mission_id'    => 11,
            'timestamp'     => 0,
            'readout'       => "The vehicle is supersonic"
        ]);
        Telemetry::create([
            'mission_id'    => 11,
            'timestamp'     => 0,
            'readout'       => "Good telemetry, good power health"
        ]);
        Telemetry::create([
            'mission_id'    => 11,
            'timestamp'     => 0,
            'readout'       => "The vehicle is passing through maximum aerodynamic pressure"
        ]);
        Telemetry::create([
            'mission_id'    => 11,
            'timestamp'     => 0,
            'readout'       => "Telemetry still nominal, power still nominal"
        ]);
        Telemetry::create([
            'mission_id'    => 11,
            'timestamp'     => 0,
            'readout'       => "Second stage engine chill has started"
        ]);
        Telemetry::create([
            'mission_id'    => 11,
            'timestamp'     => 0,
            'readout'       => "The vehicle remains on a velocity of 1.1km/s downrange distance of [cutoff]"
        ]);
        Telemetry::create([
            'mission_id'    => 11,
            'timestamp'     => 0,
            'readout'       => "nominal trajectory, altitude is 61km, velocity of 1.8km/s, downrange distance of 45km"
        ]);
        Telemetry::create([
            'mission_id'    => 11,
            'timestamp'     => 0,
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
            'timestamp'     => 0,
            'readout'       => "MVac ignition confirmed"
        ]);
        Telemetry::create([
            'mission_id'    => 11,
            'timestamp'     => 0,
            'readout'       => "Stage two propellant utilization active"
        ]);
        Telemetry::create([
            'mission_id'    => 11,
            'timestamp'     => 0,
            'readout'       => "Stage 2 propulsion looking good"
        ]);
        Telemetry::create([
            'mission_id'    => 11,
            'timestamp'     => 0,
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
            'readout'       => "The vehicle remains on a nominal trajectory. Altitude of 232km, velocity of 2.9km/s, downrange distance of 383km"
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
            'timestamp'     => 0,
            'readout'       => "Vehicle remains on a nominal trajectory. Altitude of 274km, velocity of 3.7km/s, with a downrange distance of 565km"
        ]);
        Telemetry::create([
            'mission_id'    => 11,
            'timestamp'     => 0,
            'readout'       => "Cook link 13, link 51 from cook is still up"
        ]);
        Telemetry::create([
            'mission_id'    => 11,
            'timestamp'     => 0,
            'readout'       => "The vehicle remains on a nominal trajectory. Altitude of 310km, velocity of 5km/s, with a downrange distance of 850km"
        ]);
        Telemetry::create([
            'mission_id'    => 11,
            'timestamp'     => 0,
            'readout'       => "First stage is burning, err- relighting at this time"
        ]);
        Telemetry::create([
            'mission_id'    => 11,
            'timestamp'     => 0,
            'readout'       => "Stage 2's transitioned to terminal guidance"
        ]);
        Telemetry::create([
            'mission_id'    => 11,
            'timestamp'     => 0,
            'readout'       => "FTS is safed"
        ]);
        Telemetry::create([
            'mission_id'    => 11,
            'timestamp'     => 0,
            'readout'       => "Upproaching SECO 1"
        ]);
        Telemetry::create([
            'mission_id'    => 11,
            'timestamp'     => 0,
            'readout'       => "MVac shutdown confirmed"
        ]);
        Telemetry::create([
            'mission_id'    => 11,
            'timestamp'     => 0,
            'readout'       => "Vandenberg Air Force base loss of signal, on second stage. Expected loss of signal. That was a little bit better than we predicted."
        ]);
        Telemetry::create([
            'mission_id'    => 11,
            'timestamp'     => 0,
            'readout'       => "Ugh, what a ride! And you can hear the cheering behind us, as everybody was following along the Falcon 9 team, as we rode to space, is an amazing flight. So far I see tons of data coming back, it looks like it was a picture perfect flight everything was looking good, right down the middle of the track, looks like orbit's good, so we'll be waiting to hear, as we go onto the morning, uhh but I think right now, that brings us to the end of the scripted events for the morning! So I think right now lets throws it to Keiko, who's downstairs with the crowd, and then come back to us, and we'll be signing off"
        ]);
        Telemetry::create([
            'mission_id'    => 11,
            'timestamp'     => 0,
            'readout'       => "Well, that was a pretty awesome launch. Everybody down here is super excited, as you can hear them. I think uhh, we'll definitely want to get right back to work and get ready for the next one, that's what we do here."
        ]);
        Telemetry::create([
            'mission_id'    => 11,
            'timestamp'     => 0,
            'readout'       => "Thank you Keiko. Well, from the SpaceX team, Jessica, anything you want to say to wrap it up?"
        ]);
        Telemetry::create([
            'mission_id'    => 11,
            'timestamp'     => 0,
            'readout'       => "I just want to thank all of you for supporting us, this was a new demonstration launch and it went perfect, we were so excited and we're glad you all tuned in, so, stay up to date for us, we'll be doing more Grasshopper stuff, and we have a lot more Falcon 9 launches coming, so, stay up to date, and thank you!"
        ]);
        Telemetry::create([
            'mission_id'    => 11,
            'timestamp'     => 0,
            'readout'       => "I think right now the plan is there'll probably be some type of media conference later this afternoon. Tie in to our website, see what's happening, as well as we'll give updates as we go along in the mission, but for that, I also want to send thanks for not only the people that support us, but MDA Corporation who rode with us on the Falcon 9 as well as our other smallsat partners. It's been a great day here in Hawthorne, a great day in Vandenberg, and all over the SpaceX crews, in McGregor, DC, the Cape, everybody participating working along here. So with that, what we'd like to do is close the webcast with a thank you for tuning in, come back, we've got another launch coming out of the Cape coming up in just several weeks, where we get to live this all over again! So with that, a goodbye from Hawthorne, California at the SpaceX factory!"
        ]);
    }

    public function SES8() {
        Telemetry::create([
            'mission_id'    => 12,
            'timestamp'     => 0,
            'readout'       => "We have liftoff of the Falcon 9"
        ]);
        Telemetry::create([
            'mission_id'    => 12,
            'timestamp'     => 0,
            'readout'       => "Falcon 9 has cleared the towers"
        ]);
        Telemetry::create([
            'mission_id'    => 12,
            'timestamp'     => 0,
            'readout'       => "[inaudible]"
        ]);
        Telemetry::create([
            'mission_id'    => 12,
            'timestamp'     => 0,
            'readout'       => "First propellant utilization active"
        ]);
        Telemetry::create([
            'mission_id'    => 12,
            'timestamp'     => 0,
            'readout'       => "Power systems nominal and we have good telemetry lock"
        ]);
        Telemetry::create([
            'mission_id'    => 12,
            'timestamp'     => 0,
            'readout'       => "Vehicle remains on a nominal trajectory with an altitude of 6km [inaudible]"
        ]);
        Telemetry::create([
            'mission_id'    => 12,
            'timestamp'     => 0,
            'readout'       => "[inaudible]"
        ]);
        Telemetry::create([
            'mission_id'    => 12,
            'timestamp'     => 0,
            'readout'       => "Vehicle is passing through maximum aerodynamic pressure"
        ]);
        Telemetry::create([
            'mission_id'    => 12,
            'timestamp'     => 0,
            'readout'       => "Avionics, power systems nominal, and we still have a good telemetry lock"
        ]);
        Telemetry::create([
            'mission_id'    => 12,
            'timestamp'     => 0,
            'readout'       => "The vehicle remains on a nominal trajectory with an altitude of 30km, a downrange distance of 26km, and a velocity of 1.2km/s"
        ]);
        Telemetry::create([
            'mission_id'    => 12,
            'timestamp'     => 0,
            'readout'       => "First stage propulsion performing nominally"
        ]);
        Telemetry::create([
            'mission_id'    => 12,
            'timestamp'     => 0,
            'readout'       => "The vehicle remains on a nominal trajectory with an altitude of 48km, a downrange distance of 64km, and a velocity of 1.9km/s"
        ]);
        Telemetry::create([
            'mission_id'    => 12,
            'timestamp'     => 0,
            'readout'       => "Second stage engine is chilling in"
        ]);
        Telemetry::create([
            'mission_id'    => 12,
            'timestamp'     => 0,
            'readout'       => "MECO 1"
        ]);
        Telemetry::create([
            'mission_id'    => 12,
            'timestamp'     => 0,
            'readout'       => "Stage Sep commanded"
        ]);
        Telemetry::create([
            'mission_id'    => 12,
            'timestamp'     => 0,
            'readout'       => "MVac ignition confirmed"
        ]);
        Telemetry::create([
            'mission_id'    => 12,
            'timestamp'     => 0,
            'readout'       => "Second stage propellant utilization active"
        ]);
        Telemetry::create([
            'mission_id'    => 12,
            'timestamp'     => 0,
            'readout'       => "Fairing sep commanded"
        ]);
        Telemetry::create([
            'mission_id'    => 12,
            'timestamp'     => 0,
            'readout'       => "The vehicle's on a nominal trajectory with an altitude of 129km, a downrange distance 355km, and a velocity of 3.2km/s"
        ]);
        Telemetry::create([
            'mission_id'    => 12,
            'timestamp'     => 0,
            'readout'       => "Avionics, power systems are nominal"
        ]);
        Telemetry::create([
            'mission_id'    => 12,
            'timestamp'     => 0,
            'readout'       => "Stage 2 propulsion systems look good"
        ]);
        Telemetry::create([
            'mission_id'    => 12,
            'timestamp'     => 0,
            'readout'       => "The vehicle remains on a nominal trajectory with an altitude of 153km, a downrange distance of 550km, and a velocity of 3.7km/s"
        ]);
        Telemetry::create([
            'mission_id'    => 12,
            'timestamp'     => 0,
            'readout'       => "Avionics, power systems nominal and we continue to have a good telemetry lock"
        ]);
        Telemetry::create([
            'mission_id'    => 12,
            'timestamp'     => 0,
            'readout'       => "Stage 2 propulsion also nominal"
        ]);
        Telemetry::create([
            'mission_id'    => 12,
            'timestamp'     => 0,
            'readout'       => "Vehicle's at an altitude of 168km, a downrange distance of 790km, and a velocity of 4.5km/s"
        ]);
        Telemetry::create([
            'mission_id'    => 12,
            'timestamp'     => 0,
            'readout'       => "The vehicle's at an altitude 177km, a downrange distance of 1150km, and a velocity of 5.7km/s"
        ]);
        Telemetry::create([
            'mission_id'    => 12,
            'timestamp'     => 0,
            'readout'       => "Stage 2 and MVac propulsion still looking good"
        ]);
        Telemetry::create([
            'mission_id'    => 12,
            'timestamp'     => 0,
            'readout'       => "Terminal guidance has begun"
        ]);
        Telemetry::create([
            'mission_id'    => 12,
            'timestamp'     => 0,
            'readout'       => "FTS is safed"
        ]);
        Telemetry::create([
            'mission_id'    => 12,
            'timestamp'     => 0,
            'readout'       => "The vehicle remains on a nominal trajectory with an altitude of 178km, a downrange distance of 1500km, and a velocity of 7.6km/s"
        ]);
        Telemetry::create([
            'mission_id'    => 12,
            'timestamp'     => 0,
            'readout'       => "All stations AOS Bermuda, TX1"
        ]);
        Telemetry::create([
            'mission_id'    => 12,
            'timestamp'     => 0,
            'readout'       => "MVac shutdown confirmed"
        ]);
        Telemetry::create([
            'mission_id'    => 12,
            'timestamp'     => 0,
            'readout'       => "Well, although we lost video, right as we flew out of range, the second stage of Falcon 9 and SEs spacecraft are now in orbit, as expect when we passed out of sight from the ground stations, we lost the signal and we weren't able to bring you any additional video. This is going to bring an end to the coverage from orbit. We've had a great launch today, and the seventh flight of our Falcon 9 rocket. We will continue to post updates on our web at spacex.com/webcast as well as our social media pages. Now for updates on the mission, please check those sites as we prepared for spacecraft deployment later in this flight. On behalf of the over 3000 people here at SpaceX, we want to thank our SES customer for their confidence, and selectnig SpaceX and the Falcon 9 for their launch service. Please continue to follow along for the rest of the mission, and thanks to all of you for joining today."
        ]);
        Telemetry::create([
            'mission_id'    => 12,
            'timestamp'     => 0,
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
            'readout'       => "T+60 seconds, altitude 6km, velocity 266m/s, downrange distance 1.9km"
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
            'readout'       => "T+2 minutes. Altitude 30km, speed 1.1km/s, downrange distance 30km"
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
            'readout'       => "T+270 seconds, alttiude 135km, speed 3km/s, downrange distance 383km"
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
            'readout'       => "T+325 seconds, altitude 160km, speed 3.8km/s, downrange distance 582km"
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
            'readout'       => "T+410 seconds, altitude 175km, speed 4.8km/s, downrange distance 920km"
        ]);
        Telemetry::create([
            'mission_id'    => 13,
            'timestamp'     => 0,
            'readout'       => "Stage propulsion performance is good"
        ]);
        Telemetry::create([
            'mission_id'    => 13,
            'timestamp'     => 0,
            'readout'       => "T+460 seconds, altitude 178km, speed 5.6km/s, downrange distance 1200km"
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
            'readout'       => "T+515 seconds, altitude 178km, distance- downrange distance 1 point- 1500km"
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
        
    }
}