<?php

namespace SpaceXStats\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use SpaceXStats\Console\Commands\MissionCountdownNotificationCommand;
use SpaceXStats\Console\Commands\QuestionUpdaterCommand;
use SpaceXStats\Console\Commands\WebcastCheckCommand;
use SpaceXStats\Console\Commands\SpaceTrackDataFetchCommand;
use SpaceXStats\Console\Commands\DeleteOrphanedFilesCommand;
use SpaceXStats\Console\Commands\DatabaseBackupCommand;

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
        SpaceTrackDataFetchCommand::class,
        MissionCountdownNotificationCommand::class,
        DeleteOrphanedFilesCommand::class,
        DatabaseBackupCommand::class
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
        $schedule->command('mission:notify')->everyMinute();
        $schedule->command('objects:deleteOrphanedFiles')->weekly();
        $schedule->command('db:backup')->hourly();
    }
}
