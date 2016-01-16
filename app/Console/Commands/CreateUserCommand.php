<?php

namespace SpaceXStats\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use SpaceXStats\Library\Enums\UserRole;
use SpaceXStats\Models\Profile;
use SpaceXStats\Models\User;

class CreateUserCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:user {username} {password} {role} {--launchctl}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates a user with the required input parameters without sending an email.';

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
     * @return mixed
     */
    public function handle()
    {
        $user = new User();
        $user->username     = $this->argument('username');
        $user->email        = $this->argument('username') . '@spacexstats.com';
        $user->password     = $this->argument('password'); // Hashed as a mutator on the User model
        $user->key          = str_random(32);
        $user->role_id      = UserRole::fromString($this->argument('role'));

        if ($this->option('launchctl')) {
            $user->launch_controller_flag = true;
        }

        DB::transaction(function() use($user) {
            $user->save();

            // Associate a profile
            $profile = new Profile();
            $profile->user()->associate($user)->save();
        });
    }
}
