<?php
namespace AppHttpControllers;

class CalendarController extends Controller {
	// GET All Calendars for mission
	public function getAll() {
		// get all missions in the future where a launch is exact
		$missions = Mission::whereUpcoming()->whereNotNull('launch_exact')->with('launchSite')->get();
		return $this->returnCalendarOrRedirect($missions, 'spacexstats');
	}

	// GET Specific Calendar for mission
	public function get($slug) {
		// get a mission in the future if a launch is exact
		$missions = Mission::whereSlug($slug)->whereUpcoming()->whereNotNull('launch_exact')->with('launchSite')->get();
		return $this->returnCalendarOrRedirect($missions, $slug);
	}

	private function returnCalendarOrRedirect($missions, $filename) {
		if (!$missions->isEmpty()) {
			$calendar = new SpaceXStats\Library\CalendarBuilder($missions);

			return Response::make($calendar->getContent(), 200, array(
				'Content-type' => 'text/calendar',
				'Content-Disposition' => 'inline;filename="'.$filename.'.ics"'
			));			
		} else {
			return Redirect::route('home');
		}
	}
}