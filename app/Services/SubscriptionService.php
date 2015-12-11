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

    /**
     * Creates a subscription for the currently Authenticated user, provided they are first
     * at least a member of the site.
     *
     * Once a subscription is created, it also creates a payment model for that user and upgrades
     * their role to 'Susbcriber'.
     *
     * @param string $token    The user subscription token from Stripe.
     */
    public function createSubscription($token) {

        // It makes no sense to try and give a subscription to someone who
        // is not a member
        if (Auth::isMember()) {
            // Subscribe the user
            Auth::user()->subscription($this->currentPlan)->create($token);

            $subscriptionEndsAt = Auth::user()->subscription()->getSubscriptionEndDate();

            // Create a payment representation
            Payment::create([
                'user_id' => Auth::id(),
                'price' => Plan::retrieve($this->currentPlan)->amount,
                'subscription_ends_at' => $subscriptionEndsAt
            ]);

            // Set the user to the subscriber role
            Auth::user()->role_id = UserRole::Subscriber;
            Auth::user()->subscription_ends_at = $subscriptionEndsAt;
            Auth::user()->trial_ends_at = null;
            Auth::user()->save();
        }
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

            // Fetch the current subscription/trial end
            $endDate = is_null($user->getTrialEndDate()) ? $user->getSubscriptionEndDate() : $user->getTrialEndDate();

            // Calculate the new end date
            $newEndDate = $endDate->addSeconds($seconds);

            // Extend trial to that date
            $user->subscription($this->currentPlan)->noProrate()->trialFor($newEndDate)->swap();

            // Update the database
            $user->trial_ends_at = $user->subsription()->getTrialEndDate();
            $user->save();
        }
    }

    public function deleteSubscription() {

    }

    public function makeCharterSubscriber() {

    }
}