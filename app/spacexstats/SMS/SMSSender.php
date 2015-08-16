<?php

namespace SpaceXStats\SMS;

use SpaceXStats\Enums\NotificationType;

class SMSSender {
    private $client, $sentCount = 0, $errorCount = 0;

    public function __construct() {
        $this->client = new \Services_Twilio(\Credential::TwilioSID, \Credential::TwilioToken);
    }

    /**
     * Send a SMS message.
     *
     * Given an collection of users, send the provided $message to each user via SMS.
     *
     * @param collection $users Collection of users to send a message to.
     * @param string $message Message to send to each user.
     * @return bool
     */
    public function send($users, $message) {

        foreach ($users as $user) {
            if (!is_null($user->mobile)) {
                try {

                    // Send the message
                    $this->client->account->messages->sendMessage(\Credential::TwilioFromNumber, $user->mobile, $message);

                    // Add an indication the message has been sent to the db
                    $sms = new \SMS();
                    $sms->user_id = $user->user_id;
                    $sms->message = $message;

                    // Associate notification type
                    $sms->notification()->associate($user->notifications()->whereHas('notificationType', function($q) {
                        $q->where('name', NotificationType::tMinus24HoursSMS)->orWhere('name', NotificationType::tMinus3HoursSMS)->orWhere('name', NotificationType::tMinus1HourSMS);
                    })->first());

                    $sms->save();

                    // Increment sent count
                    $this->sentCount++;

                } catch (\Services_Twilio_RestException $e) {
                    $this->errorCount++;
                }
            } else {
                $this->errorCount++;
            }
        }
    }

    public function resetCounts() {
        $this->sentCount = 0;
        $this->errorCount = 0;
    }

    public function getSentCount() {
        return $this->sentCount;
    }

    public function getErrorCount() {
        return $this->errorCount;
    }
}