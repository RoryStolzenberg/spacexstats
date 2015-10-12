<?php
namespace SpaceXStats\Http\Controllers\MissionControl;

use SpaceXStats\Http\Controllers\Controller;

class PublishersController extends Controller {

	public function __construct(Publisher $publisher) {
		$this->publisher = $publisher;
	}

	public function get($publisherId) {
		$publisher = Publisher::find($publisherId);

		return view('missionControl.publishers.get', array(
			'publisher' => $publisher
		));
	}

	public function create() {
		if (Request::isMethod('get')) {

			return view('missionControl.publishers.create');

		} elseif (Request::isMethod('post')) {

			if ($this->publisher->isValid(Input::get('publisher'))) {

				// Create publisher
				/*$publisher = Publisher::create(array(
					'name' =>
					'description' =>
				));*/

				//return response()->json($publisher, 200);
			}
			return response()->json();
		}
	}

	public function edit($publisherId) {
		if (Request::isMethod('get')) {			

			$publisher = Publisher::find($publisherId);
			JavaScript::put([
				'publisher' => $this->publisher
			]);
			return view('missionControl.publishers.edit');

		} elseif (Request::isMethod('post')) {

			// Is the publisher details provided valid?
			if ($this->publisher->isValid(Input::get('publisher'))) {

				// update
				$publisher = Publisher::find(Input::get('publisher.publisher_id'));
				$publisher->name = 
				$publisher->description = 
				$publisher->save();

				// Edit publisher
				return response()->json(null, 204);
			}
			return response()->json();
		}
	}
}