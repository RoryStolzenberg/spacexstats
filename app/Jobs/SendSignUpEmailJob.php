<?php

namespace SpaceXStats\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Contracts\Bus\SelfHandling;
use SpaceXStats\Mail\Mailers\UserMailer;

class SendSignUpEmailJob extends Job implements SelfHandling, ShouldQueue
{
    public $user;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($user)
    {
        $this->user = $user;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(UserMailer $mailer)
    {
        $mailer->welcome($this->user);
    }
}
