<?php

class UserPresenter {
    protected $entity;

    function __construct($entity) {
        $this->entity = $entity;
    }

    public function role_id() {
        return SpaceXStats\Enums\UserRole::getKey($this->entity->role_id);
    }

    /**
     * @return null|string
     */
    public function subscription_details(User $user) {
        // If the user is accessing themselves and is a subscriber, show when their subscription expires (or if an admin)
        if ((Auth::isAccessingSelf($user) && Auth::isSubscriber()) || Auth::isAdmin()) {
            $subscriptionExpiry = 'Subscription expires ' . $this->entity->subscription_expiry->toFormattedDateString();

            // If the subscription also expires in less than 30 days... ask them to renew!
            if ($this->entity->daysUntilSubscriptionExpires < 30) {
                $subscriptionExpiry .= ' (Renew!)';
            }

            return $subscriptionExpiry;
        } else {
            return null;
        }
    }
}