<?php
class PublishersController extends BaseController {

	public function get($publisherId) {
		$publisher = Publisher::find($publisherId);

		View::make('missionControl.publishers.get', array(
			'publisher' => $publisher
		));
	}

	public function create() {
		if (Request::isMethod('get')) {

		} elseif (Request::isMethod('post')) {

		}
	}

	public function edit(publisherId) {
		if (Request::isMethod('get')) {

		} elseif (Request::isMethod('post')) {
			
		}
	}
}