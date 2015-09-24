<?php
class PublishersController extends BaseController {

	public function get($publisherId) {
		$publisher = Publisher::find($publisherId);

		return View::make('missionControl.publishers.get', array(
			'publisher' => $publisher
		));
	}

	public function create() {
		if (Request::isMethod('get')) {

			return View::make('missionControl.publishers.create');

		} elseif (Request::isMethod('post')) {

			return Response::json();

		}
	}

	public function edit(publisherId) {
		if (Request::isMethod('get')) {
			$publisher = Publisher::find($publisherId);

			JavaScript::put([
				'publisher' => $publisher
			]);

			return View::make('missionControl.publishers.edit');

		} elseif (Request::isMethod('post')) {

			return Response::json();
			
		}
	}
}