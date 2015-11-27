<?php

namespace SpaceXStats\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Redis;
use Illuminate\Contracts\Bus\SelfHandling;
use SpaceXStats\Models\Object;

class PutObjectToCloudJob extends Job implements SelfHandling, ShouldQueue
{
    /**
     * @var Object
     */
    private $object;

    /**
     * Create a new job instance.
     *
     * @param Object $object
     */
    public function __construct(Object $object)
    {
        $this->object = $object;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->object->putToCloud();
        $this->object->deleteFromTemporary();

        $this->object->save();
    }
}
