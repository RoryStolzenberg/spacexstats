<?php
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use SpaceXStats\Library\Enums\LaunchSpecificity;
use SpaceXStats\Models\PrelaunchEvent;

class PrelaunchEventsTableSeeder extends Seeder {
    public function run() {
        // F9F1
        PrelaunchEvent::create([
            'mission_id' => 6,
            'event' => 'Launch Change',
            'occurred_at' => Carbon::createFromDate(2010, 3, 9),
            'summary' => 'Abort at spin start T-0:02',
            'supporting_document' => null
        ]);

        PrelaunchEvent::create([
            'mission_id' => 6,
            'event' => 'Launch Change',
            'occurred_at' => Carbon::createFromDate(2010, 6, 4),
            'summary' => 'Out of range engine parameter, sensor error',
            'supporting_document' => null
        ]);

        //F9F2
        PrelaunchEvent::create([
            'mission_id' => 7,
            'event' => 'Launch Change',
            'occurred_at' => Carbon::createFromDate(2010, 12, 3),
            'summary' => 'Aborted at T-1.1 seconds due to high engine chamber pressure',
            'supporting_document' => null
        ]);

        PrelaunchEvent::create([
            'mission_id' => 7,
            'event' => 'Launch Static Fire',
            'occurred_at' => Carbon::createFromDate(2010, 12, 4),
            'summary' => null,
            'supporting_document' => null
        ]);

        PrelaunchEvent::create([
            'mission_id' => 7,
            'event' => 'Launch Change',
            'occurred_at' => Carbon::createFromDate(2010, 12, 4),
            'summary' => 'Low gas generator pressure in engine 6',
            'supporting_document' => null
        ]);

        PrelaunchEvent::create([
            'mission_id' => 7,
            'event' => 'Launch Change',
            'occurred_at' => Carbon::createFromDate(2010, 12, 8),
            'summary' => 'False abort on the Ordnance Interrupter (OI) ground feedback',
            'supporting_document' => null
        ]);

        //F9F3
        PrelaunchEvent::create([
            'mission_id' => 8,
            'event' => 'Launch Change',
            'occurred_at' => Carbon::createFromDate(2012, 5, 19),
            'summary' => 'High pressure reading in engine 5 chamber due to a faulty check valve T-0:01',
            'supporting_document' => null
        ]);

        // F9F4
        PrelaunchEvent::create([
            'mission_id' => 9,
            'event' => 'Launch Static Fire',
            'occurred_at' => Carbon::createFromDate(2012, 9, 29),
            'summary' => null,
            'supporting_document' => null
        ]);

        // F9F5
        PrelaunchEvent::create([
            'mission_id' => 10,
            'event' => 'Launch Static Fire',
            'occurred_at' => Carbon::createFromDate(2013, 2, 25),
            'summary' => null,
            'supporting_document' => null
        ]);

        // F9F6
        PrelaunchEvent::create([
            'mission_id' => 11,
            'event' => 'Launch Change',
            'occurred_at' => Carbon::createFromDate(2013, 9, 11),
            'summary' => 'Several issues during tanking',
            'supporting_document' => null
        ]);

        PrelaunchEvent::create([
            'mission_id' => 11,
            'event' => 'Launch Change',
            'occurred_at' => Carbon::createFromDate(2013, 9, 12),
            'summary' => 'Countdown abort',
            'supporting_document' => null
        ]);

        PrelaunchEvent::create([
            'mission_id' => 11,
            'event' => 'Launch Change',
            'occurred_at' => Carbon::createFromDate(2013, 9, 12),
            'summary' => 'Countdown abort',
            'supporting_document' => null
        ]);

        PrelaunchEvent::create([
            'mission_id' => 11,
            'event' => 'Launch Static Fire',
            'occurred_at' => Carbon::createFromDate(2013, 9, 19),
            'summary' => null,
            'supporting_document' => null
        ]);

        // F9F7
        PrelaunchEvent::create([
            'mission_id' => 12,
            'event' => 'Launch Change',
            'occurred_at' => Carbon::createFromDate(2013, 11, 20),
            'summary' => 'Unspecified issues & weather',
            'supporting_document' => null
        ]);

        PrelaunchEvent::create([
            'mission_id' => 12,
            'event' => 'Launch Static Fire',
            'occurred_at' => Carbon::createFromDate(2013, 11, 21),
            'summary' => 'Successful, but with excessive venting',
            'supporting_document' => null
        ]);

        PrelaunchEvent::create([
            'mission_id' => 12,
            'event' => 'Launch Change',
            'occurred_at' => Carbon::createFromDate(2013, 11, 25),
            'summary' => '1st stage LOX vent/pressure relief valve',
            'supporting_document' => null
        ]);

        PrelaunchEvent::create([
            'mission_id' => 12,
            'event' => 'Launch Change',
            'occurred_at' => Carbon::createFromDate(2013, 11, 25),
            'summary' => 'Ground electrical power supply',
            'supporting_document' => null
        ]);

        PrelaunchEvent::create([
            'mission_id' => 12,
            'event' => 'Launch Change',
            'occurred_at' => Carbon::createFromDate(2013, 11, 25),
            'summary' => '1st stage LOX vent/pressure relief valve, premature release of ECS duct',
            'supporting_document' => null
        ]);

        PrelaunchEvent::create([
            'mission_id' => 12,
            'event' => 'Launch Change',
            'occurred_at' => Carbon::createFromDate(2013, 11, 28),
            'summary' => 'Abort at ignition by low ramp up of thrust on Merlin 1D engines, T-0:01',
            'supporting_document' => null
        ]);

        PrelaunchEvent::create([
            'mission_id' => 12,
            'event' => 'Launch Change',
            'occurred_at' => Carbon::createFromDate(2013, 11, 28),
            'summary' => 'Oxygen contamination of ground side TEA-TEB T-1:00',
            'supporting_document' => null
        ]);

        // F9F8 (Thaicom 6)
        PrelaunchEvent::create([
            'mission_id' => 13,
            'event' => 'Launch Static Fire',
            'occurred_at' => Carbon::createFromDate(2013, 12, 29),
            'summary' => null,
            'supporting_document' => null
        ]);

        PrelaunchEvent::create([
            'mission_id' => 13,
            'event' => 'Launch Change',
            'occurred_at' => Carbon::createFromDate(2014, 1, 3),
            'summary' => "payload fairing issue",
            'supporting_document' => null
        ]);

        //F9F9
        PrelaunchEvent::create([
            'mission_id' => 14,
            'event' => 'Launch Static Fire',
            'occurred_at' => Carbon::createFromDate(2014, 3, 8),
            'summary' => null,
            'supporting_document' => null
        ]);

        PrelaunchEvent::create([
            'mission_id' => 14,
            'event' => 'Launch Change',
            'occurred_at' => Carbon::createFromDate(2014, 3, 16),
            'scheduled_launch_exact' => Carbon::createFromDate(2014, 3, 30),
            'scheduled_launch_specificity' => LaunchSpecificity::Day,
            'summary' => "Delay due to payload contamination",
            'supporting_document' => null
        ]);

        PrelaunchEvent::create([
            'mission_id' => 14,
            'event' => 'Launch Change',
            'occurred_at' => Carbon::createFromDate(2014, 3, 30),
            'scheduled_launch_exact' => Carbon::createFromDate(2014, 4, 14),
            'scheduled_launch_specificity' => LaunchSpecificity::Day,
            'summary' => "Delay due to fire damage to range radar",
            'supporting_document' => null
        ]);

        PrelaunchEvent::create([
            'mission_id' => 14,
            'event' => 'Launch Change',
            'occurred_at' => Carbon::createFromDate(2014, 4, 14),
            'summary' => "Helium leak on 1st stage",
            'supporting_document' => null
        ]);

        //F9F10
        PrelaunchEvent::create([
            'mission_id' => 15,
            'event' => 'Launch Change',
            'occurred_at' => Carbon::createFromDate(2014, 5, 8),
            'summary' => "Umbilical connections between the pad and the rocket",
            'supporting_document' => null
        ]);

        PrelaunchEvent::create([
            'mission_id' => 15,
            'event' => 'Launch Change',
            'occurred_at' => Carbon::createFromDate(2014, 5, 9),
            'summary' => "Helium leak at Composite Overwrap Pressure Vessels (COPV)",
            'supporting_document' => null
        ]);

        PrelaunchEvent::create([
            'mission_id' => 15,
            'event' => 'Launch Change',
            'occurred_at' => Carbon::createFromDate(2014, 5, 10),
            'summary' => "Delay due to helium leak, range, re-test on the satellites",
            'scheduled_launch_exact' => Carbon::createFromDate(2014, 6, 20),
            'scheduled_launch_specificity' => LaunchSpecificity::Day,
            'supporting_document' => null
        ]);

        PrelaunchEvent::create([
            'mission_id' => 15,
            'event' => 'Launch Static Fire',
            'occurred_at' => Carbon::createFromDate(2014, 6, 13),
            'summary' => null,
            'supporting_document' => null
        ]);

        PrelaunchEvent::create([
            'mission_id' => 15,
            'event' => 'Launch Change',
            'occurred_at' => Carbon::createFromDate(2014, 6, 20),
            'summary' => "Pressure decrease in 2nd stage",
            'supporting_document' => null
        ]);

        PrelaunchEvent::create([
            'mission_id' => 15,
            'event' => 'Launch Change',
            'occurred_at' => Carbon::createFromDate(2014, 6, 21),
            'summary' => "Weather (no webcast)",
            'supporting_document' => null
        ]);

        PrelaunchEvent::create([
            'mission_id' => 15,
            'event' => 'Launch Change',
            'occurred_at' => Carbon::createFromDate(2014, 6, 22),
            'scheduled_launch_exact' => Carbon::createFromDate(2014, 7, 14),
            'scheduled_launch_specificity' => LaunchSpecificity::Day,
            'summary' => "1st stage TVC actuator",
            'supporting_document' => null
        ]);

        PrelaunchEvent::create([
            'mission_id' => 15,
            'event' => 'Launch Static Fire',
            'occurred_at' => Carbon::createFromDate(2014, 7, 11),
            'summary' => null,
            'supporting_document' => null
        ]);

        PrelaunchEvent::create([
            'mission_id' => 15,
            'event' => 'Launch Change',
            'occurred_at' => Carbon::createFromDate(2014, 7, 14),
            'summary' => "Ground Support Equipment (GSE)",
            'supporting_document' => null
        ]);

        //F9F11
        PrelaunchEvent::create([
            'mission_id' => 16,
            'event' => 'Launch Static Fire',
            'occurred_at' => Carbon::createFromDate(2014, 7, 31),
            'summary' => null,
            'supporting_document' => null
        ]);

        PrelaunchEvent::create([
            'mission_id' => 16,
            'event' => 'Launch Change',
            'occurred_at' => Carbon::createFromDate(2014, 8, 5),
            'summary' => "Abort, 1st stage hydraulic parameters T-0:45",
            'supporting_document' => null
        ]);

        //F9F12
        PrelaunchEvent::create([
            'mission_id' => 17,
            'event' => 'Launch Static Fire',
            'occurred_at' => Carbon::createFromDate(2014, 8, 22),
            'summary' => null,
            'supporting_document' => null
        ]);

        PrelaunchEvent::create([
            'mission_id' => 17,
            'event' => 'Launch Change',
            'occurred_at' => Carbon::createFromDate(2014, 8, 27),
            'scheduled_launch_exact' => Carbon::createFromDate(2014, 9, 6),
            'scheduled_launch_specificity' => LaunchSpecificity::Day,
            'summary' => "Delay due to F9R accident, commonality evaluation",
            'supporting_document' => null
        ]);

        //F9F13
        PrelaunchEvent::create([
            'mission_id' => 18,
            'event' => 'Launch Static Fire',
            'occurred_at' => Carbon::createFromDate(2014, 9, 17),
            'summary' => null,
            'supporting_document' => null
        ]);

        PrelaunchEvent::create([
            'mission_id' => 18,
            'event' => 'Launch Change',
            'occurred_at' => Carbon::createFromDate(2014, 9, 19),
            'summary' => "Scrub due to weather",
            'supporting_document' => null
        ]);

        //F9F14
        PrelaunchEvent::create([
            'mission_id' => 19,
            'event' => 'Launch Static Fire',
            'occurred_at' => Carbon::createFromDate(2014, 12, 17),
            'summary' => "Early engine shutdown, static fire unsucessful",
            'supporting_document' => null
        ]);

        PrelaunchEvent::create([
            'mission_id' => 19,
            'event' => 'Launch Change',
            'occurred_at' => Carbon::createFromDate(2014, 12, 19),
            'scheduled_launch_exact' => Carbon::createFromDate(2015, 1, 5),
            'scheduled_launch_specificity' => LaunchSpecificity::Day,
            'summary' => "Delay due to static fire issue, ISS beta angles and holidays",
            'supporting_document' => null
        ]);

        PrelaunchEvent::create([
            'mission_id' => 19,
            'event' => 'Launch Static Fire',
            'occurred_at' => Carbon::createFromDate(2014, 12, 19),
            'summary' => null,
            'supporting_document' => null
        ]);

        PrelaunchEvent::create([
            'mission_id' => 19,
            'event' => 'Launch Change',
            'occurred_at' => Carbon::createFromDate(2015, 1, 6),
            'summary' => "Z axis actuator drift on the 2nd stage thrust vector control system, ?-1:21",
            'supporting_document' => null
        ]);

        //F9F15 DSCOVR
        PrelaunchEvent::create([
            'mission_id' => 20,
            'event' => 'Launch Static Fire',
            'occurred_at' => Carbon::createFromDate(2015, 1, 31),
            'summary' => null,
            'supporting_document' => null
        ]);

        PrelaunchEvent::create([
            'mission_id' => 20,
            'event' => 'Launch Change',
            'occurred_at' => Carbon::createFromDate(2015, 2, 8),
            'summary' => "Scrub due to AF radar outage, ?-2:26. Issue with 1st stage video transmitter (not needed for launch). There may have been a non-public vehicle issue that would have scrubbed launch as well",
            'supporting_document' => null
        ]);

        PrelaunchEvent::create([
            'mission_id' => 20,
            'event' => 'Launch Change',
            'occurred_at' => Carbon::createFromDate(2015, 2, 9),
            'summary' => "Delay due to weather",
            'supporting_document' => null
        ]);

        PrelaunchEvent::create([
            'mission_id' => 20,
            'event' => 'Launch Change',
            'occurred_at' => Carbon::createFromDate(2015, 2, 10),
            'summary' => "Weather scrub, red upper level winds T-12:41",
            'supporting_document' => null
        ]);

        // F9F16
        PrelaunchEvent::create([
            'mission_id' => 21,
            'event' => 'Launch Static Fire',
            'occurred_at' => Carbon::createFromDate(2015, 2, 25),
            'summary' => null,
            'supporting_document' => null
        ]);

        // F9F17
        PrelaunchEvent::create([
            'mission_id' => 22,
            'event' => 'Launch Static Fire',
            'occurred_at' => Carbon::createFromDate(2015, 4, 11),
            'summary' => null,
            'supporting_document' => null
        ]);

        PrelaunchEvent::create([
            'mission_id' => 22,
            'event' => 'Launch Change',
            'occurred_at' => Carbon::createFromDate(2015, 4, 13),
            'summary' => "Weather scrub, anvil rule, T-3:07",
            'supporting_document' => null
        ]);

        //F9F18
        PrelaunchEvent::create([
            'mission_id' => 23,
            'event' => 'Launch Static Fire',
            'occurred_at' => Carbon::createFromDate(2015, 4, 22),
            'summary' => null,
            'supporting_document' => null
        ]);

        //F9F20
        PrelaunchEvent::create([
            'mission_id' => 25,
            'event' => 'Launch Change',
            'occurred_at' => Carbon::create(2015, 12, 20, 20, 52, 17),
            'scheduled_launch_exact' => Carbon::create(2015, 12, 22, 1, 33, 00),
            'scheduled_launch_specificity' => LaunchSpecificity::Precise,
            'summary' => "10% better landing probability tomorrow, more time needed to densify LOX",
            'supporting_document' => "https://twitter.com/elonmusk/status/678679083782377472"
        ]);
    }
}