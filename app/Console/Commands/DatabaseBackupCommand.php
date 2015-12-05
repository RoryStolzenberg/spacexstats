<?php

namespace SpaceXStats\Console\Commands;

use AWS;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Config;

class DatabaseBackupCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:backup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Backup the production database and email/upload/save the results';

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
        $username = Config::get('database.connections.mysql.username');
        $password = Config::get('database.connections.mysql.password');
        $database = Config::get('database.connections.mysql.database');
        $date = Carbon::now()->format('Y-m-d');

        exec("mysqldump -u " . $username . " -p" . $password . " " . $database . ' > storage/backups/' . $date .'_mysql_backup.sql');

        $s3 = AWS::createClient('s3');

        $s3->putObject([
            'Bucket' => Config::get('filesystems.disks.s3.bucketMetadata'),
            'Key' => $date .'_mysql_backup.sql',
            'Body' => file_get_contents(base_path('storage/backups/' . $date .'_mysql_backup.sql')),
            'ACL' => 'private',
        ]);
    }
}
