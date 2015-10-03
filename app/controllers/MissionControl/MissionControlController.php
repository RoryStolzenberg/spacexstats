<?php
use SpaceXStats\Enums\MissionControlSubtype;
use SpaceXStats\Enums\MissionControlType;

class MissionControlController extends BaseController {
	/*
	GET
	The Mission Control home page. If users is not a subscriber,
	go to About Mission Control + subscribe link, if they are, go to Mission Control.
	*/
	public function home() {
		if (Auth::isSubscriber()) {

            JavaScript::put([
                'missions' => Mission::all(),
                'types' => array_merge(MissionControlType::toArray(), MissionControlSubtype::toArray())
            ]);

            return View::make('missionControl.home', array(
                'title' => 'Misson Control',
                'currentPage' => 'mission-control'
            ));
		} else {
            return Redirect::route('missionControl.about');
		}
	}

    // AJAX GET
    public function fetch() {
        $uploads['latest'] = Object::wherePublished()
    }
}