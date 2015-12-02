<?php

namespace SpaceXStats\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use SpaceXStats\Library\Enums\ObjectPublicationStatus;
use SpaceXStats\Models\Object;

class DeleteOrphanedFilesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'objects:deleteOrphanedFiles';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Remove any objects and files from the database and server which have not been queued for at least 7 days.';

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
        $orphanedObjects = Object::where('status', ObjectPublicationStatus::NewStatus)->where('created_at', '<', Carbon::now()->subWeek())->get();

        $trashedObjectsByKey = $orphanedObjects->each(function($orphanedObject) {
            $orphanedObject->deleteFromTemporary();
        })->keyBy('object_id');

        Object::destroy($trashedObjectsByKey->keys());
    }
}
