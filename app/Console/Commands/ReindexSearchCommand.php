<?php

namespace SpaceXStats\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Redis;
use SpaceXStats\Facades\Search;
use SpaceXStats\Models\Object;

class ReindexSearchCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'search:reindex';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reindex documents which have been updates since the last reindexing';

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
        $objects = Object::whereIn('object_id', Redis::smembers('objects:toReindex'))->get();
        Redis::del('objects:toReindex');

        $objects->each(function($object) {
            Search::reindex($object->search());
        });
    }
}
