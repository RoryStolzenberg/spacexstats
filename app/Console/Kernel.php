<?php

namespace SpaceXStats\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use SpaceXStats\Console\Commands\QuestionUpdaterCommand;
use SpaceXStats\Console\Commands\WebcastCheckCommand;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        QuestionUpdaterCommand::class,
        WebcastCheckCommand::class,
        SpaceTrackDataFetchCommand::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('reddit:questions')->daily();
        $schedule->command('webcast:check')->everyMinute();
        $schedule->command('spacetrack:fetch')->dailyAt('19:37'); // Random time after 1700 to satisfy API request rules
    }
}
