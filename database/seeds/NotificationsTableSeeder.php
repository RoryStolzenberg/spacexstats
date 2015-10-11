<?php
use Illuminate\Database\Seeder;
use SpaceXStats\Models\Notification;

class NotificationsTableSeeder extends Seeder {
    public function run() {
        Notification::create(array(
            'user_id' => 1,
            'notification_type_id' => 1
        ));
    }
}