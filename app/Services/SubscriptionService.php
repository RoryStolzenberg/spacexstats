<?php

namespace SpaceXStats\Services;

use Illuminate\Support\Facades\Auth;
use SpaceXStats\Library\Enums\UserRole;
use SpaceXStats\Models\Award;
use SpaceXStats\Models\Payment;
use SpaceXStats\Models\User;

class SubscriptionService
{
    public function createSubscription($token) {
        // Set the plan
        $plan = 'missioncontrol';

        // Subscribe the user
        $stripeResponse = Auth::user()->subscription($plan)->create($token);

        // Create a payment model
        Payment::create([
            'user_id' => Auth::id(),
            'price' => $stripeResponse->plan->amount
        ]);

        // Set the user to the subscriber role
        Auth::user()->role_id = UserRole::Subscriber;
        Auth::user()->save();

        return $stripeResponse;
    }

    /**
     * Increment the user's Mission Control subscription by the given number of seconds if they are a
     * Mission Control subscriber.
     *
     * @param User $user    The user to award
     * @param Award $award The award for which we can calculate the subscription length
     */
    public function incrementSubscription(User $user, Award $award) {
        // Calculate the seconds to extend by
        $seconds = (new DeltaVCalculator())->toSeconds($award->value);

        // Extend trial somehow
        //$user->
    }

    public function deleteSubscription() {

    }

    public function makeCharterSubscriber() {

    }
}