<?php

namespace SpaceXStats\Mailers;

class MissionNotificationsMailer extends Mailer {
    public function newMission(Mission $mission) {
        $view = 'emails.missions.new';
        $data = ['mission' => $mission];
        $subject = $mission->name . ' has been added to SpaceX\'s launch manifest';

        $this->sendTo('new.mission@email.com', $subject, $view, $data);
    }

    public function updateMission(Mission $mission) {

    }

    public function tMinus24HoursMission(Mission $mission) {

    }
}