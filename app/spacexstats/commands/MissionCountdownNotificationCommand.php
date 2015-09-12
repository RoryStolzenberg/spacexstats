<?php

use Indatus\Dispatcher\Scheduling\ScheduledCommand;
use Indatus\Dispatcher\Scheduling\Schedulable;
use Indatus\Dispatcher\Drivers\Cron\Scheduler;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class MissionCountdownNotificationCommand extends ScheduledCommand {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'MissionCountdownNotificationCommand';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Send out SMS\'s and emails as mission countdowns progress';

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
		return $scheduler->everyMinutes(1);;
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{
        $SMSnotifier = new SMSMissionCountdownNotifier();

        if ($SMSnotifier->notificationIsNeeded()) {
            $SMSnotifier->notify();
        }

        $emailnotifier = new EmailMissionCountdownNotifier();

        if ($emailnotifier->notificationIsNeeded()) {
            $emailnotifier->notify();
        }
	}
}
