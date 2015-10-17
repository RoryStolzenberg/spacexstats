<?php
namespace SpaceXStats\Models\Traits;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;
use ReflectionClass;

trait CountsViewsTrait {

    public function incrementViewCounter() {
        // Only increment the view counter if the current user is a subscriber
        if (Auth::isSubscriber()) {

            $modelName = (new ReflectionClass($this))->getShortName();
            $modelKey = strtolower($modelName) . '_id';

            // Only increment the view counter if the user has not visited in 1 hour
            if (!Redis::exists($modelName . 'ViewByUser:' . $this->$modelKey . ':' . Auth::id())) {

                // Increment
                Redis::hincrby($modelName . ':' . $this->$modelKey, 'views', 1);

                // Add user to recent views
                Redis::setex($modelName . 'ViewByUser:' . $this->$modelKey . ':' . Auth::id(), 3600, true);
            }
        }
    }
}