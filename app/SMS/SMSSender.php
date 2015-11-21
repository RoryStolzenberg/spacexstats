<?php

namespace SpaceXStats\SMS;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Config;
use SpaceXStats\Library\Enums\NotificationType;
use SpaceXStats\Models\SMS;

class SMSSender {
    private $client, $sentCount = 0, $errorCount = 0;

    public function __construct() {
        $this->client = new \Services_Twilio(Config::get('services.twilio.sid'), Config::get('services.twilio.token'));
    }

    /**
     * Send a SMS message.
     *
     * Given an collection of users, send the provided $message to each user via SMS.
     *
     * @param Collection $users     Collection of users to send a message to.
     * @param string $message       Message to send to each user.
     * @return bool
     */
    public function send($users, $message) {

        foreach ($users as $user) {
            if (!is_null($user->mobile)) {
                try {
                    // Send the message
                    $this->client->account->messages->sendMessage(Config::get('services.twilio.fromNumber'), $user->mobile, $message);

                    // Add an indication the message has been sent to the db
                    $sms = new SMS();
                    $sms->user_id = $user->user_id;
                    $sms->message = $message;

                    // Associate notification type. We can use an orWhere query here because currently a user cannot have more than
                    // one SMS notification concurrently.
                    $sms->notification()->associate($user->notifications()
                        ->where('notification_type_id', NotificationType::TMinus24HoursSMS)
                        ->orWhere('notification_type_id', NotificationType::TMinus3HoursSMS)
                        ->orWhere('notification_type_id', NotificationType::TMinus1HourSMS)
                        ->first);

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