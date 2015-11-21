<?php

namespace SpaceXStats\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use SpaceXStats\Notifications\EmailMissionCountdownNotifier;
use SpaceXStats\Notifications\SMSMissionCountdownNotifier;

class MissionCountdownNotificationCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mission:notify';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Send out SMS and email messages as a mission countdown progresses.";

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
     * Execute the console command.
     *
     * @param SMSMissionCountdownNotifier $smsNotifier
     * @param EmailMissionCountdownNotifier $emailNotifier
     * @return mixed
     */
    public function handle(SMSMissionCountdownNotifier $smsNotifier, EmailMissionCountdownNotifier $emailNotifier)
    {
        if ($smsNotifier->notificationIsNeeded()) {
            $smsNotifier->notify();
        }
        if ($emailNotifier->notificationIsNeeded()) {
            $emailNotifier->notify();
        }
    }
}
