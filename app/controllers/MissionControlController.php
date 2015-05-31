<?php
class MissionControlController extends BaseController {
	/*
	GET
	The Mission Control home page. If users are not logged in or are not a subscriber,
	go to About Mission Control + subscribe link, if they are, go to Mission Control.
	*/
	public function home() {
		if (Auth::guest() || Auth::user()->role_id < UserRole::Subscriber) {
			return Redirect::route('missionControl.about');
		} else {
			return View::make('missionControl.home', array(
				'title' => 'Misson Control',
				'currentPage' => 'mission-control'
			));
		}
	}
}