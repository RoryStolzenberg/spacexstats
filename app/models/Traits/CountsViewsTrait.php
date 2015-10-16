<?php
namespace SpaceXStats\Models\Traits;

trait CountsViewsTrait {

    public function incrementViewCounter() {
        // Only increment the view counter if the current user is a subscriber
        if (Auth::isSubscriber()) {

            $className = strtolower(get_class());

            // Only increment the view counter if the user has not visited in 1 hour
            if (Redis::exists($className . 'ViewByUser:' . $this->primaryKey . ':' . Auth::user()->user_id)) {

                // Increment
                Redis::hincrby($className . ':' . $this->primaryKey, 'views', 1);

                // Add user to recent views
                Redis::setex($className . 'ViewByUser:' . $this->primaryKey . ':' . Auth::user()->user_id, true, 3600);
            }
        }
    }
}