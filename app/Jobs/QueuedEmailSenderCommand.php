<?php

use Indatus\Dispatcher\Scheduling\ScheduledCommand;
use Indatus\Dispatcher\Scheduling\Schedulable;
use Indatus\Dispatcher\Drivers\Cron\Scheduler;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

use \SpaceXStats\Library\Enums\EmailStatus;

class QueuedEmailSenderCommand extends ScheduledCommand {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'QueuedEmailSenderCommand';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Send all emails that are queued';

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
		return $scheduler->everyMinutes(5);
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{
		$emails = \Email::where('status', EmailStatus::Queued)->get();

        foreach ($emails as $email) {
            //Mail::send();
        }

        // Update all emails
        \Email::where('status', EmailStatus::Queued)->update(array(
            'status' => EmailStatus::Sent
        ));
	}
}
