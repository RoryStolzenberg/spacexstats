<?php

namespace SpaceXStats\Services;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use SpaceXStats\Library\Enums\UserRole;
use SpaceXStats\Models\Award;
use SpaceXStats\Models\Payment;
use SpaceXStats\Models\User;
use Stripe\Plan;

class SubscriptionService
{
    protected $currentPlan = 'missioncontrol';

    public function createSubscription($token) {

        // Subscribe the user
        Auth::user()->subscription($this->currentPlan)->create($token);

        // Create a payment representation
        Payment::create([
            'user_id' => Auth::id(),
            'price' => Plan::retrieve($this->currentPlan)->amount
        ]);

        // Set the user to the subscriber role
        Auth::user()->role_id = UserRole::Subscriber;
        Auth::user()->save();
    }

    /**
     * Increment the user's Mission Control subscription by the given number of seconds if they are a
     * Mission Control subscriber.
     *
     * This method has safeguards to prevent users with higher roles (charter subscribers, admins) from
     * being awarded extra time on a nonexistent subscription.
     *
     * @param User $user    The user to award
     * @param Award $award The award for which we can calculate the subscription length
     */
    public function incrementSubscription(User $user, Award $award) {
        if ($user->role_id == UserRole::Subscriber) {
            // Calculate the seconds to extend by
            $seconds = (new DeltaVCalculator())->toSeconds($award->value);

            // Fetch the current subscription/trail end
            //$endDate = is_null($user->getTrialEndDate()) ? $user->getSubscriptionEndDate() : $user->getTrialEndDate();

            $endDate = $user->subscription()->getSubscriptionEndDate();

            // Calculate the new end date
            $newEndDate = $endDate->addSeconds($seconds);

            // Extend trial by to that date
            $user->subscription()->noProrate()->trialFor($newEndDate);
        }
    }

    public function deleteSubscription() {

    }

    public function makeCharterSubscriber() {

    }
}