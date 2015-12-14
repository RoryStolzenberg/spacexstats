<?php

namespace SpaceXStats\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;
use SpaceXStats\Facades\Search;
use SpaceXStats\Models\Collection;
use SpaceXStats\Models\DataView;
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
        // Fetch objects and delete redis sets
        $objects = Object::whereIn('object_id', Redis::smembers('objects:toReindex'))->get();
        $collections = Collection::whereIn('collection_id', Redis::smembers('collections:toReindex'))->get();
        $dataViews = DataView::whereIn('dataview_id', Redis::smembers('dataviews:toReindex'))->get();

        Redis::del(['objects:toReindex', 'collections:toReindex', 'dataviews:toReindex']);

        // Map to return searchable interfaces and reindex
        if ($objects->count() > 0) {
            foreach($objects as $object) {
                $searchableObjects[] = $object->search();
            }
            Search::bulkReindex($searchableObjects);
        }

        if ($collections->count() > 0) {
            foreach($collections as $collection) {
                $searchableCollections[] = $collection->search();
            }
            Search::bulkReindex($searchableCollections);
        }

        if ($dataViews->count() > 0) {
            foreach ($dataViews as $dataView) {
                $searchableDataViews[] = $dataView->search();
            }
            Search::bulkReindex($searchableDataViews);
        }
    }
}
