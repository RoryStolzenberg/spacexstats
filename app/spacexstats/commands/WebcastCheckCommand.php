<?php
namespace SpaceXStats\Commands;

use SpaceXStats\Library\WebcastChecker;
use Indatus\Dispatcher\Scheduling\ScheduledCommand;
use Indatus\Dispatcher\Scheduling\Schedulable;
use Indatus\Dispatcher\Drivers\Cron\Scheduler;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class WebcastCheckCommand extends ScheduledCommand {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'webcastCheck';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Check whether the SpaceX webcast is live or not.';

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
		// Fire this every minute
		return $scheduler->everyMinutes(1);
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{
        $livestream = json_decode(file_get_contents('http://xspacexx.api.channel.livestream.com/2.0/livestatus.json'));

        \Redis::hmset('webcast', 'isLive', $livestream->channel->isLive === true ? 'true' : 'false', 'viewers', $livestream->channel->currentViewerCount);

        // Add to Database if livestream is active
        if ($livestream->channel->isLive === true) {
            \WebcastStatus::create(array(
                'viewers' => $livestream->channel->currentViewerCount
            ));
        }
	}
}
