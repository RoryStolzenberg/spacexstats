<?php
class MissionControlController extends BaseController {
	/*
	GET
	The Mission Control home page. If users is not a subscriber,
	go to About Mission Control + subscribe link, if they are, go to Mission Control.
	*/
	public function home() {
		if (Auth::isSubscriber()) {
            return View::make('missionControl.home', array(
                'title' => 'Misson Control',
                'currentPage' => 'mission-control'
            ));
		} else {
            return Redirect::route('missionControl.about');
		}
	}
}