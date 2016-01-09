<?php
namespace SpaceXStats\Services;

class CalendarBuilder {
	private $missions;

	public function __construct($missions) {
		$this->missions = $missions;
	}

	public function getContent() {
		$ical = "BEGIN:VCALENDAR
VERSION:2.0
PRODID:-//hacksw/handcal//NONSGML v1.0//EN\r\n";

		$ical .= $this->buildEvents();

		$ical .= "END:VCALENDAR";

		return $ical;
	}

	private function buildEvents() {
		$ical = "";
		foreach ($this->missions as $mission) {
			$ical .= "BEGIN:VEVENT
UID:" . md5(uniqid(mt_rand(), true)) . "@spacexstats.com
DTSTAMP:" . gmdate('Ymd').'T'. gmdate('His') . "Z
DTSTART:".$this->eventStart($mission)."
DTEND:".$this->eventEnd($mission)."
SUMMARY:".$this->eventSummary($mission)."
LOCATION:".$this->eventLocation($mission)."
DESCRIPTION:".$this->eventDescription($mission)."
END:VEVENT\r\n";
		}

		return $ical;
	}

	private function eventStart($mission) {
		$temp = \DateTime::createFromFormat('Y-m-d H:i:s', $mission->launch_exact);
		return $temp->format('Ymd\THis\Z');
	}

	private function eventEnd($mission) {
		$temp = \DateTime::createFromFormat('Y-m-d H:i:s', $mission->launch_exact);
		$temp->add(\DateInterval::createFromDateString('1 hour'));
		return $temp->format('Ymd\THis\Z');
	}

	private function eventSummary($mission) {
		return $mission->name.' Launch';
	}

	private function eventDescription($mission) {
		return $mission->summary;
	}

	private function eventLocation($mission) {
		return $mission->launchSite->fullLocation;
	}
}