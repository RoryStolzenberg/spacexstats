<?php

namespace SpaceXStats\Mail\Mailers;

class MissionNotificationsMailer extends Mailer {

    public function newMission(\Mission $mission) {
        $view = 'emails.missions.new';
        $data = ['mission' => $mission];
        $subject = $mission->name . ' has been added to SpaceX\'s launch manifest';

        $this->sendTo('new.mission@email.com', $subject, $view, $data);
    }

    public function launchTimeChange(\Mission $mission, $action) {
        // if action 'queue'
            //
    }

    public function tMinus24HoursMission(\Mission $mission) {

    }

    public function tMinus3HoursMission(\Mission $mission) {

    }

    public function tMinus1HourMission(\Mission $mission) {

    }
}