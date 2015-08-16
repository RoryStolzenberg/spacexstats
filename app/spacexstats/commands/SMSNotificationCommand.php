<?php

use Indatus\Dispatcher\Scheduling\ScheduledCommand;
use Indatus\Dispatcher\Scheduling\Schedulable;
use Indatus\Dispatcher\Drivers\Cron\Scheduler;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

use Carbon\Carbon;
use SpaceXStats\Enums\LaunchSpecificity;

class SMSNotificationCommand extends ScheduledCommand {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'SMSNotificationService';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Send SMS Notifications about upcoming launches';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * When a command should run
	 *
	 * @param Scheduler $scheduler
	 * @return \Indatus\Dispatcher\Scheduling\Schedulable
	 */
	public function schedule(Schedulable $scheduler)
	{
		return $scheduler->everyMinutes(1);
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{
        $now = Carbon::now();
        $lastRun = $now->subMinute();

		$nextMission = \Mission::future()->first();

        if ($nextMission->launchSpecificity == LaunchSpecificity::Precise) {

            $nowDiffInSeconds = $nextMission->launchDateTime->diffInSeconds($now);
            $lastRunDiffInSeconds = $nextMission->launchDateTime->diffInSeconds($lastRun);

            // if the current time to launch is 86,400 seconds or less (24 hour notification)
            if ($nowDiffInSeconds < 86400 && $lastRunDiffInSeconds >= 86400) {
                // Send notification
            } else if ($nowDiffInSeconds < 10800 && $lastRunDiffInSeconds >= 10800) {

            } else if ($nowDiffInSeconds < 3600 && $lastRunDiffInSeconds >= 3600) {

            }
        }
	}
}
